<?php

header('Content-Type: application/json');

require __DIR__ . '/../vendor/autoload.php';

use MohsenNajafizadeh\TelegramNotifier\Telegram;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_ENV['APP_ENV'] == 'production') {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} elseif ($_ENV['APP_ENV'] == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(404);
    header('Content-Type: text/html');
    include '404.html';
    exit;
}

if ($_ENV['CHECK_API_TOKEN']) {
    $apiToken = $_ENV['API_TOKEN'];
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ' . $apiToken) {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'Unauthorized',
            'header-code' => 401,
        ]);
        exit;
    }
}

// Read JSON payload
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['botToken'], $data['chatId'], $data['message'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request. botToken, chatId, and message are required.',
        'header-code' => 400,
    ]);
    exit;
}

$message = $data['message'];
$botToken = $data['botToken'];
$chatId = $data['chatId'];
$parseMode = $data['parse_mode'] ?? null;

try {
    $result = Telegram::sendMessage($message, $botToken, $chatId, $parseMode);
    die($result);
    if ($result) {
        http_response_code($result['header-code']);
        echo json_encode([
            'status' => $result['success'],
            'message' => $result['message'],
            'header-code' => $result['header-code'],
        ]);
    }
} catch (\MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
