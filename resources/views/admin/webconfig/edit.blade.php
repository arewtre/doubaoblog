@extends('default.layouts.adminPublic')
@section('title', '编辑配置')

@section('content')
<!--导航开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin')}}">首页</a> &raquo; {{ $v->keyname or '' }}
</div>
<!--导航结束-->

<!--导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>增加配置</h3>
        @include('flash::message')
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{ route('webconfig.makeadd') }}"><i class="fa fa-plus"></i>增加配置</a>
            <a href="{{ route('webconfig.makelist') }}"><i class="fa fa-recycle"></i>配置列表</a>
        </div>
    </div>
</div>
<!--导航组件 结束-->

<div class="result_wrap">
    <form action="{{ route('webconfig.makemodifysave') }}" method="post"  name="configForm" id="configForm" onsubmit="return checkForm('#configForm')">
        {{csrf_field()}}

        <table class="add_tab">
            <tbody>
            <tr>
                <th class="makelefttd"><i class="require">*</i> 标签：</th>
                <td>
                    <input type="hidden" class="lg" name="id" value="{{ $config->id or '' }}">
                    <input type="text" class="lg" name="sign" value="{{ $config->sign or '' }}">
                    {{ $errors->first('sign') }}
                </td>
            </tr>
            <tr>
                <th class="makelefttd"><i class="require"></i> 标签中文名：</th>
                <td>
                    <input type="text" class="lg" name="keyname" value="{{ $config->keyname or '' }}">
                    {{ $errors->first('keyname') }}
                </td>
            </tr>

            <tr>
                <th class="makelefttd"><i class="require"></i> 标签值：</th>
                <td>
                    @if($config->type == 'text')
                        <input type="text"  class="lg" name="keyvalue" value="{{ $config->keyvalue or '' }}">
                    @elseif($config->type == 'textarea')
                        <textarea name="keyvalue" class="maketextarea">{{ $config->keyvalue or '' }}</textarea>
                    @endif
                        {{ $errors->first('keyvalue') }}
                </td>
            </tr>


            <tr>
                <th class="makelefttd"><i class="require"></i> 标签解释：</th>
                <td>
                    <input type="text"  class="lg" name="tip" value="{{ $config->tip or '' }}">
                    {{ $errors->first('tip') }}
                </td>
            </tr>
            <tr>
                <th class="makelefttd"><i class="require">*</i> 标签类型：</th>
                <td>
                    <select name="type">
                        <option value="text" @if($config->type == 'text') selected @endif>文本</option>
                        <option value="textarea" @if($config->type == 'textarea') selected @endif>长文本</option>
                    </select>

                </td>
            </tr>

            <tr>
                <th class="makelefttd"><i class="require">*</i> 所属类别：</th>
                <td>
                    <select name="categroy">
                        @if(count($Catetroy) > 0)
                            @foreach($Catetroy as $v)
                                @if($config->categroy == $v->id)
                                    <option value="{{ $v->id }}" selected>{{ $v->describe }}</option>
                                @else
                                    <option value="{{ $v->id }}">{{ $v->describe }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </td>
            </tr>
            <tr>
                <th class="makelefttd"><i class="require"></i> 标签排序：</th>
                <td>
                    <input type="text" class="lg" name="sort" placeholder="数字越小，排在越前面" value="{{ $config->sort }}">{{ $errors->first('sort') }}
                </td>
            </tr>

            <tr id="subrole">
                <th></th>
                <td>
                    <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <input type="hidden" style="width:190px" class="lg" name="make" value="modify">
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


