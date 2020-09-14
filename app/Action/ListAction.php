<?php declare(strict_types=1);

namespace App\Action;

use App\Model\Codes;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAction extends AbstractAction implements Action
{
    public function run(): JsonResponse
    {
        return new JsonResponse(
            array_map('intval', array_merge(
                array_fill_keys(Codes::COUNTRIES, 0),
                $this->dataManager->hGetAll(Codes::HASH)
            ))
        );
    }
}
