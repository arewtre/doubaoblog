@extends('layouts.wap')
@section('content')
<header class="header">
    <a href="/" class="goBack fl">返回</a>
    <h1>豆宝影集</h1>
</header>
<div class="forumListHeader cfix">
	<div class="fl_icon fl"><img src="http://linxinran.cn/public/uploads/images/201806260951th_5b319c2e5d229.png" alt="豆宝影集" /></div>
	<h3>豆宝影集</h3>
	<p>
            <span>今日: {{$todayf}}</span>
            <span>相册: {{$xcnum}}</span>
            <span title="">照片: {{$counts}}</span>
	</p>
	<a class="fa_fav" href="" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);">收藏<strong class="xi1" id="number_favorite" {if !$_G[forum][favtimes]} style="display:none;"{/if}>(<span id="number_favorite_num">$_G[forum][favtimes]</span>)</strong></a>
</div>

<div class="forumListTab cfix">
    <ul>
        <li>
                <a href="{{url('wap/imageXc')}}" class="@if($filter == '')cur @endif">全部</a>
        </li>
        <li>
                <a href="{{url('wap/imageXc?filter=updated_at')}}" class="@if($filter == 'updated_at')cur @endif">最新</a>
        </li>
        <li>
                <a href="{{url('wap/imageXc?filter=xc_view')}}" class="@if($filter == 'xc_view')cur @endif">热门</a>
        </li>
        <li>
                <a href="{{url('wap/imageXc?filter=is_top')}}" class="@if($filter == 'is_top')cur @endif">精华</a>
        </li>
    </ul>
</div>
<div class="threadlist">
<div class="xr_waterfall cfix">
<script src="{{asset('resources/wap/js/jquery.masonry.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    var container = $('#waterfall');
        container.imagesLoaded(function() {
            container.masonry({
            itemSelector: '.imgItem',
            isResizableL: true,
        });
    });
});
</script>
<div id="waterfall" class="waterfall cfix masonry" style="position: relative; height: 1540px;">
    @foreach($xc as $v)
    <div class="imgItem masonry-brick" style="position: absolute; top: 0px; left: 0px;">
        <a href="{{url('wap/imageList/'.$v->xc_id)}}">
            <div class="img">
                <img src="{{asset($v->fengm)}}?imageView2/0/w/350" alt="" width="270" zsrc="" style="display: inline; visibility: visible;">
            </div>
            <h3>{{$v->xc_name}}</h3>
            <div class="desc cfix">
                {{$v->nickname}}<span class="fr">
                    <span class="views icon">{{$v->xc_view}}</span>
                    <span class="replies icon">{{$v->xc_rep}}</span>
                </span>
            </div>
        </a>
    </div>
@endforeach
</div>
</div>
    </div>
   @include('layouts/footer') 
@endsection