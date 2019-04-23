<?php

namespace Gwleuverink\Lockdown\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Gwleuverink\Lockdown\ServiceProvider;

class TestCase extends BaseTestCase {

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}