<?php declare(strict_types=1);

$requestsCount = 300;

function randomCountryCode(): string {
    $countriesList = ['ru', 'us', 'cy'];
    $key = array_rand($countriesList);
    return $countriesList[$key];
}

$chs = [];
$url = 'http://127.0.0.1:3002/index.php?action=increment';

$mh = curl_multi_init();
for ($key = 1; $key <= $requestsCount; $key++) {
    $chs[$key] = curl_init($url);
    curl_setopt($chs[$key], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chs[$key], CURLOPT_POST, true);
    curl_setopt($chs[$key], CURLOPT_POSTFIELDS, [
        'param' => randomCountryCode(),
    ]);
    curl_multi_add_handle($mh, $chs[$key]);
}


$running = null;
do {
    curl_multi_exec($mh, $running);
} while ($running);

$errors = 0;
$sent = 0;
$lost = 0;

foreach(array_keys($chs) as $key){
    $error = curl_error($chs[$key]);
    $last_effective_URL = curl_getinfo($chs[$key], CURLINFO_EFFECTIVE_URL);
    $time = curl_getinfo($chs[$key], CURLINFO_TOTAL_TIME);
    $response = curl_multi_getcontent($chs[$key]);  // get results
    if (!empty($error)) {
        $errors++;
//        echo "The request $key return a error: $error" . "\n";
    } else {
        $sent++;
        if (strlen($response) === 0) {
            $lost++;
        }
//        echo "The request to '$last_effective_URL' returned '$response' in $time seconds." . "\n";
    }
    curl_multi_remove_handle($mh, $chs[$key]);
}

curl_multi_close($mh);

echo sprintf('Отправлено: %d | Потеряно: %d', $sent, $lost), PHP_EOL;
