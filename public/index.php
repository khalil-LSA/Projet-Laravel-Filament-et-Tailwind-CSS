<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Load intl polyfill BEFORE autoloader if extension is not available
if (!extension_loaded('intl')) {
    require __DIR__.'/../bootstrap/intl_polyfill.php';
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Load Number class patch to override Laravel's intl check
if (!extension_loaded('intl')) {
    require __DIR__.'/../bootstrap/number_patch.php';
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
