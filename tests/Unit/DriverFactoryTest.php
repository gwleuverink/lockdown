<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\Exceptions\LockdownDriverNotFound;
use Gwleuverink\Lockdown\Drivers\Driver;
use Gwleuverink\Lockdown\DriverFactory;

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
        $factory = new DriverFactory($this->app->request, $this->guard);

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
        $factory = new DriverFactory($this->app->request, $this->guard);

        // act
        $this->expectException(LockdownDriverNotFound::class);
        $driver = $factory->build();
    }
}
