<?php
$questions = require __DIR__ . '/questions.php';
require __DIR__ . '/api.php';

$pdo = new PDO('mysql:host=localhost;dbname=survey;charset=utf8mb4', 'root', '');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api/hello') {
    handleHello();
    return;
}

$parts = array_values(array_filter(explode('/', trim($uri, '/'))));

if (isset($parts[0]) && $parts[0] === 'api' && count($parts) >= 2) {
    $surveyId = $parts[1];
    if (!preg_match('/^[23456789CFGHJMPQRVWX]{8}$/i', $surveyId)) {
        http_response_code(400);
        echo 'Invalid survey id';
        return;
    }
    $endpoint = $parts[2] ?? 'history';
    switch ($endpoint) {
        case 'hello':
            handleHello();
            break;
        case 'history':
            handleHistory($pdo, $surveyId, $questions);
            break;
        case 'question':
            handleQuestion($pdo, $surveyId, $questions);
            break;
        case 'answer':
            handleAnswer($pdo, $surveyId, $questions);
            break;
        default:
            http_response_code(404);
    }
    return;
}

$clientBase = realpath(__DIR__ . '/../app');
if ($uri === '/') {
    $path = realpath($clientBase . '/front.html');
} elseif (preg_match('#^/survey/[23456789CFGHJMPQRVWX]{8}$#i', $uri)) {
    $path = realpath($clientBase . '/index.html');
} else {
    $path = realpath($clientBase . $uri);
}
if ($path && strpos($path, $clientBase) === 0 && is_file($path)) {
    $mime = mime_content_type($path);
    header('Content-Type: ' . $mime);
    readfile($path);
} else {
    http_response_code(404);
    echo 'Not Found';
}
