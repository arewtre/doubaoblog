<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    
    protected function getTags($id)
    {
        return Tags::where("status",1)
                //->skip(42*($id-1))->take(42)
                ->get();
    }
       

}
