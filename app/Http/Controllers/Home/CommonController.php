<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Model\BlogCategory;
use App\Http\Model\NewsCategory;
use App\Http\Model\ForumCategory;
use App\Http\Model\MemberVisitLog;
use Illuminate\Support\Facades\DB;
class CommonController extends Controller
{
    public function __construct()
    {
//        $a = getIpInfo();
//        if(!empty($a['ip'])){
//            $res = MemberVisitLog::where('ip',$a['ip'])->count();
//            if($res<1){
//                $a['os'] = GetOS();
//                $a['lang'] = get_lang();
//                $a['browse'] = browse_info();
//                //pre($a);
//                MemberVisitLog::create($a);
//            };
//        }
        clientlog();
        getSpider();
        $cates = NewsCategory::where("is_display",1)
                ->where("level",1)
                ->where("type",2)
                ->orderby("descid","desc")
                ->get();
        
        $ncate = NewsCategory::where("is_display",1)
                ->where("level",1)
                ->where("type",1)
                ->orderby("descid","desc")
                ->get();
        
        $fcate = ForumCategory::where("is_display",1)
                ->where("level",1)
                ->orderby("descid","desc")
                ->get();
        
        View::share('cates',$cates);
        View::share('ncate',$ncate);
        View::share('fcate',$fcate);
    }
}
