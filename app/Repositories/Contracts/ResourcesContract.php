<?php

namespace App\Repositories\Contracts;

interface ResourcesContract{

    /**
     * 获取选项栏的资源
     * @param $name
     * @param $array
     * @return mixed
     */
    public function jsOption($sign);

}