<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\VisitLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{

    public function index(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['clientip','page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 12;
            $data = VisitLog::where(function ($query) use ($input) {
                $keyword = (!empty($input['clientip'])) ? $input['clientip'] : '';
                if(!empty($input['clientip'])){
                    $query->where('clientip', 'like', '%'.$keyword.'%');
                } 
            })
            ->orderBy('created_at','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = VisitLog::where(function ($query) use ($input) {
                $keyword = (!empty($input['clientip'])) ? $input['clientip'] : '';
                if(!empty($input['clientip'])){
                    $query->where('clientip', 'like', '%'.$keyword.'%');
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

        return view('admin.visit.index');
    }

    

}
