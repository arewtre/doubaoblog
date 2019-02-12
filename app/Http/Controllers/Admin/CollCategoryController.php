<?php

namespace App\Http\Controllers\Admin;
use App\Models\Common\CollCategory;
use App\Models\Common\CollOption;
use App\Http\Requests\Admin\CollCategory\CreateRequest;
use App\Http\Requests\Admin\CollCategory\UpdateRequest;
use Style;

class CollCategoryController extends CommonController{

    public function __construct(){
    }

    /**
     * 分类列表
     * @return mixed
     */
    public function index(){
        $collCategory = CollCategory::paginate(20);
        return view('admin.category.coll_category.index',compact('collCategory'));
    }

    /**
     * 添加分类
     * @return mixed
     */
    public function create(){
        return view('admin.category.coll_category.create');
    }

    /**
     * 添加分类提交
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request){
        $result = CollCategory::create($request->all());
        if($result){
            flash('分类管理添加成功', 'success');
            return redirect('admin/coll_category');
        }else{
            return back()->with('errors','分类管理添加失败，请稍后重试！');
        }
    }

    /**
     * 编辑分类
     * @param $id
     * @return mixed
     */
    public function edit($id){
        $collCategoryData = CollCategory::find($id);
        return view('admin.category.coll_category.edit',compact('collCategoryData'));
    }

    /**
     * 更新分类
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request,$id){
        $collCategory = CollCategory::where('id',$id)->first()->toArray();
        $input = $request->except(['_method','_token']);
        $result = CollCategory::where('id',$id)->update($input);
        if($result){
            //更新分类管理成功 子类选项更新
            $collOption['sign'] = $request->input('sign');
            CollOption::where('sign',$collCategory['sign'])->update($collOption);
            flash('更新分类成功', 'success');
            return redirect('admin/coll_category');
        }else{
            return back()->with('errors','更新前和更新后数据相同，更新失败！！');
        }
    }

    /**
     * 删除分类
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $collCategoryData = CollCategory::find($id)->toArray();
        $result = CollCategory::where('id',$id)->delete();
        if($result){
            //删除分类管理下面的选项分类
            CollOption::where('sign',$collCategoryData['sign'])->delete();
            return response()->json(['status' => 0,'msg' => '删除分类成功！']);
        }else{
            return response()->json(['status' => 1,'msg' => '删除分类失败，请稍后重试！']);
        }
    }
}