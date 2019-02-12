<?php

namespace App\Http\Requests\Admin\WebConfig;
use App\Http\Requests\Request;

class WebconfigMake extends Request{
    public function authorize(){
        return true;
    }
    public function rules(){
        $input = $this->all();
        return [
            'sign'=>'required|max:60',
            'keyname'=>'required|max:60',
            'keyvalue'=>'max:2000',
            'tip'=>'max:60',
            'type'=>'max:60',
        ];
    }
    public function messages(){
        return [
            'sign.required'=>'标签不能为空',
            'sign.max'=>'标签字数最多60个字',
            'keyname.required'=>'标签中文不能为空',
            'keyname.max'=>'标签中文最多60个字',
            'keyvalue.max'=>'标签内容最多250个字',
            'tip.max'=>'解释信息最多60个字',
            'type.max'=>'类型最多60个字',
        ];
    }
}
