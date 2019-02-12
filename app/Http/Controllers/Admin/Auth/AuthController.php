<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Models\Admin\AdminUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;

class AuthController extends Controller{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    //登录以后跳转到什么位置
    protected $redirectTo = '/admin';
    //退出以后跳转到什么位置
    protected $redirectAfterLogout = '/';
    protected $guard = 'admin';
    protected $loginView = 'default.admin.auth.login';
    protected $registerView = 'default.admin.auth.register';
    //使用用户名登录后台
    protected $username = 'name';

    /**
     * 除了退出其它多要自动验证
     * AuthController constructor.
     */
    public function __construct(){
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    /**
     * 前台登录验证方法
     * @param Request $request
     */
    protected function validateLogin(Request $request){
        $message = [
            $this->loginUsername().'.required' => '用户名称必须填写',
            $this->loginUsername().'.alpha_dash' => '用户仅允许字母、数字、底线_',
            $this->loginUsername().'.max' => '用户名称最多32个字符',
            'password.required' => '密码必须填写',
            'code.required' =>'验证码不能为空！',
            'code.captcha' => '验证码错误，请重新输入！',
        ];
        $this->validate($request, [
            $this->loginUsername() => 'required|alpha_dash|max:32',
            'password' => 'required',
            'code' => 'required|captcha'
           
        ],$message);
    }

    /**
     * 判断前台是不是登录成功
     * @return string
     */
    protected function getFailedLoginMessage(){
        return '账号或密码错误';
    }


}
