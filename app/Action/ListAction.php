<?php declare(strict_types=1);

namespace App\Action;

use Redis;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAction implements Action
{
    public function run(): JsonResponse
    {
        $redis = new Redis();
        $redis->pconnect('127.0.0.1', 6379);
        $countriesList = ['ru', 'us', 'cy'];
        $responseBody = [];
        foreach ($countriesList as $item) {
            $responseBody[$item] = $redis->get($item);
        }
        $redis->close();
        return new JsonResponse($responseBody);
    }
}
