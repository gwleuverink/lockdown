<?php

namespace Leuverink\Lockdown\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lockdown:create-user {user} {password} {group?}';

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
        if (! Schema::hasTable(config('lockdown.table'))) {
            return $this->error('Please migrate the lockdown table before running this command.');
        }

        $created = DB::table(config('lockdown.table'))->insert([
            'group' => $group = $this->argument('group') ?? 'default',
            'user' => $user = $this->argument('user'),
            'password' => Hash::make($this->argument('password')),
        ]);

        if ($created) {
            $this->info("User with name `$user` created in $group group");
        }
    }
}
