<?php

namespace App\Http\Model;
//use App\Http\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

//class Test extends BaseModel{
class Test extends Model{
    protected $table = 'test';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            // do stuff
             echo "插入前<br/>";
             $data['name'] = "插入前";
             $res= $model->where("name",$data['name'])->first();
             if(!$res){
                    $model->create($data);
             }else{
                 echo "数据已存在";
             }
             return  true;
        });
        
        static::created(function($model)
        {
            // do stuff
             echo "插入后<br/>";
             $data['name'] = "插入后";
             $model->create($data);
             return  true;
        });

        static::updating(function($model)
        {
            // do stuff
             echo "修改前";
             return  true;
        });
        
        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }
    
//    public function beforeCreate() {
//        echo "插入前<br/>";
//        return  true;
//    }
//    
//    public function afterCreate() {
//        echo "插入后";
//        return  true;
//    }
    

}
