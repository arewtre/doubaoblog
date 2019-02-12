@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 分类名称</label>
                <div class="layui-input-block">
                    <input type="text" name="defectsname" value="{{$data->defectsname}}" lay-verify="required" placeholder="请输入分类名称" class="layui-input">
                    <input type="hidden" name="id" value="{{$data->id}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 分类标识</label>
                <div class="layui-input-block">
                    <input type="text" name="new_sign" value="{{$data->new_sign}}" lay-verify="required" placeholder="请输入分类标识" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 父级分类</label>
                <div class="layui-input-block">
                    <select name="pid" lay-verify="required">
                        <option value="0" @if($data->pid==0) selected @endif>顶级分类</option>
                        @foreach($CategoryList as $vo)
                            <option value="{{$vo['id']}}" @if($data->pid == $vo['id']) selected @endif @if($data->id == $vo['id']) disabled @endif >{{$vo['defectsname']}}</option>
                        @endforeach
                        </volist>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 是否隐藏</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_display" lay-skin="switch" lay-text="显示|隐藏" @if($data->is_display=="1")checked @endif>
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">分类描述</label>
                <div class="layui-input-block">
                    <textarea name="dec" placeholder="请输入分类描述" class="layui-input" style="height:100px">{{$data->dec}}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">分类排序</label>
                <div class="layui-input-block">
                    <input type="text" name="descid" value="{{$data->descid}}" placeholder="请输入正整数，越大排名越靠前" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="admin-form">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
  </div>

<script>
    layui.use('form', function(){
        var form = layui.form;
        form.on('submit(admin-form)', function(data){
        	//console.log(data.field);//return;
        	$.ajax({
                type: "POST",
                url: '{{url("admin/imageXc_cate_edit")}}',
                data: data.field,
                success: function(msg){
                    if( msg.code == 1 ){
                        //parent.location.reload();
                        //$('#formid')[0].reset();
                    	layer.msg(msg.msg, {time:1500});
                        setTimeout(function(){
                            parent.location.reload();
                        },1500)
                    }else{
                        parent.layer.msg(msg.msg, {
                            icon: 5,
                            shade: [0.6, '#393D49'],
                            time:1500
                        }); 
                    }
                }
            });
            return false;
        });

    });
</script>
@endsection


