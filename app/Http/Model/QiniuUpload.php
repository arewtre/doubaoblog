<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class QiniuUpload extends Model
{
    protected $table='qiniu_upload';
    protected $primaryKey='id';
//    public $timestamps=false;
//    protected $fillable = ['name','type','ext','addtime','url','size','uid'];
    protected $guarded = [];
}
