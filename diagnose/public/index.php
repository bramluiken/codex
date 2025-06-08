<?php
session_start();

// Map of available surveys (default plus any others)
$surveys = [
    'default' => [
        'How satisfied are you with our service?',
        'How likely are you to recommend us to a friend?',
        'How would you rate the overall experience?'
    ],
    // Example secondary survey that can be accessed via /survey/product
    'product' => [
        'How would you rate the product quality?',
        'How was the packaging?',
        'How easy was the purchase process?'
    ],
];

// Handle links like /survey/<id> to select a survey
if (preg_match('#^/survey/([A-Za-z0-9_-]+)$#',
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $m)) {
    $id = $m[1];
    $_SESSION['surveyId'] = $id;
    if (!isset($_SESSION['surveys'][$id])) {
        $_SESSION['surveys'][$id] = ['index' => 0, 'answers' => []];
    }
    header('Location: /');
    exit;
}

$surveyId = $_SESSION['surveyId'] ?? 'default';
$questions = $surveys[$surveyId] ?? $surveys['default'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api/hello') {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
    return;
}

if ($uri === '/api/history') {
    header('Content-Type: application/json');
    $sessionData = $_SESSION['surveys'][$surveyId] ?? ['index' => 0, 'answers' => []];
    $answers = $sessionData['answers'];
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
        'nextIndex' => $sessionData['index'] ?? 0,
    ]);
    return;
}

if ($uri === '/api/question') {
    header('Content-Type: application/json');
    $sessionData = $_SESSION['surveys'][$surveyId] ?? ['index' => 0, 'answers' => []];
    $index = $sessionData['index'] ?? 0;
    if ($index < count($questions)) {
        echo json_encode(['question' => $questions[$index], 'index' => $index]);
    } else {
        echo json_encode(['done' => true]);
    }
    return;
}

if ($uri === '/api/answer') {
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
    if (!isset($_SESSION['surveys'][$surveyId])) {
        $_SESSION['surveys'][$surveyId] = ['index' => 0, 'answers' => []];
    }
    $_SESSION['surveys'][$surveyId]['answers'][$index] = $value;
    if (!isset($_SESSION['surveys'][$surveyId]['index']) ||
        $index >= $_SESSION['surveys'][$surveyId]['index']) {
        $_SESSION['surveys'][$surveyId]['index'] = $index + 1;
    }
    echo json_encode(['status' => 'ok']);
    return;
}

$clientBase = realpath(__DIR__ . '/../client');
$path = realpath($clientBase . ($uri === '/' ? '/index.html' : $uri));
if ($path && strpos($path, $clientBase) === 0 && is_file($path)) {
    $mime = mime_content_type($path);
    header('Content-Type: ' . $mime);
    readfile($path);
} else {
    http_response_code(404);
    echo 'Not Found';
}
?>
