<?php declare(strict_types=1);

namespace App\Action;

use App\Exception\ValidationException;
use App\Model\Codes;
use Redis;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;

class IncrementAction implements Action
{
    public function run(): JsonResponse
    {
        $redis = new Redis();
        $redis->pconnect('127.0.0.1', 6379);

        $requestParam = $_REQUEST['param'] ?? null;
        if ($requestParam === null) {
            throw new BadRequestException('Передайте параметр в теле запроса');
        }

        if (in_array($requestParam, Codes::COUNTRIES, true)) {
            $value = $redis->incr($requestParam);
            $responseBody = [$requestParam => $value];
            return new JsonResponse($responseBody);
        }

        throw new ValidationException('Выберите параметр из доступного списка');
    }
}
