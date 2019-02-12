<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CollPlace\CreateRequest;
use App\Http\Requests\Admin\CollPlace\UpdateRequest;
use App\Models\Admin\CollPlace;
use App\Models\Common\CollArea;
use Illuminate\Http\Request;

use Style;

class CollPlaceController extends CommonController{

    public function __construct(){
    }

    /**
     * 地方(点)列表
     * @return mixed
     */
    public function index(){
        $collPlace = CollPlace::orderBy('cid', 'asc')->paginate(20);
        foreach($collPlace as $v){
            $v->currCity = CollArea::getAreaName($v->pid);
        }
        return view('admin.category.coll_place.index', compact('collPlace'));
    }

    /**
     * 当前地方(点)列表
     * @param $pid
     * @return mixed
     */
    public function show($pid){

    }

    /**
     * 添加地方(点)
     * @return mixed
     */
    public function create(){
        return view('admin.category.coll_place.create');
    }

    /**
     * 添加地方(点)提交
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request){
        $input = $request->only(['name', 'cid', 'pid', 'sort', 'longitude', 'latitude']);
        $result = CollPlace::create($input);
        if($result){
            flash('添加地标管理成功', 'success');
            return redirect('admin/coll_place');
        }else{
            return back()->with('errors', '地标管理添加失败，请稍后重试！');
        }
    }

    /**
     * 编辑地方(点)
     * @param $id
     * @return bool
     */
    public function edit($id){
        $collPlace = CollPlace::find($id);
        return view('admin.category.coll_place.edit', compact('collPlace'));
    }

    /**
     * 更新地方(点)
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id){
        $input = $request->only(['name', 'cid', 'pid', 'sort', 'longitude', 'latitude']);
        $result = CollPlace::where('id', $id)->update($input);
        flash('更新地标管理成功', 'success');
        return redirect('admin/coll_place');
    }

    /**
     * 删除地方(点)
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $result = CollPlace::where('id', $id)->delete();
        if($result){
            return response()->json(['status' => 0, 'msg' => '删除地标管理成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '删除地标管理失败，请稍后重试！']);
        }
    }

    /**
     * 地标地图设置
     * @param  $request
     */
    public function placeMap(Request $request){
        return view("admin.category.coll_place.placeMap");
    }

}