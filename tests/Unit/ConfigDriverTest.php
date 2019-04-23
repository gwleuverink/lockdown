<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\BasicLockFactory;

class ConfigDriverTest extends TestCase
{
    const DRIVER = 'config';
    private $factory;

    public function setUp() : void
    {
        parent::setUp();

        $this->factory = $this->app->make(BasicLockFactory::class);
    }

    /** @test */
    public function it_does_not_pass_authentication_without_credentials()
    {
        // arrange
        $lock = $this->factory->build($this->app->request);

        // act
        $authenticates = $lock->authenticates(self::DRIVER);

        // assert
        $this->assertFalse($authenticates);
    }

    /** @test */
    public function it_does_not_pass_authentication_with_faulty_credentials()
    {
        // arrange
        $this->app->request->server->add([
            'PHP_AUTH_USER' => 'wrong_user',
            'PHP_AUTH_PW' => 'wrong_password'
        ]);

        $lock = $this->factory->build($this->app->request);

        // act
        $authenticates = $lock->authenticates(self::DRIVER);

        // assert
        $this->assertFalse($authenticates);
    }

    /** @test */
    public function it_passes_authentication_with_credentials()
    {
        // arrange
        $this->app->request->server->add([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'secret'
        ]);
        $lock = $this->factory->build($this->app->request);

        // act
        $authenticates = $lock->authenticates(self::DRIVER);

        // assert
        $this->assertTrue($authenticates);
    }
}
