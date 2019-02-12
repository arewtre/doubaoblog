<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\NewsCategory;
use DB, View;

class NewsCategoryController extends Controller{
    /**
     * 分类列表
     * @return mixed
     */
    public function index(){
        $Category = NewsCategory::where("type",1)->where('pid', '0')->orderBy('descid', 'asc')->get();
        $CategoryList = [];
        if(count($Category) > 0){
            foreach($Category as $key => $value){
                $NewsCategory = NewsCategory::where("type",1)->where('pid', $value['id'])->orderBy('descid', 'asc')->get();
                $value['twoCategory'] = $NewsCategory;
                $value['html'] = '├─ ';
                $CategoryList[] = $value;
            }
        }
        //pre($CategoryList);
        return view('admin.news.cateList', compact('CategoryList'));
    }
    
    
    public function ajaxGetCate(Request $request){
        $Category = NewsCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        $CategoryList = [];
        if(count($Category) > 0){
            foreach($Category as $key => $value){
                $NewsCategory = NewsCategory::where('pid', $value['id'])->orderBy('descid', 'asc')->get();
                $value['twoCategory'] = $NewsCategory;
                $value['html'] = '├─ ';
                $CategoryList[] = $value;
            }
        }
        $datainfo =  [
            'code'  =>  0,
            'msg'   =>  '',
            'count' =>  $count,
            'data'  =>$CategoryList,
            'size'  =>$limit,
        ];
        
        return response()->json($datainfo);
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
            $input['type'] = 1;
            $result = NewsCategory::create($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        $pid = $request->pid;
        if($pid==0){
            $level = 0;
            $CategoryList = NewsCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        }else{
            $level = 1;
            $CategoryList = NewsCategory::select('id','pid','defectsname')->where('id',$pid)->get();
        }

        return view('admin.news.cateAdd', compact('CategoryList','level'));
    }

    public function store(NewsClass $request){
        $input = $request->only(['defectsname', 'level', 'pid', 'new_sign', 'descid']);
        $result = NewsCategory::create($input);
        if($result){
            flash('添加分类成功', 'success');
            return redirect('admin/newscategory');
        }else{
            return back()->with('errors', '添加分类失败，请稍后重试！');
        }
    }

    /**
     * 资讯修改
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function edit($id, Request $request){
        switch($request->level){
            case "0":
                //一级分类
                $firstClass = NewsCategory::where('id', $id)->first();
                return view('admin.newscategory.editFirstClass', compact('firstClass'));
                break;
            case "1"://二级分类
                //查询父类 类别
                $bigCategory = NewsCategory::select('id', 'defectsname')->where('pid', 0)->get();
                //二级类的信息
                $secondClass = NewsCategory::where('id', $id)->first();
                return view('admin.news.cateEdit', compact('bigCategory', 'secondClass'));
                break;
        }
    }

    /**
     * 资讯更新
     * @param $id
     * @param NewsClass $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->only(['id','defectsname','is_display', 'pid', 'new_sign', 'descid']);
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $input['pid']==0?$input['level']=0:$input['level']=1;
            $result = NewsCategory::where('id', $request->id)->update($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        $data = NewsCategory::where('id', $request->id)->first();
        $CategoryList = NewsCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        return view('admin.news.cateEdit', compact('data','CategoryList'));
    }

    /**
     * 资讯删除
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request){
        $level = $request->level;
        if($level == '0'){
            $result = NewsCategory::where('pid', $id)->orWhere('id', $id)->delete();
            if($result){
                //NewsCategory::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除资讯分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除资讯分类失败！']); 
            }
        }else{
            $result = NewsCategory::where('id', $id)->delete();
            if($result){
                NewsCategory::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除资讯分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除资讯分类失败！']);
            }
        }
    }
}
