@extends('layouts.base')
@section('content')
        <div class="layui-field-box">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>友链名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="link_name" required value="" lay-verify="required" placeholder="请输入友链名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>友链地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="link_url" required value="" lay-verify="required" placeholder="请输入友链地址" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">友链状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="status" lay-skin="switch" lay-text="显示|暂不" checked>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="link_sort" required value="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="admin-form">立即提交</button>
                        <button type="reset" class="layui-btn">重置</button>
                    </div>
                </div>
            </form>
        </div>
<script>
            layui.use('form', function(){
                var form = layui.form;
                form.on('submit(admin-form)', function(data){
                    $.ajax({
                        type: "POST",
                        url: "{{url('admin/links')}}",
                        data: data.field,
                        success: function(msg){
                            if( msg.status == 0 ){
                                parent.location.reload();
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
