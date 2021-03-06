<?php

namespace App\Http\Controllers\Wap;
use Illuminate\Http\Request;
use App\Http\Model\Images;
use App\Http\Model\ImagesXc;
use App\Http\Model\Member;
use App\Http\Model\ImagesXcCate;
use App\Http\Model\ImageRep;
use View;
use DB;
class ImagesController extends CommonController
{
    public function __construct(Request $request){
        //
        parent::__construct();        
    }
    
     public function index(Request $request)
    {
        $input = $request->all();
        //pre($input);
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
        $filter = $request->filter;
        !empty($filter)?$fil = $filter: $fil ="is_top";
        $xc = ImagesXc::select("image_xc.*","images_category.defectsname","member.nickname","member.userface")
            ->join('images_category', 'image_xc.pid', '=', 'images_category.id')
            ->join('member', 'member.id', '=', 'image_xc.uid')
            ->where(function ($query) use ($input) {
               $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
               if(!empty($input['keyword'])){
                   $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
               } 
           })
           ->where(function ($query) use ($input) {
               $cate = (!empty($input['pid'])) ? $input['pid'] : '';
               if(!empty($input['pid'])){
                   $query->where('images_category.pid', '=', $cate);
               } 
           })
           ->where(function ($query) use ($input) {
               $scate = (!empty($input['sid'])) ? $input['sid'] : '';
               if(!empty($input['sid'])){
                   $query->where('image_xc.pid', '=', $scate);
               } 
           })
           ->orderby("image_xc.".$fil,"desc")
           ->skip($limit*($page-1))->take($limit)
           ->get();
           //pre($xc);
            $count = ImagesXc::select()
                ->join('images_category', 'image_xc.pid', '=', 'images_category.id')
                ->join('member', 'member.id', '=', 'image_xc.uid')
                ->where(function ($query) use ($input) {
                   $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                   if(!empty($input['keyword'])){
                       $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
                   } 
               })
               ->where(function ($query) use ($input) {
               $cate = (!empty($input['pid'])) ? $input['pid'] : '';
               if(!empty($input['pid'])){
                   $query->where('images_category.pid', '=', $cate);
               } 
           })
           ->where(function ($query) use ($input) {
               $scate = (!empty($input['sid'])) ? $input['sid'] : '';
               if(!empty($input['sid'])){
                   $query->where('image_xc.pid', '=', $scate);
               } 
           })
                ->count();    
               //pre($count);
           foreach($xc as $k=>$v){
                $xc[$k]['num'] = Images::select()
                        ->where("cat_id",$v->xc_id)
                        ->where("status",0)
                        ->count();
            }
            $cid = $request->pid;
            $sid = $request->sid;
            $ixcate = ImagesXcCate::where("pid",0)->get();
            $ixcateson = ""; 
            if($cid>0){
                $ixcateson = ImagesXcCate::where("pid",$cid)->get();
                foreach($ixcateson as $k=>$v){
                    $ixcateson[$k]['num'] = Images::select()
                            ->join('image_xc', 'image_xc.xc_id', '=', 'image.cat_id')
                            ->where("image_xc.pid",$v->id)
                            ->where("image.status",0)
                            ->count();
                }
            }
            //pre($ixcateson);
            $counts = Images::where('status',0)->count();
            $todayf = DB::table('image')
                ->where('status',0)
                ->whereDate('created_at','=', date("Y-m-d"))
                ->count(); //今日帖子数
            $xcnum = ImagesXc::where("status",1)->count();
            return view('wap.images.imageXc',compact("xc",'page','count','filter','limit','counts','cid','sid','ixcate','ixcateson',"todayf","xcnum"));
        }  
        
         public function imageList($id,Request $request)
        {

            $images = Images::where("cat_id",$id)
                    ->get();
            //pre($images);
            ImagesXc::where("xc_id",$id)->increment('xc_view');
            $xc = ImagesXc::select("image_xc.*","images_category.defectsname","member.nickname","member.userface")
                    ->join('images_category', 'image_xc.pid', '=', 'images_category.id')
                    ->join('member', 'member.id', '=', 'image_xc.uid')
                    ->where("xc_id",$id)
                    ->first();
            $data = ImageRep::select("image_rep.*","member.nickname","member.userface")
                ->where('image_rep.display',1)
                ->join('member', 'member.id', '=', 'image_rep.uid')
                ->where('image_rep.xc_id',$id)
                ->orderby('image_rep.created_at',"asc")
                ->get();
            foreach($data as $v){
                if(!empty($v->rep_id)){
                    $v->child = ImageRep::select("image_rep.*","member.nickname","member.userface")
                        ->where('image_rep.display',1)
                        ->join('member', 'member.id', '=', 'image_rep.uid')
                        ->where('image_rep.repid',$v->rep_id)
                     ->first();
                }
            }

            //pre(session('userinfo.id'));
             return view('wap.images.imageList',compact("images","xc","data"));
        }  
         
        public function image_album($id,Request $request){
         
            $imageUrl = Images::where("cat_id",$id)->get();
            return view('wap.images.image_album',compact('imageUrl','id'));  
     }
     
     public function reply(Request $request){
        if(is_ajax()){
            $d['uid'] = session('userinfo.id');
            $d['xc_id'] = $request->xc_id;
            $d['rep_id'] = $request->rep_id;
            $d['content'] = $request->content;
            //pre($d);
            ImageRep::create($d);
            ImagesXc::where("xc_id",$request->xc_id)->increment('xc_rep');
            return response()->json(array('code' => 1, 'msg' =>"回复成功!","fid"=>$request->xc_id));
        }        
        $xc_id = $request->xc_id;
        $xc = ImagesXc::select("xc_name")->where("xc_id",$xc_id)->first();
        $rep_id = $request->rep_id;
        
        $imageRep = ImageRep::select("image_rep.*","member.nickname","member.userface")
                 ->where('image_rep.display',1)
                 ->join('member', 'member.id', '=', 'image_rep.uid')
                 ->where('image_rep.repid',$rep_id)
                 ->first(); 
        //pre($rep_id);
        return view('wap.images.reply',compact('xc','xc_id','imageRep','rep_id'));  
    }
    
}
