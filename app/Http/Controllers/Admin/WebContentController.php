<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\WebContent;

class WebContentController extends CommonController
{
    public function __construct(Request $request){

    }
    
    public function index()
    {
            
            return view('admin.webcontent.list');

    }
    
    public function ajaxGetWebContent(Request $request)
    {
        
        $data = WebContent::all();
        $count = count($data);
        //$data=$user->skip($limit*($page-1))->take($limit)->get()->toArray();
        $datainfo =  [
            'code'  =>  0,
            'msg'   =>  '',
            'count' =>  $count,
            'data'  =>$data,
            'size'  =>20,
        ];
        
        return response()->json($datainfo);
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            //pre($request->all());
            $input = $request->all();
            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");
            isset($input['is_show'])?$input['is_show']=1:$input['is_show']=0;
            $id = WebContent::create($input);
            if($id){
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        $collCategory = array("username"=>1); 
        return view('admin.webcontent.add',compact('collCategory'));
    
    }
    
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['updated_at'] = date("Y-m-d H:i:s");
            isset($input['is_show'])?$input['is_show']=1:$input['is_show']=0;
            $id = WebContent::where("id",$input['id'])->update($input);
            if($id){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        
        $detail = WebContent::where("id",$request->id)->first();
        return view('admin.webcontent.edit',compact('detail'));   
    }
    
    public function del(Request $request)
    {
        $res = WebContent::where("id",$request->id)->delete();
        if($res){
            return response()->json(array('code' => 1, 'msg' => '删除成功！'));
        }else{
            return response()->json(array('code' => 0, 'msg' => '删除失败！'));
        }   
    }
    

}
