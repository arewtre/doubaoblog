<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\Forum;
use App\Http\Model\ForumRep;
use App\Http\Model\ForumCategory;
use App\Http\Model\Ftype;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\VideoUploadController;
use App\Http\Controllers\Admin\UploadController;
class ForumController extends CommonController
{
    public function __construct(Request $request){
        $Category = ForumCategory::select()->orderBy('descid', 'asc')->get()->toArray();
        $CategoryList = ForumCategory::formatTree(ForumCategory::listToTree($Category));
        View::share('CategoryList',$CategoryList);
    }
    
    public function index(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['keyword','cate_id','page','limit']));
            //pre($request->all());
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
            $data = Forum::select('forum.forum_id','forum.pid','forum.title','forum.content','forum.views','forum_category.defectsname','forum.created_at')
            ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
            ->where(function ($query) use ($input) {
                $keyword = !empty($input['keyword']) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('forum.title', 'like', '%'.$keyword.'%');
                } 
            })
            ->where(function ($query) use ($input) {
                $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
                if(!empty($input['cate_id'])){
                    $query->where('forum.pid', '=', $cate);
                } 
            })
            ->orderBy('forum.created_at','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = Forum::select()
            ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('forum.title', 'like', '%'.$keyword.'%');
                } 
            })->where(function ($query) use ($input) {
                $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
                if(!empty($input['cate_id'])){
                    $query->where('forum.pid', '=', $cate);
                } 
            })->count();
            
            foreach($data as $v){
                preg_match("/<video[^>]*?>(.*\s*?)<\/video>/is",$v->content, $matches1);
                preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                $v->art_thumb = "";
                if(!empty($matches1)){  
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $matches1[0], $img_array);
                    $v->art_thumb = "<image src='".@$img_array[1]."'>";
                }
                //pre($matches2[1]);
                if(!empty($matches2)){
                    $v->art_thumb = "<image src='".@$matches2[1]."'>";
                }
            }
            
            $datainfo =  array(
                'code'  =>  0,
                'msg'   =>  '',
                'count' =>  $count,
                'data'  =>$data,
                'size'  =>$limit,
            );
            
            return response()->json($datainfo);
            
        }    
        return view('admin.forum.list');

    }
    
    
    public function del(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $forum = Forum::where('forum_id',$input['id'])->first();
            $this->deleQiniu($forum->content); 
            $id = Forum::where('forum_id',$input['id'])->delete();
            $frep = ForumRep::where('forum_id',$input['id'])->get();
            foreach($frep as $v){
               $this->deleQiniu($v->content);                
            }
            ForumRep::where('forum_id',$input['id'])->delete();
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
            $input['uid'] = 1;
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            $id = Forum::create($input);
            if($id){ 
                return response()->json(array('code' => 1, 'msg' => '添加成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '添加失败！'));
            }
        }
        
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        $mod = ForumCategory::formatTree(ForumCategory::listToTree($Category));
        $ftype = Ftype::select()->where('display',1)->get()->toArray();
        return view('admin.forum.add',compact('mod','ftype'));
    
    }
    
    public function edit(Request $request)
    {
        $detail = Forum::where("forum_id",$request->id)->first();
        if ($request->isMethod('post')) {
            $input = $request->all();
            $input['uid'] = 1;
            isset($input['is_top'])?$input['is_top']=1:$input['is_top']=0;
            
            $id = Forum::where("forum_id",$input['forum_id'])->update($input);
            if($id){
                //@unlink($detail->art_thumb);
                return response()->json(array('code' => 1, 'msg' => '修改成功！'));
            }else{
                return response()->json(array('code' => 0, 'msg' => '修改失败！'));
            }
        }
        
        $Category = ForumCategory::select()->where('is_display',1)->orderBy('descid', 'asc')->get()->toArray();
        $mod = ForumCategory::formatTree(ForumCategory::listToTree($Category));
        $ftype = Ftype::select()->where('display',1)->get()->toArray();
        return view('admin.forum.edit',compact('detail','mod','ftype'));
    
    }
    
    public function deleQiniu($content)
    {
    
        preg_match_all('/<video[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', @$content, $img_array1); 
        preg_match_all('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', @$content, $img_array2); 
        //pre($img_array1);
        if(!empty(@$img_array1)){
            foreach(@$img_array1[1] as $v){
                 $dd = new VideoUploadController();
                $dd->delqiniu($v);
            }
        }
        if(!empty(@$img_array2)){
            foreach(@$img_array2[1] as $v){
                $dd = new UploadController();
                $dd->delqiniu(@$v);
            }
        }
    
    }
    
    public function comList(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['keyword','cate_id','page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 15;
            $data = ForumRep::select('forum_rep.*','member.nickname','forum.pid','forum.title','forum.content','forum.views','forum_category.defectsname')
            ->join('forum', 'forum.forum_id', '=', 'forum_rep.forum_id')
            ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
            ->join('member', 'forum_rep.uid', '=', 'member.id')
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('forum_rep.content', 'like', '%'.$keyword.'%');
                } 
            })->where(function ($query) use ($input) {
                $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
                if(!empty($input['cate_id'])){
                    $query->where('forum.pid', '=', $cate);
                } 
            })->orderBy('forum_rep.created_at','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = ForumRep::select()
            ->join('forum', 'forum.forum_id', '=', 'forum_rep.forum_id')
            ->join('forum_category', 'forum.pid', '=', 'forum_category.id')
            ->where(function ($query) use ($input) {
                $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                if(!empty($input['keyword'])){
                    $query->where('forum_rep.content', 'like', '%'.$keyword.'%');
                } 
            })->where(function ($query) use ($input) {
                $cate = (!empty($input['cate_id'])) ? $input['cate_id'] : '';
                if(!empty($input['cate_id'])){
                    $query->where('forum.pid', '=', $cate);
                } 
            })->count();
            
            foreach($data as $v){
                preg_match("/<video[^>]*?>(.*\s*?)<\/video>/is",$v->content, $matches1);
                preg_match('/<img[^>]*src=[\'"]([^\'"]*)[\'"][^>]*>/is', $v->content, $matches2);
                $v->art_thumb = "";
                if(!empty($matches1)){  
                    preg_match('/<video[^>]*poster=[\'"]([^\'"]*)[\'"][^>]*>/is', $matches1[0], $img_array);
                    $v->art_thumb = "<image src='".@$img_array[1]."'>";
                }
                //pre($matches2[1]);
                if(!empty($matches2)){
                    $v->art_thumb = "<image src='".@$matches2[1]."'>";
                }
            }
            //pre(ForumRep::listToTree($data->toArray()));
            $list = ForumRep::formatTree(ForumRep::listToTree($data->toArray()));
            //pre($list);
            $datainfo =  array(
                'code'  =>  0,
                'msg'   =>  '',
                'count' =>  $count,
                'data'  =>$list,
                'size'  =>$limit,
            );
            
            return response()->json($datainfo);
            
        } 
        return view('admin.forum.comList');
    
    }
    
    public function repView(Request $request)
    {
        $forumRep = ForumRep::select("*")
                ->where("repid",$request->id)
                ->first();
        if(empty($forumRep)){//没有转404
            abort(404);
        }
        
        return view('admin.forum.repView',compact("forumRep"));
    
    }

}
