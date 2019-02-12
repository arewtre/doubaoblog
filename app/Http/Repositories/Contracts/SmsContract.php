<?php

namespace App\Repositories\Contracts;

interface SmsContract{
    /**
     * 阿里大鱼短信接口
     * @param $mobileNum  //手机号码
     * @param $smsParam  //参数
     * @param $smsTemplateCode //短信模板
     * @param $smsFreeSignName //短信签名
     **/
    public function send($mobileNum,$smsParam,$smsTemplateCode,$smsFreeSignName);
}