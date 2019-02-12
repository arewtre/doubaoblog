@extends('layouts.wap')
@section('content')
<style>
    .avatar_m {
        width: 1.2rem;
        height: 1.2rem;
        overflow: hidden;
        border-radius: 50% 50%; 
        margin: 0 auto;
        background-image: url("{{asset($list->userface)}}");
        background-size:100%;
    }
</style>
	<!-- header start -->
        <div class="userHead header">
            <a href="javascript:;" onclick="history.go(-1);" class="goBack z" style="margin-top:5px">返回</a>
            <h1 style="margin-top:10px">个人中心</h1>
            <div class="user_avatar">
                <div class="avatar_m"></div>
                <h2>{{$list->nickname}}<span>注册会员</span></h2>
            </div>
        </div>
	<!-- header end -->

	<!-- userInfoNv start -->
	<div class="userInfoNv">
		<div class="myinfo_list cl">
                    <ul>
                    <li class="unv5"><a href="javascript:;"><span></span>今日签到</a></li>
                    <li class="unv1"><a href="javascript:;"><span></span>我的收藏</a></li>
                    <li class="unv2"><a href="javascript:;"><span></span>我的主题</a></li>
                    <li class="unv3"><a href="javascript:;"><span></span>我的消息</a></li>
                    <li class="unv4"><a href="javascript:;"><span></span>我的资料</a></li>
                    </ul>
                    <div class="myinfo_list cl">
                        <ul>
                            <li class="xrLoginNv5"><a href="javascript:;"><em></em>绑定微信</a></li>
                        </ul>
                        <div class="myinfo_list cl">
                            <ul>
                                <li class="xrLoginNv1"><a href="javascript:;" data-url="" class="xinrui_qq_menu"><em></em>绑定老用户</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="myinfo_list cl">
                        <ul>
                            <li class="xrLoginNv1"><a href="javascript:;" data-url="" class="xinrui_qq_menu"><em></em>绑定老用户</a>
                            </li>
                        </ul>
                    </div>
                </div>
		<p><a href="{{url('wap/logout')}}" class="btn3">退出</a></p>
	</div>
<script>
$(function(){
   $(".btFixed a").removeClass("cur");
   $(".btPerson").addClass("cur"); 
   layui.use(['form','upload'], function(){
    $(".myinfo_list ul li").click(function(){
        layer.msg("正在建设中...");
    })
   })
})

</script>
   @include('layouts/footer') 
@endsection