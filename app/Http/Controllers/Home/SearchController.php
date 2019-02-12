<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use App\Http\Model\Member;
use App\Http\Model\NewsRep;
use App\Http\Model\Forum;
use App\Http\Model\Blog;
use View;
class SearchController extends CommonController
{
    public function __construct(){
        parent::__construct();
        
    }
    
    public function index(Request $request)
    {
        //pre($request->all());
        switch ($request->mod)
        {
        case "news":
          return redirect("/news?keywords=".$request->keywords); 
          break;
        case "blog":
          return redirect("/blog?keywords=".$request->keywords);
          break; 
        case "forum":
          return redirect("/guide?keywords=".$request->keywords);
          break; 
        }
        
    }
    
    
}
