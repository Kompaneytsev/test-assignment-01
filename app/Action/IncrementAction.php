<?php declare(strict_types=1);

namespace App\Action;

use Redis;
use Symfony\Component\HttpFoundation\JsonResponse;

class IncrementAction implements Action
{
    public function run(): JsonResponse
    {
        $redis = new Redis();
        $redis->pconnect('127.0.0.1', 6379);
        $countriesList = ['ru', 'us', 'cy'];

        $requestParam = $_REQUEST['param'] ?? null;
        if ($requestParam !== null && in_array($requestParam, $countriesList, true)) {
            $value = $redis->incr($requestParam);
            $responseBody = [$requestParam => $value];
            $responseCode = 200;
        } else {
            $responseBody = 'bad request';
            $responseCode = 400;
        }
        return new JsonResponse($responseBody, $responseCode);
    }
}
