<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\BasicLockFactory;
use Illuminate\Config\Repository as ConfigRepository;
use Gwleuverink\Lockdown\BasicLock;

class BasicLockFactoryTest extends TestCase
{
    /** @test */
    public function it_resolves_a_factory_from_the_container()
    {
        $factory = $this->app->make(BasicLockFactory::class);

        $this->assertInstanceOf(BasicLockFactory::class, $factory);
    }

    /** @test */
    public function it_loads_configuration()
    {
        $factory = $this->app->make(BasicLockFactory::class);
        $this->assertInstanceOf(ConfigRepository::class, $factory->config);
    }

    /** @test */
    public function it_builds_a_lock()
    {
        $factory = $this->app->make(BasicLockFactory::class);
        
        $lock = $factory->build(
            $this->app->request
        );

        $this->assertInstanceOf(BasicLock::class, $lock);
    }
}
