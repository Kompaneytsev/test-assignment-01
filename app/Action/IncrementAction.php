<?php declare(strict_types=1);

namespace App\Action;

use App\Exception\ValidationException;
use App\Model\Codes;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;

class IncrementAction extends AbstractAction implements Action
{
    public function run(): JsonResponse
    {
        $requestParam = $_REQUEST['param'] ?? null;
        if ($requestParam === null) {
            throw new BadRequestException('Передайте параметр в теле запроса');
        }

        if (in_array($requestParam, Codes::COUNTRIES, true)) {
            $value = $this->dataManager->hIncrBy(Codes::HASH, $requestParam, 1);
            $responseBody = [$requestParam => $value];
            return new JsonResponse($responseBody);
        }

        throw new ValidationException('Выберите параметр из доступного списка: ' . implode(', ', Codes::COUNTRIES));
    }
}
