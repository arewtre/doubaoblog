<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\CollArea;
use Illuminate\Http\Request;
use App\Http\Requests;
// use App\Http\Requests\Admin\CollArea\ProvinceCreateRequest;
// use App\Http\Requests\Admin\CollArea\CreateRequest;
// use App\Http\Requests\Admin\CollArea\UpdateRequest;
//use Style;

class CollAreaController extends CommonController{

    public function __construct(){
    }

    /**
     * 地区列表
     * @return mixed
     */
    public function index(){
        $province = CollArea::where('grade', '1')->orderBy('cid', 'asc')->get();
        //$province = setSort($province);
        return view('admin.category.coll_area.index', compact('province'));
    }

    /**
     * 当前地区列表
     * @param $pid
     * @return mixed
     */
    public function show($pid){
        //全部省
        $province = CollArea::where('grade', '1')->orderBy('cid', 'asc')->get();
        //$province = setSort($province);
        //当前省
        $provinceList = CollArea::where('pid', $pid)->where('grade', 1)->orderBy('cid', 'asc')->first();
        if($provinceList){
            //当前省地区
            $area = CollArea::where('grade', 2)->where('pid', $provinceList->cid)->orderBy('cid', 'asc')->get();
            //$area = setSort($area);
            foreach($area as $k => $v){
                //当前省地区县级市
                $city = CollArea::where('grade', 3)->where('pid', $v->cid)->orderBy('cid', 'asc')->get();
                //$city = setSort($city);
                foreach($city as $kk => $vv){
                    $vv->html = '├─├─ ';
                }
                $v->html = '├─ ';
                $v->city = $city;
            }
            $provinceList->area = $area;
            return view('admin.category.coll_area.index', compact('pid', 'province', 'provinceList'));
        }else{
            return redirect('admin/coll_area');
        }
    }

    /**
     * 添加省份
     * @return mixed
     */
    public function create(){
        return view('admin.category.coll_area.create');
    }

    /**
     * 添加省份选项
     * @param ProvinceCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function provinceStore(Request $request){
        $input = $request->except('_token');
        $input['pid'] = $request->input('cid');
        $result = CollArea::create($input);
        if($result){
            flash('省份管理添加成功', 'success');
            return redirect('admin/coll_area/' . $request->input('cid'));
        }else{
            return back()->with('errors', '省份管理添加失败，请稍后重试！');
        }
    }

    /**
     * 添加分类提交
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $input = $request->except('_token');
        $input['en_name'] = trim($request->en_name);
        $insertGetId = CollArea::insertGetId($input);
        $collArea = CollArea::where('id', $insertGetId)->first();
        if($collArea){
            $collArea = $this->setData($collArea);
            return response()->json(['status' => 0, 'dataInfo' => $collArea, 'msg' => '添加地区分类成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '添加地区分类失败，请稍后重试！']);
        }
    }

    /**
     * 设置地区数据
     * @param $collPosition
     * @return mixed
     */

    function setData($collArea){
        if($collArea->grade == 2){
            $collArea->edit_name = '├─ ' . trim($collArea->name);
            if(!empty($collArea->en_name)){
                $collArea->edit_en_name = '├─ ' . trim($collArea->en_name);
            }else{
                $collArea->edit_en_name = '';
            }
        }elseif($collArea->grade == 3){
            $collArea->edit_name = '├─├─ ' . trim($collArea->name);
            if(!empty($collArea->en_name)){
                $collArea->edit_en_name = '├─├─ ' . trim($collArea->en_name);
            }else{
                $collArea->edit_en_name = '';
            }
        }
        return $collArea;
    }

    /**
     * 编辑地区
     * @param $id
     * @return bool
     */
    public function edit($id){
        return true;
    }

    /**
     * 更新地区
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){
        $input = $request->except(['_method', '_token']);
        $input['en_name'] = trim($request->en_name);

        //获取当前选项自己ID
        $currArr = CollArea::CurrArea($id);
        //获取子集分类内容
        $newArr = CollArea::whereIn('id', $currArr)->get()->toArray();
        $newArrData = array();
        //判断当前修改等级
        if($input['grade'] == '1'){
            $prefix = substr($input['cid'], 0, 2);
            foreach($newArr as $v){
                $newArrData[] = array(
                    'id' => $v['id'],
                    'pid' => $prefix . substr($v['pid'], 2, 4),
                    'cid' => $prefix . substr($v['cid'], 2, 4)
                );
            }
        }else if($input['grade'] == '2'){
            $prefix = substr($input['cid'], 2, 2);
            foreach($newArr as $v){
                if($v['grade'] == '2'){
                    $newArrData[] = array(
                        'id' => $v['id'],
                        'pid' => $input['pid'],
                        'cid' => $input['cid']
                    );
                }else{
                    $newArrData[] = array(
                        'id' => $v['id'],
                        'pid' => substr($v['pid'], 0, 2) . $prefix . substr($v['pid'], 4, 2),
                        'cid' => substr($v['cid'], 0, 2) . $prefix . substr($v['cid'], 4, 2)
                    );
                }
            }
        }
        $result = CollArea::where('id', $id)->update($input);
        if($result){
            //更新子集分类
            if($input['grade'] != '3'){
                foreach($newArrData as $v){
                    CollArea::where('id', $v['id'])->update(['cid' => $v['cid'], 'pid' => $v['pid']]);
                }
            }
            $collArea = collArea::where('id', $id)->first();
            $collArea = $this->setData($collArea);
            return response()->json(['status' => 0, 'dataInfo' => $collArea, 'msg' => '更新地区选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '更新前和更新后数据相同，更新失败！']);
        }
    }

    /**
     * 删除地区
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $currArr = CollArea::CurrArea($id);
        $result = CollArea::whereIn('id', $currArr)->delete();
        if($result){
            return response()->json(['status' => 0, 'msg' => '删除地区成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '删除地区失败，请稍后重试！']);
        }
    }
}