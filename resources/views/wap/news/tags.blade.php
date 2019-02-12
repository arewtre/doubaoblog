@extends('layouts.wap')
@section('content')
<style>
    #LAY_demo1{
        width:100%;
        height:100%;
        overflow: auto;
    }
    .subNv .cur{
        font-weight:600;
        font-size:16px;
        color:#FF7F84;
    }
</style>
<header class="header">
	<a class="goBack fl" href="{{url('wap/')}}">返回</a>
	<!--{if $cat[others]}--><a class="topSort fr" href="#subMenu">分类</a><!--{/if}-->
	<h1>资讯/博客</h1>
</header>
<div class="container">
    <div class="search">
        <form method="post" action="{{url('wap/tags')}}">
            {{csrf_field()}} 
            <input type="text" name="keywords" class="inp" placeholder="输入要搜索的标签">
            <div class="scbar_btn_td"><button type="submit" class="btn1"><em>搜索</em></button></div>
        </form>
    </div>
    <div class="taglist pb cfix">
        @foreach($data as $v)
            <a href="{{url('wap/news?tags='.$v->tagname)}}" title="{{$v->tagname}}">{{$v->tagname}}</a>
        @endforeach
    </div>
</div>
<script>
//jQuery("#nv li").removeClass("a");
//jQuery("#mn_N6e26").addClass("a");

layui.use(['laypage', 'layer','form','flow'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,laypage = layui.laypage
  ,flow = layui.flow;

});


</script>
   @include('layouts/footer') 
@endsection