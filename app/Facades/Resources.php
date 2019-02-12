<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Resources extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'resources';
    }
}