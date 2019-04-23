<?php

namespace Gwleuverink\Lockdown\Commands;

use Illuminate\Console\Command;

class CreateDatabaseUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basic-lock:user {guard} {user} {password}';

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle(DripEmailer $drip)
    {
        $drip->send(User::find($this->argument('user')));
    }
}
