<?php

namespace Task;

use Slim\Factory\AppFactory;
use Task\Api;

class App
{
    private $app;

    public function __construct()
    {
        $this->app = AppFactory::create();
    }

    public function init(): void
    {
        // Register routes
        (new Api($this->app))->registerRoutes();

        // Additional configurations (middleware, error handling, etc.)
    }

    public function run(): void
    {
        $this->app->run();
    }
}