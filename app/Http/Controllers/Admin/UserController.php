<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use App\Http\Model\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class UserController extends CommonController
{
    
    public function index(Request $request){
        if(is_ajax()){
            $input = array_filter($request->only(['keyword','page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 12;
            $data = User::select('*')
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('nickname', 'like', '%'.$keyword.'%');
                } 
            })
            ->orderBy('created_at','asc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = User::select()
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('nickname', 'like', '%'.$keyword.'%');
                } 
            })
            ->count();
            $datainfo =  array(
                'code'  =>  0,
                'msg'   =>  '',
                'count' =>  $count,
                'data'  =>$data,
                'size'  =>$limit,
            );

            return response()->json($datainfo);
        }
        return view('admin.user.index');
    }
    public function member(Request $request){
        if(is_ajax()){
            $input = array_filter($request->only(['keyword','page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 12;
            $data = Member::select('*')
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('nickname', 'like', '%'.$keyword.'%');
                } 
            })
            ->orderBy('created_at','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = Member::select()
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('nickname', 'like', '%'.$keyword.'%');
                } 
            })
            ->count();
            $datainfo =  array(
                'code'  =>  0,
                'msg'   =>  '',
                'count' =>  $count,
                'data'  =>$data,
                'size'  =>$limit,
            );

            return response()->json($datainfo);
        }
        return view('admin.user.member');
    }
    public function info(Request $request)
    {
       if(is_ajax()){
         $input = $input = $request->only('user_name','sex','avatar','tel','email','remarks','nickname');
         //pre($input);
         User::where("user_id",session("user.user_id"))->update($input);
         $data = [
                'code' => 1,
                'msg' => '修改成功！',
                ];
         return response()->json($data);
         exit;
       }
       $userid = session("user.user_id");
       $info = User::where('user_id',$userid)->first();
       return view('admin.user.info',compact('info'));
    }
    
    public function addUser(Request $request)
    {
       if(is_ajax()){
         
         //pre($request->all());
         if(!isset($request->user_id) && empty($request->user_id)){
            $input = $request->only('user_name','sex','avatar','tel','email','remarks','nickname','user_pass');
            $input['user_pass'] = Crypt::encrypt($input['user_pass']); 
            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");
            //pre($input);
            User::create($input);
            $data = [
                   'code' => 1,
                   'msg' => '添加成功！',
                   ];
            return response()->json($data);
            exit; 
         }else{
            $input = $request->only('user_id','user_name','sex','avatar','tel','email','remarks','nickname');
            $input['updated_at'] = date("Y-m-d H:i:s");
            //pre($input);
            User::where("user_id",$input['user_id'])->update($input);
            $data = [
                   'code' => 1,
                   'msg' => '修改成功！',
                   ];
            return response()->json($data);
            exit;
         }
       }
       $userid = $request->id;
       $info = User::where('user_id',$userid)->first();
       return view('admin.user.addUser',compact('info'));
    }
    
    
    public function userDel(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $id = User::where('user_id',$input['id'])->delete();
            if($id){
                return response()->json(array('code' => 1, 'msg' => '删除成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '删除失败！'));
            }
        }
    
    }
     public function pass(Request $request)
    {
        if(is_ajax()){
            $input = $request->all();
            $user = session("user");
            if(Crypt::decrypt($user->user_pass)!= $input['oldPassword']){
                //return back()->with('msg','用户名或者密码错误！');
                $data = [
                'code' => 0,
                'msg' => '原密码错误！',
                ];
                return response()->json($data);
                exit;
            }
            if($input['repassword']!= $input['password']){
                //return back()->with('msg','用户名或者密码错误！');
                $data = [
                'code' => 0,
                'msg' => '两次输入新密码不一致！',
                ];
                return response()->json($data);
                exit;
            }
            $da['user_pass'] = Crypt::encrypt($input['password']);
            User::where("user_id",session("user.user_id"))->update($da);
            $data = [
                'code' => 1,
                'msg' => '修改成功！',
                ];
                return response()->json($data);
                exit;
        }
        //pre(session("user"));
        return view('admin.user.password');
    }

}
