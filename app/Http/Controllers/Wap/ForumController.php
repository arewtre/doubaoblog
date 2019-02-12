<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\Forum;
use App\Http\Model\Blog;
use App\Http\Model\Adv;
use App\Http\Model\ForumCategory;
use App\Http\Model\ForumRep;
use View;
class ForumController extends CommonController
{
    public function __construct(){
        //View::share('cate',$cate);
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        $adv = Adv::select('ad_slots.height','ad_slots.width','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","L0")
                ->where("ad_manage.status",1)
                ->where('ad_manage.created_at', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        $mod = ForumCategory::listToTree($Category);
        return view('wap.forum.index',compact('adv','mod'));
    }
    
     public function forumList($id,Request $request)
    {
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 5;
        $mod = ForumCategory::where("id",$id)->where("is_display",1)->first();
        ForumCategory::where("id",$id)->increment('views');
        $filter = $request->filter;
        !empty($filter)?$fil =$filter: $fil ="created_at";
        if(!isset($mod)){//没有转404
            abort(404);//html2imgs
        }
        $data = Forum::select("forum.*","member.nickname","member.userface")
               ->where('forum.display',1)
               ->join('member', 'member.id', '=', 'forum.uid')
               ->where("forum.pid",$request->id)
               ->orderby("forum.is_top", "desc")
               ->orderby("forum.".$fil, "desc")
               ->skip($limit*($page-1))->take($limit)
               ->get();
        //pre($data);
        //pre(html2imgs($data[0]['content']));
        foreach($data as $k=>$v){
            preg_match('/<video[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
            //pre($matches[0]);
            if(!empty($matches)) {
                $v->video = $matches[0];
            }
        }
        //pre($data->toArray());
        $modCount = ForumCategory::where('pid',">",0)->where('is_display',1)->count();
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        $mods = ForumCategory::listToTree($Category);
        return view('wap.forum.list',compact('mod','data','filter','id',"modCount","mods"));
    }
    
    
    public function forumListDetail($id,Request $request)
    {
        $forum = Forum::select("forum.*","member.nickname","member.userface")
                ->join('member', 'member.id', '=', 'forum.uid')
                ->where("forum.forum_id",$id)->where("forum.display",1)->first();
        if(empty($forum)){//没有转404
            abort(404);
        }
        preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $forum->content, $matches);
        preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $forum->content, $matches2);
        if(!empty($matches)) {
            $forum->video = $matches[1];
            
        }
        if(!empty($matches2)) {
            $forum->video = $matches2[1];
            
        }
        
        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', mb_substr(strip_tags($forum->content),0,54,'utf-8'))>0){
            $forum->dess = mb_substr(strip_tags($forum->content),0,54,'utf-8');
        }else{
            $forum->dess = "欢迎访问豆宝网,平台拥有丰富的育儿资讯方便大家交流心得!" ;
        }
        $forum->title = "[".getCateName($forum->pid)."]".$forum->title;

        $data = ForumRep::select("forum_rep.*","member.nickname","member.userface")
                ->where('forum_rep.display',1)
                ->join('member', 'member.id', '=', 'forum_rep.uid')
                ->where('forum_rep.forum_id',$id)
                ->orderby('forum_rep.created_at',"asc")
                ->get();
        foreach($data as $v){
            if(!empty($v->rep_id)){
                $v->child = ForumRep::select("forum_rep.*","member.nickname","member.userface")
                    ->where('forum_rep.display',1)
                    ->join('member', 'member.id', '=', 'forum_rep.uid')
                    ->where('forum_rep.repid',$v->rep_id)
                 ->first();
            }
        }
        if(is_ajax()){
            //pre($request->all());
            $d['uid'] = session('userinfo.id');
            $d['forum_id'] = $request->forum_id;
            $d['content'] = $request->message;
            ForumRep::create($d);
            Forum::where("forum_id",$request->forum_id)->increment('reps');
            die(1);
        }
       // pre($data->toArray());
        Forum::where("forum_id",$id)->increment('views');
        return view('wap.forum.listDetail',compact('forum','data'));
    }
    
    public function reply(Request $request){
        if(is_ajax()){
            $d['uid'] = session('userinfo.id');
            $d['forum_id'] = $request->forum_id;
            $d['rep_id'] = $request->rep_id;
            !empty($request->rep_id)?$d['level']=1:$d['level']=0;
            $d['content'] = $request->content;
            //pre($d);
            ForumRep::create($d);
            Forum::where("forum_id",$request->forum_id)->increment('reps');
            return response()->json(array('code' => 1, 'msg' =>"回帖成功!","fid"=>$request->forum_id));
        }        
        $forum_id = $request->forum_id;
        $forum = Forum::select("title")->where("forum_id",$forum_id)->first();
        $rep_id = $request->rep_id;
        
        $forumRep = ForumRep::select("forum_rep.*","member.nickname","member.userface")
                 ->where('forum_rep.display',1)
                 ->join('member', 'member.id', '=', 'forum_rep.uid')
                 ->where('forum_rep.repid',$rep_id)
                 ->first(); 
        //pre($rep_id);
        return view('wap.forum.reply',compact('forum','forum_id','forumRep','rep_id'));  
    }
    
    public function favorite(Request $request){
        if(IS_POST){
            $data['fid'] = $request->id;
            $data['type'] = $request->type;
            $data['uid'] = session('userinfo.id');
            $data['type'] = $request->type; 
            
        }        
        

        $type = $request->type;
        if($type==2){
            $forum = Forum::select("title")->where("forum_id",$request->id)->first();
        }
        if($type==1){
            $forum = ForumCategory::select("defectsname")->where("id",$request->id)->first();
        }
        return view('wap.forum.favorite',compact('forum','type'));  
    }
    
     public function image_album($id,Request $request){
         $forum = Forum::where("forum_id",$id)->first();
         //pre($forum->content);
         $imageUrl = html2imgs($forum->content);
         //pre($imageUrl);
         return view('wap.forum.image_album',compact('imageUrl','forum'));  
     }
     
     public function chooseMod(Request $request){
         $mod = ForumCategory::select()->where('is_display',1)->where("pid",">",0)->orderBy('descid', 'asc')->get();
         return view('wap.forum.chooseMod',compact('mod'));  
     }
     
     public function sendForum(Request $request){
         if(IS_POST){
            $data['title'] = $request->title;
            //$data['type'] = $request->type;
            $data['content'] = $request->content;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['pid'] = $request->pid;
            isset($request->rep_view)?$data['rep_view'] = 1:$data['rep_view'] =0;
            $data['uid'] = session('userinfo.id');
            $iid = Forum::insertGetId($data);
            return response()->json(array('code' => 1, 'msg' =>"发帖成功!","fid"=>$iid));
            
        } 
        if(!$request->id){
            return redirect("/wap/chooseMod");
        }
        $id = $request->id;
        //pre(session('userinfo'));
        return view('wap.forum.sendForum',compact('id'));  
     }
     
     
     public function guide(Request $request){
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
        $filter = $request->filter;
        $keywords = $request->keywords;
        !empty($filter)?$fil = $filter: $fil ="created_at";
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
        $adv = Adv::select('ad_slots.height','ad_slots.width','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","P1")
                ->where("ad_manage.status",1)
                ->where('ad_manage.created_at', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        return view('wap.forum.guide',compact('data','count','page','fil','keywords',"adv",'limit'));
    }
    
}
