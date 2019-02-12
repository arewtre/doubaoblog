<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\ForumCategory;
use DB, View;

class ForumCategoryController extends Controller{
    /**
     * 分类列表
     * @return mixed
     */
    public function index(){
        $Category = ForumCategory::select()->orderBy('descid', 'asc')->get()->toArray();
        $CategoryList = ForumCategory::formatTree(ForumCategory::listToTree($Category));
        //pre($CategoryList);
        return view('admin.forum.cateList', compact('CategoryList'));
    }
    
    
    public function ajaxGetCate(Request $request){
        $Category = ForumCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        $CategoryList = [];
        if(count($Category) > 0){
            foreach($Category as $key => $value){
                $ForumCategory = ForumCategory::where('pid', $value['id'])->orderBy('descid', 'asc')->get();
                $value['twoCategory'] = $ForumCategory;
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
            $result = ForumCategory::create($input);
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
            $CategoryList = ForumCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        }else{
            $lev = $level+1;
            $pid = $request->pid;
            $CategoryList = ForumCategory::select('id','pid','defectsname')->where('id',$pid)->get();
        }
        $id = $request->pid;
        return view('admin.forum.cateAdd', compact('CategoryList','lev','pid','id'));
    }

    public function store(ForumClass $request){
        $input = $request->only(['defectsname', 'level', 'pid', 'new_sign','url', 'descid']);
        $result = ForumCategory::create($input);
        if($result){
            flash('添加分类成功', 'success');
            return redirect('admin/forumcategory');
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
                $firstClass = ForumCategory::where('id', $id)->first();
                return view('admin.forumcategory.editFirstClass', compact('firstClass'));
                break;
            case "1"://二级分类
                //查询父类 类别
                $bigCategory = ForumCategory::select('id', 'defectsname')->where('pid', 0)->get();
                //二级类的信息
                $secondClass = ForumCategory::where('id', $id)->first();
                return view('admin.forum.cateEdit', compact('bigCategory', 'secondClass'));
                break;
        }
    }

    /**
     * 资讯更新
     * @param $id
     * @param ForumClass $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->only(['id','defectsname','is_display', 'pid','url', 'new_sign', 'descid','img','dec']);
            //pre($input);
            $input['is_display']=="on"?$input['is_display']=1:$input['is_display']=0;
            $input['pid']==0?$input['level']=0:$input['level']=1;
            $result = ForumCategory::where('id', $request->id)->update($input);
            if($result){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        $data = ForumCategory::where('id', $request->id)->first();
        $CategoryList = ForumCategory::where('pid', '0')->orderBy('descid', 'asc')->get();
        return view('admin.forum.cateEdit', compact('data','CategoryList'));
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
            $result = ForumCategory::where('pid', $id)->orWhere('id', $id)->delete();
            if($result){
                //ForumCategory::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除资讯分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除资讯分类失败！']); 
            }
        }else{
            $result = ForumCategory::where('id', $id)->delete();
            if($result){
                ForumCategory::where('id', $id)->delete();
                return response()->json(['status' => 0, 'msg' => '删除资讯分类成功！']);
            }else{
                return response()->json(['status' => 1, 'msg' => '删除资讯分类失败！']);
            }
        }
    }
}
