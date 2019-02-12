@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
<!--           <div class="layui-card-header">编辑广告</div> -->
            <form class="layui-form layui-form-pane" id="formid" action="">
                <input type="hidden" name="id" required value="{{$detail->id}}">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>广告位标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="ad_name" required value="{{$detail->ad_name}}" lay-verify="required" placeholder="请输入广告位标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>广告位标识</label>
                    <div class="layui-input-block">
                        <input type="text" name="ad_sign" required value="{{$detail->ad_sign}}" lay-verify="required" placeholder="请输入广告位标识" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>最大数目</label>
                    <div class="layui-input-block">
                        <input type="text" name="ad_number" required value="{{$detail->ad_number}}" lay-verify="required" placeholder="请输入最大显示数目" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">宽度</label>
                    <div class="layui-input-block">
                        <input type="text" name="width" required value="{{$detail->width}}" placeholder="请输入宽度" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">高度</label>
                    <div class="layui-input-block">
                        <input type="text" name="height" required value="{{$detail->height}}" placeholder="请输入高度" class="layui-input">
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
<!--     </div> -->
<!-- </div> -->
	<script>
	layui.use(['form','upload','laydate'], function(){
		  var form = layui.form;
                form.on('submit(admin-form)', function(data){
                	//console.log(data.field);//return;
                	$.ajax({
                        type: "POST",
                        url: '{{url("admin/adv_addr_edit")}}',
                        data: data.field,
                        success: function(msg){
                            if( msg.code == 1 ){
                            	parent.layer.msg(msg.msg, {time:1500});
                                setTimeout(function(){
                                   parent.location.reload(); 
                                },1500)
                            	//$("#editor_id").text(""); 
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


