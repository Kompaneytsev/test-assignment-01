<?php declare(strict_types=1);

namespace App\Action;

use Redis;

/**
 * В следующей итераци можно завести DI, подключить AbstractAction к DI,
 * вынести конфиг редиса .ENV.LOCAL
 */
abstract class AbstractAction
{
    protected Redis $dataManager;

    public function __construct()
    {
        $this->dataManager = new Redis();
        $this->dataManager->pconnect('127.0.0.1', 6379);
    }
}
