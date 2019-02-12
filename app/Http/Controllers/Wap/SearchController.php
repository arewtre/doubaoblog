<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use App\Http\Model\Keywords;
use Illuminate\Support\Facades\Crypt;
class SearchController extends CommonController
{
    public function index(Request $request){
        if(IS_POST || $request->m==1){
            Keywords::addKeywords($request->keywords);
            switch ($request->type)
            {
            case "1":
              return redirect("wap/news?keywords=".$request->keywords); 
              break; 
            case "2":
              return redirect("wap/guide?keywords=".$request->keywords);
              break; 
            }
        }
        $request->type==2?$type = 2:$type = 1;
        $keywords = Keywords::getKeywords();
        return view("wap.search.index",compact('type',"keywords"));
    }
    
}
