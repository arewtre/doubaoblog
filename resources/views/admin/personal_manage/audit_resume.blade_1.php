@extends('default.layouts.adminPublic')
@section('title', '个人未审核简历')
@section('headcss')
    @parent
        <link rel="stylesheet" href="{{asset('/default/css/admin/indexList.css')}}">
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
                <form name="Formso" id="Formso" action="{{url('admin/audit_resume')}}" method="post">
                    {{csrf_field()}}
                    <span>关键字：</span>
                    <span><input name="keyword" class="keyword" id="keyword" placeholder="请输入姓名、手机号码、简历id或求职意向" type="text"></span>
                    <select name="type" id="type">
                        <option value="">不限</option>
                        <option value="0">未审核(处理)简历</option>
                        <option value="1">完全公开简历</option>
                        <option value="2">不公开简历</option>
                        <option value="3">完全保密简历</option>
                        <option value="4">已删除简历</option>
                        <option value="5">驳回简历</option>
                    </select>
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
                    <dd class="review1">姓名</dd>
                    <dd class="review2">出生日期</dd>
                    <dd class="review3">最高学历</dd>
                    <dd class="review4">寻求职位</dd>
                    <dd class="review5">手机号码</dd>
                    <dd class="review6">添加时间</dd>
                    <dd class="review7">操作</dd>
                </dl>
                @if($resume->count() > 0 )
                    @foreach($resume as $v)
                        <dl id="list{{$v->id}}">
                            <dt><input name="selected_id[]" type="checkbox" value="{{$v->id}}" /></dt>
                            <dd class="review1">
                                <a href="{{url('resume_'.idEncryption($v->id).'.html')}}" target="_blank">{{$v->name}}</a>
                                @if(!empty($v->collectionResumeID))<strong>✔</strong>@endif
                            </dd>
                            <dd class="review2">{{$v->birthday}}</dd>
                            <dd class="review3">{{$v->education}}</dd>
                            <dd class="review4">{{str_limit($v->intentionjobs,32)}}</dd>
                            <dd class="review5">{{$v->mobile}}</dd>
                            <dd class="review6">{{$v->regtime}}</dd>
                            <dd class="review7">
                                <span><a href="{{url('admin/personal_welcome/'.$v->uid)}}" target="_blank">账户中心</a></span>
                                <span><a href="{{url('admin/job_mod_two/'.$v->uid)}}">注册信息</a></span>
                                <span><a href="{{url('admin/quick_resume_manage/'.$v->id)}}" target="_blank">编辑简历</a></span>
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
                    <dd class="review6"><a onclick="showconfirm('{{url('admin/approved')}}','2')">通过审核</a></dd>
                    <dd class="review6"><a onclick="showconfirm('{{url('admin/batch_del_resume')}}','1')">删除简历</a></dd>
                    <dd class="review6"><a onclick="showconfirm('{{url('admin/dismissed_resume')}}','5')">驳回简历</a></dd>
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
@endsection