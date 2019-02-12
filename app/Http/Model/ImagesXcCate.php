<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ImagesXcCate extends Model{
    protected $table = 'images_category';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    
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
