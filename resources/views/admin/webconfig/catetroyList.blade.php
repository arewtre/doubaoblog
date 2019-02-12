@extends('default.layouts.adminPublic')
@section('title', '配置类别管理列表')

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
            <h3>配置类别列表</h3>

        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ route('webconfig.webCatetroyAdd') }}"><i class="fa fa-plus"></i>添加配置类别</a>
                <a href="{{ route('webconfig.webCatetroyList') }}"><i class="fa fa-recycle"></i>配置类别列表</a>
                <em style="color: green;">{{ session("message") }}</em>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab make">
                <tr>
                    <th width="10%">序号</th>
                    <th width="75%">类别名称</th>
                    <th width="15%">操作</th>
                </tr>
                @if(count($WebConfigCatetroy) > 0)
                    @foreach($WebConfigCatetroy as $v)
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->describe }}</td>
                            <td>
                                <a href="{{ route('webconfig.catetroyEdit',['id'=>$v->id]) }}">修改</a>
                                <a  onclick="delUser({{$v->id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</form>
<!--列表结束-->

<script>
    function delUser(id) {
        layer.confirm('您确定要删除这个配置类别吗？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            location.href = "/admin/catetroydestroy?id="+id;
        }, function () {

        });
    }
</script>
@endsection