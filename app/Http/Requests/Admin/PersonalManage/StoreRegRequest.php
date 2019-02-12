<?php

namespace App\Http\Requests\Admin\PersonalManage;
use App\Http\Requests\Request;

class StoreRegRequest extends Request{
    public function authorize(){
        return true;
    }
    public function rules(){
        return [
            //'username' => 'required|alpha_dash|isset_username:'.$this->uid,
            'username' => 'required',
            'password'=>'required',
            'email'=>'email',
            'mobile'=>'mobile_verification',
        ];
    }
    public function messages(){
        return [
            'username.required' => '用户名必须填写',
            //'username.alpha_dash' => '用户可允许字母、数字、破折号（-）以及底线（_）',
            //'username.isset_username' => '用户名以及经存在,或者手机号码和用户名相同',
            'password.required' => '密码必须填写',
            'email.required' => '邮箱必须填写',
            'email.email'=>'请输入一个正确的邮箱！',
            'mobile.mobile_verification'=>'请输入一个正确的手机号码！',
        ];
    }
}
