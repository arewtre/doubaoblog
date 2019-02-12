@extends('layouts.base')
@section('content')
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/style/template.css?ver=1.0')}}" media="all">
<div class="layui-fluid layadmin-maillist-fluid">
    <!--<div class="layui-card">-->
      <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
            	<input class="layui-input" name="keyword" id="demoReload" placeholder="请输入相册关键字" autocomplete="off">
        	</div>
	        <div class="layui-inline">
            <select name="pid">
	        <option value="">请选择分类</option>
	        @foreach($CategoryList as $vo)
                    <option value="{{$vo['pid']}}" {{$vo['pid'] == 0?'disabled':''}}>{{$vo['showName']}}</option>
                @endforeach
	        </select>
	        </div>
        	<div class="layui-inline">
                    <button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
                    <button type="reset" class="layui-btn">重置</button>
                    <a href="javascript:;" class="img_add"><span class="layui-btn">添加相册</span></a>
        	</div>
        	</blockquote>
        </div>
    </form>
        <div class="layui-row layui-col-space15">
            @if(count($xc)>0)
            @foreach($xc as $v)
            <div class="layui-col-md4 layui-col-sm6">
                <div class="layadmin-contact-box"> 
                    <div class="layui-col-md4 layui-col-sm6">
                      <a href="{{url('admin/imageList/'.$v->xc_id)}}">
                        <div class="layadmin-text-center">
                          <img src="{{asset($v->fengm)}}">
                          <div class="layadmin-maillist-img layadmin-font-blod">{{$v->title}}</div>
                        </div>
                      </a>
                    </div>
                  <div class="layui-col-md8 layadmin-padding-left20 layui-col-sm6">
                    <a href="javascript:;">
                      <h3 class="layadmin-title">
                        <strong>{{$v->xc_name}}</strong>
                      </h3>
                      <p class="layadmin-textimg">
                        <!--<i class="layui-icon layui-icon-time"></i>-->
                        <i class="layui-icon layui-icon-time" style="font-size: 30px; color: #1E9FFF;"></i>
                        {{$v->created_at}}
                      </p>
                    </a>
                    <div class="layadmin-address">
                      <a href="javascript:;">
                        <!--<strong></strong>-->
                        <br>
                        {{$v->xc_desc}}
                      </a>
                    </div>
                      <a href="{{url('admin/imageList/'.$v->xc_id)}}"><span class="layui-btn view"><i class="fa fa-eye"></i>查看</span></a>
                    <span class="layui-btn img_edit" data-id="{{$v->xc_id}}"><i class="fa fa-pen"></i>编辑</span>
                    <span class="layui-btn del" data-id="{{$v->xc_id}}"><i class="fa fa-pen"></i>删除</span>
                  </div>
                </div>
            </div>
            @endforeach
            @endif
            
        </div>
    <div id="page"></div>
    <!--</div>-->
  </div>
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
        content: "{{url('admin/imageXc_add')}}",
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
//完整功能
  laypage.render({
    elem: 'page'
    ,count: {{$count}}
    ,skip: true
    ,limit:{{$limit}}
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      if(!first){   
            window.location.href="/admin/imageXc_list?page="+obj.curr+"&cid="+"{{$cid}}";
        }  
    }
  });
  
});
  </script>
@endsection


