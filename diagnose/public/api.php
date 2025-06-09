<?php
function handleHello() {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
}

function handleHistory(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');

    $stmt = $pdo->prepare('SELECT symptom_id, answer FROM answers WHERE survey_id = ?');
    $stmt->execute([$surveyId]);
    $answers = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $answers[$row['symptom_id']] = $row['answer'];
    }
    $history = [];
    foreach ($questions as $i => $q) {
        $history[] = [
            'index' => $i,
            'question' => $q,
            'answer' => $answers[$i] ?? null,
        ];
    }
    $nextIndex = selectNextIndex($pdo, $surveyId);
    echo json_encode([
        'history' => $history,
        'nextIndex' => $nextIndex,
    ]);
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
    $stmt = $pdo->prepare('INSERT INTO answers (survey_id, symptom_id, answer) VALUES (?,?,?) ON DUPLICATE KEY UPDATE answer=VALUES(answer)');
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

function selectNextIndex(PDO $pdo, string $surveyId) {
    $sql = 'SELECT s.id
            FROM symptoms s
            LEFT JOIN answers a ON a.symptom_id = s.id AND a.survey_id = ?
            WHERE a.symptom_id IS NULL
            ORDER BY (SELECT VARIANCE(w.weight) FROM weights w WHERE w.symptom_id = s.id) DESC
            LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$surveyId]);
    $idx = $stmt->fetchColumn();
    return $idx === false ? null : intval($idx);
}
