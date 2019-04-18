<?php

namespace Gwleuverink\Lockdown\Contracts;

use Illuminate\Http\Request;
use Illuminate\Config\Repository as ConfigRepository;

interface Unlockable {
    public function __construct(Request $request, ConfigRepository $config);
    public function turnKey() : bool;
}