@extends('layouts.base2')
@section('content')
    <div class="con">
        <div class="conMain">
            <div class="result_wrap">
                <div class="search">
                    <form name="Formso" id="Formso" action="{{url('admin/job_user_reg')}}" method="post">
                        {{csrf_field()}}
                        <span>关键字：</span>
                        <span><input name="keyword" class="keyword" id="keyword" placeholder="请输入用户名或者手机号码" type="text"></span>
                        <span><input name="submit" class="skeyword" value="搜索" type="submit"></span>
                    </form>
                </div>
                <div class="message"><p>目前共查找到<strong>{{$user->total()}}</strong>个用户！且每页显示用户{{$user->perPage()}}个用户。</p></div>
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
                            <dd class="px1">用户ID</dd>
                            <dd class="px2">用户名</dd>
                            <dd class="px3">手机号码</dd>
                            <dd class="px4">邮箱地址</dd>
                            <dd class="px5">注册时间</dd>
                            <dd class="px6">账户绑定</dd>
                            <dd class="px7">操作</dd>
                        </dl>
                        @if($user->count() > 0 )
                            @foreach($user as $v)
                                <dl id="list{{$v->uid}}">
                                    <dt><input name="selected_id[]" type="checkbox" value="{{$v->uid}}" /></dt>
                                    <dd class="px1">{{$v->uid}}</dd>
                                    <dd class="px2">{{str_limit($v->username,16)}}</dd>
                                    <dd class="px3">{{str_limit($v->mobile,12)}}</dd>
                                    <dd class="px4">{{str_limit($v->email,24)}}</dd>
                                    <dd class="px5">{{$v->regtime}}</dd>
                                    <dd class="px6">
                                        @if(!empty($v->email_id))
                                            <i class="email"></i>
                                        @endif
                                        @if(!empty($v->mobile_id))
                                            <i class="mobile"></i>
                                        @endif
                                        @if(!empty($v->qqopenid))
                                            <i class="qq"></i>
                                        @endif
                                        @if(!empty($v->wechatopenid))
                                            <i class="wechat"></i>
                                        @endif
                                    </dd>
                                    <dd class="px7">
                                        <span><a lay-href=="{{url('admin/personal_welcome/'.$v->uid)}}" target="_blank">账户中心</a></span>
                                        <span><a lay-href=="{{url('admin/job_user_mod/'.$v->uid)}}">注册信息</a></span>
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
                        </dl>
                    </div>
                </form>
                <div class="page_list" style="width: 100%; float: left; margin-top:15px;">
                    {!! $user->links() !!}
                </div>
            </div>

            <div class="stopper" style="margin-top:10px; border-top: 1px solid #e5e5e5"></div>
        </div>
    </div>
    <script>
        //全选中与全不选中职位资料
        function CheckAll(form){
            if (form.checked==true){
                for (var i=0;i<document.thisForm.elements.length;i++){
                    var e = document.thisForm.elements[i];
                    if (e.name == 'selectedid' || e.name=='selected_id[]' || e.name=='selectall')
                        e.checked=true;
                }
            }else{
                for (var i=0;i<document.thisForm.elements.length;i++){
                    var e = document.thisForm.elements[i];
                    if (e.name == 'selectedid' || e.name=='selected_id[]' || e.name=='selectall')
                        e.checked=false;
                }
            }
        }
        $(function(){

        });
    </script>
    <script>
        $(function(){
            //删除当前
            @if($user->count() > 0 )
                @foreach($user as $v)
                    $('#conList').find("#list" + '{{$v->uid}}').find('.del a').click(function(){
                layer.confirm('确定要删除该用户所有数据吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    $.get("/admin/job_user_del/"+'{{$v->uid}}',{'_token':"{{csrf_token()}}"},function (data) {
                        if(data.status==0){
                            $('#conList').find("#list" + '{{$v->uid}}').remove();
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
@endsection