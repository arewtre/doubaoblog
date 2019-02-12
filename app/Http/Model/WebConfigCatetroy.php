<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Cache,Validator;

class WebConfigCatetroy extends Model{
    //后台网站配置模块
    protected $table = 'web_config_categroy';
    //设置主键值
    protected $fillable = ['describe'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}