<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Cache,Validator;

class WebConfig extends Model{
//后台网站配置模块
    protected $table = 'web_config';
    //设置主键值
    protected $fillable = [
        'id', 'sign', 'keyname', 'keyvalue', 'tip', 'type','categroy','sort'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static $config='';

    public static function getAll(){
        return self::where("status",1)->orderBy('categroy')->orderBy('sort')->get()->toArray();
    }

    public static function getConfig($name){
        if(empty(self::$config)) {
            if (Cache::has('config')) {
                self::$config = Cache::get('config');
            } else {
                $array=array();
                foreach(self::all() as $key=>$value){
                    $array[$value->sign]=$value->keyvalue;
                }
                self::$config =$array;
                Cache::forever('config', self::$config);
            }
        }
        return isset(self::$config[$name]) ? self::$config[$name]: '' ;//判断字符串长度大于0代表有填写
    }
    public static function checkSign($sign){
        return self::select('sign')->where('sign',$sign)->take(1)->get();
    }
}