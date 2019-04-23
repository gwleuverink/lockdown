<?php

namespace Gwleuverink\Lockdown\Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Gwleuverink\Lockdown\Tests\TestCase;

class DatabaseUserCommandTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        
        // Create a database user
        Artisan::call('basic-lock:create-user', [
            'user' => 'tester',
            'password' => 'secret',
            'group' => 'testing'
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../../database/migrations/create_basic_lock_users_table.php.stub';

        (new \CreateBasicAuthUsersTable)->up();
    }

    /** @test */
    public function it_creates_a_basic_lock_user_record()
    {
        $users = DB::table(config('basic-lock.table'))
            ->whereGroup('testing')
            ->whereUser('tester')
            ->get();

        $this->assertTrue($users->isNotEmpty());
    }

    /** @test */
    public function it_deletes_a_basic_lock_user_record()
    {
        Artisan::call('basic-lock:delete-user', [
            'user' => 'tester',
            'group' => 'testing'
        ]);

        $users = DB::table(config('basic-lock.table'))
            ->whereGroup('testing')
            ->whereUser('admin')
            ->get();

        $this->assertFalse($users->isNotEmpty());
    }
}
