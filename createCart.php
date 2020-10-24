<?php

require_once 'vendor/autoload.php';

use App\App;
use App\Models\Cart;

require_once __DIR__ . '/helpers.php';

$app = App::get();

try {
    $app->run($argv);
} catch (Exception $exception) {
    echo $exception->getMessage() . "\r\n";
}
