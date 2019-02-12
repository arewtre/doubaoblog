<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Images;
use App\Http\Model\ImagesXc;
use App\Http\Model\Member;
use App\Http\Model\Test;
use App\Http\Model\Forum;
use App\Http\Model\ImagesXcCate;
use Illuminate\Support\Facades\Cookie;
use Site;
class TestController extends CommonController
{
    public function getExpress(Request $request)
    {
        
//        $data = Images::select("*")->get();
//        foreach($data as &$v){
//            $mm = explode("/", $v->image_url);
//            $v->da = $mm[3];
//        }
        //pre($data);
//        foreach($data as &$v){
//            $input['image_url'] = "http://image.linxinran.cn/".$v->da;
//            Images::where('img_id',$v->img_id)->update($input);
//        }
        
        //echo "成功";
        //return response()->json($data);
        //pre($request->all());
       
        $express = getExpress($request->com,$request->postcode);
        //pre($express);
        return response()->json($express);
        
    }
    
    public function index(Request $request)
    {
//        $data['name']= "插入";
//        Test::create($data);
        //pre(Forum::posts());
       //pre($request->cookie());
       //pre($request->cookie('test5'));
        //$cookie = Cookie::make('test3', 'Hello, Laravel3', 100);
      //return  \Response::make('index')->withCookie($cookie);
//        $a = array();
//        for($j=1;$j<=47;$j++){
//            $a[] = date('Y-m-d H:i', strtotime(date('Y-m-d'))+($j)*30*60);
//        }
//        $num['date'] = $a;
        //pre($num);
          
         //Cookie::queue('test5', 'Hello, Laravel5', 10);
//$coo =  \Cookie::get('account');
//response('Hello Cookie')->cookie('test', 'value', 60);

    }
    
}
