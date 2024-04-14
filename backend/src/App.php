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
        (new Api($this->app))->registerRoutes();
    }

    public function run(): void
    {
        $this->app->run();
    }
}
