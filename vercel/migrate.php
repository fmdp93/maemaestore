<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__.'/../vendor/autoload.php'; // Adjust the path if needed
require __DIR__.'/../bootstrap/app.php';   // Adjust the path if needed

Capsule::schema()->dropIfExists('migrations');

exec('php '.__DIR__.'/../artisan migrate --force');
