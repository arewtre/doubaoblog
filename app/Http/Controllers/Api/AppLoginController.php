<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use App\Http\Model\Openid;
use Illuminate\Support\Facades\Crypt;
use View;
use Cache;
use DB;
class AppLoginController extends CommonController
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
    public function index(Request $request)
    {

        $userinfo = $this->login($request->username,$request->password);
        // 生成token (session3rd)
        $this->token = $this->token($userinfo->id);
        $data['userinfo'] = $userinfo;
        $data['userinfo']['token'] = $this->token;
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
     * 登录
     * @param $username $password
     * @return string
     */
    private function login($username, $password)
    {
        $user = Member::select()
            ->where('username',$username)
            ->first();
        if(!$user){
            return $this->error(array('msg' =>"用户名不存在!"));
        }else{
            if(Crypt::decrypt($user->password)!= $password){
                return $this->error(array('msg' =>"密码不正确!"));
            }
        }
        return $user;
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
