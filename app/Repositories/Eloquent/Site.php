<?php

/**
 * Created by PhpStorm.
 * User: zhangyurong
 * Date: 2016/7/22
 * Time: 8:33
 */
namespace App\Repositories\Eloquent;

use App\Http\Model\WebConfig;
use App\Repositories\Contracts\SiteContract;

class Site implements SiteContract{
    /**
     * @param $tplfile
     * @param array $tpldata
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($name){
        return WebConfig::getConfig($name);
    }

    /**
     * 儿取全部配置
     * @return mixed
     */
    public function getAll(){
        return WebConfig::getAll();
    }

}