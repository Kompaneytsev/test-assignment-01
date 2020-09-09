<?php declare(strict_types=1);
require_once 'common/common.php';

foreach ($countriesList as $value) {
    $redis->set($value, 0);
}
