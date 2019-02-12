@extends('layouts.base')
@section('content')
<link rel="stylesheet" href="{{asset('resources/admin/css/ch-ui.admin.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/adminPublic.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/category.css')}}">
<link rel="stylesheet" href="{{asset('resources/admin/css/indexList.css')}}">
<style>
    input[type='text'], input[type='password'], input[type='email'] {
    width: 400px !important;
    margin-right: 5px;
    padding: 0px 5px;
    line-height: 38px;
    height: 38px;
    font-size: 12px;
}

</style>
    <div class="layui-fluid con">
        <div class="conMain">

            <div class="cRight">
                <div class="list" style="left:15px;">
                    <div class="cTitle cTitleList"><i class="fa fa-folder" style="color: #333"></i>请配置网站信息</div>
                    <div class="listBox">
                        <div class="listCon configDiv">
                            <ul>
                                <li class="optColl">
                                    <div class="options one">
                                        <dl>
                                            <dd class="config_opt_name" style="color: #333">配置项{{Site::get('webname')}}</dd>
                                            <dd class="config_opt_id">配置内容</dd>
                                            <dd class="operating"></dd>
                                        </dl>
                                    </div>
                                </li>
                                <form action="{{ url('admin/webconfig/modify') }}" name="upconfigForm" id="upconfigForm" method="post">
                                    {{csrf_field()}}
                                    @if(count($catetroyArray) > 0)
                                        @foreach($catetroyArray as $k=>$v)
                                            <li class="optColl">#{{ $v }}</li>{{--类别--}}
                                            @if(count($config) > 0)
                                                @foreach($config as $key=>$list)
                                                    @if($list['categroy'] == $k)
                                                        <li {{$list['type']=='textarea' ? $descride_css='class=config_descride_li' : ''}}>
                                                            <div class="options optBefore">
                                                                <dl>
                                                                    <dd class="config_opt_name nameColor config_right {{$list['type']=='textarea' ? $descride_css='lineheight150' : ''}}" id="oName">{{$list['keyname']}}</dd>
                                                                    <dd class="config_opt_id {{$list['type']=='textarea' ? $descride_css='lineheight150' : ''}}" id="oCid">
                                                                        @if($list['type']=='textarea')
                                                                            <textarea class="mm" name="keyvalue[{{$list['id']}}]" placeholder="网站描述最佳字数少于250个字！">{{$list['keyvalue']}}</textarea>
                                                                        @else
                                                                            <input name="keyvalue[{{$list['id']}}]" type="text" value="{{$list['keyvalue']}}" class="config_content_input">
                                                                            
                                                                        @endif
                                                                    </dd>
                                                                    <dd class="operating config_err {{$list['type']=='textarea'? $descride_css='lineheight150' : ''}}">
                                                                        {{ !empty($errors->first($key)) ? "<em>".$errors->first($key)."</em>" : $list['tip']}}
                                                                    </dd>
                                                                </dl>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    <li class="config_center">
                                        <div class="options">
                                            <dl>
                                                <dt class="opt_sort"></dt>
                                                <dd class="config_opt_name config_bordernone" style="color: #333"></dd>
                                                <dd class="config_opt_id config_left config_bordernone">
                                                    <input type="submit" class="sub" value="修改网站信息"/>
                                                    @if($status=='modify' && count($errors->all())==0 )
                                                        <span class='config_green'>信息修改成功！</span>
                                                    @endif
                                                </dd>
                                                <dd class="operating config_bordernone"></dd>
                                            </dl>
                                        </div>
                                    </li>
                                 </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('resources/admin/default/js/jquery/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/admin/default/js/admin/position.js')}}"></script>
@endsection