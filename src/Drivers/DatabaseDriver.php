<?php

namespace Gwleuverink\Lockdown\Drivers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Gwleuverink\Lockdown\Exceptions\LockdownUsersTableNotFound;

class DatabaseDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @throws LockdownUsersTableNotFound
     * @return boolean
     */
    public function passesAuthentication($user, $password) : bool
    {
        throw_unless(
            Schema::hasTable(config('lockdown.table')),
            LockdownUsersTableNotFound::class
        );
        
        
        $user = DB::table(config('lockdown.table'))
                    ->whereGroup($this->arguments->get('group'))
                    ->whereUser($user)
                    ->first();

        // User exists and password matches
        return $user && Hash::check($password, $user->password);
    }
}
