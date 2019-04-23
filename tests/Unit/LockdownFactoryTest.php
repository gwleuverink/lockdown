<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\LockdownFactory;
use Illuminate\Config\Repository as ConfigRepository;
use Gwleuverink\Lockdown\Lockdown;

class LockdownFactoryTest extends TestCase
{
    /** @test */
    public function it_resolves_a_factory_from_the_container()
    {
        $factory = $this->app->make(LockdownFactory::class);

        $this->assertInstanceOf(LockdownFactory::class, $factory);
    }

    /** @test */
    public function it_loads_configuration()
    {
        $factory = $this->app->make(LockdownFactory::class);
        $this->assertInstanceOf(ConfigRepository::class, $factory->config);
    }

    /** @test */
    public function it_builds_a_lock()
    {
        $factory = $this->app->make(LockdownFactory::class);
        
        $lock = $factory->build(
            $this->app->request
        );

        $this->assertInstanceOf(Lockdown::class, $lock);
    }
}
