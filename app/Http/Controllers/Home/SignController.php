<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Member;
class SignController extends CommonController
{
    public function index(Request $request){
        
        if(is_ajax()){ 
             
            $data = array(
                'code' => 1,
                'msg' => '签到成功！',
                );
                return response()->json($data);
                exit;
         }
         
        return view("home.sign.index");
    }
        
}
