@extends('default.layouts.adminPublic')
@section('title', '添加配置列表')

@section('content')
        <!--导航开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin')}}">首页</a> &raquo; 增加配置类别
</div>
<!--导航结束-->
<!--导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>增加配置类别</h3>
        @include('flash::message')
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{ route('webconfig.webCatetroyAdd') }}"><i class="fa fa-plus"></i>添加配置类别</a>
            <a href="{{ route('webconfig.webCatetroyList') }}"><i class="fa fa-recycle"></i>配置类别列表</a>
        </div>
    </div>
</div>
<!--导航组件 结束-->

<div class="result_wrap">
    <form action="{{ route('webconfig.catetroySave') }}" method="post" name="configForm" id="configForm" onsubmit="return checkForm('#configForm')">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th class="makelefttd"><i class="require"></i> 类别名称：</th>
                <td>
                    <input type="text" class="lg" name="describe" placeholder="网站配置类别中文名称" value="{{ old('describe') }}">{{ $errors->first('describe') }}
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="hidden" style="width:190px" class="lg" name="make" value="add">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">

                </td>
            </tr>
            </tbody>
        </table>

    </form>
</div>
@endsection
@section('footerjs')
    @parent
@show


