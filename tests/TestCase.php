<?php

namespace Leuverink\Lockdown\Tests;

use Leuverink\Lockdown\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
