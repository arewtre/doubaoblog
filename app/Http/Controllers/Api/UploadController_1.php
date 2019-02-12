<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;

class UploadController extends CommonController
{
    
    
    public function index(Request $request){
        
        //echo 1;die;
        $Path = "/uploads/images/";
        if (!empty($_FILES['file'])) {
            //获取扩展名
            $exename = $this->getExeName($_FILES['file']['name']);
            if ($exename != 'png' && $exename != 'jpg' && $exename != 'gif') {
                exit('不允许的扩展名');
            }
            $fileName = $_SERVER['DOCUMENT_ROOT'] . $Path . date('Ym');//文件路径
            $upload_name = '/img_' . date("YmdHis") . rand(0, 100) . '.' . $exename;//文件名加后缀
            if (!file_exists($fileName)) {
                //进行文件创建
                mkdir($fileName, 0777, true);
            }
            $imageSavePath = $fileName . $upload_name;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $imageSavePath)) {
                echo asset('public'.$Path . date('Ym') . $upload_name);
            } 
        }
    }
    
    public function getExeName($fileName)
    {
        $pathinfo = pathinfo($fileName);
        return strtolower($pathinfo['extension']);  
    } 
    
  
}
