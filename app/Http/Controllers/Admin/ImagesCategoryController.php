<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\ImagesXcCate;
use DB, View;

class ImagesCategoryController extends Controller{
    /**
     * 分类列表
     * @return mixed
     */ 
    public function index(){
        $Category = ImagesXcCate::select()->orderBy('descid', 'asc')->get()->toArray();
        $CategoryList = ImagesXcCate::formatTree(ImagesXcCate::listToTree($Category));
        //pre($CategoryList);
        return view('admin.images.cateList', compact('CategoryList'));
    }
    
 

    /**
     * 分类添加
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request){
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
        $level = $request->level;
        if($level==0){
            $lev = 1;
            $pid = 0;
            $CategoryList = ImagesXcCate::where('pid', '0')->orderBy('descid', 'asc')->get();
        }else{
            $lev = $level+1;
            $pid = $request->pid;
            $CategoryList = ImagesXcCate::select('id','pid','defectsname')->where('id',$pid)->get();
        }
        $id = $request->pid;
        return view('admin.images.cateAdd', compact('CategoryList','lev','pid','id'));
    }

    public function store(ImagesClass $request){
        $input = $request->only(['defectsname', 'level', 'pid', 'new_sign', 'descid']);
        $result = ImagesXcCate::create($input);
        if($result){
            flash('添加分类成功', 'success');
            return redirect('admin/imagescategory');
        }else{
            return back()->with('errors', '添加分类失败，请稍后重试！');
        }
    }

    /**
     * 相册修改
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function edit($id, Request $request){
        switch($request->level){
            case "0":
                //一级分类
                $firstClass = ImagesXcCate::where('id', $id)->first();
                return view('admin.imagescategory.editFirstClass', compact('firstClass'));
                break;
            case "1"://二级分类
                //查询父类 类别
                $bigCategory = ImagesXcCate::select('id', 'defectsname')->where('pid', 0)->get();
                //二级类的信息
                $secondClass = ImagesXcCate::where('id', $id)->first();
                return view('admin.images.cateEdit', compact('bigCategory', 'secondClass'));
                break;
        }
    }

    /**
     * 分类更新
     * @param $id
     * @param ImagesClass $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request){
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
        $CategoryList = ImagesXcCate::where('pid', '0')->orderBy('descid', 'asc')->get();
        return view('admin.images.cateEdit', compact('data','CategoryList'));
    }

    /**
     * 相册删除
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request){
        $level = $request->level;
        if($level == '0'){
            $result = ImagesXcCate::where('pid', $id)->orWhere('id', $id)->delete();
            if($result){
                //ImagesXcCate::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除相册分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除相册分类失败！']); 
            }
        }else{
            $result = ImagesXcCate::where('id', $id)->delete();
            if($result){
                ImagesXcCate::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除相册分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除相册分类失败！']);
            }
        }
    }
}
