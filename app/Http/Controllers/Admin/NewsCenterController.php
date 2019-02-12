<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\News;
use App\Http\Model\NewsCategory;
use Illuminate\Support\Facades\View;

class NewsCenterController extends CommonController
{
    public function __construct(Request $request){
        $Category = NewsCategory::select()->orderBy('descid', 'asc')->get()->toArray();
        $CategoryList = NewsCategory::formatTree(NewsCategory::listToTree($Category));
        View::share('CategoryList',$CategoryList);
    }
    
    public function index()
    {
            
        return view('admin.newscenter.index');

    }
    
    public function ajaxGetNewsCenters(Request $request)
    {
        $input = array_filter($request->only(['keyword','cate_id','page','limit']));
        $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
        $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
        $data = News::select('news.art_id','news.cate_id','news.art_thumb','news.art_title','news.art_view','news_category.defectsname','news.art_time')
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where(function ($query) use ($input) {
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(!empty($input['keyword'])){
                $query->where('news.art_title', 'like', '%'.$keyword.'%');
            } 
        })->where(function ($query) use ($input) {
            $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
            if(!empty($input['cate_id'])){
                $query->where('news.cate_id', '=', $cate);
            } 
        })->orderBy('news.art_time','desc')
        ->skip($limit*($page-1))->take($limit)
        ->get();
        $count = News::select()
        ->join('news_category', 'news.cate_id', '=', 'news_category.id')
        ->where(function ($query) use ($input) {
            $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
            if(!empty($input['keyword'])){
                $query->where('news.art_title', 'like', '%'.$keyword.'%');
            } 
        })->where(function ($query) use ($input) {
            $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
            if(!empty($input['cate_id'])){
                $query->where('news.cate_id', '=', $cate);
            } 
        })->count();
        $datainfo =  array(
            'code'  =>  0,
            'msg'   =>  '',
            'count' =>  $count,
            'data'  =>$data,
            'size'  =>$limit,
        );
        
        return response()->json($datainfo);
    }
    
    public function del(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $id = News::where('art_id',$input['id'])->delete();
            if($id){
                return response()->json(array('code' => 1, 'msg' => '删除成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '删除失败！'));
            }
        }
    
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['art_time'] = date("Y-m-d H:i:s");
            $input['art_istop']=="on"?$input['art_istop']=1:$input['art_istop']=0;
            $id = News::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        
        return view('admin.news.add');
    
    }
    
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['art_update_time'] = date("Y-m-d H:i:s");
            $input['update_editor'] = "admin";
            $input['art_istop']=="on"?$input['art_istop']=1:$input['art_istop']=0;
            $id = News::where("art_id",$input['art_id'])->update($input);
            if($id){
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        
        $detail = News::where("art_id",$request->id)->first();
        $collCategory = array("username"=>1);
        return view('admin.news.edit',compact('detail','collCategory'));
    
    }
    
    public function cateList()
    {
    
        return view('admin.news.cateList');
    
    }
    
    public function cateAdd()
    {
    
        return view('admin.news.cateAdd');
    
    }
    
    public function cateEdit()
    {
    
        return view('admin.news.cateEdit');
    
    }


}
