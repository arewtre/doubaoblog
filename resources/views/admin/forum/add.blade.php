@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
          <div class="layui-card-header">添加帖子</div>
        
            <form class="layui-form" id="formid" action="">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="text" name="title" required value="" lay-verify="required" placeholder="请输入帖子标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="text" name="keywords" required value="" lay-verify="required" placeholder="请输入关键字','隔开" class="layui-input">
                </div>
            </div>
<!--            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span类别</label>
                <div class="layui-input-block">
                    <select name="type" lay-verify="required">
                        <option value="">请选择发帖类型</option>
                        @foreach($ftype as $v)
                            <option value="{{$v['ft_id']}}">{{$v['name']}}</option>
                       @endforeach
                    </select>
                </div>
            </div>-->
            <div class="layui-form-item">
                <!--<label class="layui-form-label"><span style="color:red">*</span类别</label>-->
                <div class="layui-input-block">
                    <select name="pid" lay-verify="required">
                        <option value="">请选择发帖板块</option>
                        @foreach($mod as $v)
                            <option value="{{$v['id']}}" {{$v['level'] == 0?'disabled':''}}>{{$v['defectsname']}}</option>
                       @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <textarea style="height:500px;width:100%;margin-bottom:200px" id="editor_id" class="span7 richtext-clone layui-input" name="content" cols="70">
                    </textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否置顶?</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_top" lay-skin="switch" lay-text="是|否">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit lay-filter="admin-form">确认提交</button>
                    <button type="reset" class="layui-btn">重置</button>
                </div>
            </div>
        </forum>
    </div>
</div>
<script>
$(function(){		
	KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id', {
        	uploadJson : "{{url('addqiniu')}}",
                imageSizeLimit : '10MB', //批量上传图片单张最大容量
                imageUploadLimit : 100, //批量上传图片同时上传最多个数
	        fileManagerJson : "{{url('upload_manage')}}",
			allowFileManager : true,
			afterBlur: function () { this.sync()},
		});
	});
});

</script>
<script type="text/javascript">
	function thumb(obj) {
		if (obj.height > obj.width) { obj.style.height = "100px"; obj.style.width = "auto"}
	}
    $(function(){		
		var editor = KindEditor.editor({
			uploadJson : "{{url('addqiniu')}}",
                        fileManagerJson : "{{url('upload_manage')}}",
			allowFileManager : true,
			afterUpload : function(url, data) {
                            console.log(url);
			}
		});
		
	</script>
	
    
        <script>
            layui.use('form', function(){
                var form = layui.form;
                form.on('submit(admin-form)', function(data){
                	//console.log(data);return;
                    $.ajax({
                        type: "POST",
                        url: '{{url("admin/forum_add")}}',
                        data: data.field,
                        success: function(msg){
                            if( msg.code == 1 ){
                                location.reload();
                            	layer.msg(msg.msg, {time:1500});
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
      
</script>
          

@endsection


