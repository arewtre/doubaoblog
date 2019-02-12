<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Style;
use App\Models\Common\CollTown;
use App\Models\Common\CollArea;
use App\Http\Requests\Admin\CollTown\CreateRequest;
use App\Http\Requests\Admin\CollTown\UpdateRequest;
use Illuminate\Http\Request;

class CollTownController extends CommonController{
    /**
     * 构造函数
     * CollTownController constructor.
     */
    public function __construct(){
        //
    }

    /**
     * 街道坐标列表
     * @return mixed
     */
    public function index(Request $request){
        $input = arrayFilter($request->only(['keyword']));
        $collTown = CollTown::where(function($query) use ($input){
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(strlen($keyword) > 0){
                $query->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('en_name', 'like', '%' . $keyword . '%');
            }
        })->orderBy('cid', 'asc')->paginate(20);

        foreach($collTown as $v){
            $v->currCity = CollArea::getAreaName($v->pid);
        }
        return Style::view('admin.category.coll_town.index', compact('collTown'));
    }

    /**
     * 添加街道坐标
     * @return mixed
     */
    public function create(){
        return Style::view('admin.category.coll_town.create');
    }

    /**
     * 乡镇管理添加提交
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request){
        $input = $request->only(['name', 'en_name', 'cid', 'pid', 'longitude', 'latitude', 'sort']);
        $result = CollTown::create($input);
        if($result){
            flash('添加乡镇管理成功', 'success');
            return redirect('admin/coll_town');
        }else{
            return back()->with('error', '乡镇管理添加失败，请稍后重试！');
        }
    }

    /**
     * 编辑乡镇
     * @param $id
     * @return mixed
     */
    public function edit($id){
        $collTown = CollTown::where('id', $id)->first();
        return Style::view('admin.category.coll_town.edit', compact('collTown'));
    }

    /**
     * 更新乡镇
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, $id){
        $input = $request->only(['name', 'en_name', 'cid', 'pid', 'longitude', 'latitude', 'sort']);
        $result = CollTown::where('id', $id)->update($input);
        if($result){
            flash('修改乡镇管理成功', 'success');
            return redirect('admin/coll_town');
        }else{
            return back()->with('error', '乡镇管理修改失败，请稍后重试！');
        }
    }

    /**
     * 删除乡镇
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $result = CollTown::where('id', $id)->delete();
        if($result){
            return response()->json(['status' => '0', 'msg' => '删除乡镇管理成功！']);
        }else{
            return response()->json(['status' => '0', 'msg' => '删除乡镇管理失败，请稍后重试！']);
        }
    }

    /**
     * 乡镇地图设置
     * @param  $request
     */
    public function townMap(Request $request){
        return Style::view("admin.category.coll_town.townMap");
    }
}



   



