@extends('default.layouts.adminPublic')
@section('title', '充值提现管理')
@section('headcss')
    @parent
      <link rel="stylesheet" href="{{asset('/default/css/admin/indexList.css')}}">
    @endsection
    @section('content')
            <!--导航开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> 充值提现列表
    </div>
    <!--导航结束-->
    <!--结果集标题与导航组件 开始-->

    <div class="con">
        <div class="conMain">
            <div class="result_wrap">
                <div class="search">
                    <form name="Formso" id="Formso" action="{{url('admin/resume_cash')}}" method="post">
                        {{csrf_field()}}
                        <span>关键字：</span>
                        <span><input name="keyword" class="keyword" id="keyword" placeholder="请输入简历姓名或者手机号码" type="text"></span>
                        <select name="type" id="type">
                            <option value="0">不限</option>
                            <option value="1">充值</option>
                            <option value="2">提现</option>
                        </select>
                        <span><input name="submit" class="skeyword" value="搜索" type="submit"></span>
                    </form>
                </div>
                <div class="message"><p>目前共查找到<strong>{{$resumeCash->total()}}</strong>个充值提现记录！且每页显示充值提现记录{{$resumeCash->perPage()}}个。</p></div>
            </div>
            <div class="manage">
                @include('flash::message')
            </div>
            <div class="conInfo">
                <form name="thisForm" id="thisForm" action="" method="post">
                    {{csrf_field()}}
                    <div class="conList" id="conList">
                        <dl class="one">
                            <dt class="cash">序号</dt>
                            <dd class="cash1">简历姓名</dd>
                            <dd class="cash2">出生日期</dd>
                            <dd class="cash3">最高学历</dd>
                            <dd class="cash4">手机号码</dd>
                            <dd class="cash5">类型</dd>
                            <dd class="cash6">金额</dd>
                            <dd class="cash7">创建时间</dd>
                            <dd class="cash8">操作</dd>
                        </dl>
                        @if($resumeCash->count() > 0 )
                            @foreach($resumeCash as $k => $v)
                                <dl id="list{{ $v->id }}">
                                    <dt class="cash">{{ $k+1 }}.</dt>
                                    <dd class="cash1">{{ $v->name or '' }}</dd>
                                    <dd class="cash2">{{ $v->birthday or '' }}</dd>
                                    <dd class="cash3">{{ $v->education_name or '' }}</dd>
                                    <dd class="cash4">{{ $v->mobile or '' }}</dd>
                                    <dd class="cash5">{{ $v->cash_type_name or '' }}</dd>
                                    <dd class="cash6">{{ $v->cash_money or '' }}</dd>
                                    <dd class="cash7">{{ $v->created_at }}</dd>
                                    <dd class="cash8">
                                        <span><a onclick="delCash({{ $v->id }})">删除</a></span>
                                    </dd>
                                </dl>
                            @endforeach
                        @else
                            <div class="nullcon">对不起！没有充值提现的记录！</div>
                        @endif

                    </div>
                </form>
                <div class="page_list" style="width: 100%; float: left; margin-top:15px;">
                    {!! $resumeCash->links() !!}
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
        function delCash(e){

            layer.confirm('您确定要删除这条记录吗？', {
                        btn: ['确定', '取消'] 
                    },
                    function(){
                        $.post("{{url('admin/del_cash')}}", {
                            'id':e,
                            '_token': '{{csrf_token()}}'
                        }, function (data) {
                            if (data.status == 0) {
                                layer.msg(data.msg,{icon: 6,width:'50px'});
                                window.location.href = "{{url('/admin/resume_cash')}}";
                            } else {
                                layer.msg(data.msg,{icon: 5,width:'50px'});
                            }
                        });
                    }
            );
        }
    </script>
@endsection