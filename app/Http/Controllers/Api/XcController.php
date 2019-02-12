<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Model\ImagesXc;
use App\Http\Model\ImagesXcCate;
use App\Http\Model\Images;
use App\Http\Model\Member;
use View;
class XcController extends CommonController
{
    public function __construct(){
        parent::__construct();
        
    }
    
    public function index(Request $request)
    {
        $input = $request->all(); 
        $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
        $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 20;
        $xc = ImagesXc::select()
                ->join('images_category', 'images_category.id', '=', 'image_xc.pid')
                ->where(function ($query) use ($input) {
                    $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                    if(!empty($input['keyword'])){
                        $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
                    } 
                })
                ->where(function ($query) use ($input) {
                    $cid = (!empty($input['pid'])) ? $input['pid'] : '';
                    if(!empty($cid)){
                        $query->where('images_category.pid', '=', $cid);
                    } 
                })
                ->orderby("image_xc.created_at","desc")
                ->skip($limit*($page-1))->take($limit)
                ->get();
                
        $count = ImagesXc::select()
                ->join('images_category', 'images_category.id', '=', 'image_xc.pid')
                ->where(function ($query) use ($input) {
                    $keyword = (!empty($input['keyword'])) ? $input['keyword'] : '';
                    if(!empty($input['keyword'])){
                        $query->where('image_xc.xc_name', 'like', '%'.$keyword.'%');
                    } 
                })
                ->where(function ($query) use ($input) {
                    $cid = (!empty($input['pid'])) ? $input['pid'] : '';
                    if(!empty($cid)){
                        $query->where('image_xc.pid', '=', $cid);
                    } 
                })
                ->count();
        
        return $this->success($xc);
    }
    
    
    public function cate(Request $request)
    {
       $input = $request->all(); 
       $cate = ImagesXcCate::select()
                ->where("pid",0)
                ->orderby("descid","desc")
                ->get();
                 
        return $this->success($cate);
    }
    
     public function getImages(Request $request) {
         $page = isset ( $request->page ) ? intval ( $request->page ) : 1;
         $limit = isset ( $request->limit ) ? intval ( $request->limit ) : 10;
         $data = Images::where("cat_id",$request->id)
                 ->where("status",0)
                 ->skip($limit*($page-1))->take($limit)
                    ->get();
         return $this->success($data);
     }
    
    
    
    
    
}
