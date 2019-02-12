@extends('layouts.base')
@section('content')
<link rel="stylesheet" href="{{asset('resources/admin/css/ch-ui.admin.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/adminPublic.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/category.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/indexList.css')}}">
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <button class="layui-btn addCate" data-pid="0"><i class="fa fa-plus"></i>添加模块</button>
<!--                     <button class="layui-btn layui-btn-normal " href="{{ url('admin/forumcategory/create?type=secondclass') }}"><i class="fa fa-plus"></i>添加二级类</button> -->
                    <em>{{ session('message') }}</em>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
      
      <div class="result_wrap">
    <div class="result_content">
        <ul class="list_tab make">
            <li class="title border_buttom">
                <span class="first">排序</span>
                <!--<span class="two"></span>-->
                <span class="category-third ">缩略图/模块名称</span>
                <span class="two">模块标识</span>
                <span class="four">模块等级</span>
                <span class="two">状态</span>
                <span class="category-five">操作</span>
            </li>
            @if(count($CategoryList) > 0)
                @foreach($CategoryList as $k => $v)
                    <li class="saith_bg">
                        <span class="first">{{  $v['descid'] }}</span>
                        
                        <span class="category-third">@if($v['level']==1)
                        <img src="{{asset($v['img'])}}" style="height:36px">
                        @endif &nbsp;&nbsp;&nbsp;&nbsp;{{ $v['showName']  }}</span>
                        <span class="two">{{ $v['new_sign']  }}</span>
                         @if($v['level']==0)
                        <span class="four">父级</span>
                        @else
                        <span class="four">子级</span>
                       @endif
                        <span class="two">@if($v['is_display']==0)
                        <button class="layui-btn layui-btn-danger layui-btn-xs">隐藏</button>
                        @else
                        <button class="layui-btn layui-btn-normal layui-btn-xs">显示</button>
                        @endif </span>
                    <span class="category-five">
                    @if($v['level']==0)
                    <button class="layui-btn layui-btn-xs editCate"  data-id="{{$v['id']}}">修改模块</button>
                    <button class="layui-btn layui-btn-danger layui-btn-xs"  onclick="delClass({{$v['id']}},{{$v['level']}})">删除模块</button>
                    <button class="layui-btn layui-btn-normal layui-btn-xs addCate" data-pid="{{$v['id'] }}" data-level="{{$v['level'] }}">添加模块</button>
                    @elseif($v['level']==1)
                    <button class="layui-btn layui-btn-xs editCate"  data-id="{{$v['id']}}">修改模块</button>
                    <button class="layui-btn layui-btn-danger layui-btn-xs"  onclick="delClass({{$v['id']}},{{$v['level']}})">删除模块</button>
                    <button class="layui-btn layui-btn-danger layui-btn-xs addCate" data-pid="{{$v['id'] }}" data-level="{{$v['level']}}" style="background:#FF5722">添加主题</button>
                    @else
                     <button class="layui-btn layui-btn-xs editCate"  data-id="{{$v['id']}}">修改主题</button>   
                    <button class="layui-btn layui-btn-danger layui-btn-xs"  onclick="delClass({{$v['id']}},{{$v['level']}})">删除主题</button>
                    @endif
                    </span>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- <div class="page_list"> -->
<!--     {{--<div>{!! $forum->links() !!}</div>--}} -->
<!-- </div> -->
<!--列表结束-->

<script>
layui.use(['table','form','laydate'], function () {
    var table = layui.table,form=layui.form,laydate=layui.laydate;
	$(".editCate").click(function(){
            var id = $(this).attr("data-id");
            layer.open({
        	title: "编辑模块",
                type: 2,
                area: ['80%', '60%'],
                maxmin: true,
                content: "/admin/forum_mod_edit?id="+ id,
            });
	});

	$(".addCate").click(function(){
            var level = $(this).attr("data-level");
            var pid = $(this).attr("data-pid");
            layer.open({
                title: "添加模块",
                type: 2,
                area: ['80%', '60%'],
                maxmin: true,
                content: "/admin/forum_mod_add?level="+ level+"&pid="+pid,
            });
	});
})

    //删除资讯
    function delClass(id, level){
        if(level==2){
            mo = "主题";
        }else{
            mo = "模块";
        }
        layer.confirm('您确定要删除这个'+mo+'吗？', {
            btn: ['确定', '取消'] //按钮
        }, function(){
            $.post("{{url('admin/forum_mod_del/')}}/" + id, {
                '_method': 'delete',
                'level': level,
                '_token': "{{csrf_token()}}"
            }, function(data){
                if(data.status == 0){
                    layer.msg(data.msg, {icon: 6, time: 1500});
                    location = '/admin/forum_mod';
                }else{
                    layer.msg(data.msg, {icon: 5, time: 1500});
                }
            });
        });
    }
</script>
    </div>
  </div>

@endsection


