<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Biaotai extends Model{
    protected $table = 'news_biaotai';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    
    protected function getAllBt($type,$pid)
    {
        $re = Biaotai::where("type",$type)
                ->where("pid",$pid);
        $res = array();
        for($i=1;$i<6;$i++){
            $res[] = Biaotai::where("type",$type)
                ->where("pid",$pid)
                ->where("bt",$i)->count();
           //print_r($res);
        }
        return $res;
    }
    
    

}
