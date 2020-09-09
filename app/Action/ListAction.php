<?php declare(strict_types=1);

namespace App\Action;

use App\Model\Codes;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAction extends AbstractAction implements Action
{
    public function run(): JsonResponse
    {
        $countriesList = Codes::COUNTRIES;
        $responseBody = [];
        foreach ($countriesList as $item) {
            $responseBody[$item] = $this->dataManager->get($item);
        }
        return new JsonResponse($responseBody);
    }
}
