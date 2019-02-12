<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Model\Member;
use App\Http\Model\Search;
use App\Http\Model\News;
use App\Http\Model\VisitLog;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use \Carbon\Carbon;
use DB;
class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    //更改超级管理员密码
    public function pass()
    {
        if($input = Input::all()){

            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];

            $message = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码和确认密码不一致！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.pass');
        }
    }
    
    //首页面板
    public function main(Request $request)
    {
//        $resumeCount = Resume::where("resume_status",0)->count();
//        $jobCount = CompanyJob::where("job_status",0)->count();
//        $certCount = CompanyCertification::where("status",0)->count();
//        $partCount = PartTimeJobs::where("job_status",0)->count();
        //CpU 内存
//        $fp = popen('top -b -n 2 | grep -E "^(Cpu|Mem|Tasks)"',"r");//获取某一时刻系统cpu和内存使用情况
//        $rs = "";
//        while(!feof($fp)){
//            $rs .= fread($fp,1024);
//        }
//        pclose($fp);
//        $sys_info = explode("\n",$rs);
//        pre($sys_info);
//        $tast_info = explode(",",$sys_info[3]);//进程 数组
//        $cpu_info = explode(",",$sys_info[4]); //CPU占有量 数组
//        $mem_info = explode(",",$sys_info[5]); //内存占有量 数组
//
//        //正在运行的进程数
//        $tast_running = trim(trim($tast_info[1],'running'));
//
//        //CPU占有量
//        $cpu_usage = trim(trim($cpu_info[0],'Cpu(s): '),'%us'); //百分比
//
//        //内存占有量
//        $mem_total = trim(trim($mem_info[0],'Mem: '),'k total'); 
//        $mem_used = trim($mem_info[1],'k used');
//        $mem_usage = round(100*intval($mem_used)/intval($mem_total),2); //百分比
//
//        /*硬盘使用率 begin*/
//        $fp = popen('df -lh | grep -E "^(/)"',"r");
//        $rs = fread($fp,1024);
//        pclose($fp);
//        $rs = preg_replace("/\s{2,}/",' ',$rs); //把多个空格换成 “_”
//        $hd = explode(" ",$rs);
//        $hd_avail = trim($hd[3],'G'); //磁盘可用空间大小 单位G
//        $hd_usage = trim($hd[4],'%'); //挂载点 百分比
//        //print_r($hd);
//        /*硬盘使用率 end*/ 
//
//        //检测时间
//        $fp = popen("date +\"%Y-%m-%d %H:%M\"","r");
//        $rs = fread($fp,1024);
//        pclose($fp);
//        $detection_time = trim($rs);
//        pre(cpu_usage);
        //return array('cpu_usage'=>$cpu_usage,'mem_usage'=>$mem_usage,'hd_avail'=>$hd_avail,'hd_usage'=>$hd_usage,'tast_running'=>$tast_running,'detection_time'=>$detection_time);
        if(is_ajax()){
            switch ($request->type) {
                case 1:                  
                    $a = $b = $num = array();
//                    $b = array();
//                    $num = array();
                    for($j=1;$j<=47;$j++){
                        $a[] = date('Y-m-d H:i', strtotime(date('Y-m-d'))+($j)*30*60);
                        $b[] = date('H:i', strtotime(date('Y-m-d'))+($j)*30*60);
                    }
                    $num['date'] = $b;
                    foreach($a as $k=>$v){
                        $bros= DB::table('visit_log')
                            ->select(DB::raw('count(*) as value'))
                           ->where('created_at', '>=', $v)
                            ->where('created_at', '<=', date('Y-m-d H:i', strtotime($v)+1*30*60) )
                             ->first();
                        $num['num'][] = $bros->value;
                        
                    }
                    break;
                case 2:
                    $num = DB::select('select os as name,count(*)as value from lin_visit_log group by os order by value desc ');    
                    break;
                case 3:
                    $day = getLatelyTime("month");
                    $num = array();
                    $num['date'] = $day;
                    foreach($day as $k=>$v){
                        $bros= DB::table('member')
                            ->select(DB::raw('count(*) as value'))
                           ->where('created_at', '>=', $v)
                            ->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($v)+86399) )
                             ->first();
                        $num['num'][]= $bros->value;

                    }
                    break;

                    default:
                    break;
            }
          return response()->json($num);
            
        }
        $days = request('days', 7);

        $range = \Carbon\Carbon::now()->subDays($days);
        $data = $this->getNumber();
        return view('admin.main',compact('data'));
    }
    
    //热门文章
    public function getArticle(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
            $data = News::select('news.art_id','news.cate_id','news.art_thumb','news.art_title','news.art_view','news_category.defectsname','news.created_at')
            ->join('news_category', 'news.cate_id', '=', 'news_category.id')
            ->orderBy('news.art_view','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = News::select()
            ->join('news_category', 'news.cate_id', '=', 'news_category.id')
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
    }
    
    //新增会员
    public function getUser(Request $request)
    {
        if(is_ajax()){
            $input = array_filter($request->only(['page','limit']));
            $page = isset ( $input['page'] ) ? intval ( $input['page'] ) : 1;
            $limit = isset ( $input['limit'] ) ? intval ( $input['limit'] ) : 10;
            $data = Member::select('*')
            ->orderBy('created_at','desc')
            ->skip($limit*($page-1))->take($limit)
            ->get();
            $count = Member::select()
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
    }
    
    public function getData($type){
        if($type==3){
            $days = Input::get('days', 7);
            $range = \Carbon\Carbon::now()->subDays($days);
            $stats = Member::where('created_at', '>=', $range)
                ->groupBy('date')
                ->orderBy('date', 'DESC')
                ->get([
                    DB::raw('Date(created_at) as date'),
                    DB::raw('COUNT(*) as value')
                ]);
            return response()->json($stats);
        }
    }
    
    
    public function getNumber()
    {
        $data = [];
        $customers = Member::all(['id','created_at']);

        #今天数据
        $data['customer_today'] = Member::where('created_at', Carbon::today())->count();
        $data['teacher_today'] = Member::where('created_at', Carbon::today())->count();

        #昨天数据
        $data['customer_yesterday'] = Member::where('created_at', Carbon::yesterday())->count();
        $data['teacher_yesterday'] = Member::where('created_at', Carbon::yesterday())->count();

        $data['today'] = $data['customer_today'] + $data['teacher_today'];
        $data['yesterday'] = $data['customer_yesterday'] + $data['teacher_yesterday'];

        // 本周数据
        $this_week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $data['customer_this_week'] = Member::whereBetween('created_at', $this_week)->count();

        $data['teacher_this_week'] = Member::whereBetween('created_at', $this_week)->count();

        // 上周数据
        $last_week = [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()];
        $data['customer_last_week'] = Member::whereBetween('created_at', $last_week)->count();

        $data['teacher_last_week'] = Member::whereBetween('created_at', $last_week)->count();

        $data['this_week'] = $data['customer_this_week'] + $data['teacher_this_week'];
        $data['last_week'] = $data['customer_last_week'] + $data['teacher_last_week'];

        // 本月数据
//        $data['customer_this_month'] = Member::whereMonth('created_at', Carbon::now()->month)->count();
//        $data['teacher_this_month'] = Member::whereMonth('created_at', Carbon::now()->month)->count();
//
//        // 上月数据
//        $data['customer_last_month'] = Member::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
//        $data['teacher_last_month'] = Member::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

//        $data['this_month'] = $data['customer_this_month'] + $data['teacher_this_month'];
//        $data['last_month'] = $data['customer_last_month'] + $data['teacher_last_month'];

//        // 本年数据
//        $data['customer_this_year'] = Member::whereYear('created_at', Carbon::now()->year)->count();
//        $data['teacher_this_year'] = Member::whereYear('created_at', Carbon::now()->year)->count();
//
//        $data['today_login_users'] = VisitLog::whereDate('created_at', '=', Carbon::today())
//            ->groupBy('id')
//            ->orderBy('id')
//            ->count();
//
//        $data['yesterday_login_users'] = VisitLog::whereDate('created_at', '=', Carbon::yesterday())
//            ->groupBy('id')
//            ->orderBy('id')
//            ->count();
//
//        $data['this_month_login_users'] = VisitLog::whereMonth('created_at', Carbon::now()->month)
//            ->groupBy('id')
//            ->orderBy('id')
//            ->count();
//
//        $data['last_month_login_users'] = VisitLog::whereMonth('created_at', Carbon::now()->subMonth()->month)
//            ->groupBy('id')
//            ->orderBy('id')
//            ->count();

        return $data;
    }

}
