<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\CollOption;
use App\Models\Common\CollCategory;
use App\Http\Requests\Admin\CollOption\CreateRequest;
use App\Http\Requests\Admin\CollOption\UpdateRequest;
use App\Models\Common\CollTwoOption;
use Style;

class CollOptionController extends CommonController{
    public function __construct(){
    }

    /**
     * 所有分类选项列表
     * @return mixed
     */
    public function index(){
        //获取分类管理
        $collCategory = CollCategory::all();
        //获取分类选项
        $collOptionPage = CollOption::paginate(12);
        $collOption = CollOption::paginate(12)->toArray();
        $collOptions = $collOption['data'];
        return view('admin.category.coll_options.index', compact('collCategory', 'collOptions', 'collOptionPage'));
    }

    /**
     * 指定分类选项列表
     * @param $parameter
     * @return mixed
     */
    public function show($parameter){
        //echo $parameter;
        $collCategory = CollCategory::all();
        $collOption = CollOption::where('sign', $parameter)->orderBy('opt_id', 'asc')->get();
        //$collOption = setSort($collOption, 'opt_sort');
        //获取分类的列表
        $collOptions = [];
        if(count($collOption) > 0){
            foreach($collOption as $key => $value){
                $CollTwoOption = CollTwoOption::where('pid', $value['opt_id'])->where('sign', $parameter)->orderBy('cid', 'asc')->get();
                //$value['CollTwoOption'] = setSort($CollTwoOption, 'sort');
                $value['html'] = '├─ ';
                //$value['en_name'] = trim( $value['en_name']);
                $collOptions[] = $value;
            }
        }
//pre($collOptions);
        return view('admin.category.coll_options.index', compact('parameter', 'collCategory', 'collOptions', 'collOptionPage', 'parameter'));
    }

    /**
     * 添加分类选项
     * @return bool
     */
    public function create(){
        return true;
    }

    /**
     * 添加分类选项提交
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request){
        $input = $request->except('_token');
        $input['en_opt_name'] = trim($request->en_opt_name);
        $insertGetId = CollOption::insertGetId($input);
        //获取更新后的数据
        $collOption = CollOption::where('id', $insertGetId)->first();
        if($collOption){
            return response()->json(['status' => 0, 'dataInfo' => $collOption, 'msg' => '添加分类选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '添加分类选项失败，请稍后重试！']);
        }
    }

    /**
     * 编辑选项
     * @param $id
     * @return mixed
     */
    public function edit($id){
//        $rolefield = Role::find($id);
//        return Style::view('admin.rbac.roles.edit', compact('rolefield'));
    }

    /**
     * 更新选项
     * @param UpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id){
        $input = $request->except(['_method', '_token']);
        $input['en_opt_name'] = trim($request->en_opt_name);
        $result = CollOption::where('id', $id)->update($input);
        if($result){
            $collOption = CollOption::where('id', $id)->first();
            return response()->json(['status' => 0,'dataInfo' => $collOption,  'msg' => '更新分类选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '更新前和更新后数据相同，更新失败！']);
        }
    }

    /**
     * 删除选项
     * @param $id
     * @return array
     */
    public function destroy($id){
        $CollOption = CollOption::where('id', $id)->first()->toArray();
        $result = CollOption::where('id', $id)->delete();
        if($result){
            CollTwoOption::where('pid', $CollOption['opt_id'])->delete();
            return response()->json(['status' => 0, 'msg' => '分类选项删除成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '分类选项删除失败，请稍后重试！']);
        }
    }
}