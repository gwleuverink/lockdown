<?php

namespace Leuverink\Lockdown\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Leuverink\Lockdown\Exceptions\LockdownUsersTableNotFound;
use Leuverink\Lockdown\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DatabaseDriverTest extends TestCase
{
    const DRIVER = 'database';

    public function setUp(): void
    {
        parent::setUp();

        // Create a database user
        Artisan::call('lockdown:create-user', [
            'user' => 'dbadmin',
            'password' => 'dbsecret',
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__.'/../../database/migrations/create_lockdown_users_table.php.stub';

        (new \CreateLockdownUsersTable)->up();
    }

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
            'PHP_AUTH_PW' => 'wrong_password',
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
            'PHP_AUTH_USER' => 'dbadmin',
            'PHP_AUTH_PW' => 'dbsecret',
        ]);

        // act
        $authenticates = $this->app->lockdown->verifyRequest(self::DRIVER);

        // assert
        $this->assertTrue($authenticates);
    }

    /** @test */
    public function it_throws_an_exception_if_no_user_table_exists_when_user_command_is_called()
    {
        // arrange
        Schema::dropIfExists(config('lockdown.table'));
        $this->app->request->server->add([
            'PHP_AUTH_USER' => 'dbadmin',
            'PHP_AUTH_PW' => 'dbsecret',
        ]);

        // act
        $this->expectException(LockdownUsersTableNotFound::class);
        $authenticates = $this->app->lockdown->verifyRequest(self::DRIVER);
    }
}
