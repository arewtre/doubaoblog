@extends('layouts.wap')
@section('content')

   <header class="header p_header">
	<a class="topMenu fl" href="#mainNv">菜单</a>
	@if (!session('userinfo'))
	<a class="topLogin fr" href="{{url('wap/login')}}"></a>
	@else
        <a class="topLogin fr" href="{{url('wap/profile')}}"><img  src="{{session('userinfo.userface')}}"></a>
	@endif
	<h1 class="logo"><img  src="{{asset('resources/wap/touch/images/logo.ico')}}"></h1>
</header>
<div class="container">
	<script src="{{asset('resources/wap/touch/images/js/TouchSlide.1.1.js')}}" type="text/javascript"></script>
	<!--二级导航-->
<!--	<div class="nvBar">
		<div class="subNv">
			<ul><li><a href="{{url('wap/news')}}">资讯/博客</a></li>
                            <li><a href="{{url('wap/blog')}}">博客文章</a></li>
                            <li><a href="{{url('wap/imageXc')}}">豆宝相册</a></li>
                            <li><a href="{{url('wap/forum')}}">论坛版块</a></li>
                            <li><a href="{{url('wap/login')}}">热门标签</a></li>
                            <li><a href="{{url('wap/audio')}}">音乐欣赏</a></li>
                            <li><a href="{{url('wap/video')}}">热门视频</a></li>
                            <li><a href="{{url('wap/sign')}}">每日签到</a></li>
                            <li><a href="{{url('wap/special')}}">特殊主题</a></li></ul>
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
	<!-- 栏目导航 -->
	<div class="cNav cfix pb">
            <ul><li><a href="{{url('wap/news')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv1.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv1.png')}}" style="display: inline; visibility: visible;"></span>资讯</a></li>
                <li><a href="{{url('wap/forum')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv2.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv2.png')}}" style="display: inline; visibility: visible;"></span>论坛</a></li>
                <li><a href="{{url('wap/imageXc')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv3.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv3.png')}}" style="display: inline; visibility: visible;"></span>影集</a></li>
                <li><a href="{{url('wap/guide')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv4.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv4.png')}}" style="display: inline; visibility: visible;"></span>导读</a></li>
                <li><a href="{{url('wap/tags')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv5.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv5.png')}}" style="display: inline; visibility: visible;"></span>标签</a></li>
                <li><a href="{{url('wap/search')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv6.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv6.png')}}" style="display: inline; visibility: visible;"></span>搜索</a></li>
                <li><a href="{{url('wap/sign')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv7.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv7.png')}}" style="display: inline; visibility: visible;"></span>签到</a></li>
                <li><a href="{{url('wap/forum_list/80')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv8.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv8.png')}}" style="display: inline; visibility: visible;"></span>视频</a></li>
                <li><a href="{{url('wap/forum_list/81')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv9.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv9.png')}}" style="display: inline; visibility: visible;"></span>音频</a></li>
                <li><a href="{{url('wap/forum_list/83')}}"><span><img src="{{asset('resources/wap/touch/images/img/cNv10.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv10.png')}}" style="display: inline; visibility: visible;"></span>亲子教育</a></li></ul>
	</div>
    <!-- 首页广告1 -->
    @if(count($advtop)>0)
        <div class="adPic pb">
            <a href="#" target="_self">
                <img src="{{asset($v->pic_url)}}" width="100%" height="200" zsrc="{{asset($v->pic_url)}}" style="display: inline; visibility: visible;">
            </a>
        </div>
    @endif
	<!--热帖推荐-->
	<div class="hotPosts cfix pb">
		<ul>
                    @foreach($forum as $k=>$v)
                    <li  @if($k==0) class="first" @endif>
                        <a href="{{url('wap/forum_list_detail/'.$v->forum_id)}}" title="{{$v->title}}">
                            @if($k==0)
                                <font style="font-weight: 900;color: #FF9900;">{{$v->title}}</font>
                            @else
                                {{$v->title}}
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
	</div>

	<!--图文精选-->
	<div class="pb">
		<div class="hdTit cfix">
                    <h2>图文精选</h2>
		</div>
		<div class="ausPt cfix" id="ausPt"> 
                <div class="tempWrap" style="overflow:hidden; position:relative;"> 
                 <div class="ausPtCon" style="width: 2484px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 200ms; transform: translate(-414px, 0px) translateZ(0px);"> 
                @foreach($article as $vv)
                  <ul style="display: table-cell; vertical-align: top; width: 414px;"> 
                      @foreach($vv as $v)
                        <li><a href="{{url('wap/news_'.$v['art_id'].'.html')}}">
                             <img height="180px" src="{{$v['art_thumb']}}" zsrc="{{$v['art_thumb']}}" style="display: inline; visibility: visible;" />
                             <h3>{{$v['art_title']}}</h3></a>
                        </li>
                      @endforeach
                  </ul>
                @endforeach
                 </div>
                </div> 
                <ul class="ausPtNum"> 
                 @for($i=1;$i<=(ceil(count($article)/3));$i++)
                    <li @if($i==1) class="on" @endif >{{$i}}</li>  
                 @endfor
                </ul>
               </div>
		<script type="text/javascript">
		TouchSlide({ 
			slideCell:"#ausPt",
			titCell:".ausPtNum li",
			mainCell:".ausPtCon", 
			effect:"leftLoop"
		});
		</script>
	</div>


	<!--最新文章-->
	<div class="pb">
		<div class="hdTit cfix">
			<h2>最新文章</h2>
			<span><a href="{{url('wap/news')}}">更多&gt;&gt;</a></span>
		</div>
		<div class="newPosts">
		<ul>
                    @foreach($data as $v) 
                    <li>
                     <a href="{{url('wap/news_'.$v->art_id.'.html')}}"> 
                            <div class="pic">
                                    <img width="300" height="200" src="{{$v->art_thumb}}" zsrc="{{$v->art_thumb}}" style="display: inline; visibility: visible;">
                            </div>
                            <h3>{{$v->art_title}}</h3>
                            <div class="attr cl">
                                    <div class="fl">
                                            <span class="au icon">{{$v->nickname}}</span>
                                    </div>
                                    <div class="fr">
                                            <span class="views icon">{{$v->art_view}}</span>
                                            <span class="replies icon">{{$v->art_rep}}</span>
                                    </div>
                            </div>
                    </a>
                    </li>
                    @endforeach
                </ul>
		</div>
	</div>


	<!-- 图片广告2 -->
        @if($advtop)
	<div class="adPic pb">
            <img src="{{$advtop->pic_url}}" width="100%" zsrc="{{$advtop->pic_url}}" style="display: inline; visibility: visible;">
	</div>
        @endif
	<!--版块导航-->
	<div class="pb">
		<div class="hdTit cfix">
			<h2>版块导航</h2>
			<span><a href="{{url('wap/forum')}}">更多&gt;&gt;</a></span>
		</div>
		<div class="coluNv cfix">
                    <ul>
                        @foreach($mod as $v)
                        <li>
                            <a href="{{url('wap/forum_list/'.$v['id'])}}">
                            <div class="cPic"><img src="{{asset($v['img'])}}" zsrc="{{asset($v['img'])}}" style="display: inline; visibility: visible;"></div>
                            <h4>{{$v['defectsname']}}</h4>
                            </a>
                        </li>
                        @endforeach
                    </ul>
		</div>
	</div>

	@if (!session('userinfo'))
	<div class="pb indexLogin">
		<p>登录之后可以体验更多功能！</p>
		<a href="{{url('wap/login')}}">立即登录</a>
	</div>
	@endif
</div>
   @include('layouts/footer') 
@endsection