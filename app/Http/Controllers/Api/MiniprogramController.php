<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use View;
use App\Http\Model\News;
use App\Http\Model\Adv;
use App\Http\Model\WebConfig;
use Site,Cache;
//require_once 'resources/miniprogram/wxBizMsgCrypt.php';
class MiniprogramController extends CommonController
{
    public function __construct(){
        
        parent::__construct();
        
    }
    
    public function index(Request $request)
    {
        //echo 1;die;
//        $signature = $request->signature;
//	$timestamp = $request->timestamp;
//	$nonce = $request->nonce;
//	$token = "doudoubao";
//	$tmpArr = array($token, $timestamp, $nonce);
//	sort($tmpArr, SORT_STRING);
//	$tmpStr = implode( $tmpArr );
//	$tmpStr = sha1( $tmpStr );
//	if( $tmpStr == $signature ){
//		return 1;
//	}else{
//		return 0;
//	} 
        $adv = Adv::select('ad_slots.height','ad_slots.width','ad_manage.id','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","P1")
                ->where("ad_manage.status",1)
                ->where('ad_manage.created_at', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        foreach($adv as $v){
            $v['pic_url'] = "https://".$_SERVER["HTTP_HOST"].$v['pic_url'];
        }
        return response()->json($adv);
    }
    
    /*
    *登录（调用wx.login获取）
    * @param $code string
    * @param $rawData string
    * @param $signatrue string
    * @param $encryptedData string
    * @param $iv string
    * @return $code 成功码
    * @return $session3rd 第三方3rd_session
    * @return $data 用户数据
   */  
    public function login()  {
        //开发者使用登陆凭证 code 获取 session_key 和 openid   $APPID = '';
        //自己配置   $AppSecret = '';
        //自己配置   $code = input('code');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $APPID . "&secret=" . $AppSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $arr = $this->vget($url); // 一个使用curl实现的get方法请求   $arr = json_decode($arr, true);
        $openid = $arr['openid'];
        $session_key = $arr['session_key'];
        // 数据签名校验   $signature = input('signature');
        $rawData = Request::instance()->post('rawData');
        $signature2 = sha1($rawData . $session_key);
        if ($signature != $signature2) {
         return json(['code' => 500, 'msg' => '数据签名验证失败！']);
        }
        Vendor("PHP.wxBizDataCrypt"); //加载解密文件，在官方有下载   $encryptedData = input('encryptedData');
        $iv = input('iv');
        $pc = new \WXBizDataCrypt($APPID, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $data); //其中$data包含用户的所有数据   $data = json_decode($data);
        if ($errCode == 0) {
         dump($data);
         die;//打印解密所得的用户信息   } else {
         echo $errCode;//打印失败信息   }
       }
    }
    public function vget($url){
     $info=curl_init();
     curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
     curl_setopt($info,CURLOPT_HEADER,0);
     curl_setopt($info,CURLOPT_NOBODY,0);
     curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
     curl_setopt($info,CURLOPT_URL,$url);
     $output= curl_exec($info);
     curl_close($info);
     return $output;
   }
   
   
   public function onLogin(Request $request){
       $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxb73f46cea17e1d7f&secret=ace3e213f7b8fcf2a6b9dcf26a72575e&js_code=".$request->code."&grant_type=authorization_code";
   
       $response = $this->vget($url);
       echo $response;
   }
   
   public function getConfig(){
       $config =Site::getAll();
       return $this->success($config);
   }
    
}
