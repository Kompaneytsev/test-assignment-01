<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ErrorFormatter
{
    protected $codeMapper = [
        BadRequestException::class => 400,
        ResourceNotFoundException::class => 404,
        MethodNotAllowedException::class => 405,
        ValidationException::class => 422,
    ];

    public function format(Exception $exception): JsonResponse
    {
        $message = $exception->getMessage();
        $statusCode = $this->codeMapper[get_class($exception)] ?? 500;
        return new JsonResponse(['error' => $message], $statusCode);
    }
}
