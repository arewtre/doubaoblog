<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Model\Upload;
use Storage;
use App\Http\Requests;

class UploadController extends CommonController
{
    
    
    public function index(Request $request){
        
        pre($request->all());
        $file = $request->file('imgFile'); 
        //判断文件是否上传成功
        if($file->isValid()){
            //获取原文件名
            $input['name'] = $file->getClientOriginalName();
            //扩展名
            $input['ext'] = $file->getClientOriginalExtension();
            //文件类型
            $input['type'] = $file->getClientMimeType();
            //临时绝对路径
            $realPath = $file->getRealPath();
            //文件大小
            $input['size'] = $file->getClientSize();
            $filename = date('YmdHiS').'_'.uniqid().'.'.$input['ext'];
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            return response()->json(array('error' => 0, 'url' => $path));
            exit;
        }
    }
  
}
