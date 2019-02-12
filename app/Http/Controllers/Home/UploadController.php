<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Upload;
use Storage;
use App\Http\Requests;
use Site;
require_once 'resources/org/Qiniu/QiniuStorage.class.php';
class UploadController extends CommonController
{
    public function __construct() {
        parent::__construct();
        $config = array(
            'accessKey'=>Site::get("qiniu_ak"),
            'secretKey'=>Site::get("qiniu_sk"),
            'bucket'=>Site::get("qiniu_image_bucket"),
            'domain'=>Site::get("qiniu_image_domain")
        );
        $this->qiniu = new \QiniuStorage($config);
    }
    public function index()
    {
        //pre($input);
        return view('admin.index');
    }
    
    
    public function add(Request $request){
        
        $file = $request->file('imgFile'); 
        //pre($file); 
        //判断文件是否上传成功
//        if($file->isValid()){
//            //获取原文件名
//            $input['name'] = $file->getClientOriginalName();
//            //扩展名
//            $input['ext'] = $file->getClientOriginalExtension();
//            //文件类型
//            $input['type'] = $file->getClientMimeType();
//            //临时绝对路径
//            $realPath = $file->getRealPath();
//            //文件大小
//            $input['size'] = $file->getClientSize();
//            $filename = date('YmdHiS').'_'.uniqid().'.'.$input['ext'];
//            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
//            $input['url'] = "/public/uploads/images/".$filename;
//            $path = 'http://'.$_SERVER['SERVER_NAME'].$input['url'];
//            $input['addtime'] = date("Y-m-d H:i:s");
//            $input['uid'] = 1;
//            //pre($input);
//            Upload::create($input);
//            return response()->json(array('error' => 0, 'url' => $path));
//            exit;
//        }
        $Path = "/uploads/images/";
        
        if (!empty($_FILES['imgFile'])) {
            //获取扩展名
            $exename = $this->getExeName($_FILES['imgFile']['name']);
            if ($exename != 'png' && $exename != 'jpg' && $exename != 'gif') {
                exit('不允许的扩展名');
            }
            //$fileName = $_SERVER['DOCUMENT_ROOT'] . $Path . date('Ym');//文件路径
            $fileName = $_SERVER['DOCUMENT_ROOT'] . $Path . session("userinfo.id");//文件路径
            $upload_name = '/img_' . date("YmdHis") . rand(0, 100) . '.' . $exename;//文件名加后缀
            if (!file_exists($fileName)) {
                //进行文件创建
                mkdir($fileName, 0777, true);
            }
            $imageSavePath = $fileName . $upload_name;
            $url = $Path . session("userinfo.id").$upload_name;
            if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $imageSavePath)) {
                return response()->json(array('error' => 0, 'url' => $url));
            } 
        }
    }
    public function getExeName($fileName)
    {
        $pathinfo = pathinfo($fileName);
        return strtolower($pathinfo['extension']);  
    } 
/**
     * 删除图片
     * @author  九月一十八
     */
    public function del(Request $request) {
        $url = $request->get('pic');
        $delurl = ".".$url;
        if ($this->file_delete($delurl)) {
            Upload::where('url',$url)->delete();
            echo 1;
        } else {
            echo 0;
        }
    }
    /**
     * 删除文件
     * @author  九月一十八
     */
    public function file_delete($file) {
        if (empty($file)) {
            return FALSE;
        }
        if (file_exists($file)) {
            unlink($file);
        }
        return TRUE;
    }
    
    /**
     * 管理文件列表
     * @author  九月一十八
     */
    public function manage(){
        //根目录路径，可以指定绝对路径，比如 /var/www/attached/
        $root_path =  IA_ROOT . '/uploads/images/'.session("userinfo.id").'/';
        //print_r($root_path);die;
        //根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
        $root_url =  '/uploads/images/'.session("userinfo.id").'/';
        $root_u = 'uploads/images/'.session("userinfo.id").'/'; 
        //图片扩展名
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        //目录名
        $dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
        if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
            echo "Invalid Directory name.";
            exit;
        }   
        //根据path参数，设置各路径和URL
        if (empty($_GET['path'])) {
            $current_path = $root_path;
            $current_url = $root_url;
            $current_u = $root_u;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . '/' . $_GET['path'];
            $current_url = $root_url . $_GET['path'];
            $current_u = $root_u. $_GET['path'];
            $current_dir_path = $_GET['path'];
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }

        //排序形式，name or size or type
        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
    
        //不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit;
        }
        //最后一个字符不是/
        if (!preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit;
        }
        //目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit;
        }
    
        //遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.') continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
        }
       //pre($file_list) ;
        //\usort($file_list, 'cmp_func');
        \usort($file_list, array($this, 'cmp_func'));
        //$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));    
        //$siteroot = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].base_path()); 
        $siteroot = 'http://'.$_SERVER['SERVER_NAME'];
        $result = array();   
        //相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        //相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        //当前目录的URL
        $result['current_url'] =  $siteroot."/".$current_u;
        //$result['current_url'] = $current_u;
        //文件数
        $result['total_count'] = count($file_list);
        //文件列表数组
        $result['file_list'] = $file_list;
        //输出JSON字符串
        //pre($result);
        return response()->json($result);
    }
    
    //排序
    public function cmp_func($a, $b) {
        global $order;
        if ($a['is_dir'] && !$b['is_dir']) {
            return -1;
        } else if (!$a['is_dir'] && $b['is_dir']) {
            return 1;
        } else {
            if ($order == 'size') {
                if ($a['filesize'] > $b['filesize']) {
                    return 1;
                } else if ($a['filesize'] < $b['filesize']) {
                    return -1;
                } else {
                    return 0;
                }
            } else if ($order == 'type') {
                return strcmp($a['filetype'], $b['filetype']);
            } else {
                return strcmp($a['filename'], $b['filename']);
            }
        }
    }
    
    
    public function addqiniu(Request $request){
        //pre($_FILES);
        $file = $_FILES['imgFile'];
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
        return response()->json(array('error' => 0, 'url' => "http://".Site::get("qiniu_image_domain").'/'.$result['key']));
    } 
}
