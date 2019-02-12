<?php

namespace App\Http\Middleware;
use App\Http\Model\Member;
use Closure;
use Cache;

class IsApi
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
        
        $token = \Cache::get("token");
        if(empty($request->user_id) || empty($request->token)){
            return response()->json(array("code"=>-1,"msg"=>"缺少参数"));
        }else{
            $user = Member::select()
                ->join('openid', 'openid.uid', '=', 'member.id')
                ->where('member.id',$request->user_id)
                ->first();
            if(empty($user)){
                return response()->json(array("code"=>-1,"msg"=>"用户不存在"));
            }
        }

        return $next($request);
    }
}
