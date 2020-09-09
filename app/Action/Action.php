<?php declare(strict_types=1);

namespace App\Action;

use Symfony\Component\HttpFoundation\JsonResponse;

interface Action
{
    public function run(): JsonResponse;
}
