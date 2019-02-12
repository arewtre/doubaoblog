@extends('layouts.wap')
@section('content')
<style>
.atd .atdc{position:relative;margin:0 auto 10px;width:.6rem;height:50px;}
.atdc div{position:absolute;left:50%;bottom:0;width:.16rem;border-radius:.08rem;margin-left:-.08rem;}
.atd .ac1{background:#C30;}
.atd .ac2{background:#0C0;}
.atd .ac3{background:#F90;}
.atd .ac4{background:#06F;}
.atdc em{position:absolute;left:50%;margin:-25px 0 0 -20px;width:40px;text-align:center;color:#999;}
.dec_tit{font-size:.28rem;color:#999;font-weight:normal;text-align:center;}
.dec_tit a{color:#FF7F84;}
#click_div td a { display: block; color: #999; text-align: center; font-size: .24rem;}
#click_div td { vertical-align: bottom; }
#article_content table{
        background-color: #282c34;
        color: #B9BDB6 !important;
        width:100%;
    }
</style>
<header class="header">
	<a class="goBack fl" href="javascript:history.back()">返回</a>
	<a class="topShare fr" href="#viewShare">分享</a>
	<h1>文章详情</h1>
</header>

<div class="container">
	<div id="pt">
		<a href="{{url('wap')}}">首页</a> <em>&rsaquo;</em>
		<!--{loop $cat[ups] $value}-->
			<a href="{{url('wap/blog')}}">博客文章</a><em>&rsaquo;</em>
		<!--{/loop}-->
		<a href="">详情</a> <em>&rsaquo;</em>
	</div>
	<div class="article_view pb">
		<div class="article_tit">
			<h1>{{$detail->art_title}}</h1>
			<p>
				<span class="fr">{{word_time($detail->updated_at,1)}}</span>
				<a href="">{{$detail->update_editor}}</a>
				查看：<em id="_viewnum">{{$detail->art_view}}</em>
				评论：<a href="$common_url" title=""><em id="_commentnum">{{$detail->art_rep}}</em></a>
			</p>
		</div>
            <!--<img style="width:100%"src="{{$detail->art_thumb}}" />-->
		<div id="article_content" class="article_con">{!! nl2br($detail->art_content) !!}</div>
		<!--{if $multi}<div class="ptw pbw cl">$multi</div>{/if}-->
<!--        <div align="center">
          <a href=""><img src="{{$detail->art_thumb}}" /></a>
        </div>-->


<!-- 资讯表态开始 -->
<div id="click_div">					
<!--{template home/space_click}-->				
</div>
<!-- 资讯表态结束 -->

	</div>
<!-- 相关阅读开始 -->
        <div id="related_article" class="relateItem">
            <h3 class="postListHd">相关阅读</h3>
            <ul class="bp" id="raid_div">
                @foreach($xg as $k=>$v)
               <input type="hidden" value="{{$k+1}}">  
                 <li><a href="{{url('blog_'.$v->art_id.'.html')}}">{{$v->art_title}}</a></li>
              @endforeach
            </ul>
        </div>
<!-- 相关阅读结束 -->
	<!--<script type="text/javascript" src="{$_G[setting][jspath]}home.js?{VERHASH}"></script>-->

	<div id="comment">
	<div class="comment_tit">
		<span class="y">已有 <strong id="_commentnum">{{count($rep)}}</strong> 人参与评论1</span>
		<h3>最新评论</h3>
	</div>
	<div id="comment_ul" class="pb">
		@if(count($rep)>0)
			<ul>
                            @foreach($rep as $k=>$v)
			<div class="postListItem" href="#replybtn_11509" id="pid11509">
                            <div class="postListTit">
                                <span class="h_avatar"><img src="{{asset($v->userface)}}"></span>
                                <h4>
                                    
                                    <em class="y">
                                       @if($k==0) 
                                        沙发
                                        @elseif($k==1)
                                        板凳
                                        @elseif($k==2)
                                        地板
                                        @else
                                         {{$k+1}}<sup>#</sup>
                                        @endif
                                    </em>
                                   
                                    <a href="#" class="blue">{{$v->nickname}}</a>
                                </h4>
                                <div class="postListAttr">{{word_time($v->created_at,1)}}</div>
                            </div>
                            <div class="postListCon">{{$v->nickname}}</div>
                            <div id="replybtn_11509" class="replybtn" display="true">
                            <input type="button" class="redirect button" href="" value="回复">
                            </div>
                            <!--signature start-->	
                            <!--signature end-->
                            <!--xinrui tag start-->
                            <!--xinrui tag end-->
                            </div>
                            @endforeach
			</ul>
		@else
			<div class="comShaFa">
				暂无评论，赶紧抢沙发吧
			</div>
		@endif		
		
		<!--{if !$data[htmlmade]}-->
		<form id="cform" name="cform" action="" method="post" autocomplete="off" class="layui-form">

			<textarea lay-verify="required" name="message" rows="3" class="textarea" id="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" placeholder="发表内容，参与互动"></textarea>
			<button lay-submit lay-filter="admin-form" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="btn1 mt20">评论</button>
		</form>
		<!--{/if}-->
	</div>
</div> 

</div>

<div id="viewShare" class="viewShare" style="display:none">
	<div class="bdsharebuttonbox">
		<div class="wxShare"><a class="jiathis_button_weixin" href="#" style="background:url({{asset('resources/wap/touch/images/img/weixin.png')}})">微信</a></div>
		<div class="wxShare"><a class="jiathis_button_weixin" href="#" style="background:url({{asset('resources/wap/touch/images/img/weibo.png')}})">微博</a></div>
                <!-- JiaThis Button BEGIN -->		
		<div class="jiathis_style_m"></div>
		<!--<script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_m.js" charset=gbk></script>-->
		<!-- JiaThis Button END -->
	</div>
</div>
<div class="popMask">
	<img src="{{asset('resources/wap/touch/images/img/share.png')}}" />
</div>

<script type="text/javascript">
    layui.use(['layer','form','code'], function(){
      var form = layui.form
      ,layer = layui.layer;
      layui.code({
        title: '代码'
        ,skin: 'notepad' //如果要默认风格，不用设定该key。
      });
      form.on('submit(admin-form)', function(data){
                	//console.log(data);return;
            $.ajax({
                type: "POST",
                url: '{{url("edit")}}',
                data: data.field,
                success: function(msg){
                    if( msg.code == 1 ){
                        window.location.reload();
                        layer.msg(msg.msg, {time:1500});
                    }else{
                        parent.layer.msg(msg.msg, {
                            icon: 5,
                            shade: [0.6, '#393D49'],
                            time:1500
                        });
                    }
                }
            });
            return false;
        });
    })
$(function() {
	$('#viewShare').mmenu({
		autoHeight	: true,
		navbar		: {
			title 	: false
		},
		offCanvas	: {
			position	: "bottom",
			zposition	: "front",
			modal		: true
		}
	});
});
$(function() {
	$("#mm-blocker").click(function(){
		$("html").removeClass();
		$(".viewShare").attr("class","viewShare mm-menu mm-offcanvas mm-bottom mm-front mm-autoheight");
	});
	$('.jiathis_button_weixin').click(function(){
		$(".popMask").show();
		$("#mm-blocker").trigger("click");
		return false;
	});
	$('.popMask').click(function(){
		$(this).hide();
		window.location.reload();
	})
});
</script>
   @include('layouts/footer') 
@endsection

