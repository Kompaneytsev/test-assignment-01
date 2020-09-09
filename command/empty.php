<?php declare(strict_types=1);

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$countriesList = ['ru', 'us', 'cy'];

foreach ($countriesList as $value) {
    $redis->set($value, 0);
}
