<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use App\Http\Model\Biaotai;
use App\Http\Model\NewsRep;
use App\Http\Model\Forum;
use View;
class BlogController extends CommonController
{
    public function __construct(){
        
        parent::__construct();
        $hot = News::select('*')
        ->where("is_display",1)
        ->orderBy('updated_at','desc')
        ->orderBy('art_view','desc')
        ->take(10)
        ->get();
        $hotForum = Forum::select()
                ->orderby("reps","desc")
                ->orderby("views","desc")
                ->orderby("created_at","desc")
                ->take(10)
                ->get();
         View::share('hotForum',$hotForum);
        View::share('hot',$hot);
    }
    
    public function index(Request $request)
    {
        $input = $request->all();
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 12;
        $cid = $request->cid;
        $keywords = $request->keywords;
        $data = News::select('news_category.id','user.nickname','news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
         ->join('user', 'user.user_id', '=', 'news.update_editor')
        ->where("news.is_display",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('news.cate_id', '=', $cid);
            } 
        })
        ->where(function ($query) use ($request) { 
            $keywords = (!empty($request->keywords)) ? $request->keywords : '';
            if(!empty($keywords)){
                $query->where('news.art_title', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_description', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_content', 'like', '%'.$keywords.'%');
            } 
        })
        ->where(function ($query) use ($request) {
            if (trim($request->tags)) {
                $query->whereRaw("find_in_set('$request->tags',tags)");
            }
        })
        ->where("news.type",2)
        ->orderBy('news.created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        
        $count = News::select('news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where("news.is_display",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('news.cate_id', '=', $cid);
            } 
        })
        ->where(function ($query) use ($request) { 
            $keywords = (!empty($request->keywords)) ? $request->keywords : '';
            if(!empty($keywords)){
                $query->where('news.art_title', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_description', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_content', 'like', '%'.$keywords.'%');
            } 
        })
        ->where(function ($query) use ($request) {
            if (trim($request->tags)) {
                $query->whereRaw("find_in_set('$request->tags',tags)");
            }
        })
        ->where("news.type",2)
        ->count();
        //pre($cid);
        return view('home.blog.index',compact('data',"count","cid","page",'limit','keywords'));
    }
    
     public function detail($id,Request $request)
    {
        //$id = idDecryption($id);
        //pre($id);
        $detail = News::where('art_id',$id)
                 ->join('user', 'user.user_id', '=', 'news.update_editor')
                ->first();
        //pre($detail);
        if(!isset($detail)){//没有文章转404
            abort(404);
        }
        News::where("art_id",$id)->increment('art_view');
        $pre = News::where("art_id",News::getPrevArticleId($id,2))->first();
        $next = News::where("art_id",News::getNextArticleId($id,2))->first();
        $xg = News::where("cate_id",$detail->cate_id)
                ->where("is_display",1)
                ->take(8)
                ->get();
        $bt = Biaotai::getAllBt(2,$id);
        $btmember = Biaotai::select("member.nickname","member.userface")
                ->join('member', 'member.id', '=', 'news_biaotai.uid')
                ->where("news_biaotai.pid",$id)
                ->where("news_biaotai.type",2)
                ->get();
        $isbt = Biaotai::where("pid",$id)
                ->where("type",1)
                ->where("uid",session('userinfo.id'))
                ->count();
        $rep = NewsRep::select("member.nickname","member.userface","news_rep.content","news_rep.created_at")
                ->join('member', 'member.id', '=', 'news_rep.uid')
                ->where("news_rep.news_id",$id)
                ->where("news_rep.type",2)
                ->where("news_rep.display",1)
                ->get();
        return view('home.blog.detail',compact('detail','pre','next','xg','bt','btmember','rep','isbt'));

    }
    
}
