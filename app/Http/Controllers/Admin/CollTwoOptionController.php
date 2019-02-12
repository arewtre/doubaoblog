<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\CollTwoOption;
use App\Http\Requests\Admin\CollTwoOption\CreateTwoRequest;
use App\Http\Requests\Admin\CollTwoOption\UpdateTwoRequest;
use Style;

class CollTwoOptionController extends CommonController{
    public function __construct(){
    }

    public function index(){

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
     * @param CreateTwoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTwoRequest $request){
        $input = $request->except('_token');
        $input['en_name'] = trim($request->en_name);
        $id = CollTwoOption::insertGetId($input);

        $collTwoOption = CollTwoOption::where('id', $id)->first();
        if($collTwoOption){
            $collTwoOption = $this->setData($collTwoOption);
            return response()->json(['status' => 0, 'dataInfo' => $collTwoOption, 'msg' => '添加分类选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '添加职位分类失败，请稍后重试！']);
        }
    }

    /**
     * 设置数据
     * @param $collTwoOption
     * @return mixed
     */
    function setData($collTwoOption){
        $collTwoOption->edit_name = '├─ ' . trim($collTwoOption->name);
        if(!empty($collTwoOption->en_name)){
            $collTwoOption->edit_en_name = '├─ ' . trim($collTwoOption->en_name);
        }else{
            $collTwoOption->edit_en_name = '';
        }
        return $collTwoOption;
    }

    /**
     * 编辑分类选项
     * @param $id
     */
    public function edit($id){

    }

    /**
     * 更新分类选项
     * @param UpdateTwoRequest $request
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateTwoRequest $request, $id){
        $input = $request->except(['_method', '_token']);
        pre($input);
        $input['en_name'] = trim($request->en_name);
        $result = CollTwoOption::where('id', $id)->update($input);
        if($result){
            $collTwoOption = CollTwoOption::where('id', $id)->first();
            $collTwoOption = $this->setData($collTwoOption);
            return response()->json(['status' => 0, 'dataInfo' => $collTwoOption, 'msg' => '更新分类选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '更新前和更新后数据相同，更新失败！']);
        }
    }

    /**
     * 删除分类选项
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $result = CollTwoOption::where('id', $id)->delete();
        if($result){
            return response()->json(['status' => 0, 'msg' => '删除分类选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '删除分类选项失败，请稍后重试！']);
        }
    }
}