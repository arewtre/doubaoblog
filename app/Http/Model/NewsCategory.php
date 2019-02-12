<?php

namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model{
    //设置表的类型和表名
    protected $table = 'news_category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    //返回所有类
    static public function cate($cate,$pid = 0,$html = '#',$level = 0){
        static $arr = array();
        static $parentname ='';
        foreach($cate as $v){

            if($v['pid'] == $pid ){
                $v['pid'] == 0 ?  $parentname = $v['defectsname'] : '';
                $v['parent'] = $parentname;
                $v['level'] = $level;
                $v['html'] = str_repeat($html,$level);
                $arr[] = $v;
                self::cate($cate,$v['id'], '#',$level+1);
            }
        }
        return $arr;
    }
    //返回类
    static public function allCate($cate,$pid = 0){
        $arr2 = array();
        foreach($cate as $v){
            if($v['pid'] == $pid ){
                $v['ddd'] = self::allCate($cate,$v['id']);
                $arr2[] = $v;
            }
        }
        return $arr2;
    }

    //传入父ID返回所有子类无限分类
    static public function parentCate($cate,$id = 9){
        $arr2 = array();
        foreach($cate as $v){
            if($v['pid'] == $id ){
                $v['ddd'] = self::parentCate($cate,$v['id']);
                $arr2[] = $v;
            }
        }
        return $arr2;
    }

    //传入子类ID返回所有父类 子类=》父类
    static public function childCate($cate,$id = 41){
        $arr2 = array();
        foreach($cate as $v){
            if($v['id'] == $id ){
                $v['ddd'] = self::childCate($cate,$v['pid']);
                $arr2[] = $v;
            }
        }
        return $arr2;
    }
    
    
    /**
     * 把返回的数据集转换成Tree
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param string $root
     * @return array
     */
    static public function listToTree($list, $pk='id', $pid = 'pid', $child = '_child', $root = '0') {
        $tree = array();
        if(is_array($list)) {
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $data) {
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] = &$list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent = &$refer[$parentId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }
    
    static public function formatTree($list, $lv = 0, $title = 'defectsname'){
        $formatTree = array();
        foreach($list as $key => $val){
            $title_prefix = '';
            for( $i=0;$i<$lv;$i++ ){
                $title_prefix .= "|---";
            }
            $lv = $val['level'];
            $val['namePrefix'] = $lv == 0 ? '' : $title_prefix;
            $val['showName'] = $lv == 0 ? $val[$title] : $title_prefix.$val[$title];
            if(!array_key_exists('_child', $val)){
                array_push($formatTree, $val);
            }else{
                $child = $val['_child'];
                unset($val['_child']);
                array_push($formatTree, $val);
                $middle = self::formatTree($child, $lv+1, $title); //进行下一层递归
                $formatTree = array_merge($formatTree, $middle);
            }
        }
        return $formatTree;
    }
}