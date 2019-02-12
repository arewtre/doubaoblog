<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Video;
use App\Http\Model\VideoCate;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\VideoUploadController;

class VideoController extends CommonController
{
    public function __construct(Request $request){
        $Category = VideoCate::select()->get()->toArray();
        $CategoryList = VideoCate::formatTree(VideoCate::listToTree($Category));
        View::share('CategoryList',$CategoryList);
    }
    
     public function index(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['keyword','pid','page','limit']));
            $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
            $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
            isset($input['pid'])?$cid = $input['pid']:$cid ="";
            $xc = Video::select()
                    ->join('video_category', 'video_category.id', '=', 'video.v_cid')
                    ->where(function ($query) use ($input) {
                        $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                        if(!empty($input['keyword'])){
                            $query->where('video.v_name', 'like', '%'.$keyword.'%');
                        } 
                    })
                    ->where(function ($query) use ($input) {
                        if(!empty($cid)){
                            $query->where('video.v_cid','=',$cid);
                        } 
                    })
                    ->orderby("video.created_at","desc")
                    ->skip($limit*($page-1))->take($limit)
                    ->get();

            $count = Video::select()
                    ->join('video_category', 'video_category.id', '=', 'video.v_cid')
                    ->where(function ($query) use ($input) {
                        $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                        if(!empty($input['keyword'])){
                            $query->where('video.v_name', 'like', '%'.$keyword.'%');
                        } 
                    })
                    ->where(function ($query) use ($input) {
                        if(!empty($cid)){
                            $query->where('video.v_cid','=',$cid);
                        } 
                    })
                    ->count();

            $datainfo =  array(
                'code'  =>  0,
                'msg'   =>  '',
                'count' =>  $count,
                'data'  =>$xc,
                'size'  =>$limit,
            );

            return response()->json($datainfo);
        }
         return view('admin.video.list'); 
     }
    
    public function del(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $res = Video::where('v_id',$input['id'])->first();
            $upload = new VideoUploadController();
            $upload->delqiniu($res->v_url);
            $id = Video::where('v_id',$input['id'])->delete();
            
            if($id){
                return response()->json(array('code' => 1, 'msg' => '删除成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '删除失败！'));
            }
        }
    
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->only('v_name','is_member','v_cid','is_top','v_desc','v_url');
            $input['uid'] = 1;
//            $input['update_editor'] = session("user.user_name");
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            isset($input['is_member'])?$input['is_member']=1:$input['is_member']=0;
            $id = Video::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        
        return view('admin.video.add');
    
    }
    
    public function edit(Request $request)
    {
        $detail = Video::where("v_id",$request->id)->first();
        if ($request->isMethod('post')) {
            $input = $request->only('v_id','v_name','is_member','v_cid','is_top','v_desc');
            //pre($detail);
            $detail = Video::where("v_id",$request->v_id)->first();
            $input['uid'] = 1;
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            isset($input['is_member'])?$input['is_member']=1:$input['is_member']=0;
            $id = Video::where("v_id",$input['v_id'])->update($input);
            
            if($id){               
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        return view('admin.video.edit',compact('detail'));
    
    }
    
    
    public function videoAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['uid'] = 1;
//            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
//            isset($input['is_member'])?$input['is_member']=1:$input['is_member']=0;
            $id = Images::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        $v_id = $request->v_id;
        return view('admin.video.videoAdd',compact('v_id'));
    
    }
    public function cateList(Request $request)
    {

        return view('admin.video.cateList',compact(""));
    
    }
    
    public function cateAdd(Request $request)
    {
        
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $result = VideoCate::create($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        $pid = $request->pid;
        if($pid==0){
            $lev = 0;
            $pid = 0;
            $CategoryList = VideoCate::where('pid', '0')->orderBy('descid', 'asc')->get();
        }else{
            $lev = 1;
            $pid = $request->pid;
            $CategoryList = VideoCate::select('id','pid','defectsname')->where('id',$pid)->get();
        }
        $id = $request->pid;
        return view('admin.video.cateAdd', compact('CategoryList','lev','pid','id'));
    
    }
    
    public function cateEdit(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->only(['id','defectsname','is_display', 'pid', 'new_sign', 'descid','img','dec']);
            //pre($input);
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $input['pid']==0?$input['level']=0:$input['level']=1;
            $result = VideoCate::where('id', $request->id)->update($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        $data = VideoCate::where('id', $request->id)->first();
        return view('admin.video.cateEdit',compact("data"));
    
    }
    
     public function cateDel(Request $request)
    {
    
        $result = VideoCate::where('pid', $request->id)->count();
        if($result>0){
            return response()->json(['status' => 0, 'msg' => '该分类下有子分类,请先删除子分类！']);
        }else{
            $video = Video::where("v_cid",$request->id)->count();
            if($video>0){
                return response()->json(['status' => 0, 'msg' => '该分类下有视频,请先删除照片！']);
            }
            VideoCate::where('id', $request->id)->delete();
            return response()->json(['status' => 1, 'msg' => '删除分类成功！']); 
        }
        
    
    }


}
