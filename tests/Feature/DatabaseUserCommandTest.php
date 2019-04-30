<?php

namespace Gwleuverink\Lockdown\Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Gwleuverink\Lockdown\Tests\TestCase;

class DatabaseUserCommandTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        
        // Create a database user
        Artisan::call('lockdown:create-user', [
            'user' => 'tester',
            'password' => 'secret',
            'group' => 'testing'
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../../database/migrations/create_lockdown_users_table.php.stub';

        (new \CreateLockdownUsersTable)->up();
    }


    /** @test */
    public function it_creates_a_basic_lock_user_record()
    {
        $users = DB::table(config('lockdown.table'))
            ->whereGroup('testing')
            ->whereUser('tester')
            ->get();

        $this->assertTrue($users->isNotEmpty());
    }


    /** @test */
    public function it_deletes_a_basic_lock_user_record()
    {
        Artisan::call('lockdown:delete-user', [
            'user' => 'tester',
            'group' => 'testing'
        ]);

        $users = DB::table(config('lockdown.table'))
            ->whereGroup('testing')
            ->whereUser('admin')
            ->get();

        $this->assertFalse($users->isNotEmpty());
    }


    /** @test */
    public function it_returns_exit_code_when_deleting_nonexisting_user()
    {
        $this->artisan('lockdown:delete-user', [
            'user' => 'nonexisting-user',
            'group' => 'nonexisting-group'
        ])->assertExitCode(0);
    }

    /** @test */
    public function it_returns_exit_code_when_database_table_does_not_exist()
    {
        Schema::dropIfExists(config('lockdown.table'));

        $this->artisan('lockdown:create-user', [
            'user' => 'tester',
            'password' => 'secret',
            'group' => 'testing'
        ])->assertExitCode(0);

        $this->artisan('lockdown:delete-user', [
            'user' => 'tester',
            'group' => 'testing'
        ])->assertExitCode(0);
    }
}
