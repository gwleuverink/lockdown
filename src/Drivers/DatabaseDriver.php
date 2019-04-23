<?php

namespace Gwleuverink\Lockdown\Drivers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Gwleuverink\Lockdown\Exceptions\BasicAuthTableNotFoundException;

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
        if (!$this->hasCredentials()) {
            return false;
        }

        throw_unless(
            Schema::hasTable(config('basic-auth.table')),
            BasicAuthTableNotFoundException::class
        );
        
        // Find a user
        $user = DB::table(config('basic-auth.table'))
                    ->whereGroup($this->arguments->get('group'))
                    ->whereUser($this->getProvidedUser())
                    ->first();

        if(! $user) return false;

        // Check the password
        return Hash::check($this->getProvidedPassword(), $user->password);
    }
}