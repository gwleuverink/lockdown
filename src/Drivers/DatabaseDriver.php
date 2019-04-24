<?php

namespace Gwleuverink\Lockdown\Drivers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
     * @return boolean
     */
    public function passesAuthentication() : bool
    {
        throw_unless(
            Schema::hasTable(config('lockdown.table')),
            LockdownUsersTableNotFound::class
        );
        
        
        $user = DB::table(config('lockdown.table'))
                    ->whereGroup($this->arguments->get('group'))
                    ->whereUser($this->getProvidedUser())
                    ->first();

        // User exists and password matches
        return $user && Hash::check($this->getProvidedPassword(), $user->password);
    }
}
