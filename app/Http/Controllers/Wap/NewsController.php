<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\Tags;
use App\Http\Model\NewsCategory;
use App\Http\Model\NewsRep;
use View;
class NewsController extends CommonController
{
    public function __construct(){
        parent::__construct();
        $hot = News::select('*')
        ->where("is_display",1)
        ->orderBy('updated_at','desc')
        ->orderBy('art_view','desc')
        ->take(6)
        ->get();
        View::share('hot',$hot);
        //pre($_SESSION);
    }
    
    public function index(Request $request)
    {
        $input = $request->all();
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
        $cid = $request->cid;
        $data = News::select('news_category.id','news.update_editor','news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where("news.is_display",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('news.cate_id', '=', $cid);
            } 
        })
        ->where(function ($query) use ($request) {
            $type = (!empty($request->type)) ? $request->type : '';
            if(!empty($type)){
                $query->where('news.type', '=', $type);
            } 
        })
        ->where(function ($query) use ($request) {
            if (trim($request->tags)) {
                $query->whereRaw("find_in_set('$request->tags',tags)");
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
            $type = (!empty($request->type)) ? $request->type : '';
            if(!empty($type)){
                $query->where('news.type', '=', $type);
            } 
        })
        ->where(function ($query) use ($request) {
            if (trim($request->tags)) {
                $query->whereRaw("find_in_set('$request->tags',tags)");
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
        ->count();
        //pre($cid);
        $newCate = NewsCategory::where("is_display",1)
                ->orderBy("descid","desc")
                ->get()
                ->toArray();
        $ncates = NewsCategory::formatTree(NewsCategory::listToTree($newCate));
        //pre($ncates);
        $pages = ceil($count/$limit);
        $type = $request->type;
        return view('wap.news.index',compact('data',"count","cid","page","pages",'limit','ncates','type'));
    }
    
     public function detail($id,Request $request)
    {
//        $id = idDecryption($id);
        //pre($id);
        $detail = News::where('news.art_id',$id)
            ->join('user', 'user.user_id', '=', 'news.update_editor')
            ->first();
        if(!isset($detail)){//没有文章转404
            abort(404);
        }
        News::where("art_id",$id)->increment('art_view');
        $pre = News::where("art_id",News::getPrevArticleId($id,1))->first();
        $next = News::where("art_id",News::getNextArticleId($id,1))->first();
        $xg = News::where("cate_id",$detail->cate_id)
                ->where("is_display",1)
                ->take(8)
                ->get();
        $rep = NewsRep::select("member.nickname","member.userface","news_rep.content","news_rep.created_at")
                ->join('member', 'member.id', '=', 'news_rep.uid')
                ->where("news_rep.news_id",$id)
//                ->where("news_rep.type",1)
                ->where("news_rep.display",1)
                ->get();
        $repcount = NewsRep::select("member.nickname","member.userface","news_rep.content","news_rep.created_at")
                ->join('member', 'member.id', '=', 'news_rep.uid')
                ->where("news_rep.news_id",$id)
//                ->where("news_rep.type",1)
                ->where("news_rep.display",1)
                ->count();
        return view('wap.news.detail',compact('detail','pre','next','xg','rep',"repcount"));

    }
    
    public function reply($id,Request $request)
    {

        $detail = News::where('art_id',$id)->first();
        if(!isset($detail)){//没有文章转404
            return response()->json(array('code' => 0, 'msg' => '文章不存在,或已被删除！'));
        }
        $d['uid'] = session('userinfo.id');
        $d['news_id'] = $id;
        $d['content'] = $request->content;
        $d['type'] = $detail->type;
        NewsRep::create($d);
        News::where("art_id",$id)->increment('art_rep');
        return response()->json(array('code' => 1, 'msg' => '评论成功！'));

    }
    
    public function tags(Request $request)
    {
        $input = $request->all();
        $data = Tags::select('*')
        ->where("status",1)
        ->where(function ($query) use ($request) {
            $keywords = (!empty($request->keywords)) ? $request->keywords : '';
            if(!empty($keywords)){
                $query->where('tagname', 'like', '%'.$keywords.'%');
            } 
        })
        ->get();
        return view('wap.news.tags',compact('data'));
    }
    
}
