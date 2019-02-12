<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class CustomPassword extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom_password';
    }
}