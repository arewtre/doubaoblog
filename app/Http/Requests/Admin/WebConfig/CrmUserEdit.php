<?php

namespace App\Http\Requests\admin\WebConfig;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CrmUserEdit extends Request{
    public function authorize(){
        return true;
    }
    public function rules(){
        $input = $this->all();
        return [
            'name'=>'required|min:2|max:20',
            'worker_name'=>'required|min:2|max:20',
            'qq'=>'min:5|integer',
            'mobile'=>'digits:11',
            'email'=>'email',
        ];
    }
    public function messages(){
        return [
            'name.required'=>'账号不能为空',
            'name.min'=>'账号最短2个字符',
            'name.max'=>'账号最多20个字符',
            'worker_name.required'=>'员工姓名不能为空',
            'worker_name.min'=>'员工姓名最短2个字符',
            'worker_name.max'=>'员工姓名最多20个字符',
            'qq.min'=>'QQ格式为纯数字',
            'qq.integer'=>'QQ格式为纯数字',
            'mobile.digits'=>'手机号格式不对exp:13123456789',
            'email.email'=>'邮箱格式不对',
            'email.max'=>'邮箱最多60个字符',
        ];
    }
}
