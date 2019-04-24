<?php

namespace Gwleuverink\Lockdown\Drivers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Gwleuverink\Lockdown\Exceptions\LockdownUsersTableNotFound;

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
        throw_unless(
            $this->hasCredentials(),
            UnauthorizedHttpException::class,
            'Basic'
        );

        throw_unless(
            Schema::hasTable(config('lockdown.table')),
            LockdownUsersTableNotFound::class
        );
        
        // Find a user
        $user = DB::table(config('lockdown.table'))
                    ->whereGroup($this->arguments->get('group'))
                    ->whereUser($this->getProvidedUser())
                    ->first();

        $passes = $user && Hash::check($this->getProvidedPassword(), $user->password);

        throw_unless(
            $passes,
            UnauthorizedHttpException::class,
            'Basic'
        );

        // Check the password
        return true;
    }
}
