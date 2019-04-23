<?php

namespace Gwleuverink\Lockdown\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Gwleuverink\Lockdown\Tests\TestCase;
use Gwleuverink\Lockdown\BasicLockFactory;

class DatabaseDriverTest extends TestCase
{
    const DRIVER = 'database';
    private $factory;

    public function setUp() : void
    {
        parent::setUp();

        $this->factory = $this->app->make(BasicLockFactory::class);
    }

    protected function getEnvironmentSetUp($app)
    {

        include_once __DIR__ . '/../../database/migrations/create_basic_lock_users_table.php.stub';
    
        (new \CreateBasicAuthUsersTable)->up();
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
        DB::table(config('basic-lock.table'))->insert([
            'group' => 'default',
            'user' => 'admin',
            'password' => Hash::make('secret')
        ]);

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
        DB::table(config('basic-lock.table'))->insert([
            'group' => 'default',
            'user' => 'admin',
            'password' => Hash::make('secret')
        ]);

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
