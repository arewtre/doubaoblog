@extends('default.layouts.adminPublic')
@section('title', '个人未审核简历')
@section('headcss')
    @parent
        <link rel="stylesheet" href="{{asset('/default/css/admin/indexList.css')}}">
        <link rel="stylesheet" href="{{asset('/vendor/jedate/skin/jedate.css')}}">
    @endsection
@section('content')
        <!--导航开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/audit_resume')}}">首页</a> &raquo; 简历管理
</div>
<!--导航结束-->
<!--结果集标题与导航组件 开始-->

<div class="con">
    <div class="conMain">
        <div class="result_wrap">
            <div class="search">
                <form name="Formso" id="Formso" action="{{url('admin/resume_admin_refresh')}}" method="get">
                    {{csrf_field()}}
                    <span>关键字：</span>
                    <span><input name="keyword" class="keyword" id="keyword" placeholder="请输入姓名或者手机号码" type="text"></span>
                    <select name="type" id="type">
                        <option value="">不限</option>
                        <option value="0">未审核简历</option>
                        <option value="1">完全公开简历</option>
                        <option value="2">不公开简历</option>
                        <option value="3">完全保密简历</option>
                        <option value="4">已删除简历</option>
                    </select>
                    <span>&nbsp;&nbsp;登陆时间：</span>
                    <input class="wicon" name="start_time" style="width:90px;text-align: center;float: left" id="start_time"
                           value="{{$start_time}}" type="text" readonly>
                    <span style="float: left">~&nbsp;</span>
                    <input class="wicon" name="end_time" style="width:90px;text-align: center;float: left" id="end_time"
                           value="{{$end_time}}" type="text" readonly>
                    <span><input name="submit" class="skeyword" value="搜索" type="submit"></span>
                </form>
            </div>
            <div class="message"><p>目前共查找到<strong>{{$resume->total()}}</strong>份简历！且每页显示条数为{{$resume->perPage()}}条。</p></div>
        </div>
        <div class="manage">
            @include('flash::message')
        </div>
        <div class="conInfo">
            <form name="thisForm" id="thisForm" action="" method="post">
            {{csrf_field()}}
            <div class="conList" id="conList">
                <dl class="one">
                    <dt><input name="selectall" type="checkbox" value="1" onclick="CheckAll(this)" /></dt>
                    <dd class="p1">姓名</dd>
                    <dd class="p2">登陆时间</dd>
                    <dd class="p3">注册时间</dd>
                    <dd class="p4">刷新时间</dd>
                    <dd class="p5">手机号码</dd>
                    <dd class="p6">寻求职位</dd>
                    <dd class="p7">操作</dd>
                </dl>
                @if($resume->count() > 0 )
                    @foreach($resume as $v)
                        <dl id="list{{$v->id}}">
                            <dt><input name="selected_id[]" type="checkbox" value="{{$v->id}}" /></dt>
                            <dd class="p1"><a href="{{url('resume_'.idEncryption($v->id).'.html')}}" target="_blank">{{$v->name}}</a></dd>
                            <dd class="p2">{{$v->last_login_time}}</dd>
                            <dd class="p3">{{$v->regtime}}</dd>
                            <dd class="p4">{{$v->updatetime}}</dd>
                            <dd class="p5">{{$v->mobile}}</dd>
                            <dd class="p6">{{$v->intentionjobs}}</dd>
                            <dd class="p7">
                                <span><a href="{{url('admin/personal_welcome/'.$v->uid)}}" target="_blank">账户中心</a></span>
                                <span><a href="{{url('admin/job_mod_two/'.$v->uid)}}">注册信息</a></span>
                                <span class="del"><a>删除</a></span>
                            </dd>
                        </dl>
                    @endforeach
                @else
                    <div class="nullcon">对不起！没有符合条件的记录！</div>
                @endif
                <dl class="last">
                    <dt>
                        <input name="selectall" id="selectall" type="checkbox" value="1" onclick="CheckAll(this)" />
                        <label for="selectall">全选</label>
                    </dt>
                    <dd class="p6"><a onclick="showconfirm('{{url('admin/adminresumerefresh')}}','3')">刷新简历</a></dd>
                </dl>
            </div>
            </form>
            <div class="page_list" style="width: 100%; float: left; margin-top:15px;">
                {!! $resume->appends($appends)->links() !!}
            </div>
        </div>

        <div class="stopper" style="margin-top:10px; border-top: 1px solid #e5e5e5"></div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->
@endsection

@section('footerjs')
    @parent
    <script>
        $(function(){
            $("#type").val('{{$type}}');
            //删除当前
            @if($resume->count() > 0 )
                @foreach($resume as $v)
                    $('#conList').find("#list" + '{{$v->id}}').find('.del a').click(function(){
                        layer.confirm('您确定要删除这个简历吗？', {
                            btn: ['确定', '取消'] //按钮
                        }, function () {
                            $.post("/admin/del_resume",{'id':'{{$v->id}}','_token':"{{csrf_token()}}"},function (data) {
                                if(data.status==0){
                                    $('#conList').find("#list" + '{{$v->id}}').remove();
                                    layer.msg(data.msg, {icon: 6,time:1500});
                                }else{
                                    layer.msg(data.msg, {icon: 5,time:1500});
                                }
                            });
                        });
                    });
                @endforeach
            @endif
        });
    </script>
    <script type="text/javascript" src="{{asset('/default/js/admin/resumeList.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/jedate/jquery.jedate.min.js')}}"></script>
    <script>
        $.jeDate('#start_time', {
            format: 'YYYY-MM-DD',
            festival: true
        });
        $.jeDate('#end_time', {
            format: 'YYYY-MM-DD',
            festival: true,
        });
    </script>
@endsection