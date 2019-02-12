<?php

namespace App\Http\Requests\Admin\WebConfig;
use App\Http\Requests\Request;

class WebconfigRequest extends Request{
    public function authorize(){
        return true;
    }
    public function rules(){
        $input = $this->all();
        return [
            'webname'=>'max:60',
            'webtitle'=>'max:250',
            'webkey'=>'max:250',
            'webdescribe'=>'max:250',
            'webicp'=>'max:60',
            'webother'=>'max:250',
        ];
    }
    public function messages(){
        return [
            'webname.max'=>'网站名称字数最多60个字',
            'webtitle.max'=>'网站标题字数最多250个字',
            'webkey.max'=>'网站关键字最多250个字',
            'webdescribe.max'=>'网站关键字最多250个字',
            'webicp.max'=>'ICP备案信息最多60个字',
            'webother.max'=>'其它信息最多250个字',
        ];
    }
}
