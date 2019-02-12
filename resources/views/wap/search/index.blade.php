@extends('layouts.wap')
@section('content')
<header class="header">
    <a class="goBack fl" title="" href="{{url('/')}}">返回</a>
    <h1>搜索</h1>
</header>
<div class="forumListTab cfix">
    <ul>
        <li style="width:50%" @if($type==1) class="a" @endif ><a href="{{url('wap/search?type=1')}}">搜索文章</a></li>
        <li style="width:50%" @if($type==2) class="a" @endif ><a href="{{url('wap/search?type=2')}}">搜索帖子</a></li>
    </ul>
</div>
<div class="search_Con mt20">
    <form id="searchform" class="searchform" method="post" autocomplete="off" action="{{url('wap/search')}}">
        <input type="hidden" name="type" value="{{$type}}">
        {{csrf_field()}} 
        <div class="search">
            <input value="" autocomplete="off" class="inp" name="keywords" id="scform_srchtxt" placeholder="请输入关键字">
            <div class="scbar_btn_td">
                <input type="submit" value="搜索" class="btn1" id="scform_submit">
            </div>
        </div>
    </form>
    <div id="scbar_hot" class="cfix">
        <span>热搜: </span>
        @foreach($keywords as $v)
            <a href="{{url('wap/search?m=1&type='.$type."&keywords=".$v->keywords)}}" class="xi2" sc="1">{{$v->keywords}}</a>
        @endforeach
    </div>
</div>
<script>
jQuery("#nv li").removeClass("a");
jQuery("#mn_N6e20").addClass("a");

layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,form = layui.form
  ,layer = layui.layer;


  
});

</script>
@endsection