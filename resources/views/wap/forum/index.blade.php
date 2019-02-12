@extends('layouts.wap')
@section('content')
<header class="header">
    <div class="nav">
	<span>论坛</span>
    </div>
</header>
<!--<div class="cl">
	<div class="clew_con">
		<h2 class="tit">{lang zsltmobileclient}</h2>
		<p>{lang visitbbsanytime}<input class="redirect button" id="visitclientid" type="button" value="{lang clicktodownload}" href="" /></p>
		<h2 class="tit">{lang iphoneandriodmobile}</h2>
		<p>{lang visitwapmobile}<input class="redirect button" type="button" value="{lang clicktovisitwapmobile}" href="$_GET[visitclient]" /></p>
	</div>
</div>-->

<header class="header p_header">
	<a class="topMenu fl" href="#mainNv">菜单</a>
	@if (!session('userinfo'))
	<a class="topLogin fr" href="{{url('wap/login')}}"></a>
	@else
        <a class="topLogin fr" href="{{url('wap/profile')}}"><img  src="{{session('userinfo.userface')}}"></a>
	@endif
	<h1 class="logo"><img  src="{{asset('resources/wap/touch/images/logo.ico')}}"></h1>
</header>
<!-- header end -->

<div class="container cfix">
<!-- main forumlist start -->
@foreach($mod as $v)
<div class="catlist">
	<div class="subforumshow cfix" href="#sub_forum_{{$v['id']}}">
            <span class="o y">
                <img src="{{asset('resources/wap/touch/images/img/collapsed_yes.png')}}">
            </span>
            <h2>{{$v['defectsname']}}</h2>
	</div>
	<div id="sub_forum_{{$v['id']}}" class="sub_forum">
		<ul>
                    @if(isset($v['_child']))
                        @foreach($v['_child'] as $vv)
			<li class="cfix">
                            <div class="f_icon">
                                @if(!empty($vv['img']))
                                    <img src="{{asset($vv['img'])}}" />
                                @else
                                    <img src="{{asset('resources/wap/touch/images/img/common_54_icon.png')}}" />
                                @endif
                            </div>
                            <a class="forum_a" href="{{url('wap/forum_list/'.$vv['id'])}}">
                                <h3>
                                    <span class="y f_count">{{getForum($vv['id'],1)}}/{{getForum($vv['id'],2)}}</span>
                                    {{$vv['defectsname']}}
                                </h3>
                                <p>{{$vv['dec']}}</p>
                            </a>
			</li>
                        @endforeach
                    @endif
		</ul>
	</div>
</div>
@endforeach
</div>
<script>
$(function(){
   $(".btFixed a").removeClass("cur");
   $(".btForum").addClass("cur"); 
})

</script>
   @include('layouts/footer') 
@endsection