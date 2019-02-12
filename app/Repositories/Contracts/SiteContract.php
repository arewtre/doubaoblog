<?php

namespace App\Repositories\Contracts;

interface SiteContract{
    /**
     * @param $tplfile  //文件
     * @param $tpldata  //数组
     **/
    public function get($name);
    public function getAll();
}