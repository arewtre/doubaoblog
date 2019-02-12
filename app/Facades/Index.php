<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Index extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'index';//处理网站前台门面
    }
}