<?php
namespace App\Repositories\Eloquent;

use App\Facades\Site as SiteFacades;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Hash;

class CustomPassword implements HasherContract{
    /**
     * 是将用户登录的密码进行加密
     * 加密方式
     * @作者 柯良志CustomPassword::make()
     * @date   2016-8-24
     * @param  [type]                   $value   [description]
     * @param  array $options [description]
     */
    public function make($value, array $options = array()){
        switch(SiteFacades::get('hasher')){
            case "md5":
                return md5($value);
                break;
            case "md5_c16":
                return substr(md5($value), 8, 16);
                break;
            case "bcrypt":
                return Hash::make($value, $options);
                break;
            default:
                exit('密码加密方式设置不正确可选 bcrypt 或 md5!');
                break;
        }
    }

    /**
     * 是将用户登录的密码和数据库中的密码进行对比
     * 验证方法
     * @作者 柯良志
     * @date   2016-8-24
     * @param  $value //用户的值
     * @param  $hashedValue //数据库的值
     * @param  array
     */
    public function check($value, $hashedValue, array $options = array()){
        switch(SiteFacades::get('hasher')){
            case "bcrypt":
                return Hash::check($value, $hashedValue, $options);
                break;
            default:
                return $this->make($value) === $hashedValue;
                break;
        }
    }

    /**
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array()){
        switch(SiteFacades::get('hasher')){
            case "bcrypt":
                return Hash::needsRehash($hashedValue, $options);
                break;
            default:
                return false;
                break;
        }
    }
}