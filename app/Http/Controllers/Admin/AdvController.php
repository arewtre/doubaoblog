<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Adv;
use App\Http\Model\Addr;
use App\Http\Model\AdSite;
use App\Http\Model\AdSlots;
use Illuminate\Support\Facades\View;
use DB;
class AdvController extends CommonController
{
    public function __construct(){
        $ad_site = AdSite::get();
        $as_slots = AdSlots::get();
        View::share('ad_site',$ad_site);
        View::share('as_slots',$as_slots);
    }
    
    public function index()
    {
        return view('admin.adv.list');
    }
    
    public function ajaxGetAdv(Request $request)
    {
        $input = array_filter($request->only(['keyword','ad_site','ad_slots','status','page','limit']));
        //pre($input);
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
        $ad_manage = Adv::select()
        ->where(function ($query) use ($input) {
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(!empty($input['keyword'])){
                $query->where('title', 'like', '%'.$keyword.'%');
            }
        })->where(function ($query) use ($input) {
            $ad_site = (!empty($input['ad_site'])) ? $input['ad_site'] : '';
            if(!empty($input['ad_site'])){
                $query->where('ad_site',"=",$input['ad_site']);
            }
        })->where(function ($query) use ($input) {
            $ad_slots = (!empty($input['ad_slots'])) ? $input['ad_slots'] : '';
            if(!empty($input['ad_slots'])){
                $query->where('ad_slots',"=",$input['ad_slots']);
            }

        })->where(function ($query) use ($input) {
            $status = (!empty($input['status'])) ? $input['status'] : '';
            if(!empty($input['status'])){
                $query->where('status',"=",$input['status']);
            }
        })->orderBy('status','desc')
                ->orderBy('created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        if(count($ad_manage) > 0){
            foreach($ad_manage as $v){
                $v->end_time = substr($v->end_time,0,10);
                $adSlots = AdSlots::where('id', $v->ad_slots)->first(['ad_name']);
                $v->ad_slots_name = !empty($adSlots) ? $adSlots->ad_name : '';
                $adSite = AdSite::where('id', $v->ad_site)->first(['site_name']);
                $v->ad_site = !empty($adSite) ? $adSite->site_name : '';
                $v->ad_url = $v->url_type.'_'.$v->url;
            }
        }
        $count = Adv::select()
        ->where(function ($query) use ($input) {
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(!empty($input['keyword'])){
                $query->where('title', 'like', '%'.$keyword.'%');
            }
        })->where(function ($query) use ($input) {
            $ad_site = (!empty($input['ad_site'])) ? $input['ad_site'] : '';
            if(!empty($input['ad_site'])){
                $query->where('ad_site',"=",$input['ad_site']);
            }
        })->where(function ($query) use ($input) {
            $ad_slots = (!empty($input['ad_slots'])) ? $input['ad_slots'] : '';
            if(!empty($input['ad_slots'])){
                $query->where('ad_slots',"=",$input['ad_slots']);
            }

        })->where(function ($query) use ($input) {
            $status = (!empty($input['status'])) ? $input['status'] : '';
            if(!empty($input['status'])){
                $query->where('status',"=",$input['status']);
            }
        })->count();
        $datainfo =  [
            'code'  =>  0,
            'msg'   =>  '',
            'count' =>  $count,
            'data'  =>$ad_manage,
            'size'  =>$limit,
        ];
        
        return response()->json($datainfo);
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->except(['file']);
            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");
            isset($input['status'])? $input['status'] = 1:$input['status'] = -1;
            $id = Adv::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        $job_id = $request->job_id;
        if(!empty($job_id)){
           $url = $job_id;
           $url_type = 3;
           return view('admin.adv.add',compact('url','url_type'));
        }else{
           return view('admin.adv.add'); 
        }
    
    }
    
    public function edit(Request $request)
    {        
        $detail = Adv::where('id',$request->id)->first();
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['updated_at'] = date("Y-m-d H:i:s");
            isset($input['status'])? $input['status'] = 1:$input['status'] = -1; 
            $id = Adv::where("id",$input['id'])->update($input);
            if($id){
                @unlink(asset($detail->pic_url));
                return response()->json(array('code' => 1, 'msg' => '编辑成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '编辑失败！'));
            }
        }
        return view('admin.adv.edit',compact('detail'));
    
    }
    
    public function del(Request $request)
    {        
        if ($request->isMethod('post')) {
            $input = $request->id;
            $id = Adv::where("id",$input)->delete();
            if($id){
                return response()->json(array('code' => 1, 'msg' => '删除成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '删除失败！'));
            }
        }
    }
    
    public function addr()
    {
    
        return view('admin.adv.addr');
    
    }
    
    public function ajaxGetAddr(Request $request)
    {
        $input = array_filter($request->only(['keyword','page','limit']));
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
        $ad_manage = Addr::select()
        ->where(function ($query) use ($input) {
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(!empty($input['keyword'])){
                $query->where('ad_name', 'like', '%'.$keyword.'%');
            } 
        })->orderBy('created_at','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        if(count($ad_manage) > 0){
            foreach($ad_manage as $v){
                $v->end_time = substr($v->end_time,0,10);
                $adSlots = AdSlots::where('id', $v->ad_slots)->first(['ad_name']);
                $v->ad_slots_name = !empty($adSlots) ? $adSlots->ad_name : '';
                $adSite = AdSite::where('id', $v->ad_site)->first(['site_name']);
                $v->ad_site = !empty($adSite) ? $adSite->site_name : '';
                $v->ad_url = $v->url_type.'_'.$v->url;
            }
        }
        $count = Addr::count();
        $datainfo =  [
            'code'  =>  0,
            'msg'   =>  '',
            'count' =>  $count,
            'data'  =>$ad_manage,
            'size'  =>$limit,
        ];
    
        return response()->json($datainfo);
    }
    
    public function addrAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");
            $id = AdSlots::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        return view('admin.adv.addrAdd');
    
    }
    
    public function addrEdit(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['updated_at'] = date("Y-m-d H:i:s");
            $id = AdSlots::where("id",$input['id'])->update($input);
            if($id){
                return response()->json(array('code' => 1, 'msg' => '编辑成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '编辑失败！'));
            }
        }
        $id = $request->id;
        $detail = AdSlots::where('id',$id)->first();
        return view('admin.adv.addrEdit',compact('detail'));
    
    }
    
    public function addrDel(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->id;
            $id = AdSlots::where("id",$input)->delete();
            if($id){
                return response()->json(array('code' => 1, 'msg' => '删除成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '删除失败！'));
            }
        }
    }


}
