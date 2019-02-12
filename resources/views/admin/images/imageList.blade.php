@extends('layouts.base')
@section('content')
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/style/template.css')}}" media="all">
  <link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/pubu/default.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/pubu/component.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/tupianchakan/normalize.css')}}" /><!--CSS RESET-->
<link href="{{asset('resources/home/css/tupianchakan/lightgallery.css')}}" rel="stylesheet">
<style>
    #lightgallery img{
        min-width:150px
    }
</style>
<div class="layui-fluid layadmin-maillist-fluid">
    <!--<div class="layui-card">-->
      <form class="layui-form layui-form-pane" action="">
        <div class="demoTable">
            <blockquote class="layui-elem-quote" style="background:white">
                <div class="layui-inline">
                    <a href="javascript:;" class="img_add"><span class="layui-btn">添加照片</span></a>
                    <a href="{{url('admin/imageXc_list')}}"><span class="layui-btn">返回相册列表</span></a>
                </div>
            </blockquote>
        </div>
    </form>
    <div class="layui-row layui-col-space15">
        <ul class="grid effect-8 list-unstyled row" id="lightgallery">    				
            @if(count($images)>0)
                @foreach($images as $v)
                    <li data-src="{{$v->image_url}}">
                     <a href="">   
                        <img src="{{$v->image_url}}?imageView2/0/w/150">
                     </a>
                    </li>
                @endforeach  
            @endif
        </ul>
    </div>        
  </div>
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
  
  layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,form = layui.form
  ,layer = layui.layer;
  
  $('.img_add').on('click', function () {
    layer.open({
        type: 2,
        area: ['80%', '80%'],
        maxmin: true,
        content: "{{url('admin/images_add')}}?xc_id="+"{{$id}}",
    });
});


$('.img_edit').on('click', function () {
    var id = $(this).attr("data-id");
        layer.open({
        type: 2,
        area: ['80%', '80%'],
        maxmin: true,
        content: "{{url('admin/imageXc_edit')}}?id="+id,
    });
});
$('.del').on('click', function () {
    var _this = $(this);
        layer.confirm('您确定要删除该相册么', function (index) {
        $.ajax({
            url: "{{url('admin/imageXc_del')}}",
            type: "POST",
            data: { id: _this.attr("data-id"),'_token':"{{csrf_token()}}"},
            dataType: "json",
            success: function (data) {
                if (data.code == 1) {
                    _this.parent().parent().parent().remove();
                    layer.close(index);
                    layer.msg(data.msg, { icon: 6 });
                } else {
                    layer.msg(data.msg, { icon: 5 });
                }
            }

        });
    });
});
  
});
  </script>
@endsection


