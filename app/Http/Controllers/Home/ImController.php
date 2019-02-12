<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use Site;
class ImController extends CommonController
{
    public function index(Request $request)
    {
        
        return view('home.im.index');
    }
    
}
