<?php

<<<<<<< HEAD
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
=======
require_once __DIR__ . '/../autoload.php';

session_start();

echo '<h1>Transaksi Barang</h1>';
echo '<p>Autoload lokal sudah diatur. Arahkan ke controllers dan views secara manual.</p>';
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
