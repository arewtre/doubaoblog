<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\Member;
use App\Http\Model\Collect;
use App\Http\Model\Openid;
use App\Http\Model\Forum;
use App\Http\Model\ForumZan;
use App\Http\Model\MemberViewHistory;
use App\Http\Model\ForumWxComment;
use App\Http\Model\ForumWxRep;
use App\Http\Model\MemberMsg;
use App\Http\Model\MemberMsgRep;
use Redrain\express\LaravelExpress;
use View;
use Express;
class MyController extends CommonController
{
    private $user;
    
    public function __construct(){
        parent::__construct();
    }
    

    /**
     * 用户信息
     * @param $open_id
     * @param $userInfo
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        $data['fcount'] = Forum::where('display',1)
            ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
                ->where('forum_category.is_display',1)
               ->where('forum.uid',$request->user_id)
               ->where('forum.display',1)
               ->count();
        $data['zancount'] = ForumZan::select()
                ->join('forum', 'forum.forum_id', '=', 'forum_zan.forum_id')
                ->where('forum.uid',$request->user_id)
                ->where('forum.display',1)
               ->count();
        $data['msgcount'] = MemberMsg::select("*")
               ->join('member_msg_rep', 'member_msg.msgid', '=', 'member_msg_rep.msgid')
               ->where('member_msg_rep.type',0)
               ->where('member_msg_rep.status',1)
               ->where('member_msg.uid',$request->user_id)
               ->count();
        return $this->success($data);
    }
    
    /**
     * 最新用户列表
     * @param $open_id
     * @param $userInfo
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public function memberList(Request $request)
    {
        $data= Member::select("*")
               ->join('openid', 'member.id', '=', 'openid.uid')
               ->where('member.status',1)
               ->orderby("member.created_at", "desc")
               ->get();
        return $this->success($data);
    }
    
    /**
     * 用户收藏信息
     * @param $open_id
     * @param $userInfo
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public function myCollect(Request $request)
    {
        
        $limit = isset ( $request->limit ) ? intval ( $request->limit) : 8;
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        //pre($request->cid);
        switch ($request->cid)
        {
        case 1:
            $collect = Collect::select("collect.*","collect.created_at as cdate",'forum.created_at','forum.forum_id','forum.title','forum.content','forum.views','forum.reps','forum.zan',"member.nickname","member.userface")
                ->join('forum', 'collect.forum_id', '=', 'forum.forum_id')
                ->join('member', 'member.id', '=', 'collect.uid')
                ->where("collect.uid",$request->user_id)
                ->orderby("collect.created_at", "desc")
                ->skip($limit*($page-1))->take($limit)
                ->get();
          break;  
        case 2:
            $collect = ForumWxComment::select("forum_wx_comment.created_at as cdate","forum_wx_comment.content as com",'forum.forum_id','forum.title','forum.created_at','forum.content','forum.views','forum.reps','forum.zan',"member.nickname","member.userface")
                ->join('forum', 'forum_wx_comment.forum_id', '=', 'forum.forum_id')
                ->join('member', 'member.id', '=', 'forum.uid')
                ->where("forum_wx_comment.uid",$request->user_id)
                ->orderby("forum_wx_comment.created_at", "desc")
                ->skip($limit*($page-1))->take($limit)
                ->get(); 
            foreach($collect as $v){
                $v->com = userTextDecode($v->com);
            }
          break;
        case 3:
            $collect = ForumZan::select("forum_zan.*","forum_zan.created_at as cdate",'forum.created_at','forum.forum_id','forum.title','forum.content','forum.views','forum.reps','forum.zan',"member.nickname","member.userface")
                ->join('forum', 'forum_zan.forum_id', '=', 'forum.forum_id')
                ->join('member', 'member.id', '=', 'forum_zan.uid')
                ->where("forum_zan.uid",$request->user_id)
                ->orderby("forum_zan.created_at", "desc")
                ->skip($limit*($page-1))->take($limit)
                ->get();
  
          break;
        case 4:
            $collect = MemberViewHistory::select("member_view_history.type","member_view_history.updated_at as cdate",'forum.created_at',"forum.*","member.nickname","member.userface")
                ->join('forum', 'member_view_history.fid', '=', 'forum.forum_id')
                ->join('member', 'member.id', '=', 'member_view_history.uid')
                ->where("member_view_history.uid",$request->user_id)
                ->orderby("member_view_history.updated_at", "desc")
                ->skip($limit*($page-1))->take($limit)
                ->get();  
          break;
          default:
          
        }
        //pre($collect);
        foreach($collect as $k=>$v){
            if($v->imgList==""){
                $imglist = html2img($v->content);
                if(count($imglist)>2){
                    $v->imgList = array_slice($imglist,0,3);
                }else{
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches);
                    preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                    if(!empty($matches)) {
                      $v->video = $matches[1];
                    }
                    if(!empty($matches2)) {
                        $v->video = $matches2[1];
                    }  
                }
            }else{
               $v->imgList = json_decode($v->imgList); 
            }
            $v->date = word_time($v->created_at,1);
            $v->cdate = word_time($v->cdate,1);
            $isZan = ForumZan::select("*")
                ->where('uid',$request->user_id)
                ->where('forum_id',$v->forum_id)
                ->first();
            $isCollect = Collect::select("*")
                ->where('uid',$request->user_id)
                ->where('forum_id',$v->forum_id)
                ->first();
            !empty($isCollect)?$v->isCollect=true:$v->isCollect=false;
            !empty($isZan)?$v->like=true:$v->like=false;
        }
        return $this->success($collect);
    }

    public function getExpress(Request $request) {
//        $param = $request->expressCode;
        $param = "75106699833237";
//        $express = new Redrain\Express\LaravelExpress();
        return LaravelExpress::getExpressInfoByNo($param);
    }
    
    public function getMylevelMsg(Request $request){
        $limit = isset ( $request->limit ) ? intval ( $request->limit) : 6;
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $op = $request->op;
        $data = MemberMsg::select("member_msg.*","member.nickname","member.userface")
                ->where('member_msg.status',1)
                ->join('member', 'member.id', '=', 'member_msg.uid')
                ->orderby('member_msg.created_at',"desc")
                ->where(function ($query) use ($request) {
                    if(!empty($op)){
                        $query->where('member_msg.uid', '=', $request->user_id);
                    } 
                })
                ->skip($limit*($page-1))->take($limit)
                ->get();
               
        foreach($data as &$v){
            $v->children = MemberMsgRep::select("member_msg_rep.*","member.nickname","member.userface")
                ->where('member_msg_rep.status',1)
                ->join('member', 'member.id', '=', 'member_msg_rep.uid')
                ->where('member_msg_rep.msgid',$v->msgid)
                ->orderby('member_msg_rep.created_at',"asc")    
                ->get();
                foreach($v->children as &$vv){
                    $vv->content = userTextDecode($vv->repcontent);
                    if(!empty($vv->repid)){
                        $vv->reply_name = getMsgReplyName($vv->repid);
                    }
                    if(!empty($op) && $vv->type==0){
                        MemberMsgRep::where('type',0)->update(['type'=>1]); 
                     }
                }
            $v->date = word_time($v->created_at,1);
            $v->content = userTextDecode($v->msgcontent);
        }
        
        //pre($data->toArray());
        return $this->success($data);
    }
    
    public function addMsg(Request $request){
        //pre($request->all());
        if(empty($request->comid)){
            $d['uid'] = $request->user_id;
            $d['msgcontent'] = userTextEncode($request->content);
            MemberMsg::create($d);
        }else{
            $d['uid'] = $request->user_id;
            $d['repid'] = $request->rep_id;
            $d['msgid'] = $request->comid;
            $d['repcontent'] = userTextEncode($request->content);
            MemberMsgRep::create($d);
            if(empty($request->rep_id)){
//                $com = getCommentContent($request->comid);
//                $da = getTemplateData($com->uid,$request->user_id);
//                $da['repcontent'] = $request->content;
//                $da['comcontent'] = $com->content;
//                $da['comname'] = getMemberName($com->uid);
//                $da['fid'] = $request->fid;
//                $da['title'] = $request->title;
//                $da['comtime'] = date("Y-m-d H:i:s",strtotime($com->created_at));
//                $da['reptime'] = date("Y-m-d H:i:s");
                //$res = sendMsgByRep($request->formId,$da);
            }else{
//                $com = getCommentContent($request->comid);
//                $rep = getRepContent($request->rep_id);
//                
//                $comopenid = getMemberOpenid($com->uid);
//                $repopenid = getMemberOpenid($rep->uid);
//                $da['repcontent'] = $request->content;
//                $da['repuser'] = getMemberName($request->user_id);
//                $da['fid'] = $request->fid;
//                $da['title'] = $request->title;
//                $da['reptime'] = date("Y-m-d H:i:s");
                //sendMsgByRepBack($request->formId,$comopenid,$da);
                //sendMsgByRepBack($request->formId,$repopenid,$da);
            }
        }
//        $da = getTemplateData($request->uid,$request->user_id);
//        $da['content'] = $request->content;
//        $da['title'] = $request->title;
//        $da['addtime'] = date("Y-m-d H:i:s");
        //$res = sendMsgByComment($request->formId,$da);
        //sendMsgByComment("ee784b597a2ac8f1a645704b0b1724a3",$da);
        return $this->success(array('code' => 1, 'msg' =>"留言成功!"));
    }
    
    public function publish(Request $request){
        //pre($request->all());
        $img = explode(",",$request->content);    
//        $imgs = array_slice($img,0,3);
//        foreach($imgs as &$v){
//            $v = $v."?imageView2/2/200";
//        }
        $im = "";
        foreach($img as &$v){
            $type = file_format($v);
            if($type=="image"){
                $im .="<img src='".$v."?imageView2/2/400'>";
            }elseif($type=="video"){
                $im .='<video src="'.$v.'" controls="controls" poster="'.$v.'?vframe/jpg/offset/2/h/270"> </video>';
                $v= $v.'?vframe/jpg/offset/2/h/270';
            }
        } 
        
        $data['title'] = $request->title;
        $data['keywords'] = $request->keywords;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['description'] = $request->textarea;
        count($img)>2?$data['imgList']= json_encode($img):"";
        $data['content'] = $im;
        $data['pid'] = $request->pid;
        $data['uid'] = $request->user_id;
        $iid = Forum::insertGetId($data);              
        return $this->success(array('code' => 1, 'msg' =>"发布成功!","id"=>$iid));
    }
    
}
