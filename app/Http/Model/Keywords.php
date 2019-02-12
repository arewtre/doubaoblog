<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model{
    protected $table = 'keywords';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    
    protected function getKeywords()
    {
        return Keywords::select()
                ->orderBy("num","desc")
                ->take(10)
                ->get();
    }
    
    protected function addKeywords($keywords)
    {
        $res =  Keywords::where('keywords', 'like', '%'.$keywords.'%')->first();
        if($res){
            Keywords::where("id",$res->id)->increment('num');
        }else{
            $data['keywords'] = $keywords;
            Keywords::create($data);
        }
        //return true;
    }
       

}
