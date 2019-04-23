<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\BasicLockFactory;

class BasicLockConfigurationTest extends TestCase
{
    /** @test */
    public function it_is_valid()
    {
        $lock = $this->app->make(BasicLockFactory::class);

        $this->assertNotNull($lock->config->get('enabled'));
        $this->assertNotNull($lock->config->get('default'));
        $this->assertNotNull($lock->config->get('guards'));
        $this->assertNotNull($lock->config->get('guards.config'));
        $this->assertNotNull($lock->config->get('guards.database'));
    }
}