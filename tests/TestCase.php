<?php

namespace Gwleuverink\Lockdown\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Gwleuverink\Lockdown\ServiceProvider;

class TestCase extends BaseTestCase {
    
    public function setUp() : void
    {
        parent::setUp();
        $this->registerPackageServiceProvider();
    }

    private function registerPackageServiceProvider()
    {
        $this->app->register(ServiceProvider::class);
    }
}