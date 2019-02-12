<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(Request $request)
    {
        
        //pre(session('user'));
        if(session('user')){
            return redirect('admin/');
        }
        
        if(is_ajax()){
            $code = new \Code;
            $_code = $code->get();
            $input = $request->all();
            if(strtoupper($input['code'])!=$_code){
                $data = [
                'code' => 0,
                'msg' => '验证码错误！',
                ];
                return response()->json($data);
                exit;
            }
            $user = User::where("user_name",$input['user_name'])->first();
            if(empty($user ) || Crypt::decrypt($user->user_pass)!= $input['user_pass']){
                $data = [
                'code' => 0,
                'msg' => '用户名或者密码错误！',
                ];
                return response()->json($data);
                exit;
            }
            \Session::set('user',$user); 
            \Session::save();
            //return redirect('admin/index');
            $data = [
                'code' => 1,
                'msg' => '登录成功！',
                ];
                return response()->json($data);
                exit;
        }else {
            return view('admin.login');
        }
    }

    public function logout()
    {
        session(['user'=>null]);
        if(session('user')==""){
            $data = [
                'code' => 1,
                'msg' => '退出成功！',
            ];
            return response()->json($data);
            exit;
        }
        
        //return redirect('admin/login');
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }
    
    

}
