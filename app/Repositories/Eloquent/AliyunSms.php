<?php
namespace App\Repositories\Eloquent;

use App\Facades\Site as SiteSms;
use App\Repositories\Contracts\SmsContract;

//引入第三方阿里云短信入口文件
require_once(app_path('Vendor/AliyunSms/aliyun-php-sdk-core/Config.php'));
require_once(app_path('Vendor/AliyunSms/Dysmsapi/Request/V20170525/SendSmsRequest.php'));
require_once(app_path('Vendor/AliyunSms/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php'));

class AliyunSms implements SmsContract{
    //短线发送
    public function send($mobileNum, $smsParam, $smsTemplateCode, $smsFreeSignName){
        //此处需要替换成自己的AK信息
        $accessKeyId = SiteSms::get('AlidayuAppKey');
        $accessKeySecret = SiteSms::get('AlidayuAppSecret');
        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";
        //初始化访问的acsCleint
        $profile = \DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient = new \DefaultAcsClient($profile);
        $request = new \Dysmsapi\Request\V20170525\SendSmsRequest;
        //必填-短信接收号码
        $request->setPhoneNumbers($mobileNum);
        //必填-短信签名
        $request->setSignName($smsFreeSignName);
        //必填-短信模板Code
        $request->setTemplateCode($smsTemplateCode);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam(json_encode($smsParam));
        //选填-发送短信流水号
        //$request->setOutId("");//可忽略
        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);
        //当前步骤是返回和阿里大鱼相同的格式信息
        if($acsResponse->Code == 'OK'){
            $acsResponse->result =(object)array();
            $acsResponse->result->err_code ='0';
        }
        return $acsResponse;
    }

    //获取短信验证码发送
    public function codeSend($mobileNum, $smsParam, $smsTemplateCode = '', $smsFreeSignName = ''){
        //默认使用短信身份验证模板和签名
        $smsTemplateCode = empty($smsTemplateCode) ? SiteSms::get('smsTemplateCode') : $smsTemplateCode;
        $smsFreeSignName = empty($smsFreeSignName) ? SiteSms::get('smsFreeSignName') : $smsFreeSignName;
        return  $this->send($mobileNum,$smsParam,$smsTemplateCode,$smsFreeSignName);
    }
}