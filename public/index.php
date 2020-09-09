<?php declare(strict_types=1);
require_once './../common/common.php';

header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_REQUEST['action'] ?? null;

$responseBody = 'method not found';
$responseCode = 404;

if ($requestMethod === 'GET' && $action === 'list') {
    $responseBody = [];
    foreach ($countriesList as $item) {
        $responseBody[$item] = $redis->get($item);
    }
    $responseCode = 200;
} elseif ($requestMethod === 'POST' && $action === 'increment') {
    $requestParam = $_REQUEST['param'] ?? null;
    if ($requestParam !== null && in_array($requestParam, $countriesList, true)) {
        $value = $redis->incr($requestParam);
        $responseBody = [$requestParam => $value];
        $responseCode = 200;
    } else {
        $responseBody = 'bad request';
        $responseCode = 400;
    }
}

http_response_code($responseCode);
echo json_encode($responseBody);
$redis->close();
