<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    protected $table='web_content';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable = ['id','title','sign','img','editorvalue','updated_at','created_at','is_show','descid'];
}
