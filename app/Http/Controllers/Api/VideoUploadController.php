<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Model\Upload;
use App\Http\Model\Images;
use Storage;
use App\Http\Requests;
use Site;
require_once 'resources/org/Qiniu/QiniuStorage.class.php';
class VideoUploadController extends CommonController
{
    public function __construct() {
        parent::__construct();
        $config = array(
            'accessKey'=>Site::get("qiniu_ak"),
            'secretKey'=>Site::get("qiniu_sk"),
            'bucket'=>Site::get("qiniu_video_bucket"),
            'domain'=>Site::get("qiniu_video_domain")
        );
        $this->qiniu = new \QiniuStorage($config);
    }
    
    
    //上传单个文件 用uploadify
    public function addVideo(Request $request){
        //pre($request->all());
        $file = $_FILES['video'];
        //pre($file);
        $arr=explode(".", $file['name']);
        $file = array(
            'name'=>'file',
            'fileName'=>time().rand().".".$arr[count($arr)-1],
            'fileBody'=>file_get_contents($file['tmp_name'])
        );
        $config = array();
        $result = $this->qiniu->upload($config, $file);
         //$this->qiniu->error,
         //$this->qiniu->errorStr
        //pre($this->qiniu->errorStr);
        //$data['image_url']= "http://oiwban6zi.bkt.clouddn.com/".$result['key'];
        return response()->json(array('error' => 0, 'url' => "http://".Site::get("qiniu_video_domain").'/'.$result['key']));
    }  
    //上传单个文件 用uploadify
    public function addimage(Request $request){
        $file = $_FILES['file'];
        $arr=explode(".", $file['name']);
        $file = array(
            'name'=>'file',
            'fileName'=>time().rand().".".$arr[count($arr)-1],
            'fileBody'=>file_get_contents($file['tmp_name'])
        );
        $config = array();
        $result = $this->qiniu->upload($config, $file);
        if(isset($result['key']) && !empty($result['key'])){
//            $files = $request->file;
            $data['image_url'] = "http://".Site::get("qiniu_image_domain").'/'.$result['key'];
            
            $data['name'] = $request->file->getClientOriginalName();
            //扩展名
            $data['ext'] = $request->file->getClientOriginalExtension();
            //文件类型
            $data['type'] = $request->file->getClientMimeType();
            //临时绝对路径
            $data['realPath'] = $request->file->getRealPath();
            //文件大小
            $data['size'] = $request->file->getClientSize();
            $data['cat_id'] = $request->xc_id;
           Images::create($data); 
        }
        return response()->json(array('code' => 1, 'src' => "http://".Site::get("qiniu_image_domain").'/'.$result['key']));
    }  
    public function delqiniu($file){
        $file = explode("/",$file);
        //print_r($file);
        $result = $this->qiniu->del($file[3]);
        ///pre($this->qiniu->errorStr);
        //pre($result);
//        if($result){                        
//            return true;
//        }else{
//            return false;
//        }
    }
}
