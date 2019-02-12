<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\Adv;
use App\Http\Model\Link;
use App\Http\Model\Forum;
use App\Http\Model\ForumCategory;
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
                ->where('ad_manage.created_at', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        $advtop = Adv::select('ad_manage.pic_url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","P0")
                ->where("ad_manage.status",1)
                ->where('ad_manage.created_at', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->first();
        $art = News::where("art_istop",1)->where("type",1)->where("is_display",1)->orderBy("created_at","desc")->take(12)->get()->toArray();
        $article = array();
        for($i=0;$i<ceil(count($art));$i++)
        {
              $article[] = array_slice($art, $i * 3 ,3);
        }
        $input = array_filter($request->only(['keyword','cate_id','page','limit']));
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
        $data = News::select('news.update_editor','news.art_description','user.nickname','news.art_id','news.type','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
            ->join('user', 'user.user_id', '=', 'news.update_editor')
        ->where("news.is_display",1)
        ->where("news.type",1)
        ->orderBy('news.created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        $count = News::select('news.update_editor','news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where("news.is_display",1)
        ->where("news.type",1)
        ->count();
        $hot = News::select('*')
        ->where("news.is_display",1)
        ->orderBy('art_view','desc')
        ->take(8)
        ->get();
        $link = Link::where("status",1)
                ->orderby("link_sort","desc")
                ->get();
        $Category = ForumCategory::where('is_display',1)
                ->where("level",1)
                ->orderBy('descid', 'asc')
                ->get()
                ->toArray();
        //$mod = ForumCategory::listToTree($Category);
        $mod = $Category;
        //pre($article);
        $forum = Forum::where('display',1)->orderBy('is_top','desc')->orderBy('created_at','desc')->take(10)->get();
        return view('wap.index',compact('adv','article','data','hot','advtop',"link",'count','mod','forum'));
    }
    
}
