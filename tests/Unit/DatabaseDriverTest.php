<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\LockdownFactory;

class DatabaseDriverTest extends TestCase
{
    const DRIVER = 'database';
    private $factory;

    public function setUp() : void
    {
        parent::setUp();

        $this->factory = $this->app->make(LockdownFactory::class);

        // Create a database user
        Artisan::call('lockdown:create-user', [
            'user' => 'admin',
            'password' => 'secret'
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../../database/migrations/create_lockdown_users_table.php.stub';
    
        (new \CreateLockdownUsersTable)->up();
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
