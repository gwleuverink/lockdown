<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\DriverFactory;
use Gwleuverink\Lockdown\Drivers\Driver;
use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\Tests\CustomDriver;
use Gwleuverink\Lockdown\Exceptions\LockdownDriverNotFound;

class DriverFactoryTest extends TestCase
{
    private $guard;

    public function setUp() : void
    {
        parent::setUp();

        $this->guard = (object) config('lockdown.guards.config');
    }

    /** @test */
    public function it_creates_a_driver()
    {
        // arrange
        $factory = new DriverFactory($this->guard);

        // act
        $driver = $factory->build();

        // assert
        $this->assertInstanceOf(Driver::class, $driver);
    }

    /** @test */
    public function it_throws_exception_when_driver_not_found()
    {
        // arrange
        $this->guard->driver = 'non-existing-driver-name';
        $factory = new DriverFactory($this->guard);

        // act
        $this->expectException(LockdownDriverNotFound::class);
        $driver = $factory->build();
    }

    /** @test */
    public function it_creates_a_driver_instance_if_a_custom_driver_is_used()
    {
        // arrange
        config(['lockdown.guards.config.driver' => CustomDriver::class]);
        $guard = (object) config('lockdown.guards.config');
        $factory = new DriverFactory($guard);

        // act
        $driver = $factory->build();

        // assert
        $this->assertInstanceOf(Driver::class, $driver);
    }
}
