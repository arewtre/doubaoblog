<?php
namespace App\Repositories\Eloquent;
use App\Facades\Site as SiteSms ;
use App\Repositories\Contracts\SmsContract;
//引入第三方短信入口文件
//require_once('../app/Vendor/Alidayu/TopSdk.php');
require_once(app_path('Vendor/Alidayu/TopSdk.php'));


class AlidayuSms implements SmsContract{
    //短线发送
    public function send($mobileNum,$smsParam,$smsTemplateCode,$smsFreeSignName){
        $c =  new \TopClient();
        $c->format = "json";
        $c->appkey =  SiteSms::get('AlidayuAppKey');
        $c->secretKey =  SiteSms::get('AlidayuAppSecret');
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        //$req->setExtend("123456");    //可忽略
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($smsFreeSignName);
        $req->setSmsParam(json_encode($smsParam));
        $req->setRecNum($mobileNum);
        $req->setSmsTemplateCode($smsTemplateCode);
        return   $resp = $c->execute($req);
    }

    //获取短信验证码发送
    public function codeSend($mobileNum,$smsParam,$smsTemplateCode='',$smsFreeSignName=''){
        //默认使用短信身份验证模板和签名
        $smsTemplateCode = empty($smsTemplateCode) ? SiteSms::get('smsTemplateCode') : $smsTemplateCode;
        $smsFreeSignName = empty($smsFreeSignName) ? SiteSms::get('smsFreeSignName') : $smsFreeSignName;
        return  $this->send($mobileNum,$smsParam,$smsTemplateCode,$smsFreeSignName);
    }
}