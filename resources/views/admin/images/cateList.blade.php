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
                    <button class="layui-btn addCate" data-pid="0"><i class="fa fa-plus"></i>添加分类</button>
<!--                     <button class="layui-btn layui-btn-normal " href="{{ url('admin/newscategory/create?type=secondclass') }}"><i class="fa fa-plus"></i>添加二级类</button> -->
                    <!--<em>{{ session('message') }}</em>-->
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
      
      <div class="result_wrap">
    <div class="result_content">
        <ul class="list_tab make">
            <li class="title border_buttom">
                <span class="first">排序</span>
                <span class="category-third ">分类名称</span>
                <span class="third">分类标识</span>
                <span class="four">分类等级</span>
                <span class="five">状态</span>
                <span class="category-six">操作</span>
            </li>
            @if(count($CategoryList) > 0)
                @foreach($CategoryList as $k => $v)
                    <li class="saith_bg">
                        <span class="first">{{ $v['descid'] }}</span>
                        <span class="category-third">{{ $v['showName']}}</span>
                        <span class="third">{{ $v['new_sign']  }}</span>
                        <span class="four">@if($v['level']==0)父级 @else 子级 @endif</span>
                        <span class="five">
                           @if($v['is_display']==1)
                            <button class="layui-btn layui-btn-normal layui-btn-xs">显示</button>
                            @else
                            <button class="layui-btn layui-btn-danger layui-btn-xs">隐藏</button>
                            @endif 
                            
                        </span>
                    <span class="category-six">
                    <button class="layui-btn layui-btn-xs editCate"  data-id="{{$v['id']}}">修改分类</button>
                    <button class="layui-btn layui-btn-danger layui-btn-xs"  onclick="delClass(this,'{{$v['id']}}','{{$v['level']}}')">删除分类</button>
                    @if($v['level']==0)
                    <button class="layui-btn layui-btn-normal layui-btn-xs addCate" data-pid="{{$v['id'] }}">添加分类</button>
                    @endif
                    </span>
                    </li>
                    
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- <div class="page_list"> -->
<!--     {{--<div>{!! $news->links() !!}</div>--}} -->
<!-- </div> -->
<!--列表结束-->

<script>
layui.use(['table','form','laydate'], function () {
    var table = layui.table,form=layui.form,laydate=layui.laydate;
	$(".editCate").click(function(){
            var id = $(this).attr("data-id");
            layer.open({
        	title: "编辑分类",
                type: 2,
                area: ['80%', '60%'],
                maxmin: true,
                content: "/admin/imageXc_cate_edit?id="+ id,
            });
	});


	$(".addCate").click(function(){
            var pid = $(this).attr("data-pid");
            layer.open({
                title: "添加分类",
                type: 2,
                area: ['80%', '60%'],
                maxmin: true,
                content: "/admin/imageXc_cate_add?pid="+ pid,
            });
	});
})

    //删除资讯
    function delClass(obj,id, level){
        layer.confirm('您确定要删除这个分类吗？', {
            btn: ['确定', '取消'] //按钮
        }, function(){
            $.post("{{url('admin/imageXc_cate_del')}}", {
                '_method': 'delete',
                'level': level,
                'id':id,
                '_token': "{{csrf_token()}}"
            }, function(data){
                if(data.status == 1){
                    layer.msg(data.msg, {icon: 6, time: 1500});
                    $(obj).parent().parent().remove();
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


