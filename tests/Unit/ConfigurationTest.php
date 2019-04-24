<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /** @test */
    public function it_is_valid()
    {
        $lock = $this->app->lockdown;

        $this->assertNotNull($lock->config->get('middleware-enabled'));
        $this->assertNotNull($lock->config->get('default'));
        $this->assertNotNull($lock->config->get('guards'));
        $this->assertNotNull($lock->config->get('guards.config'));
        $this->assertNotNull($lock->config->get('guards.config.driver'));
        $this->assertNotNull($lock->config->get('guards.config.arguments'));
        $this->assertNotNull($lock->config->get('guards.database'));
        $this->assertNotNull($lock->config->get('guards.database.driver'));
        $this->assertNotNull($lock->config->get('guards.database.arguments.group'));
    }
}
