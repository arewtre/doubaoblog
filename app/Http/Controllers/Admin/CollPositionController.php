<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\CollPosition;
 use App\Http\Requests\Admin\CollPosition\CreateRequest;
 use App\Http\Requests\Admin\CollPosition\UpdateRequest;
 use App\Http\Requests\Admin\CollPosition\PostCreateRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use Style;

class CollPositionController extends CommonController{

    public function __construct(){
    }

    /**
     * 职位列表
     * @return mixed
     */
    public function index(){
        $position = CollPosition::where('grade', '1')->orderBy('cid', 'asc')->get();
        return view('admin.category.coll_position.index', compact('position'));
    }

    /**
     * 当前职位列表
     * @param $pid
     * @return mixed
     */
    public function show($pid){
        //全部职位
        $position = CollPosition::where('grade', '1')->orderBy('cid', 'asc')->get();
        //$position = setSort($position);
        //当前一级职位
        $positionList = CollPosition::where('pid', $pid)->where('grade', 1)->first();
        if($positionList){
            //当前二级职位
            $twoPosition = CollPosition::where('grade', 2)->where('pid', $positionList->cid)->orderBy('cid', 'asc')->get();
            //$twoPosition = setSort($twoPosition);
            foreach($twoPosition as $k => $v){
                //当前三级职位
                $threePosition = CollPosition::where('grade', 3)->where('pid', $v->cid)->orderBy('cid', 'asc')->get();
                //$threePosition = setSort($threePosition);
                foreach($threePosition as $kk => $vv){
                    $vv->html = '├─├─ ';
                    $vv->en_name = trim($vv->en_name);
                }
                $v->html = '├─ ';
                $v->en_name = trim($v->en_name);
                $v->threePosition = $threePosition;
            }
            $positionList->twoPosition = $twoPosition;
            return view('admin.category.coll_position.index', compact('pid', 'position', 'positionList'));
        }else{
            return redirect('admin/coll_position');
        }
    }

    /**
     * 添加职位
     * @return mixed
     */
    public function create(){
        return view('admin.category.coll_position.create');
    }

    /**
     * 添加职位选项
     * @param PostCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStore(PostCreateRequest $request){
        $input = $request->except('_token');
        $input['pid'] = $request->input('cid');
        $result = CollPosition::create($input);
        if($result){
            flash('职位管理添加成功', 'success');
            return redirect('admin/coll_position/' . $request->input('cid'));
        }else{
            return back()->with('errors', '职位管理添加失败，请稍后重试！');
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
        $insertGetId = CollPosition::insertGetId($input);
        $collPosition = CollPosition::where('id', $insertGetId)->first();
        if($collPosition){
            $collPosition = $this->setData($collPosition);
            return response()->json(['status' => 0, 'dataInfo' => $collPosition, 'msg' => '添加职位分类成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '添加职位分类失败，请稍后重试！']);
        }
    }

    /**
     * 设置数据
     * @param $collPosition
     * @return mixed
     */

    function setData($collPosition){
        if($collPosition->grade == 2){
            $collPosition->edit_name = '├─ ' . trim($collPosition->name);
            if(!empty($collPosition->en_name)){
                $collPosition->edit_en_name = '├─ ' . trim($collPosition->en_name);
            }else{
                $collPosition->edit_en_name = '';
            }
        }elseif($collPosition->grade == 3){
            $collPosition->edit_name = '├─├─ ' . trim($collPosition->name);
            if(!empty($collPosition->en_name)){
                $collPosition->edit_en_name = '├─├─ ' . trim($collPosition->en_name);
            }else{
                $collPosition->edit_en_name = '';
            }
        }
        return $collPosition;
    }

    /**
     * 编辑职位
     * @param $id
     * @return bool
     */
    public function edit($id){
        return true;
    }

    /**
     * 更新职位
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){
         $input = $request->except('_token');
        $input['en_name'] = trim($request->en_name);
        //更新数据处理
        $currArr = CollPosition::CurrPosition($id);
        //获取子集分类内容
        $newArr = CollPosition::whereIn('id', $currArr)->get()->toArray();
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
        $result = CollPosition::where('id', $id)->update($input);
        if($result){
            //更新子集分类
            if($input['grade'] != '3'){
                foreach($newArrData as $v){
                    CollPosition::where('id', $v['id'])->update(['cid' => $v['cid'], 'pid' => $v['pid']]);
                }
            }
            $collPosition = CollPosition::where('id', $id)->first();
            $collPosition = $this->setData($collPosition);
            return response()->json(['status' => 0, 'dataInfo' => $collPosition, 'msg' => '更新职位选项成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '更新前和更新后数据相同，更新失败！']);
        }
    }

    /**
     * 删除职位
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $currArr = CollPosition::CurrPosition($id);
        $result = CollPosition::whereIn('id', $currArr)->delete();
        if($result){
            return response()->json(['status' => 0, 'msg' => '删除职位成功！']);
        }else{
            return response()->json(['status' => 1, 'msg' => '删除职位失败，请稍后重试！']);
        }
    }
}