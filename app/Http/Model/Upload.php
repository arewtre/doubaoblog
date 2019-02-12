<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table='upload';
    protected $primaryKey='up_id';
    public $timestamps=false;
    protected $fillable = ['name','type','ext','addtime','url','size','uid'];
}
