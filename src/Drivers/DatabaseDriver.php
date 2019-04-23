<?php

namespace Gwleuverink\Lockdown\Drivers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Gwleuverink\Lockdown\Exceptions\BasicLockUsersTableNotFoundException;

class DatabaseDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @return boolean
     */
    public function authenticate() : bool
    {
        // Just do it all in one method, no need to overcomplicate things.
        if (!$this->hasCredentials()) {
            return false;
        }

        throw_unless(
            Schema::hasTable(config('lockdown.table')),
            BasicLockUsersTableNotFoundException::class
        );
        
        // Find a user
        $user = DB::table(config('lockdown.table'))
                    ->whereGroup($this->arguments->get('group'))
                    ->whereUser($this->getProvidedUser())
                    ->first();

        if (! $user) {
            return false;
        }

        // Check the password
        return Hash::check($this->getProvidedPassword(), $user->password);
    }
}
