<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Images;
use App\Http\Model\ImagesXc;
use App\Http\Model\ImagesXcCate;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\UploadController;

class ImagesController extends CommonController
{
    public function __construct(Request $request){
        $Category = ImagesXcCate::select()->get()->toArray();
        $CategoryList = ImagesXcCate::formatTree(ImagesXcCate::listToTree($Category));
        View::share('CategoryList',$CategoryList);
    }
    
    public function index(Request $request)
    {
        $input = $request->all(); 
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) :8;
        isset($input['pid'])?$cid = $input['pid']:$cid ="";
        $xc = ImagesXc::select("image_xc.*")
                ->join('images_category', 'images_category.id', '=', 'image_xc.pid')
                ->where(function ($query) use ($input) {
                    $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                    if(!empty($input['keyword'])){
                        $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
                    } 
                })
                ->where(function ($query) use ($input) {
                    if(!empty($cid)){
                        $query->where('image_xc.pid', '=', $cid);
                    } 
                })
                ->orderby("image_xc.created_at","desc")
                ->skip($limit*($page-1))->take($limit)
                ->get();
                
        $count = ImagesXc::select()
                ->join('images_category', 'images_category.id', '=', 'image_xc.pid')
                ->where(function ($query) use ($input) {
                    $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                    if(!empty($input['keyword'])){
                        $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
                    } 
                })
                ->where(function ($query) use ($input) {
                    if(!empty($cid)){
                        $query->where('image_xc.pid', '=', $cid);
                    } 
                })
                ->count();
                //pre($xc);
        return view('admin.images.index',compact("xc","count","limit","page","cid"));

    }
    
    
    
    public function del(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $res = Images::where("cate_id",$input['id'])->get();
            if($res){
                return response()->json(array('code' => 0, 'msg' => '该相册下有照片,请先删除照片！'));
            }
            $id = ImagesXc::where('xc_id',$input['id'])->delete();
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
            $input = $request->only('xc_name','is_member','pid','is_top','xc_desc','fengm');
            $input['uid'] = 1;
//            $input['update_editor'] = session("user.user_name");
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            isset($input['is_member'])?$input['is_member']=1:$input['is_member']=0;
            $id = ImagesXc::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        
        return view('admin.images.add');
    
    }
    
    public function edit(Request $request)
    {
        $detail = ImagesXc::where("xc_id",$request->id)->first();
        if ($request->isMethod('post')) {
            $input = $request->only('xc_id','xc_name','is_member','pid','is_top','xc_desc','fengm');
            //pre($detail);
            $detail = ImagesXc::where("xc_id",$request->xc_id)->first();
            $input['uid'] = 1;
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            isset($input['is_member'])?$input['is_member']=1:$input['is_member']=0;
            $id = ImagesXc::where("xc_id",$input['xc_id'])->update($input);
            
            if($id){
                //@unlink($detail->art_thumb);
                if($input['fengm']!=$detail->fengm){
                    $dd = new UploadController();
                    $dd->delqiniu($detail->fengm);
                }
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        return view('admin.images.edit',compact('detail'));
    
    }
    
    public function imageList($id,Request $request)
    {
    
        $images = Images::where("cat_id",$id)
                    ->get();
        return view('admin.images.imageList',compact("images","id"));
    
    }
    public function imagesAdd(Request $request)
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
        $xc_id = $request->xc_id;
        return view('admin.images.imagesAdd',compact('xc_id'));
    
    }
    public function cateList(Request $request)
    {

        return view('admin.images.cateList',compact(""));
    
    }
    
    public function cateAdd(Request $request)
    {
        
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $result = ImagesXcCate::create($input);
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
            $CategoryList = ImagesXcCate::where('pid', '0')->orderBy('descid', 'asc')->get();
        }else{
            $lev = 1;
            $pid = $request->pid;
            $CategoryList = ImagesXcCate::select('id','pid','defectsname')->where('id',$pid)->get();
        }
        $id = $request->pid;
        return view('admin.images.cateAdd', compact('CategoryList','lev','pid','id'));
    
    }
    
    public function cateEdit(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->only(['id','defectsname','is_display', 'pid', 'new_sign', 'descid','img','dec']);
            //pre($input);
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $input['pid']==0?$input['level']=0:$input['level']=1;
            $result = ImagesXcCate::where('id', $request->id)->update($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        $data = ImagesXcCate::where('id', $request->id)->first();
        return view('admin.images.cateEdit',compact("data"));
    
    }
    
     public function cateDel(Request $request)
    {
    
        $result = ImagesXcCate::where('pid', $request->id)->count();
        if($result>0){
            return response()->json(['status' => 0, 'msg' => '该分类下有子分类,请先删除子分类！']);
        }else{
            $images = Images::where("cat_id",$request->id)->count();
            if($images>0){
                return response()->json(['status' => 0, 'msg' => '该分类下有照片,请先删除照片！']);
            }
            ImagesXcCate::where('id', $request->id)->delete();
            return response()->json(['status' => 1, 'msg' => '删除分类成功！']); 
        }
        
    
    }


}
