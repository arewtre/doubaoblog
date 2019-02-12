<?php

namespace App\Http\Requests\Admin\WebConfig;
use App\Http\Requests\Request;

class WebconfigCatetroyRequest extends Request{
    public function authorize(){
        return true;
    }
    public function rules(){
        return [
            'describe'=>'required|max:60'
        ];
    }
    public function messages(){
        return [
            'describe.required'=>'标签不能为空',
            'describe.max'=>'类别名称最多60个字符'
        ];
    }
}
