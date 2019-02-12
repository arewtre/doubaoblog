<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use View;
class BlogController extends CommonController
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
    }
    
    public function index(Request $request)
    {
        $input = $request->all();
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
        $cid = $request->cid;
        $data = News::select('blog_category.id','blog.update_editor','blog.art_description','blog.art_id','blog.updated_at','blog.cate_id','blog.art_thumb','blog.art_title','blog.art_rep','blog.art_view','blog_category.defectsname','blog.created_at')
        ->join('blog_category', 'blog.cate_id', '=', 'blog_category.id')
        ->where("blog.is_display",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('blog.cate_id', '=', $cid);
            } 
        })
        ->orderBy('blog.created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        
        $count = News::select('blog.art_description','blog.art_id','blog.updated_at','blog.cate_id','blog.art_thumb','blog.art_title','blog.art_rep','blog.art_view','blog_category.defectsname','blog.created_at')
        ->join('blog_category', 'blog.cate_id', '=', 'blog_category.id')
        ->where("blog.is_display",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('blog.cate_id', '=', $cid);
            } 
        })
        ->count();
        //pre($cid);
        return view('wap.blog.index',compact('data',"count","cid","page",'limit'));
    }
    
     public function detail($id,Request $request)
    {
        //$id = idDecryption($id);
        //pre($id);
        $detail = News::where('art_id',$id)->first();
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
        return view('wap.blog.detail',compact('detail','pre','next','xg'));

    }
    
}
