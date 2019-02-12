<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use Illuminate\Support\Facades\Crypt;
class ProfileController extends CommonController
{
    public function index(){
        $list = Member::where('id',session("userinfo.id"))->first();
        return view("wap.profile.index",compact('list'));
    }
    
}
