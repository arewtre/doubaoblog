<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Sms extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'Sms';
    }
}