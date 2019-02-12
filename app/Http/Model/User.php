<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //use Notifiable,HasRoles;
    //use HasRoles;
    protected $table='user';
    protected $primaryKey='user_id';
    public $timestamps=false;
    protected $guarded = [];
    
    
    public function setPasswordAttribute($value)
    {
        if(strlen($value)!=60)
        {
            $value=bcrypt($value);
        }
        $this->attributes['password']=$value;
    }
}
