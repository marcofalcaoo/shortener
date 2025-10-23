<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        
        // Ensure test database exists
        $dbPath = database_path('testing.sqlite');
        if (!file_exists($dbPath)) {
            touch($dbPath);
        }

        return $app;
    }
}
