@extends('layouts.wap')
@section('content')
<header class="header">
	<a href="{{url('wap/forum')}}" class="goBack fl">返回</a>
	<a class="topSort fr" href="#subMenu">子版块</a>
	<h1>{{$mod->defectsname}}</h1>
	<div id="subMenu" class="subMenu">
            <div class="subMenuBox">
                <h3>子版块</h3>
                <ul>
                    <li><a href="">{{$mod->defectsname}}</a></li>
                </ul>
                <h3>全部板块<span class="num">({{$modCount}})</span></h3>
                @foreach($mods as $v)
                <ul id="thread_types">
                    <li class="a"><a href="javascript:;">{{$v['defectsname']}}</a></li>
                    @if(isset($v['_child']))
                        @foreach($v['_child'] as $vv)
                            <li><a href="{{url('wap/forum_list/'.$vv['id'])}}">{{$vv['defectsname']}}<span class="xg1 num">({{getForum($vv['id'],2)}})</span></a></li>
                        @endforeach
                    @endif
                </ul>
                @endforeach
            </div>
	</div>
	<script type="text/javascript">
		$(function() {
			$('#subMenu').mmenu({
				autoHeight	: true,
				navbar		: {
					title 	: false
				},
				offCanvas	: {
					position	: "right",
					zposition	: "front",
					modal		: true
				}
			});
		});
	</script>
	
</header>
<!-- header end -->

<div class="forumListHeader cfix">
	<!--{if $_G['forum'][icon]}-->
	<div class="fl_icon fl"><img src="{{asset($mod->img)}}" alt="{{$mod->defectsname}}" /></div>
	<!--{/if}-->
	<h3>{{$mod->defectsname}}</h3>
	<p>
            <span>今日: {{getForum($mod->id,1)}}</span>
            <span>帖子: {{getForum($mod->id,2)}}</span>
	</p>
	<a class="fa_fav" href="" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);">收藏<strong class="xi1" id="number_favorite" {if !$_G[forum][favtimes]} style="display:none;"{/if}>(<span id="number_favorite_num">$_G[forum][favtimes]</span>)</strong></a>
</div>

<div class="forumListTab cfix">
	<ul>
		<li>
			<a href="{{url('wap/forum_list/'.$mod['id'])}}" class="@if($filter == '')cur @endif">全部</a>
		</li>
		<li>
			<a href="{{url('wap/forum_list/'.$mod['id'].'?filter=updated_at')}}" class="@if($filter == 'updated_at')cur @endif">最新</a>
		</li>
		<li>
			<a href="{{url('wap/forum_list/'.$mod['id']).'?filter=views'}}" class="@if($filter == 'views')cur @endif">热门</a>
		</li>
		<li>
			<a href="{{url('wap/forum_list/'.$mod['id']).'?filter=is_top'}}" class="@if($filter == 'is_top')cur @endif">精华</a>
		</li>
	</ul>
</div>

<div class="threadlist">
    @if(!empty($data))
        @include('wap/forum/list_img') 
    @else
        <ul>
            <li class="noData">暂无内容</li>
        </ul>
    @endif
</div>
<script>
   $(function(){
      $(".btFixed a").removeClass("cur");
   $(".btForum").addClass("cur");  
   })
    
</script>
<div class="pullrefresh" style="display:none;"></div>
   @include('layouts/footer2') 
@endsection