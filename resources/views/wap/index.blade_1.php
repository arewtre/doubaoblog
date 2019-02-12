@extends('layouts.wap')
@section('content')

   <header class="header p_header">
	<a class="topMenu fl" href="#mainNv">菜单</a>
	@if (!session('userinfo'))
	<a class="topLogin fr" href="{{url('wap/qqLogin')}}"></a>
	@else
        <a class="topLogin fr" href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1"><img  src="{{session('userinfo.userface')}}"></a>
	@endif
	<h1 class="logo"><img  src="{{asset('resources/wap/touch/images/img/logo.png')}}"></h1>
</header>
<div class="container">
	<script src="{{asset('resources/wap/touch/images/js/TouchSlide.1.1.js')}}" type="text/javascript"></script>
	<!--二级导航-->
	<div class="nvBar">
		<div class="subNv">
			<ul><li><a href="portal.php?mod=list&amp;catid=1&amp;mobile=2">新闻资讯</a></li>
                            <li><a href="forum.php?forumlist=1&amp;mobile=2">论坛版块</a></li>
                            <li><a href="forum.php?mod=forumdisplay&amp;fid=46&amp;mobile=2">图片瀑布流</a></li>
                            <li><a href="misc.php?mod=tag&amp;mobile=2">热门标签</a></li>
                            <li><a href="forum.php?mod=forumdisplay&amp;fid=61&amp;mobile=2">音频展示</a></li>
                            <li><a href="forum.php?mod=forumdisplay&amp;fid=55&amp;mobile=2">视频展示</a></li>
                            <li><a href="plugin.php?id=dsu_paulsign:sign&amp;mobile=2">每日签到</a></li>
                            <li><a href="forum.php?mod=forumdisplay&amp;fid=54&amp;mobile=2">特殊主题</a></li></ul>
		</div>
	</div>

	<!--焦点图-->
	<div class="xrSlider" id="xrSlider">
		<div class="sliderCon">
		<div class="tempWrap" style="overflow:hidden; position:relative;">
                    <ul style="width: 2898px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 0ms; transform: translate(-414px, 0px) translateZ(0px);">
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
            <ul><li><a href="portal.php?mod=list&amp;catid=1&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv1.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv1.png')}}" style="display: inline; visibility: visible;"></span>资讯</a></li>
                <li><a href="forum.php?forumlist=1&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv2.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv2.png')}}" style="display: inline; visibility: visible;"></span>论坛</a></li>
                <li><a href="forum.php?mod=forumdisplay&amp;fid=46&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv3.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv3.png')}}" style="display: inline; visibility: visible;"></span>瀑布流</a></li>
                <li><a href="forum.php?mod=guide&amp;view=newthread&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv4.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv4.png')}}" style="display: inline; visibility: visible;"></span>导读</a></li>
                <li><a href="misc.php?mod=tag&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv5.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv5.png')}}" style="display: inline; visibility: visible;"></span>标签</a></li>
                <li><a href="search.php?mod=forum&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv6.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv6.png')}}" style="display: inline; visibility: visible;"></span>搜索</a></li>
                <li><a href="plugin.php?id=dsu_paulsign:sign&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv7.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv7.png')}}" style="display: inline; visibility: visible;"></span>签到</a></li>
                <li><a href="forum.php?mod=forumdisplay&amp;fid=55&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv8.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv8.png')}}" style="display: inline; visibility: visible;"></span>视频</a></li>
                <li><a href="forum.php?mod=forumdisplay&amp;fid=61&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv9.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv9.png')}}" style="display: inline; visibility: visible;"></span>音频</a></li>
                <li><a href="forum.php?mod=forumdisplay&amp;fid=54&amp;mobile=2"><span><img src="{{asset('resources/wap/touch/images/img/cNv10.png')}}" zsrc="{{asset('resources/wap/touch/images/img/cNv10.png')}}" style="display: inline; visibility: visible;"></span>特殊主题</a></li></ul>
	</div>
<!-- 首页广告1 -->
<div class="adPic pb">
    <a href="#" target="_self">
        <img src="{{asset('resources/wap/touch/images/img/adpic2.jpg')}}" width="100%" zsrc="{{asset('resources/wap/touch/images/img/adpic2.jpg')}}" style="display: inline; visibility: visible;"></a>
</div>

	<!--热帖推荐-->
	<div class="hotPosts cfix pb">
		<ul>
                    <li class="first"><a href="forum.php?mod=viewthread&amp;tid=5283&amp;mobile=2" title="新锐创想APP制作服务上线啦！"><font style="font-weight: 900;color: #FF9900;">新锐创想APP制作服务上线啦！</font></a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=12&amp;mobile=2" title="恭喜北京申奥成功！许下2022年的愿望 送全">恭喜北京申奥成功！许下2022年的愿望 送全</a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=15&amp;mobile=2" title="有了这些软件，你的小米电视才是真正的智能">有了这些软件，你的小米电视才是真正的智能</a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=9&amp;mobile=2" title="资源分享版块模板，送给有需要的U友们！！">资源分享版块模板，送给有需要的U友们！！</a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=10&amp;mobile=2" title="大美青海-小蚁运动相机">大美青海-小蚁运动相机</a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=8&amp;mobile=2" title="文字锁屏——将女神留在你的手机锁屏里">文字锁屏——将女神留在你的手机锁屏里</a></li>
                    <li><a href="forum.php?mod=viewthread&amp;tid=6&amp;mobile=2" title="巧用小米手机连拍功能拍飞溅的水花">巧用小米手机连拍功能拍飞溅的水花</a></li>
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
                  <ul style="display: table-cell; vertical-align: top; width: 414px;"> 
                   @foreach($article as $v)
                   <li><a href="">
                           <img width="210" height="268" src="{{$v->art_thumb}}" zsrc="{{$v->art_thumb}}" style="display: inline; visibility: visible;" />
                           <h3>{{$v->art_title}}</h3></a>
                   </li>
                  @endforeach
                  </ul>
                 </div>
                </div> 
                <ul class="ausPtNum"> 
                 <li class="on"></li> 
                 <li class=""></li> 
                 <li class=""></li> 
                 <li class=""></li> 
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


	<!--最新主题-->
	<div class="pb">
		<div class="hdTit cfix">
			<h2>最新主题</h2>
			<span><a href="forum.php?mod=guide&view=newthread">更多&gt;&gt;</a></span>
		</div>
		<div class="newPosts">
		<ul>
                    @foreach($data as $v)
                    <li>
                    <a href="">
                            <div class="pic">
                                    <img width="300" height="200" src="{{$v->art_thumb}}" zsrc="{{$v->art_thumb}}" style="display: inline; visibility: visible;">
                            </div>
                            <h3>{{$v->art_title}}</h3>
                            <div class="attr cl">
                                    <div class="fl">
                                            <span class="au icon">{{$v->update_editor}}</span>
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
	<div class="adPic pb">
            <img src="{{$advtop->pic_url}}" width="100%" zsrc="{{$advtop->pic_url}}" style="display: inline; visibility: visible;">
	</div>

	<!--版块导航-->
	<div class="pb">
		<div class="hdTit cfix">
			<h2>版块导航</h2>
			<span><a href="forum.php?forumlist=1&mobile=2">更多&gt;&gt;</a></span>
		</div>
		<div class="coluNv cfix">
                    <ul>
                        @foreach($mod as $v)
                        <li>
                            <a href="">
                            <div class="cPic"><img src="{{$v['img']}}" zsrc="{{$v['img']}}" style="display: inline; visibility: visible;"></div>
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
		<a href="{{url('wap/qqLogin')}}">立即登录</a>
	</div>
	@endif
</div>
@endsection