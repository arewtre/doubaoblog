<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use Illuminate\Support\Facades\Crypt;
require_once 'resources/org/qqlogin/Qqconnect.class.php';
require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
    public function login(Request $request){
        
        if(is_ajax()){ 
             $code = new \Code;
             $_code = $code->get();
             $input = $request->all();
             if(strtoupper($input['vcode'])!=$_code){
                    //return back()->with('msg','验证码错误！');
                $data = [
                'code' => 0,
                'msg' => '验证码错误！',
                ];
                return response()->json($data);
                exit;
            }
            $input = $request->all();
            $user = Member::where('username',$input['username'])->first();
            //pre(Crypt::decrypt($user->password));
            if($user->username != $input['username'] || Crypt::decrypt($user->password)!= $input['password']){
                $data = array(
                'code' => 0,
                'msg' => '用户名或者密码错误！',
                );
                return response()->json($data);
                exit;
            }
            if($user->status ==0){
                $data = array(
                'code' => 0,
                'msg' => '您的账户因违规已被禁用！',
                );
                return response()->json($data);
                exit;
            }
            \Session::set('userinfo',$user); 
            \Session::save();
            $dat['prevtime'] = $user->updated_at;
            Member::where("id",$user->id)->update($dat);
            $data = array(
                'code' => 1,
                'msg' => '登录成功！',
                'url' => session('prevurl')
                );
                return response()->json($data);
                exit;
         }
         if(!empty(session('userinfo'))){
             return redirect('/');
         }
         //$prevurl =  url()->previous();
         \Session::set('prevurl',url()->previous()); 
         \Session::save();
        return view("home.login.login");
    }
    
    public function qq_login(){
        \Session::set('qqprevurl',url()->previous()); 
        \Session::save();
        //pre(session('qqprevurl'));
        //pre(session('userinfo'));
        $Qqconnect = new \Qqconnect();
	$Qqconnect->getAuthCode();
    }
    
    
    public function qqLoginCallback(){
        //pre();
        $Qqconnect = new \Qqconnect();
        $qq_openid = $Qqconnect->getOpenId();
        //pre(session('qq'));
        $qq = session('qq');
        $map = array();
        $map['qq_openid'] = $qq_openid;
        $res = Member::where("qq_openid",$qq_openid)->first(); 
        $userInfo = $Qqconnect->getInfo($qq['openid'],$qq['access_token']);
        
        $userInfo['qq_openid'] = $qq_openid;
        if(!empty($res['username'])){
            $data['prevtime'] = $res['updated_at'];
            $data['loginip'] = get_client_ip(0);
            $data['nickname'] = $userInfo['nickname'];
            $data['address'] = $userInfo['province']."-".$userInfo['city'];
            $data['userface'] = $userInfo['figureurl_qq_2'];
            Member::where("qq_openid",$qq_openid)->update($data);
            $qq['nickname'] = $res['nickname'];
            $qq['userface'] = $res['userface'];
            \Session::set('userinfo',$res); 
            \Session::save();
            //pre(session('userinfo.nickname'));
            return redirect(session('qqprevurl'));
        }else{

            \Session::set('qquserinfo',$userInfo); 
            \Session::save();
            
            return redirect('loginSetUname');
            //exit;
        }
    }
    
    public function loginSetUname(Request $request){
        if(is_ajax()){
            $input = $request->all();
            $userInfo = session('qquserinfo');
            if($input['type']==1){//创建新的用户
                $user = Member::where('username',$input['newusername'])->first();
                if($user){
                  $data = array(
                    'code' => 0,
                    'msg' => '该账号已存在！',                    
                    );
                    return response()->json($data);
                    ///exit;  
                }
                if($input['newpassword']!=$input['confirmpassword']){
                   $data = array(
                    'code' => 0,
                    'msg' => '两次输入的密码不一致！',                    
                    );
                    return response()->json($data);
                    //exit; 
                }
                
                $data['username'] = $input['newusername'];
                $data['password'] = Crypt::encrypt($input['newpassword']);
                $data['joinip'] = get_client_ip(0);
                $data['loginip'] = get_client_ip(0);
                $data['qq_openid'] = $userInfo['qq_openid'];
                $data['nickname'] = $userInfo['nickname'];
                $data['address'] = $userInfo['province']."-".$userInfo['city'];
                $data['userface'] = $userInfo['figureurl_qq_1'];
                $userInfo['gender']=='男'? $data['sex']= 1:$data['sex']=0;
                $result = Member::create($data); 
                $res = Member::where("qq_openid",$userInfo['qq_openid'])->first(); 
                \Session::set('userinfo',$res); 
                \Session::save();
                if($result){
                    $data = array(
                    'code' => 1,
                    'msg' => '账号创建成功！',
                    'url' =>session('qqprevurl')
                    );
                    return response()->json($data);
                    //exit;
                }
            }else{
                $user = Member::where('username',$input['oldusername'])->first();
                if(!empty($user->qq_openid)){
                   $data = array(
                    'code' => 0,
                    'msg' => '该账户已绑定QQ！',
                    );
                    return response()->json($data);
                   // exit; 
                }
                
                if($user->username != $input['oldusername'] || Crypt::decrypt($user->password)!= $input['oldpassword']){
                    $data = array(
                    'code' => 0,
                    'msg' => '用户名或者密码错误！',
                    );
                    return response()->json($data);
                    //exit;
                }
                if($user->status ==0){
                    $data = array(
                    'code' => 0,
                    'msg' => '您的账户因违规已被禁用！',
                    );
                    return response()->json($data);
                    //exit;
                }
                $data['prevtime'] = $user->updated_at;
                $data['qq_openid'] = $userInfo['qq_openid'];
                $data['nickname'] = $userInfo['nickname'];
                $data['loginip'] = get_client_ip(0);
                $data['address'] = $userInfo['province']."-".$userInfo['city'];
                $result = Member::where('id',$user->id)->update($data);
                $res = Member::where("qq_openid",$userInfo['qq_openid'])->first(); 
                \Session::set('userinfo',$res); 
                \Session::save();
                if($result){
                    $data = array(
                    'code' => 1,
                    'msg' => '绑定成功！',
                    'url' =>session('qqprevurl')
                    );
                    return response()->json($data);
                    //exit;
                }
            }

        }
        //pre(session()->all());
        if(!empty(session('userinfo.username'))){
             return redirect('/');
        }
        return view("home.login.loginSetUname");
        
    }
    
    public function logout(Request $request){
        \Session::set('userinfo',null); 
        \Session::save();
        return redirect('/');
        exit;
    }
}
