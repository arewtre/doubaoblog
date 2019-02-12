<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //get.admin/links  全部友情链接列表
    public function index(Request $request)
    {
        $input = $request->all();
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
        $data = Link::orderBy('link_sort','asc')
                ->skip($limit*($page-1))->take($limit)
                ->get();
        $count =  Link::select()->orderBy('link_sort','asc')->count();
        return view('admin.links.index',compact('data','count','page','limit'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $links = Link::find($input['link_id']);
        $links->link_sort = $input['link_sort'];
        $re = $links->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败，请稍后重试！',
            ];
        }
        return response()->json($data);
    }
    
    public function changeStatus()
    {
        $input = Input::all();
        $links = Link::find($input['id']);
        $links->status ==1? $links->status =0: $links->status =1;
        $re = $links->update();
        if($re){
            $data = [
                'status' => 0,
                'info' => $links->status,
                'msg' => '状态更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '状态更新失败，请稍后重试！',
            ];
        }
        return response()->json($data);
    }

    //get.admin/links/create   添加友情链接
    public function create()
    {
        return view('admin/links/add');
    }

    //post.admin/links  添加友情链接提交
    public function store()
    {
        $input = Input::except('_token');
         isset($input['status'])?$input['status']=1:$input['status']=0;
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',
        ];

        $message = [
            'link_name.required'=>'友情链接名称不能为空！',
            'link_url.required'=>'友情链接URL不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);
        
        if($validator->passes()){
            $re = Link::create($input);
            if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接添加成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接添加失败，请稍后重试！',
            ];
        }
       
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接添加失败，请稍后重试！',
            ];
        }
         return response()->json($data);
    }

    //get.admin/links/{links}/edit  编辑友情链接
    public function edit($link_id)
    {
        $field = Link::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    //put.admin/links/{links}    更新友情链接
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        isset($input['status'])?$input['status']=1:$input['status']=0;
        $re = Link::where('link_id',$link_id)->update($input);
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return response()->json($data);
        
    }

    //delete.admin/links/{links}   删除友情链接
    public function destroy($link_id)
    {
        $re = Link::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return response()->json($data);
    }


    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }

}
