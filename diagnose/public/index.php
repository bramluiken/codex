<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, '/api/hello') === 0) {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from API']);
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
