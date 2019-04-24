<?php

namespace Gwleuverink\Lockdown\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Gwleuverink\Lockdown\ServiceProvider;
use Gwleuverink\Lockdown\Lockdown;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
