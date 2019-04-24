<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\LockdownFactory;

class ConfigDriverTest extends TestCase
{
    const DRIVER = 'config';


    /** @test */
    public function it_does_not_pass_authentication_without_credentials()
    {
        // act
        $this->expectException(UnauthorizedHttpException::class);
        $this->app->lockdown->verifyRequest(self::DRIVER);
    }

    /** @test */
    public function it_does_not_pass_authentication_with_faulty_credentials()
    {
        // arrange
        $this->app->request->server->add([
            'PHP_AUTH_USER' => 'wrong_user',
            'PHP_AUTH_PW' => 'wrong_password'
        ]);

        // act
        $this->expectException(UnauthorizedHttpException::class);
        $this->app->lockdown->verifyRequest(self::DRIVER);
    }

    /** @test */
    public function it_passes_authentication_with_credentials()
    {
        // arrange
        $this->app->request->server->add([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'secret'
        ]);
     
        // act
        $authenticates = $this->app->lockdown->verifyRequest(self::DRIVER);

        // assert
        $this->assertTrue($authenticates);
    }
}
