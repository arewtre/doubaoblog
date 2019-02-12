@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_forumdisplay.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/pubu/default.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/pubu/component.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/tupianchakan/normalize.css')}}" /><!--CSS RESET-->
<link href="{{asset('resources/home/css/tupianchakan/lightgallery.css')}}" rel="stylesheet">
<style>
    #lightgallery img{
        min-width:350px
    }
    #toptb.siteTopBar {
        background: #444;
        color: #8c8c8c;
        border-bottom: none;
        height: 38px;
        line-height:38px;
        font-size: 13px;
        padding: 0px 0;
    }
</style>
<div id="pt" class="bm cl">
<div class="z">
<a href="" class="nvhm" title="首页">首页</a>
<em>&#187;</em>
<a href="{{url("imageXc")}}">图片瀑布流</a></div>
<span class="y">
    <a href="" target="_blank" title="RSS">订阅</a> 
</span>
</div>        
<div class="wp">
    <ul class="grid effect-8 list-unstyled row" id="lightgallery">    				
        @if(count($images)>0)
            @foreach($images as $v)
                <li data-src="{{$v->image_url}}">
                 <a href="">   
                    <img src="{{$v->image_url}}?imageView2/0/w/350">
                 </a>
                </li>
            @endforeach  
        @endif
    </ul>
</div>
<script src="{{asset('resources/home/js/jquery-1.11.0.min.js')}}"></script>
<script src="{{asset('resources/home/js/pubu/modernizr.custom.js')}}"></script>
<script src="{{asset('resources/home/js/pubu/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('resources/home/js/pubu/imagesloaded.js')}}"></script>
<script src="{{asset('resources/home/js/pubu/classie.js')}}"></script>
<script src="{{asset('resources/home/js/pubu/AnimOnScroll.js')}}"></script>
<script src="{{asset('resources/home/js/tupianchakan/lightgallery-all.min.js')}}"></script>
<script>
    //$(function(){
        $('#lightgallery').lightGallery();
    //});   
    new AnimOnScroll( document.getElementById( 'lightgallery' ), {
            minDuration : 0.4,
            maxDuration : 0.7,
            viewportFactor : 0.2
    } );
        
        
</script>
  <script>
  jQuery("#nv li").removeClass("a");
  jQuery("#mn_Nb67d").addClass("a");
  layui.use(['laypage', 'layer'], function(){
    var laypage = layui.laypage
    ,layer = layui.layer;
  });
  </script>
@endsection