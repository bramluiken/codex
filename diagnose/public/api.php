<?php
function handleHello() {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
}

function handleHistory(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');

    $stmt = $pdo->prepare('SELECT symptom_id, answer FROM answers WHERE survey_id = ? ORDER BY created_at');
    $stmt->execute([$surveyId]);
    $history = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sid = $row['symptom_id'];
        if (!isset($questions[$sid])) {
            continue;
        }
        $history[] = [
            'index' => $sid,
            'question' => $questions[$sid],
            'answer' => $row['answer'],
        ];
    }
    echo json_encode(['history' => $history]);
}

function handleQuestion(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');
    $index = selectNextIndex($pdo, $surveyId);
    if ($index !== null && isset($questions[$index])) {
        echo json_encode(['question' => $questions[$index], 'index' => $index]);
    } else {
        echo json_encode(['done' => true]);
    }
}

function handleAnswer(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $index = isset($input['index']) ? intval($input['index']) : null;
    $value = isset($input['value']) ? intval($input['value']) : null;
    if ($index === null || !isset($questions[$index]) ||
        $value === null || $value < 1 || $value > 7) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid answer']);
        return;
    }
    $stmt = $pdo->prepare('INSERT INTO answers (survey_id, symptom_id, answer, created_at) VALUES (?,?,?,NOW()) ON DUPLICATE KEY UPDATE answer=VALUES(answer)');
    $stmt->execute([$surveyId, $index, $value]);
    echo json_encode(['status' => 'ok']);
}

function handleScores(PDO $pdo, string $surveyId) {
    header('Content-Type: application/json');
    $scores = computeDiagnosisScores($pdo, $surveyId);
    echo json_encode(['scores' => $scores]);
}

function computeDiagnosisScores(PDO $pdo, string $surveyId) {
    $sql = 'SELECT d.id, d.name, COALESCE(SUM(a.answer * w.weight),0) AS score
            FROM diagnoses d
            LEFT JOIN weights w ON w.diagnosis_id = d.id
            LEFT JOIN answers a ON a.symptom_id = w.symptom_id AND a.survey_id = ?
            GROUP BY d.id, d.name
            ORDER BY score DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$surveyId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function loadWeightMatrix(PDO $pdo): array {
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    $stmt = $pdo->query('SELECT symptom_id, diagnosis_id, weight FROM weights');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $s = (int)$row['symptom_id'];
        $d = (int)$row['diagnosis_id'];
        $cache[$s][$d] = (float)$row['weight'];
    }
    return $cache;
}

function softmax(array $scores, ?array $subset = null): array {
    $max = null;
    foreach ($scores as $id => $score) {
        if ($subset !== null && !in_array($id, $subset, true)) {
            continue;
        }
        $max = $max === null ? $score : max($max, $score);
    }
    $exp = [];
    $sum = 0.0;
    foreach ($scores as $id => $score) {
        if ($subset !== null && !in_array($id, $subset, true)) {
            continue;
        }
        $e = exp($score - $max);
        $exp[$id] = $e;
        $sum += $e;
    }
    $probs = [];
    foreach ($exp as $id => $e) {
        $probs[$id] = $e / $sum;
    }
    return $probs;
}

function entropy(array $probs): float {
    $h = 0.0;
    foreach ($probs as $p) {
        if ($p > 0.0) {
            $h -= $p * log($p, 2);
        }
    }
    return $h;
}

function expectedGain(array $scores, array $weights, ?array $subset = null): float {
    $H0 = entropy(softmax($scores, $subset));
    $total = 0.0;
    for ($v = 1; $v <= 7; $v++) {
        $new = $scores;
        foreach ($weights as $d => $w) {
            if ($subset !== null && !in_array($d, $subset, true)) {
                continue;
            }
            $new[$d] = ($new[$d] ?? 0) + $w * $v;
        }
        $total += entropy(softmax($new, $subset));
    }
    $H1 = $total / 7.0;
    return $H0 - $H1;
}

function selectNextIndex(PDO $pdo, string $surveyId) {
    $weights = loadWeightMatrix($pdo);

    // Already answered questions
    $stmt = $pdo->prepare('SELECT symptom_id FROM answers WHERE survey_id = ?');
    $stmt->execute([$surveyId]);
    $answered = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $Q = count($answered);

    // Candidates
    $stmt = $pdo->query('SELECT id FROM symptoms');
    $candidates = [];
    while ($row = $stmt->fetch(PDO::FETCH_COLUMN)) {
        if (!in_array($row, $answered)) {
            $candidates[] = (int)$row;
        }
    }
    if (!$candidates) {
        return null;
    }

    // Current scores
    $scores = computeDiagnosisScores($pdo, $surveyId);
    $cur = [];
    foreach ($scores as $row) {
        $cur[(int)$row['id']] = (float)$row['score'];
    }

    $alpha = 0.5;
    $beta = 0.2;
    $threshold = $alpha * exp(-$beta * $Q);

    // ----- Stage 1: global information -----
    $best = [null, -INF];
    foreach ($candidates as $sym) {
        $gain = expectedGain($cur, $weights[$sym] ?? []);
        if ($gain > $best[1]) {
            $best = [$sym, $gain];
        }
    }
    if ($best[1] >= $threshold) {
        return $best[0];
    }

    // ----- Stage 2: top diagnoses -----
    $probs = softmax($cur);
    arsort($probs);
    $topIds = array_slice(array_keys($probs), 0, 3);
    $best = [null, -INF];
    foreach ($candidates as $sym) {
        $gain = expectedGain($cur, $weights[$sym] ?? [], $topIds);
        if ($gain > $best[1]) {
            $best = [$sym, $gain];
        }
    }
    if ($best[1] >= $threshold) {
        return $best[0];
    }

    // ----- Stage 3: confirm top diagnosis -----
    $top = $topIds[0];
    $best = [null, -INF];
    foreach ($candidates as $sym) {
        $w = $weights[$sym] ?? [];
        $topW = abs($w[$top] ?? 0.0);
        $alt = 0.0;
        foreach ($w as $d => $val) {
            if ($d == $top) {
                continue;
            }
            $alt = max($alt, abs($val));
        }
        $diff = $topW - $alt;
        if ($diff > $best[1]) {
            $best = [$sym, $diff];
        }
    }

    if ($best[1] >= $threshold) {
        return $best[0];
    }

    return null;
}
