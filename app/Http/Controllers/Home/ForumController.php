<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Model\Forum;
use App\Http\Model\Blog;
use App\Http\Model\Adv;
use App\Http\Model\ForumCategory;
use App\Http\Model\ForumRep;
use App\Http\Model\Ftype;
use App\Http\Model\Member;
use App\Http\Model\News;
use App\Http\Model\Link;
use View;
use DB;
class ForumController extends CommonController
{
    public function __construct(Request $request){
        //
        parent::__construct();
        
        $cid = $request->cid;
        View::share('cid',$cid);
    }
    
    public function index(Request $request)
    {
        $adv = Adv::select('ad_slots.height','ad_slots.width','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","L0")
                ->where("ad_manage.status",1)
                ->where('ad_manage.start_time', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();//广告
        //pre($adv);
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        
        
        foreach($Category as $k=>$v){
                $Category[$k]['zhutinum'] = Forum::where('display',1)->where('pid',$v['id'])->count();
                $Category[$k]['tiezinum'] = Forum::where('display',1)->where('pid',$v['id'])->sum('reps'); 
                //pre($v['_child']);
        }
        $mod = ForumCategory::listToTree($Category);
        //pre($mod); 
        $newf = Forum::where('display',1)
                ->orderBy('created_at',"desc")
                ->take(10)
                ->get();//最新主题
        
        $newrep = ForumRep::where('display',1)
                ->orderBy('created_at',"desc")
                ->take(10)
                ->get();//最新回复
        
        $hotrep = Forum::where('display',1)
                ->orderBy('reps',"desc")
                ->take(10)
                ->get();//热门帖子
        
        $member = Member::where('status',1)
                ->orderBy('created_at','desc')
                ->get()->toArray();//热心居民
        
        $todayf = DB::table('forum')
                ->where('display',1)
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); //今日帖子数
        
        $lastdayf = DB::table('forum')
                ->where('display',1)
                ->whereDate('created_at','=', date("Y-m-d",strtotime("-1 day")))
                ->count();//昨日帖子数
        
        $fnum = DB::table('forum')
                ->where('display',1)
                ->count();//总数
        $link = Link::where("status",1)
                ->orderby("link_sort","desc")
                ->get();
        return view('home.forum.index',compact('adv','mod','newf','newrep','hotrep','member','todayf','lastdayf','fnum','link'));
    }
    
     public function forumList($id,Request $request)
    {
        $mod = ForumCategory::where("id",$id)->where("is_display",1)->first();
        ForumCategory::where("id",$id)->increment('views');
        if(!isset($mod)){//没有转404
            abort(404);
        }
        $hot = News::select('*')
        ->where("news.is_display",1)
        ->orderBy('art_view','desc')
        ->take(8)
        ->get();
        $member = Member::where('status',1)->orderBy('updated_at','desc')->take(8)->get();
        $filter = $request->filter;
        !empty($filter)?$fil = $filter: $fil ="created_at";
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
        $data = Forum::select("forum.*","member.nickname","member.userface")
               ->join('member', 'member.id', '=', 'forum.uid')
               ->where('forum.display',1)
               ->where("forum.pid",$id)
               ->orderby("forum.".$fil, "desc")
               ->skip($limit*($page-1))->take($limit)
               ->get();
        $count = Forum::select("forum.*","member.nickname","member.userface")
               ->join('member', 'member.id', '=', 'forum.uid')
               ->where('forum.display',1)
               ->where("forum.pid",$id)
               ->count();
        
        //pre($data);
        foreach($data as $v){
            $lastrep = ForumRep::select("member.nickname","forum_rep.created_at")
                ->where("forum_rep.forum_id",$v->forum_id)
                ->join('member', 'member.id', '=', 'forum_rep.uid')
                ->orderby("forum_rep.created_at", "desc")
                ->first();
            $v['lastrepname'] = $lastrep['nickname'];
            $v['lastrepcreated_at'] = $lastrep['created_at'];
            preg_match('/<video[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
            //pre($matches[0]);
            if(!empty($matches)) {
                $v->video = $matches[0];
            }
        }
        //pre($data->toArray());
        //pre($mod);
        $todayf = DB::table('forum')
                ->where('display',1)
                ->where('forum_id',$id)
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); //今日帖子数
        $res = Db::select("SELECT
    temp.*
    FROM
    (
        SELECT
            ta.*,
            @index := @index + 1,
	    @rank := (CASE
		WHEN @temp_view_count = ta.reps THEN
		    @rank
		WHEN @temp_view_count := ta.reps THEN
		    @index
		WHEN @temp_view_count = 0 OR @temp_view_count IS NULL THEN
		    @index
		END) AS rank
        FROM
        (
	    SELECT *
	    FROM lin_forum
	    ORDER BY reps DESC
        ) AS ta,
        ( SELECT @rank := 0 ,@rowtotal := NULL ,@index := 0 ) r
    ) AS temp");
        
        //pre($data);
        return view('home.forum.list',compact('adv','mod','hot','member','data','page','count','id','todayf'));
    }
    
    public function forumListDetail($id,Request $request)
    {
        $pid = $request->pid;
        $forum = Forum::select("forum.*","member.nickname","member.userface","member.score",'forum_category.defectsname')
                ->join('member', 'member.id', '=', 'forum.uid')
                ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
                ->where("forum.forum_id",$id)
                ->where("forum.display",1)
                ->first();
        //$pid = $forum->pid;
        $forum->forumNum = Forum::where('uid',$forum->uid)->count();
        if(empty($forum)){//没有转404
            abort(404);
        }else{
           $pid = $forum->pid; 
        }
        //pre($forum);
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 12;
        $data = ForumRep::select("forum_rep.*","member.nickname","member.userface","member.score")
                ->where('forum_rep.display',1)
                ->join('member', 'member.id', '=', 'forum_rep.uid')
                ->where('forum_rep.forum_id',$id)
                ->orderby('forum_rep.created_at',"asc")
                ->skip($limit*($page-1))->take($limit)
                ->get();
        //$iid[] = array();
        //pre($data);
        $iid[] = intval($id);
        foreach($data as $v){
            if(!empty($v->rep_id)){
                $v->child = ForumRep::select("forum_rep.*","member.nickname","member.userface")
                    ->where('forum_rep.display',1)
                    ->join('member', 'member.id', '=', 'forum_rep.uid')
                    ->where('forum_rep.repid',$v->rep_id)
                 ->first();
                $v->forumNum = Forum::where('uid',$v->uid)->count();
            }
            $iid[] = $v->repid;
        }
        $count = ForumRep::select("forum_rep.*","member.nickname","member.userface")
                ->where('forum_rep.display',1)
                ->join('member', 'member.id', '=', 'forum_rep.uid')
                ->where('forum_rep.forum_id',$id)
                ->count();
        
        
        //pre(session()->all());
        //pre($iid);
        $iid = json_encode($iid);
        //pre($iid);
        Forum::where("forum_id",$id)->increment('views');
        $mod = ForumCategory::where("id",$pid)->where("is_display",1)->first();
        $is_show = 1;
        if($forum->rep_view==1){
            $re = ForumRep::where('forum_id',$forum->forum_id)
                    ->where("uid",session('userinfo.id'))
                    ->count();
            if($re==0)
                $is_show = 0;
        }
        return view('home.forum.listDetail',compact('forum','data','mod','count','page','iid','is_show'));
    }
    
    public function guide(Request $request){
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
        $filter = $request->filter;
        $keywords = $request->keywords;
        !empty($filter)?$fil = $filter: $fil ="lastrepcreated_at";
        $data = Forum::select("forum.*","member.nickname","member.userface","forum_category.defectsname")
               ->where('forum.display',1)
                ->where(function ($query) use ($request) { 
                    $keywords = (!empty($request->keywords)) ? $request->keywords : '';
                    if(!empty($keywords)){
                        $query->where('forum.title', 'like', '%'.$keywords.'%')
                              ->orWhere('forum_category.defectsname', 'like', '%'.$keywords.'%')
                              ->orWhere('forum.content', 'like', '%'.$keywords.'%');
                    } 
                })
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum_category.id', '=', 'forum.pid')
//               ->where("forum.pid",$id)
               ->orderby("forum.is_top", "desc")
//               ->orderby("forum.".$fil, "desc")
                ->skip($limit*($page-1))->take($limit)
                ->get()
                ->toArray();
        foreach($data as $k=>$v){
            $lastrep = ForumRep::select("member.nickname","forum_rep.created_at")
                ->where("forum_rep.forum_id",$v['forum_id'])
                ->where(function ($query) use ($request) { 
                    if(!empty($keywords)){
                        $query->where('forum.title', 'like', '%'.$keywords.'%')
                              ->orWhere('forum_category.defectsname', 'like', '%'.$keywords.'%')
                              ->orWhere('forum.content', 'like', '%'.$keywords.'%');
                    } 
                })
                ->join('member', 'member.id', '=', 'forum_rep.uid')
                ->orderby("forum_rep.created_at", "desc")
                ->first();
//            if($lastrep){
                $data[$k]['lastrepname'] = $lastrep['nickname'];
                $data[$k]['lastrepcreated_at'] = $lastrep['created_at'];
//            }
        }
        $count = Forum::where('forum.display',1)
                ->where(function ($query) use ($request) { 
                    $keywords = (!empty($request->keywords)) ? $request->keywords : '';
                    if(!empty($keywords)){
                        $query->where('forum.title', 'like', '%'.$keywords.'%')
                              ->orWhere('forum_category.defectsname', 'like', '%'.$keywords.'%')
                              ->orWhere('forum.content', 'like', '%'.$keywords.'%');
                    } 
                })
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum_category.id', '=', 'forum.pid')
//               ->where("forum.pid",$id)
               ->count();
        //pre($data);
        array_multisort(array_column($data,$fil),SORT_DESC,$data);
        
        return view('home.forum.guide',compact('data','count','page','fil','keywords'));
    }
    
    public function forumAdd(Request $request){
        if(is_ajax()){
           $data['title'] = $request->title;
           $data['type'] = $request->type;
           $data['content'] = $request->content;
           $data['pid'] = $request->pid;
           isset($request->rep_view)?$data['rep_view'] = 1:$data['rep_view'] =0;
           $data['uid'] = session('userinfo.id');
           Forum::create($data);
           return response()->json(array('code' => 1, 'msg' =>"发帖成功!"));
        }
        
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        $mod = ForumCategory::formatTree(ForumCategory::listToTree($Category));
        $ftype = Ftype::select()->where('display',1)->get()->toArray();
        //pre($mod);
        return view('home.forum.forumAdd',compact('mod','ftype'));
    }
    
    public function forumRep(Request $request){
        if(is_ajax()){
            //pre($request->all());
            $d['uid'] = session('userinfo.id');
            $d['forum_id'] = $request->forum_id;
            $d['content'] = $request->message;
            ForumRep::create($d);
            Forum::where("forum_id",$request->forum_id)->increment('reps');
            return response()->json(array('code' => 1, 'msg' =>"回复成功!"));
        }
    }
    
}
