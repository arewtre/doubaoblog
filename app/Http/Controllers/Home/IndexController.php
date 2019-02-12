<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\Adv;
use App\Http\Model\Link;
use App\Http\Model\Forum;
use App\Http\Model\Member;
use App\Http\Model\ForumCategory;
use App\Http\Model\Tags;
use App\Http\Model\Tips;
use Site;
class IndexController extends CommonController
{
    public function index(Request $request)
    {
        
        $cate = array();
        $adv = Adv::select('ad_slots.height','ad_slots.width','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","P1")
                ->where("ad_manage.status",1)
                ->where('ad_manage.start_time', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        //pre($adv);
        $tags = Tags::getTags(0); 
        $advtop = Adv::select('ad_manage.pic_url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","P0")
                ->where("ad_manage.status",1)
                ->where('ad_manage.start_time', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->first();
        $article = News::where("art_istop",1)->where("is_display",1)->where("type",1)->orderBy("created_at","desc")->take(20)->get();
        $input = array_filter($request->only(['keyword','cate_id','page','limit']));
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
        $data = News::select('news.update_editor','news.art_description','user.nickname','news.art_id','news.type','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->join('user', 'user.user_id', '=', 'news.update_editor')
        ->where("news.is_display",1)
        ->orderBy('news.created_at','desc')
        //->skip($limit*($page-1))->take($limit)
        ->get();
        $count = News::select('*')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where("news.is_display",1)
        ->count();
        $hot = News::select('*')
        ->where("news.is_display",1)
        ->orderBy('art_view','desc')
        ->take(8)
        ->get();
        //pre(Site::get('webimg'));
        $link = Link::where("status",1)
                ->orderby("link_sort","desc")
                ->get();
        $forum = Forum::where('display',1)->orderBy('updated_at','desc')->take(10)->get();
        $member = Member::where('status',1)->orderBy('updated_at','desc')->take(8)->get();
        //$gonggao = News::where('cate_id',23)->orderBy('created_at','desc')->get();
        $fmod = ForumCategory::where('pid','>',0)->where('is_display',1)->orderBy('descid', 'asc')->get();
        $tips = Tips::where('status',1)->orderBy('updated_at','desc')->orderBy('displayorder','desc')->get();
        //pre($data);
        //pre(session('userinfo'));
        //echo 1;die;
        return view('home.index',compact('adv','article','data','hot','advtop',"link",'tags','count','forum','member','gonggao','fmod','tips'));
    }
    
}
