<?php declare(strict_types=1);
/**
 * Иницилизируем/обнуляем счётчики
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Model\Codes;

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$redis->del(Codes::HASH);
