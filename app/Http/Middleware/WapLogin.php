<?php

namespace App\Http\Middleware;

use Closure;

class WapLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('userinfo')){
            if(is_ajax()){
                if(IS_POST){
                    return response()->json(array('code' => 0, 'msg' =>"请先登录!"));
                }
                echo "<script>layer.msg('请先登录', {time:1500});</script>";
                die;
            }else{
              return redirect('wap/login');  
            }
            
        }

        return $next($request);
    }
}
