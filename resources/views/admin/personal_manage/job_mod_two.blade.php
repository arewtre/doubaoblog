@extends('default.layouts.adminPublic')
@section('title', '修改注册信息')
@section('headcss')
    @parent
    <link rel="stylesheet" href="{{asset('/default/css/admin/indexList.css')}}">
    @endsection
@section('content')
        <!--导航开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/audit_resume')}}">首页</a> &raquo; 个人管理
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
                    <span><input name="keyword" class="keyword" id="keyword" placeholder="请输入姓名或者手机号码" type="text"></span>
                    <select name="type" id="type">
                        <option value="">不限</option>
                        <option value="0">未审核简历</option>
                        <option value="1">完全公开简历</option>
                        <option value="2">不公开简历</option>
                        <option value="3">完全保密简历</option>
                        <option value="4">已删除简历</option>
                    </select>
                    <span><input name="submit" class="skeyword" value="搜索" type="submit"></span>
                </form>
            </div>
            <div class="message"><p>注册用户信息修改.</p></div>
        </div>

        <div class="conInfo">
            <div class="manage" style="padding: 0; margin-bottom: 10px;">
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="conAddList">
                <form action="{{url('admin/job_store_two')}}" method="post" name="resumeForm" id="resumeForm"  onsubmit="return checkForm('#resumeForm')">
                    <input type="hidden" name="uid" value="{{$user->uid}}">
                    {{csrf_field()}}
                    <dl>
                        <dt><i class="require">*</i>用户名：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->username}}" name="username" id="username"></dd>
                    </dl>
                    <dl>
                        <dt><i class="require">*</i>密码：</dt>
                        <dd><input type="text" class="inpText" name="password" value="{{$user->password}}" id="password"></dd>
                    </dl>
                    <dl>
                        <dt>手机号码：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->mobile}}" name="mobile" id="mobile"></dd>
                    </dl>
                    <dl>
                        <dt>邮箱地址：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->email}}" name="email" id="email"></dd>
                    </dl>
                    <dl>
                        <dt>绑定邮箱：</dt>
                        <dd>
                            <input name="email_id" id="emailbinded"  style="width: 16px; height: 16px; margin: 0px;" type="radio"   value="1">
                            <label for="emailbinded">已绑定</label>
                            <input name="email_id"  id="emailunbound" style="width: 16px; height: 16px; margin: 0px;" type="radio" value="0">
                            <label for="emailunbound">未绑定</label>
                        </dd>
                        {{--<dd><input type="text" class="inpText" name="email_id" value="{{$user->email_id}}" id="email_id"></dd>--}}
                    </dl>
                    <dl>
                        <dt>手机绑定：</dt>
                        <dd>
                            <input name="mobile_id" id="mobilebinded"  style="width: 16px; height: 16px; margin: 0px;" type="radio" value="1">
                            <label for="mobilebinded">已绑定</label>
                            <input name="mobile_id"  id="mobileunbound" style="width: 16px; height: 16px; margin: 0px; "  type="radio" value="0">
                            <label for="mobileunbound">未绑定</label>
                        </dd>
                    </dl>
                    <dl>
                        <dt>QQ绑定：</dt>
                        <dd><input type="text" class="inpText" name="qqopenid" value="{{$user->qqopenid}}" id="qqopenid"></dd>
                    </dl>
                    <dl>
                        <dt>微信绑定：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->wechatopenid}}" name="wechatopenid" id="wechatopenid"></dd>
                    </dl>
                    <dl>
                        <dt>微信公众平台：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->wechatmpopenid}}" name="wechatmpopenid" id="wechatmpopenid"></dd>
                    </dl>
                    <dl>
                        <dt>微信unionid：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->wechatunionid}}" name="wechatunionid" id="wechatunionid"></dd>
                    </dl>
                    <dl>
                        <dt>IOS绑定：</dt>
                        <dd><input type="text" class="inpText"  value="{{$user->device_token}}" name="device_token" id="device_token"></dd>
                    </dl>
                    <dl>
                        <dt>注册时间：</dt>
                        <dd>{{$user->regtime}}</dd>
                    </dl>
                    <dl>
                        <dt></dt>
                        <dd>
                            <input type="submit" class="sub" value="修改">
                            <input type="button" class="sub but" onclick="history.go(-1)" value="返回">
                        </dd>
                    </dl>
                </form>
            </div>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->
@endsection

@section('footerjs')
    @parent
    <script>
        $(function(){
            $("#resumeForm").find("input[name='email_id'][value='{{$user->email_id}}']").attr("checked",true);
            $("#resumeForm").find("input[name='mobile_id'][value='{{$user->mobile_id}}']").attr("checked",true);
        });
    </script>
@endsection

