<?php
session_start();

$questions = [
    'How satisfied are you with our service?',
    'How likely are you to recommend us to a friend?',
    'How would you rate the overall experience?'
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api/hello') {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
    return;
}

if ($uri === '/api/question') {
    header('Content-Type: application/json');
    $index = $_SESSION['index'] ?? 0;
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
    $value = isset($input['value']) ? intval($input['value']) : null;
    if ($value === null || $value < 1 || $value > 7) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid answer']);
        return;
    }
    $index = $_SESSION['index'] ?? 0;
    $_SESSION['answers'][$index] = $value;
    $_SESSION['index'] = $index + 1;
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
