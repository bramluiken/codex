<?php
function handleHello() {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
}

function handleHistory(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');

    $stmt = $pdo->prepare('SELECT question_index, answer FROM answers WHERE survey_id = ?');
    $stmt->execute([$surveyId]);
    $answers = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $answers[$row['question_index']] = $row['answer'];
    }
    $history = [];
    foreach ($questions as $i => $q) {
        $history[] = [
            'index' => $i,
            'question' => $q,
            'answer' => $answers[$i] ?? null,
        ];
    }
    $nextIndex = 0;
    foreach ($answers as $idx => $val) {
        if ($val !== null && $idx >= $nextIndex) {
            $nextIndex = $idx + 1;
        }
    }
    echo json_encode([
        'history' => $history,
        'nextIndex' => $nextIndex,
    ]);
}

function handleQuestion(PDO $pdo, string $surveyId, array $questions) {
    header('Content-Type: application/json');
    $stmt = $pdo->prepare('SELECT MAX(question_index) AS m FROM answers WHERE survey_id = ?');
    $stmt->execute([$surveyId]);
    $max = $stmt->fetchColumn();
    $index = $max === null ? 0 : ($max + 1);
    if ($index < count($questions)) {
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
    if ($index === null || $index < 0 || $index >= count($questions) ||
        $value === null || $value < 1 || $value > 7) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid answer']);
        return;
    }
    $stmt = $pdo->prepare('INSERT INTO answers (survey_id, question_index, answer) VALUES (?,?,?) ON DUPLICATE KEY UPDATE answer=VALUES(answer)');
    $stmt->execute([$surveyId, $index, $value]);
    echo json_encode(['status' => 'ok']);
}
