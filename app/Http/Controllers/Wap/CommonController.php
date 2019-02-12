<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Model\BlogCategory;
use App\Http\Model\NewsCategory;
use App\Http\Model\Openid;
use DB;
require_once 'resources/org/wechat/wxaccount.class.php'; 
class CommonController extends Controller
{
    
    public function __construct()
    {
        clientlog();
        
        $cates = BlogCategory::where("is_display",1)
                ->where("level",1)
                ->orderby("descid","desc")
                ->get();
        $ncate = NewsCategory::where("is_display",1)
                ->where("level",1)
                ->orderby("descid","desc")
                ->get();
       $wxaccount = new \wxaccount();
       $signPackage = $wxaccount->getJssdkConfig();
       if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $openid = session("openid");
            if(empty($openid)){         
                 if(!isset($_GET['code'])){
                      $url1 = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                      $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx51dab5a008d7aea6&redirect_uri='.urlencode($url1).'&response_type=code&scope=snsapi_base&state=wx'.'#wechat_redirect';
                      header("Location:".$url);
                 }else{
                     //if(session("userinfo.id")==1){
                          $openinfo = $wxaccount->getOpenid($_GET['code']);
                          if(!empty($openinfo->openid)){
                             \Session::set('openid',$openinfo->openid); 
                             \Session::save();
                             $uu = Openid::select("*")
                                   ->join('member', 'member.id', '=', 'openid.uid')
                                  ->where("openid.openid",$openinfo->openid)
                                  ->first();
                             if($uu){
                                \Session::set('userinfo',$uu); 
                                \Session::save();
                             }
                          }
                     //}
                 }
            }
       }
       //pre($GLOBALS['signPackage']);
        View::share('cates',$cates);
        View::share('ncate',$ncate);
        View::share('signPackage',$signPackage);
    }
}
