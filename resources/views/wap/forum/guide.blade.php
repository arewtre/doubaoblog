@extends('layouts.wap')
@section('content')

   <header class="header p_header">
	<a class="topMenu fl" href="#mainNv">菜单</a>
	@if (!session('userinfo'))
	<a class="topLogin fr" href="{{url('wap/login')}}"></a>
	@else
        <a class="topLogin fr" href="{{url('wap/profile')}}"><img  src="{{session('userinfo.userface')}}"></a>
	@endif
	<h1 class="logo"><img  src="{{asset('resources/wap/touch/images/img/logo.png')}}"></h1>
</header>
<div class="container">
	<script src="{{asset('resources/wap/touch/images/js/TouchSlide.1.1.js')}}" type="text/javascript"></script>
	<!--二级导航-->
<!--	<div class="nvBar">
		<div class="subNv">
			<ul><li><a href="{{url('wap/news')}}">资讯/技术</a></li>
                            <li><a href="{{url('wap/blog')}}">技术文章</a></li>
                            <li><a href="{{url('wap/imageXc')}}">豆宝相册</a></li>
                            <li><a href="{{url('wap/forum')}}">论坛版块</a></li>
                            <li><a href="{{url('wap/login')}}">热门标签</a></li>
                            <li><a href="{{url('wap/audio')}}">音乐欣赏</a></li>
                            <li><a href="{{url('wap/video')}}">热门视频</a></li>
                            <li><a href="{{url('wap/sign')}}">每日签到</a></li>
                            <li><a href="{{url('wap/special')}}">特殊主题</a></li>
                        </ul>
		</div>
	</div>-->

	<!--焦点图-->
	<div class="xrSlider" id="xrSlider">
		<div class="sliderCon">
		<div class="tempWrap" style="overflow:hidden; position:relative;">
                    <ul style="width: 2898px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 0ms; transform: translate(-414px, 0px) translateZ(0px);">
                        @if($adv)
                        @foreach($adv as $v)
                        <li style="display: table-cell; vertical-align: top; width: 414px;">
                            <a href="">
                                <div class="sPic">
                                    <img src="{{$v->pic_url}}" width="800" height="450" zsrc="{{$v->pic_url}}" style="display: inline; visibility: visible;">
                                </div>
                                <h3>{{$v->title}}</h3>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
	</div>
	</div>
	<script type="text/javascript">
	TouchSlide({ 
		slideCell:"#xrSlider",
		titCell:".sliderNum li",
		mainCell:".sliderCon ul", 
		effect:"leftLoop",
		autoPlay:true //自动播放
	});
	</script>
	

	<div class="forumListTab cfix">
            <ul>
                <li @if($fil=="created_at") class="xw1 a" @endif><a href="{{url('wap/guide?filter=created_at')}}">最新发表</a></li>
                <li @if($fil=="views") class="xw1 a" @endif><a href="{{url('wap/guide?filter=views')}}">最新热门</a></li>
                <li @if($fil=="reps") class="xw1 a" @endif><a href="{{url('wap/guide?filter=reps')}}">最新精华</a></li>
                <li @if($fil=="lastrepcreated_at") class="xw1 a" @endif><a href="{{url('wap/guide?filter=lastrepcreated_at')}}">最新回复</a></li>
            </ul>
        </div>
	<div class="threadlist">
            <ul>
                @if(count($data)>0)
                @foreach($data as $v)
                <li>
                    <a href="{{url('wap/forum_list_detail/'.$v['forum_id'])}}">
                        <div class="threadListTit">
                        <div class="h_avatar">
                            <img src="{{asset($v['userface'])}}" zsrc="" style="display: inline; visibility: visible;">
                        </div>
                        <h4>
                            <div class="count y">
                                <span class="views icon">{{$v['views']}}</span>
                                <span class="replies icon">{{$v['reps']}}</span>
                            </div>
                            {{$v['nickname']}}
                        </h4>
                        <p>发布于 {{word_time($v['created_at'],1)}}</p>
                        </div>
                        <h3 class="threadSubject">
                        {{mb_substr(strip_tags($v['content']),0,54,'utf-8')}}....
                        </h3>
                    </a>
                </li>
                @endforeach
                @else
                        <li class="noData">对不起，没有找到匹配结果。</li>
                        @endif
            </ul>
        </div>
        <div id="demo1" class="pgs cl" style="text-align: center"></div>
	@if (!session('userinfo'))
	<div class="pb indexLogin">
		<p>登录之后可以体验更多功能！</p>
		<a href="{{url('wap/login')}}">立即登录</a>
	</div>
	@endif
</div>
<script>
layui.use(['laypage', 'layer','form','flow'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,laypage = layui.laypage
  ,flow = layui.flow;

//完整功能
  laypage.render({
    elem: 'demo1'
    ,count: {{$count}}
    ,skip: true
    ,limit:{{$limit}}
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      if(!first){   
            window.location.href="/wap/guide?page="+obj.curr;
        }  
    }
  });
});
</script>
   @include('layouts/footer') 
@endsection