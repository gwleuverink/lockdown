<?php

namespace Gwleuverink\Lockdown\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateDatabaseUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basic-lock:create-user {user} {password} {group?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Basic Auth user for the BasicLock database driver.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table(config('basic-lock.table'))->insert([
            'group' => $this->argument('group') ?? 'default',
            'user' => $this->argument('user'),
            'password' => Hash::make($this->argument('password'))
        ]);
    }
}
