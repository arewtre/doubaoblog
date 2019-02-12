<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use App\Http\Model\Openid;
use Illuminate\Support\Facades\Crypt;
use View;
use Cache;
use DB;
class LoginController extends CommonController
{
    private $user;
    private $appid;
    private $appsecret;
    
    public function __construct(){
        parent::__construct();
        $this->appid = "wxb73f46cea17e1d7f";
        $this->appsecret = "ace3e213f7b8fcf2a6b9dcf26a72575e";
    }
    
    
    public function test(){
        
        pre(getAccessToken());
        
    }
    
    /**
     * 用户登录
     * @param array $post
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login(Request $request)
    {
        // 微信登录 获取session_key
        $session = $this->wxlogin($request->code);
        // 自动注册用户
        $userInfo = json_decode(htmlspecialchars_decode($request->user_info), true);        
        $user_id = $this->register($session['openid'], $userInfo);
        // 生成token (session3rd)
        $this->token = $this->token($session['openid']);
        // 记录缓存, 7天
        //\Cache::put($this->token, $session, 10);
        //\Cache::forever("token",$this->token);
        $data['uid'] = $user_id;
        $data['token'] = $this->token;
        $da['openid'] = $session['openid'];
        $da['nickname'] = $userInfo['nickName'];
        $da['systemInfo'] = $request->systemInfo;
        sendMsgByLogin($request->formId,$da);
        return $this->success($data);
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function wxlogin($code)
    {
        // 微信登录 (获取session_key)
        $session = getSessionKey($code,$this->appid, $this->appsecret); 
        if (!$session){
            return $this->success(['code' => '-1','msg' => 'session_key 获取失败']);
        }
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        return md5($openid . 'token_salt');
    }

    /**
     * 自动注册用户
     * @param $open_id
     * @param $userInfo
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function register($open_id, $userInfo)
    {
        $user = Member::select()
                   ->join('openid', 'openid.uid', '=', 'member.id')
                   ->where('openid.openid',$open_id) 
                   ->first();
        
        //pre($user);
        if (!$user) {           
            $d['nickname'] = $userInfo['nickName'];
            $d['username'] = $userInfo['nickName'];
            $d['sex'] = $userInfo['gender'];
            $d['address'] = $userInfo['province']."-".$userInfo['city'];
            $d['userface'] = $userInfo['avatarUrl'];
            $d['password'] = Crypt::encrypt(123456);
            $d['joinip'] = get_client_ip(0);
            Member::create($d);
            $id = DB::getPdo()->lastInsertId();
            $da['uid'] = $id;
            $da['openid'] = $open_id;
            Openid::create($da);
            return $id;
        }else{
            $d['loginip'] = get_client_ip(0);
            $d['logintimes'] = $user->logintimes + 1;
            $d['prevtime']= $user->updated_at;
             Member::where('id',$user->uid)->update($d);
        }
        
        return $user->uid;
        
    }

    
}
