<?php
session_start();

$questions = require __DIR__ . '/questions.php';
require __DIR__ . '/api.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/api/hello':
        handleHello();
        return;
    case '/api/history':
        handleHistory($questions);
        return;
    case '/api/question':
        handleQuestion($questions);
        return;
    case '/api/answer':
        handleAnswer($questions);
        return;
}

$clientBase = realpath(__DIR__ . '/../app');
$path = realpath($clientBase . ($uri === '/' ? '/index.html' : $uri));
if ($path && strpos($path, $clientBase) === 0 && is_file($path)) {
    $mime = mime_content_type($path);
    header('Content-Type: ' . $mime);
    readfile($path);
} else {
    http_response_code(404);
    echo 'Not Found';
}
