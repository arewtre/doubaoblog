<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use App\Http\Model\Biaotai;
use App\Http\Model\Member;
use App\Http\Model\NewsRep;
use App\Http\Model\Forum;
use App\Http\Model\Blog;
use View;
class NewsController extends CommonController
{
    public function __construct(){
        parent::__construct();
        $hot = News::select('*')
        ->where("is_display",1)
//        ->where("type",1)
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
        View::share('hot',$hot);
         View::share('hotForum',$hotForum);
        //pre($_SESSION);
    }
    
    public function index(Request $request)
    {
        $input = $request->all();
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
        $cid = $request->cid;
        $data = News::select('news_category.id','user.nickname','news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->join('user', 'user.user_id', '=', 'news.update_editor')
        ->where("news.is_display",1)
        ->where("news.type",1)
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
        ->orderBy('news.created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        //pre($data->toSql());
        $count = News::select('news.art_description','news.art_id','news.updated_at','news.cate_id','news.art_thumb','news.art_title','news.art_rep','news.art_view','news_category.defectsname','news.created_at')
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
            $keywords = (!empty($request->keywords)) ? $request->keywords : '';
            if(!empty($keywords)){
                $query->where('news.art_title', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_description', 'like', '%'.$keywords.'%')
                      ->orWhere('news.art_content', 'like', '%'.$keywords.'%');
            } 
        })
        ->count();
        //pre($cid);
        return view('home.news.index',compact('data',"count","cid","page",'limit','keywods'));
    }
    
     public function detail($id,Request $request)
    {
        //$id = idDecryption($id);
        //pre($id);
        $detail = News::where('art_id',$id)
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
        //pre($bt);
        $bt = Biaotai::getAllBt(1,$id);
        $btmember = Biaotai::select("member.nickname","member.userface")
                ->join('member', 'member.id', '=', 'news_biaotai.uid')
                ->where("news_biaotai.pid",$id)
                ->where("news_biaotai.type",1)
                ->get();
        $isbt = Biaotai::where("pid",$id)
                ->where("type",1)
                ->where("uid",session('userinfo.id'))
                ->count();
        $rep = NewsRep::select("member.nickname","member.userface","news_rep.content","news_rep.created_at")
                ->join('member', 'member.id', '=', 'news_rep.uid')
                ->where("news_rep.news_id",$id)
//                ->where("news_rep.type",1)
                ->where("news_rep.display",1)
                ->get();
        return view('home.news.detail',compact('detail','pre','next','xg','bt','btmember','rep','isbt'));

    }
    
    public function biaotai($id,$bt,$type,Request $request)
    {
        
        $isbt = Biaotai::where("pid",$id)
                ->where("type",$type)
                ->where("uid",session('userinfo.id'))
                ->count();
        if($isbt>0){
            echo "<script >alert('您已表过态,请勿重复操作!');history.go(-1);</script>";
            die;
        }
        $data['uid'] = session('userinfo.id');
        $data['pid'] = $id;
        $data['type'] = $type;
        $data['bt'] = $bt;
        $res = Biaotai::create($data);
        if($res){
            switch ($type)
            {
            case 1:
              return redirect("/news_".$id.".html");
              break;
            case 2:
              return redirect("/blog_".$id.".html");
              break;           
            }
            
        }

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
