<?php

namespace Gwleuverink\Lockdown\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeleteDatabaseUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lockdown:delete-user {user} {group?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a Basic Auth user for the BasicLock database driver.';

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
        $deleted = DB::table(config('lockdown.table'))
            ->whereGroup($group = $this->argument('group') ?? 'default')
            ->whereUser($user = $this->argument('user'))
            ->delete();

        if (! $deleted) {
            return $this->error("User with name `$user` not found in $group group");
        }
        
        $this->info("User with name `$user` deleted from $group group");
    }
}
