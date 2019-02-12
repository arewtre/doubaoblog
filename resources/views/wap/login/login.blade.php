@extends('layouts.wap')
@section('content')
<style>
 .btn_login a{
     margin-top: 10px; 
     background:#f60 url({{asset('resources/wap/touch/images/img/mobileIcon.png')}}) no-repeat 50px center / auto 65%;
     border-radius:3px; 
     width:100%; 
     height:.7rem; 
     display:block; 
     line-height:.7rem; 
     overflow:hidden; 
     color:#fff; 
     text-align:center;
     border:0; 
     font-size:.24rem;
 }
 .btn_login .qq{background: #f60 url({{asset('resources/wap/touch/images/img/qq_login.png')}}) no-repeat 32px center / auto 94%;}
 /*.btn_login .wechat:hover{ background:#2f9833; color:#fff; }*/
 </style>
 <!-- header start -->
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
<header class="header">
	<a href="javascript:;" onclick="history.go(-1)" class="goBack z"></a>
	<h1>登录</h1>
</header>
<!-- header end -->
<div class="loginbox">
            <form class="layui-form" id="loginform" method="post" action="">
                {{csrf_field()}} 
            <div class="login_from">
		<ul>
			<li><input lay-verify="required" type="text" value="" tabindex="1" class="inp" autocomplete="off" value="" name="username" placeholder="请输入用户名" fwin="login"></li>
			<li><input lay-verify="required" type="password" tabindex="2" class="inp"  value="" name="password" placeholder="请输入密码" fwin="login"></li>
{{--			<li>
                            <select id="questionid" name="cwid" class="sel_list">
                                    <option value="0" selected="selected"></option>
                                    @foreach($cw as $v)
                                    <option value="{$v->cwid}}">{{$v->chenw}}</option>
                                    @endforeach
                            </select>
  
			</li>			--}}
			<!--{if $seccodecheck}-->
			<li>
				<!--{subtemplate common/seccheck}-->
			</li>
			<!--{/if}-->
                        <!--<script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>-->
                        <script>
                        var clipboard = new Clipboard('.hongbao', {
                        text: function () {
                        // 将自己的红包口令放入此
                        return 'giB8ij82dv';
                        }
                        });
                        </script>
                        <li><span tabindex="3" value="true" name="submit" lay-submit="" lay-filter="login" class="formdialog btn1">登录</span></li>
			<!--{if $_G['setting']['regstatus']}-->
			<li>
				<a class="btn2" href="{{url('wap/register')}}"><button type="button" class="hongbao" style="border:0;width:100%;" onClick="return false;">还没有注册?</button></a>
			</li>
			<!--{/if}-->
                            <div class="btn_login"><a href="{{url('wap/qqLogin')}}" class="qq"><span>QQ一键登录</span></a></div>

                        </li>
			<li>
                            <!--<div class="btn_login xinruiMobileBtn"><a href=""><span>手机短信登录</span></a></div>-->
                            <!--<div class="btn_login"><a href="" class="wechat"><span>微信一键登录</span></a></div>-->
			<li><!--{hook/logging_bottom_mobile}--></li>
		</ul>
	</div>
	</form>

</div>
<script>
//jQuery("#nv li").removeClass("a");
//jQuery("#mn_N6e20").addClass("a");

layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,form = layui.form
  ,layer = layui.layer;
   
   form.on('submit(login)', function(data){
        //console.log(data.field);
        var loadIndex = layer.load(2, {
                        shade: [0.3, '#333']
                    });
        $.ajax({
            type: "POST",
            url: '{{url("wap/login")}}',
            data: data.field,
            success: function(res){
                if (res.code!=1) {
                    layer.msg(res.msg, {
                        icon: 2
                    });
                    loadIndex && layer.close(loadIndex);
                    //$('#changeCode').click(); //刷新验证码
                } else {
                   layer.msg(res.msg);
                   loadIndex && layer.close(loadIndex);
                   setTimeout(function() {
                       window.location.href = "{{url("+res.url+")}}"
                   }, 1500);
                }
            }
        });
        return false;
    });
  
});

</script>
   @include('layouts/footer') 
@endsection