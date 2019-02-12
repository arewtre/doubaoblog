<?php

/**
 * Created by PhpStorm.
 * User: zhangyurong
 * Date: 2016/7/22
 * Time: 8:33
 */
namespace App\Repositories\Eloquent;

use App\Models\Common\CollArea;
use App\Models\Common\WebConfig;
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

    /**
     * 获取当前站点的城市集合
     */
    public function getCity(){
        return collect(CollArea::getSiteCity());
    }
}