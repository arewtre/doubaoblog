@extends('default.layouts.adminPublic')
@section('title', '配置管理列表')

@section('content')
<!--导航开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin')}}">首页</a> &raquo; 配置管理
</div>
<!--导航结束-->

<!--列表开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置列表</h3>
            @include('flash::message')
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ route('webconfig.makeadd') }}"><i class="fa fa-plus"></i>添加配置</a>
                <a href="{{ route('webconfig.makelist') }}"><i class="fa fa-recycle"></i>配置列表</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab make">
                <tr>
                    <th width="10%">标签符号</th>
                    <th width="10%">标签中文名</th>
                    <th width="25%">标签值</th>
                    <th width="15%">所属分类</th>
                    <th width="15%">标签解释</th>
                    <th width="10%">标签类型</th>
                    <th width="15%">操作</th>
                </tr>
                @if(count($config) > 0)
                    @foreach($config as $k => $v)
                        @if($v->noSame == 1)
                            <tr><td colspan="7" style="text-align: left;"> ##@if(!empty($catetroyArray[$v->categroy])){{ $catetroyArray[$v->categroy] }}@endif##</td></tr>
                        @endif
                        <tr>
                            <td>{{ $v->sign }}</td>
                            <td>{{ $v->keyname }}</td>
                            <td>{{ str_limit($v->keyvalue,30) }}</td>
                            <td>@if(!empty($catetroyArray[$v->categroy])){{ $catetroyArray[$v->categroy] }}@endif</td>
                            <td>{{ $v->tip }}</td>
                            <td>{{ $v->type }}</td>
                            <td>
                                <a href="{{ route('webconfig.makemodify',['id'=>$v->id]) }}">修改</a>
                                <a  onclick="delUser({{$v->id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">暂无类别</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</form>
<!--列表结束-->

<script>
    function delUser(id) {
        layer.confirm('您确定要删除这个配置吗？', {
            btn: ['确定', '取消'] //按钮
        }, function () {

            location.href = "/admin/signdelete?id="+id;
        }, function () {

        });
    }
</script>
@endsection