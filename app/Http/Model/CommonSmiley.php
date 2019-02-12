<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CommonSmiley extends Model
{
    protected $table='common_smiley';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];

    
}
