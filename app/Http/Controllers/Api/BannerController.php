<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Adv;
use App\Http\Model\Forum;
use App\Http\Model\ForumCategory;
use App\Http\Model\ForumWxComment;
use App\Http\Model\ForumWxRep;
use App\Http\Model\ForumZan;
use App\Http\Model\Member;
use App\Http\Model\Tips;
use App\Http\Model\MemberViewHistory;
use App\Http\Model\MemberMsg;
use App\Http\Model\MemberMsgRep;
use App\Http\Model\Collect;
use App\Http\Model\Express;
use App\Http\Model\Keywords;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
use View;
use Cache;
class BannerController extends CommonController
{
    private $user;
     
    public function __construct(Request $request){
        parent::__construct();
        
        //$this->user = Member::getMember(); 
        //pre($this->user);
    }
    
    public function test(Request $request)
    {
        //pre($request->token);
//        $user = \Cache::get($request->token); 
        

    }
    
    public function index(Request $request)
    {
        $adv = Adv::select('ad_manage.id','ad_slots.height','ad_slots.width','ad_manage.title','ad_manage.pic_url','ad_manage.url_type','ad_manage.url')
                ->join('ad_slots', 'ad_slots.id', '=', 'ad_manage.ad_slots')
                ->where("ad_slots.ad_sign","M01")
                ->where("ad_manage.status",1)
                ->where('ad_manage.start_time', '<=', date("Y-m-d"))
                ->where('ad_manage.end_time', '>=', date("Y-m-d"))
                ->orderby("ad_manage.sort","desc")
                ->get();
        return $this->success($adv);
    }
    
    
    public function getCateList(Request $request)
    {
        $cate = ForumCategory::select('*')
                ->where("level",1)
                ->where("is_display",1)
                ->where("pid",82)
                ->orderby("descid","desc")
                ->get();
       foreach($cate as $k=>$v){
          $v->catenum = getTodayCateNum($v->id); 
       }
       //pre($cate);
        return $this->success($cate);
    }
    
    public function getZhuanti(Request $request)
    {
        $cate = ForumCategory::select('*')
                ->where("level",1)
                ->where("is_display",1)
                ->where("pid",1)
                ->orderby("descid","desc")
                ->get();
       foreach($cate as $k=>$v){
          $v->img = "https://wx.linxinran.cn".$v->img; 
       }
       //pre($cate);
        return $this->success($cate);
    }
    
     public function getForumTop(Request $request)
    {
        $filter = $request->filter;
        !empty($filter)?$fil =$filter: $fil ="reps";
        $data = Forum::select("forum.*","member.nickname","member.userface")
               ->where('forum.display',1)
                ->where('forum_category.is_display',1)
               ->where('forum_category.id','>',82)
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
               ->orderby("forum.is_top", "desc")
               ->orderby("forum.".$fil, "desc")
               ->take(10)
               ->get();
        //pre($data);
        foreach($data as $k=>$v){
            preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
            preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
            if(!empty($matches)) {
                $v->video = htmlspecialchars_decode ($matches[1]);

            }
            if(!empty($matches2)) {
                $v->video = htmlspecialchars_decode ($matches2[1]);

            }
            $v->date = word_time($v->created_at,1);
            
        }
        //pre($data);
        return $this->success($data);
    }
    
     public function getForumList(Request $request)
    {
        $filter = $request->filter;
        !empty($filter)?$fil =$filter: $fil ="created_at";
        $limit = isset ( $request->limit ) ? intval ( $request->limit) : 8;
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $data = Forum::select("forum.*","member.nickname","member.userface","forum_category.defectsname")
               ->where('forum.display',1)
                ->where(function ($query) use ($request) {
                    $keywords = (!empty($request->keywords)) ? $request->keywords : '';
                    if(!empty($keywords)){
                        Keywords::addKeywords($request->keywords);
                        $query->where('forum.title', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.keywords', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.description', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.content', 'like', '%'.$keywords.'%')
                            ->orWhere('forum_category.defectsname', 'like', '%'.$keywords.'%');
                    }
                })
                ->where('forum_category.is_display',1)
               ->where('forum_category.id', '>' ,82)
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
               ->orderby("forum.created_at", "desc") 
               ->skip($limit*($page-1))
               ->take($limit)
               ->get();
        ;
        //pre(html2imgs($data[0]['content']));
        foreach($data as $k=>$v){            
            if($v->imgList==""){
                $imglist = html2img($v->content);
                if(count($imglist)>2){
                    $v->imgList = array_slice($imglist,0,3);
                }else{
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
                    preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                    if(!empty($matches)) {
                      $v->video = htmlspecialchars_decode ( $matches[1]);
                      $v->isvideo = 1;
                    }
                    if(!empty($matches2)) {
                        $v->video = htmlspecialchars_decode ( $matches2[1]);
                    }  
                }
            }else{
               $v->imgList = json_decode($v->imgList); 
            }
            $v->date = word_time($v->created_at,1);            
        }
        //pre($data);
        return $this->success($data);
    }
    
    
     public function getForumLists(Request $request)
    {
        $filter = $request->filter;
        $limit = isset ( $request->limit ) ? intval ( $request->limit) : 8;
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        !empty($filter)?$fil =$filter: $fil ="created_at";
        $data = Forum::select("forum.*","member.nickname","member.userface","forum_category.defectsname")
               ->where('forum.display',1)
                ->where('forum_category.is_display',1)
                   ->where('forum_category.pid',82)
                   ->where(function ($query) use ($request) {
                        $cid = (!empty($request->cid)) ? $request->cid : '';
                        if(!empty($cid)){
                            $query->where('forum.pid', '=', $cid);
                        }
                })
                ->where(function ($query) use ($request) {
                    $keywords = (!empty($request->keywords)) ? $request->keywords : '';
                    if(!empty($keywords)){
                        Keywords::addKeywords($request->keywords);
                        $query->where('forum.title', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.keywords', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.description', 'like', '%'.$keywords.'%')
                            ->orWhere('forum.content', 'like', '%'.$keywords.'%')
                            ->orWhere('forum_category.defectsname', 'like', '%'.$keywords.'%');
                    }
                })
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
               ->orderby("forum.created_at", "desc")
               ->skip($limit*($page-1))->take($limit)
               ->get();
        ;
        //pre(html2imgs($data[0]['content']));
        foreach($data as $k=>$v){
            if($v->imgList==""){
                $imglist = html2img($v->content);
                if(count($imglist)>2){
                    $v->imgList = array_slice($imglist,0,3);
                }else{
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
                    preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                    if(!empty($matches)) {
                      $v->video = htmlspecialchars_decode ($matches[1]);
                      $v->isvideo = 1;
                    }
                    if(!empty($matches2)) {
                        $v->video = htmlspecialchars_decode ($matches2[1]);
                    }  
                }
            }else{
               $v->imgList = json_decode($v->imgList); 
            }
            
            $v->date = word_time($v->created_at,1);
        }
        //pre($data);
        return $this->success($data);
    }
    
     public function getMyForumLists(Request $request)
    {
        
        $filter = $request->filter;
        $limit = isset ( $request->limit ) ? intval ( $request->limit) : 8;
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        !empty($filter)?$fil =$filter: $fil ="created_at";
        !empty($request->uid)?$uid =$request->uid: $uid =$request->user_id;
        $data = Forum::select("forum.*","member.nickname","member.userface","forum_category.defectsname")
               ->where('forum.display',1)
            ->where('forum_category.is_display',1)
               ->where('forum_category.pid',82)
               ->where('forum.uid',$uid)
               ->where(function ($query) use ($request) {
                    $cid = (!empty($request->cid)) ? $request->cid : '';
                    if(!empty($cid)){
                        $query->where('forum.pid', '=', $cid);
                    } 
                })
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
               ->orderby("forum.created_at", "desc")
               ->skip($limit*($page-1))->take($limit)
               ->get();
        ;
        //pre(html2imgs($data[0]['content']));
        foreach($data as $k=>$v){
            if($v->imgList==""){
                $imglist = html2img($v->content);
                if(count($imglist)>2){
                    $v->imgList = array_slice($imglist,0,3);
                }else{
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
                    preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                    if(!empty($matches)) {
                      $v->video = htmlspecialchars_decode ($matches[1]);
                    }
                    if(!empty($matches2)) {
                        $v->video = htmlspecialchars_decode ($matches2[1]);
                    }  
                }
            }else{
               $v->imgList = json_decode($v->imgList); 
            }
            $v->date = word_time($v->created_at,1);
        }
        $datas['data'] = $data;
        $datas['user']['info'] = getMember($uid);
        $datas['user']['fcount'] = Forum::where('display',1)
               ->where('uid',$uid)
               ->count();
        $datas['user']['zancount'] = ForumZan::select()
                ->join('forum', 'forum.forum_id', '=', 'forum_zan.forum_id')
                ->where('forum.uid',$uid)
               ->count();
        $datas['user']['msgcount'] = MemberMsg::select("*")
               ->join('member_msg_rep', 'member_msg.msgid', '=', 'member_msg_rep.msgid')
               ->where('member_msg_rep.type',0)
               ->where('member_msg_rep.status',1)
               ->where('member_msg.uid',$uid)
               ->count();
        //pre($data);
        return $this->success($datas);
    }
    
     public function getForumDetail(Request $request)
    {

        $data = Forum::select("forum.*","member.nickname","member.userface","forum_category.defectsname")
               ->join('member', 'member.id', '=', 'forum.uid')
               ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
               ->where('forum.display',1)
            ->where('forum_category.is_display',1)
               ->where('forum.forum_id',$request->fid)
               ->first();
        $data->date = word_time($data->created_at,1);
        preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $data->content, $matches);
        preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $data->content, $matches2);
        if(!empty($matches)) {
            $data->video = htmlspecialchars_decode ($matches[1]);
 
        }
        if(!empty($matches2)) {
            $data->video = htmlspecialchars_decode ($matches2[1]);

        }
        $isZan = ForumZan::select("*")
                ->where('uid',$request->user_id)
                ->where('forum_id',$data->forum_id)
                ->first();
        $isCollect = Collect::select("*")
                ->where('uid',$request->user_id)
                ->where('forum_id',$data->forum_id)
                ->first();
        !empty($isCollect)?$data->isCollect=true:$data->isCollect=false;
        !empty($isZan)?$data->like=true:$data->like=false;
        Forum::where("forum_id",$request->fid)->increment('views');
        
        $MemberViewHistory = MemberViewHistory::where(["uid"=>$request->user_id,"fid"=>$request->fid,"type"=>1])->first();
        $po['uid'] = $request->user_id;
        $po['fid'] = $request->fid;
        if($MemberViewHistory){
            MemberViewHistory::where(["uid"=>$request->user_id,"fid"=>$request->fid,"type"=>1])->update($po);
            MemberViewHistory::where(["uid"=>$request->user_id,"fid"=>$request->fid,"type"=>1])->increment('viewnum');
        }else{
            MemberViewHistory::create($po);
        }        
        return $this->success($data);
    }
    
    public function getForumComment(Request $request)
    {
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 6;
        $data = ForumWxComment::select("forum_wx_comment.*","member.nickname","member.userface")
                ->where('forum_wx_comment.display',1)
                ->join('member', 'member.id', '=', 'forum_wx_comment.uid')
                ->where('forum_wx_comment.forum_id',$request->fid)
                ->orderby('forum_wx_comment.created_at',"desc")
                ->take($limit)
                ->get();
        foreach($data as &$v){
            $v->children = ForumWxRep::select("forum_wx_rep.*","member.nickname","member.userface")
                ->where('forum_wx_rep.display',1)
                ->join('member', 'member.id', '=', 'forum_wx_rep.uid')
                ->where('forum_wx_rep.comid',$v->comid)
                ->orderby('forum_wx_rep.created_at',"asc")    
                ->get();
                foreach($v->children as &$vv){
                    $vv->content = userTextDecode($vv->content);
                    if(!empty($vv->rep_id)){
                        $vv->reply_name = getReplyName($vv->rep_id);
                    }
                }
            $v->date = word_time($v->created_at,1);
            $v->content = userTextDecode($v->content);
        }
        
        //pre($data->toArray());
        return $this->success($data);
    }
    
    public function addComment(Request $request){
        //pre($request->all());
        if(empty($request->comid)){
            $d['uid'] = $request->user_id;
            $d['forum_id'] = $request->fid;
            $d['content'] = userTextEncode($request->content);
            ForumWxComment::create($d);
            Forum::where("forum_id",$request->fid)->increment('reps');
        }else{
            $d['uid'] = $request->user_id;
            $d['rep_id'] = $request->rep_id;
            $d['comid'] = $request->comid;
            $d['content'] = userTextEncode($request->content);
            ForumWxRep::create($d);
            Forum::where("forum_id",$request->fid)->increment('reps');
            if(empty($request->rep_id)){
                $com = getCommentContent($request->comid);
                $da = getTemplateData($com->uid,$request->user_id);
                $da['repcontent'] = $request->content;
                $da['comcontent'] = $com->content;
                $da['comname'] = getMemberName($com->uid);
                $da['fid'] = $request->fid;
                $da['title'] = $request->title;
                $da['comtime'] = date("Y-m-d H:i:s",strtotime($com->created_at));
                $da['reptime'] = date("Y-m-d H:i:s");
                $res = sendMsgByRep($request->formId,$da);
            }else{
                $com = getCommentContent($request->comid);
                $rep = getRepContent($request->rep_id);
                
                $comopenid = getMemberOpenid($com->uid);
                $repopenid = getMemberOpenid($rep->uid);
                $da['repcontent'] = $request->content;
                $da['repuser'] = getMemberName($request->user_id);
                $da['fid'] = $request->fid;
                $da['title'] = $request->title;
                $da['reptime'] = date("Y-m-d H:i:s");
                sendMsgByRepBack($request->formId,$comopenid,$da);
                sendMsgByRepBack($request->formId,$repopenid,$da);
            }
        }
        $da = getTemplateData($request->uid,$request->user_id);
        $da['content'] = $request->content;
        $da['fid'] = $request->fid;
        $da['title'] = $request->title;
        $da['addtime'] = date("Y-m-d H:i:s");
        $res = sendMsgByComment($request->formId,$da);
        //sendMsgByComment("ee784b597a2ac8f1a645704b0b1724a3",$da);
        return $this->success(array('code' => 1, 'msg' =>"回复成功!"));
    }
    
    
    public function toZan(Request $request){
        $d['uid'] = $request->user_id;
        $d['forum_id'] = $request->fid;
        $d['comid'] = $request->rep_id;
        //pre($request->like);
        if(!empty($request->fid)){
            $isZan = ForumZan::select("*")
            ->where('uid',$request->user_id)
            ->where('forum_id',$request->fid)
            ->first();
            if(!empty($isZan)){
                ForumZan::where(["forum_id"=>$request->fid,"uid"=>$request->user_id])->delete();
                Forum::where("forum_id",$request->fid)->decrement('zan'); 
            }else{
                ForumZan::create($d);
                Forum::where("forum_id",$request->fid)->increment('zan'); 
            }

        }

        if(!empty($request->rep_id)){
          $isZan = ForumZan::select("*")
            ->where('uid',$request->user_id)
            ->where('comid',$request->rep_id)
            ->first();
          if(!empty($isZan)){
                ForumZan::where(["comid"=>$request->rep_id,"uid"=>$request->user_id])->delete();
                ForumWxComment::where("comid",$request->rep_id)->decrement('zan'); 
            }else{
                ForumZan::create($d);
                Forum::where("comid",$request->rep_id)->increment('zan'); 
            }
        }
        return $this->success(array('code' => 1, 'msg' =>"赞成功!"));
    }
    
    public function toCollect(Request $request){
        $d['uid'] = $request->user_id;
        $d['forum_id'] = $request->fid;
        $isCollect = Collect::select("*")
        ->where('uid',$request->user_id)
        ->where('forum_id',$request->fid)
        ->first();
        
        if(!empty($isCollect)){
            Collect::where(["forum_id"=>$request->fid,"uid"=>$request->user_id])->delete();
            return $this->success(array('code' => 1, 'msg' =>"您已取消收藏!"));
        }else{
            Collect::create($d);
            return $this->success(array('code' => 1, 'msg' =>"感谢您的收藏!"));
        }
        
    }
    
    public function deleteForum(Request $request){
        $isCollect = Forum::select("*")
        ->where('forum_id',$request->fid)
        ->first();        
        if(!empty($isCollect)){
            Forum::where("forum_id",$request->fid)->delete();
            return $this->success(array('code' => 1, 'msg' =>"您已成功删除!"));
        }else{
            return $this->success(array('code' => 0, 'msg' =>"删除失败!"));
        }
    }
    
     public function getGg(Request $request){
        if($request->type == 2){
            $tips = Tips::select(['content', 'created_at'])->where('status', 1)->orderBy('updated_at', 'desc')->orderBy('displayorder', 'desc')->get();
            return $this->success($tips);
        }else {
            $tips = Tips::select(['content', 'created_at'])->where('status', 1)->orderBy('updated_at', 'desc')->orderBy('displayorder', 'desc')->get()->toArray();
            $tip = "";
            foreach ($tips as $v) {
                $tip .= $v['content'] . "(" . word_time($v['created_at'], 1) . ")" . " , ";
            }
            return $this->success(substr($tip, 0, -1));
        }
    }
    
    public function getExpress(Request $request){
        $exp = getExpress($request->expCom,$request->expCode); 
        if($exp['success']==true){
            return $this->success($exp);
        }else{
            return $this->error($exp['reason']);
        }
    }
    public function gethotkeywords(Request $request){
        $key = Keywords::select()->get()->toArray();
        $keywords = array_column($key,"keywords");
        return $this->success($keywords);

    }
    
    public function getExpCom(Request $request){
       $express = Express::where("status",1)->get(['exid','kdcom','kdcode']);
        return $this->success($express);
    }
    
    public function getWeather(Request $request){
        $weather = getWeather($request->city); 
        return $this->success($weather);
    }
    
    public function getCity(Request $request){
       $weather = getCity($request->latitude,$request->longitude); 
        return $this->success($weather);
    }

    public function openPublish(Request $request){
        //$weather = getCity($request->latitude,$request->longitude);
        return $this->success(array('isopen' => 0));
    }
     
    
}
