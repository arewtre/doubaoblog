<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use View;
class TestController extends CommonController
{

    public function __construct(){
        parent::__construct();
    }
    
    public function index(Request $request)
    {


    }
    
    public function getExpress(Request $request)
    {

       // pre($request->all());
        $express = getExpress($request->com,$request->postcode);
        return response()->json($express);
    }
    
   
    
    
    
}
