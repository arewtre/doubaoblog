<?php

namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Link extends Model{
    protected $table='link';
    protected $primaryKey='link_id';
    protected $guarded =[];
}
