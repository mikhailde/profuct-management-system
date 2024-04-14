<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/App.php';
require __DIR__ . '/Api.php';

use Task\App;

$app = new App();
$app->init();
$app->run();