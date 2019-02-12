<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use Site;
class ToolController extends CommonController
{
    public function index(Request $request)
    {
        
        return view('home.tool.index');
    }
    
    public function css(Request $request)
    {
        
        return view('home.tool.css');
    }
    
    public function jsq(Request $request)
    {
        
        return view('home.tool.jsq');
    }
    
    public function zishutongji(Request $request)
    {
        
        return view('home.tool.zishutongji');
    }
    
    public function daxiaoxie(Request $request)
    {
        
        return view('home.tool.daxiaoxie');
    }
    
    public function md5str(Request $request)
    {
        if(isset($request->md5str)){
           return response()->json(strtolower(md5($request->md5str))); 
        }
        if(isset($request->md5str2)){
           return response()->json(strtoupper(md5($request->md5str))); 
        }
        return view('home.tool.md5str');
    }
    
    public function url(Request $request)
    {
        
        return view('home.tool.url');
    }
    
    public function timestamp(Request $request)
    {
        if(isset($request->timestamp)){
           return response()->json(date("Y-m-d H:i:s",$request->timestamp)); 
        }
        return view('home.tool.timestamp');
    }
    
    public function utf8(Request $request)
    {
        
        return view('home.tool.utf8');
    }
    
    public function htmljs(Request $request)
    {
        
        return view('home.tool.htmljs');
    }
    
    public function jsformat(Request $request)
    {
        
        return view('home.tool.jsformat');
    }
    
}
