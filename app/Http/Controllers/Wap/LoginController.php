<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use App\Http\Model\Cw;
use App\Http\Model\Openid;
use Illuminate\Support\Facades\Crypt;
require_once 'resources/org/qqlogin/Qqconnect.class.php';
class LoginController extends CommonController
{
    public function login(Request $request){
        if(is_ajax()){
            $input = $request->all();
            $user = Member::where('username',$input['username'])->first();
            //pre($input);
            $data['url'] = url()->previous();
            if($user->username != $input['username'] || Crypt::decrypt($user->password)!= $input['password']){
                $data = [
                'code' => 0,
                'msg' => '用户名或者密码错误！',
                ];
                return response()->json($data);
                exit;
            }
            \Session::set('userinfo',$user); 
            \Session::save();
            if(session("qq_openid")){
                $da['qq_openid'] = session("qq_openid");
                $da['uid'] = $user->id;
                Openid::create($da);
            }
            $data = [
                'code' => 1,
                'msg' => '登录成功！',
                ];
                return response()->json($data);
                exit;
        }
        if(!empty(session('userinfo'))){
           return redirect('wap');
           exit; 
        }
        \Session::set('preUrl',url()->previous()); 
        \Session::save();
//        $cw = Cw::where('status',1)->get();
        return view("wap.login.login");
    }
    public function qq_login(){
        $Qqconnect = new \Qqconnect();
	$Qqconnect->getAuthCode();
    }
    
    public function qqLoginCallback(){
        //pre();
        $Qqconnect = new \Qqconnect();
        $qq_openid = $Qqconnect->getOpenId();
        $qq = session('qq');
        $map = array();
        $map['qq_openid'] = $qq_openid;
        $res = Member::where("qq_openid",$qq_openid)->first(); 
        $data['loginip'] = get_client_ip(0);
        if(!empty($res)){
            $userInfo = $Qqconnect->getInfo($qq['openid'],$qq['access_token']);
            $data['prevtime'] = $res['updated_at'];
            $data['nickname'] = $userInfo['nickname'];
            $data['address'] = $userInfo['province']."-".$userInfo['city'];
            $data['userface'] = $userInfo['figureurl_qq_1'];
            Member::where("qq_openid",$qq_openid)->update($data);
            $qq['nickname'] = $res['nickname'];
            $qq['userface'] = $res['userface'];
            \Session::set('userinfo',$res); 
            \Session::save();
            if(session("qq_openid")){
                $da['qq_openid'] = session("qq_openid");
                $da['uid'] = $res->id;
                Openid::create($da);
            }
            return redirect(session('preUrl'));
        }else{
            $userInfo = $Qqconnect->getInfo($qq['qq_openid'],$qq['access_token']);
            //pre($userInfo);
            $data['joinip'] = get_client_ip(0);
            $data['qq_openid'] = $qq['qq_openid'];
            $data['nickname'] = $userInfo['nickname'];
            $data['address'] = $userInfo['province']."-".$userInfo['city'];
            $data['userface'] = $userInfo['figureurl_qq_1'];
            $userInfo['gender']=='男'? $data['sex']= 1:$data['sex']=0;
            Member::create($data);
            $res = Member::where("qq_openid",$qq_openid)->first(); 
            \Session::set('userinfo',$res); 
            \Session::save();
            if(session("qq_openid")){
                $da['qq_openid'] = session("qq_openid");
                $da['uid'] = $res->id;
                Openid::create($da);
            }
            return redirect(session('preUrl'));
            exit;
        }
    }
    
    public function loginSetUname(Request $request){
        if(is_ajax()){
            $input = $request->all();
            $userinfo = session('userinfo');
            $input['password'] = Crypt::encrypt($input['password']);
            Member::where('qq_openid',$userinfo['qq_openid'])->update($input);
        }
        return view("home.login.loginSetUname");
        
    }
    
    public function logout(Request $request){
        \Session::set('userinfo',null); 
        \Session::save();
        if(session("qq_openid")){
            Openid::where("qq_openid",session("qq_openid"))->delete();
        }
        return redirect('/');
        exit;
    }
}
