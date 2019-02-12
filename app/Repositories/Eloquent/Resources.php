<?php

/**
 * Created by PhpStorm.
 * User: zhangyurong
 * Date: 2016/7/22
 * Time: 8:33
 */
namespace App\Repositories\Eloquent;

use App\Models\Common\CollTown;
use App\Models\Common\CollArea;
use App\Models\Common\CollCategory;
use App\Models\Common\CollOption;
use App\Models\Common\CollPosition;
use App\Repositories\Contracts\ResourcesContract;
use App\Facades\Site as CollSite;

class Resources implements ResourcesContract{

    protected $storagePath;
    protected $storageUrl;

    protected $optionAll = array(
        'company' => array('language', 'comkind', 'monthlypay', 'work_year', 'industry', 'employee_num', 'education', 'part_status'),
        'personal' => array('education', 'language', 'ComputerAbility', 'work_year', 'speciality', 'job_status', 'marital', 'expectedsalary', 'degree', 'title'),
        'resume' => array('language', 'comkind', 'monthlypay', 'work_year', 'industry', 'employee_num', 'education', 'language', 'ComputerAbility',
            'speciality', 'job_status', 'marital', 'expectedsalary', 'degree', 'title'),
        'jobsearch' => array('industry', 'work_year', 'education', 'release_date'),
        'comsearch' => array('work_year', 'education', 'age_stint', 'release_date'),
        'my_resume' => array('education', 'job_status', 'expectedsalary', 'release_date', 'marital', 'work_year'),
        'part_time' => array('education', 'part_time_type', 'part_time_salary_unit', 'part_time_salary_method'),
    );

    public function __construct(){
        $this->storagePath = 'public/storage/js/';
        $this->storageUrl = "public/storage/js/";
    }

    /**
     * 获取JS选项地址
     * @param $sign 空代表全部选择资源,数组代表指定选择资源,字符代表$optionAll指定的选项
     * @return string
     */
    public function jsOption($sign){
        if(is_array($sign)){
            $signstr = '';
            foreach($sign as $v){
                $signstr .= $v;
            }
            $cacheSign = md5($signstr);
        }else{
            $cacheSign = md5($sign);
        }
        //$cacheSign = strtolower($cacheSign);
        $cacheSign = $sign;
        $path = $this->storagePath . $sign . '.js';
        if(file_exists($path)){
            //return asset($this->storageUrl . $cacheSign . '.js');
            return asset($this->storageUrl . $sign . '.js');
        }else{
            $jsstr = '';
            $arr = array();
            if(is_array($sign)){
                foreach($sign as $value){
                    $arr[] = $value;
                }
            }elseif(empty($sign)){
                $allArray = CollCategory::all();
                foreach($allArray as $value){
                    $arr[] = $value['sign'];
                }
            }else{
                if(!empty($this->optionAll[$sign])){
                    $arr = $this->optionAll[$sign];
                }
            }
            foreach($arr as $v){
                $option = CollOption::getOption($v);//
                $option = json_encode($option);
                //print_r($option);exit;
                if($option != '[]') $jsstr .= 'var option_' . $v . '=' . $option . ';';//把json转成字符串拼接万js代码
            }
            $value = $jsstr ? $jsstr : '';
            if($value) file_put_contents($path, $value);
            return asset($this->storageUrl . $cacheSign . '.js');
        }
    }

    /**
     * 获取JS职位一级选项地址
     * @return string
     */
    public function jsOnePosition(){
        $path = $this->storagePath . 'one_position.js';
        if(file_exists($path)){
            return asset($this->storageUrl . 'one_position.js');
        }else{
            $jsstr = '';
            $arr = array();
            //获取一级职位列表
            $arr['position'] = CollPosition::getFirstPosition();
            foreach($arr as $k => $v){
                $option = json_encode($v);
                if($option != '[]') $jsstr .= 'var option_' . $k . '=' . $option . ';';//把json转成字符串拼接万js代码
            }
            $value = $jsstr ? $jsstr : '';
            if($value) file_put_contents($path, $value);
            return asset($this->storageUrl . 'one_position.js');
        }
    }

    /**
     * 获取JS当前地区和省份选项地址
     * @return string
     */
    public function jsProvinceArea(){
        $path = $this->storagePath . 'province_area.js';
        if(file_exists($path)){
            return asset($this->storageUrl . 'province_area.js');
        }else{
            $jsstr = '';
            $arr = array();
            //获取当前快选县级市
            $arr['city'] = CollArea::getSiteCity();
            //获取当前省份
            $arr['province'] = CollArea::getProvince();
            //获取当前县级市(附带市)
            $cid = substr(CollSite::get('webareacode'), 0, 4) . '00';
            $city = CollArea::getAreaName($cid);
            $arr['city_two'] = CollArea::getSiteCity();
            array_unshift($arr['city_two'], ['value' => $cid, 'text' => $city]);

            if(substr(CollSite::get('webareacode'), -2, 2) != '00'){
                $arr['town'] = CollTown::getTown(CollSite::get('webareacode'));
                $town = CollArea::getAreaName(CollSite::get('webareacode'));
                $arr['town_second'] = CollTown::getTown(CollSite::get('webareacode'));
                array_unshift($arr['town_second'], ['value' => CollSite::get('webareacode'), 'text' => $town.'-不限']);
            }
            //pre($arr);
            foreach($arr as $k => $v){
                $option = json_encode($v);
                if($option != '[]') $jsstr .= 'var option_' . $k . '=' . $option . ';';//把json转成字符串拼接万js代码
            }
            $value = $jsstr ? $jsstr : '';
            if($value) file_put_contents($path, $value);
            return asset($this->storageUrl . 'province_area.js');
        }
    }

    /**
     * 清空所有缓存
     * @return bool
     */
    public function plushCache(){
        $dirName = $this->storagePath;
        if(file_exists($dirName) && $handle = opendir($dirName)){
            while(false !== ($item = readdir($handle))){
                if($item != "." && $item != ".."){
                    if(file_exists($dirName . '/' . $item) && is_dir($dirName . '/' . $item)){
                        delFile($dirName . '/' . $item);
                    }else{
                        unlink($dirName . '/' . $item);
                    }
                }
            }
            closedir($handle);
        }
        return true;
    }
}