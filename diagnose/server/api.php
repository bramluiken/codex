<?php
function handleHello() {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
}

function handleHistory(array $questions) {
    header('Content-Type: application/json');
    $answers = $_SESSION['answers'] ?? [];
    $history = [];
    foreach ($questions as $i => $q) {
        $history[] = [
            'index' => $i,
            'question' => $q,
            'answer' => $answers[$i] ?? null,
        ];
    }
    echo json_encode([
        'history' => $history,
        'nextIndex' => $_SESSION['index'] ?? 0,
    ]);
}

function handleQuestion(array $questions) {
    header('Content-Type: application/json');
    $index = $_SESSION['index'] ?? 0;
    if ($index < count($questions)) {
        echo json_encode(['question' => $questions[$index], 'index' => $index]);
    } else {
        echo json_encode(['done' => true]);
    }
}

function handleAnswer(array $questions) {
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
    $_SESSION['answers'][$index] = $value;
    if (!isset($_SESSION['index']) || $index >= $_SESSION['index']) {
        $_SESSION['index'] = $index + 1;
    }
    echo json_encode(['status' => 'ok']);
}
