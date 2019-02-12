<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use App\Http\Model\Member;
use App\Http\Model\NewsRep;
use View;
class NewsController extends CommonController
{
    public function __construct(){
        parent::__construct();
        
    }
    
    public function index(Request $request)
    {
        $input = $request->all();
//        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
//        $lastid = intval($request->lastid);
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
        $data = News::select('news_category.id','news.update_editor','news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where("news.is_display",1)
        ->where("news.type",1)
        ->where(function ($query) use ($request) {
            $cid = (!empty($request->cid)) ? $request->cid : '';
            if(!empty($cid)){
                $query->where('news.cate_id', '=', $cid);
            } 
        })
        ->where(function ($query) use ($request) {
            $lastid = (!empty($request->lastid)) ? $request->lastid : '';
            if(!empty($lastid)){
                $query->where('news.art_id', '<', $lastid);
            } 
        })
        ->orderBy('news.created_at','desc')
        ->take($limit)
        ->get();
        
        return $this->success($data);
    }
    
     public function detail(Request $request)
    {
        $id = $request->id;
        $detail = News::where('art_id',$id)->first();
//        if(!isset($detail)){//没有文章转404
//          return response()->json(array());  
//        }
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
                ->where("news_rep.type",1)
                ->where("news_rep.display",1)
                ->get();
        return $this->success(compact("detail","rep","pre","next"));

    }
    
    
    
    public function addrep($id,$type,Request $request)
    {
        
        $nowtime = time();
        if(isset($_SESSION['reptime'])){
            if($nowtime - $_SESSION['reptime']<60){
                echo "<script >alert('回复过于频繁!');history.go(-1);</script>";
                die;
            }
        }else{
            $_SESSION['reptime'] = time();
        }  
        if(empty($request->content)){
            echo "<script>alert('请填写内容!');history.go(-1);</script>";
            die;
        }
        if(strlen($request->content)< 6){
            echo "<script>alert('请至少填写6个字符!');history.go(-1);</script>";
            die;
        }
        $data['uid'] = session('userinfo.id');
        $data['news_id'] = $id;
        $data['type'] = $type;
        $data['content'] = $request->content;
        $res = NewsRep::create($data);
        News::where("art_id",$id)->increment('art_rep');
        if($res){
            switch ($type)
            {
            case 1:
              News::where("art_id",$id)->increment('art_rep');
              return redirect("/news_".$id.".html");
              break;
            case 2:
              Blog::where("art_id",$id)->increment('art_rep');
              return redirect("/blog_".$id.".html"); 
              break;           
            }
            
        }

    }
    
}
