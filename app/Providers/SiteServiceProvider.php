<?php

namespace App\Providers;

use App\Repositories\Eloquent\Site;
use Illuminate\Support\ServiceProvider;

class SiteServiceProvider extends ServiceProvider {
    public function boot () {
    }

    public function register () {
        //单列绑定门面
        $this->app->singleton('site', function () {
            return new Site;//调用后台网站配置模块models/comon/
        });
    }
}
