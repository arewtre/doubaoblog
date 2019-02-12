@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
          <div class="layui-card-header">视频视频</div>
            <form class="layui-form layui-form-pane" id="formid" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>视频名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="v_name" required value="" lay-verify="required" placeholder="请输入视频名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>资讯类别</label>
                    <div class="layui-input-block">
                        <select name="v_cid" lay-verify="required">
                            <option value="">请选择视频分类</option>
                            @foreach($CategoryList as $vo)
                                <option value="{{$vo['id']}}">{{$vo['showName']}}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label class="layui-form-label">缩略图</label>
                    <div class="layui-input-block">
                         <div class="layui-inline">
                    		<div class="layui-input-inline" style="width:400px;">
                                        <input type="text" readonly="readonly" value="" name="v_url" id="upload-image-url" class="layui-input v_url" style="width:400px" autocomplete="off">
                                </div>
			</div>
			<div class="layui-inline">
                    		<div class="layui-input-inline">
                                        <button type="button" class="layui-btn" id="test1">上传视频</button>
                                </div>
			</div>
                        <div id="upload-image-preview" style="margin-top:10px;">
                                <img src="{{asset('resources/admin/images/nopic.jpeg')}}" style="width:112px;height:80px" class="yulan">
                        </div>     
                    </div>
                </div>
                 <div class="layui-form-item"> 
                     <label class="layui-form-label"> 会员可见</label> 
                     <div class="layui-input-block"> 
                         <input type="checkbox" name="is_member" lay-skin="switch" lay-text="是|否"> 
                     </div> 
                 </div> 
                <div class="layui-form-item">
                    <label class="layui-form-label">是否置顶</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="is_istop" lay-skin="switch" lay-text="是|否">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">视频描述</label>
                    <div class="layui-input-block">
                        <textarea name="v_desc" style="height:100px;"class="layui-input"></textarea>
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
	layui.use(['form','upload'], function(){
		  var form = layui.form,upload = layui.upload;
		  //普通图片上传
		  var uploadInst = upload.render({
		    elem: '#test1'
                    ,accept :"video"
		    ,url: "{{url('admin/upload_add_video')}}"
		    ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
		    layer.load(); //上传loading
		  }
		    ,choose: function(obj){
		        //将每次选择的文件追加到文件队列
		        var files = obj.pushFile();
		        //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
		        obj.preview(function(index, file, result){
		          $('#demo1').attr('src', result);
		        });

		        var index = layer.load(1);
		      }
		    ,done: function(res){
		      //如果上传失败
		      if(res.code ==-1){
		        return layer.msg('上传失败');
		      }
		      //上传成功
		      $('.yulan').attr('src', res.url+"?vframe/jpg/offset/2/w/160/h/90");
                      $(".v_url").val(res.url);
		      layer.msg('上传成功');
		      layer.closeAll('loading');
		    }
		  });
	});
	</script>
    
        <script>
            layui.use('form', function(){
                var form = layui.form;
                form.on('submit(admin-form)', function(data){
                	//console.log(data.field);//return;
                	$.ajax({
                        type: "POST",
                        url: '{{url("admin/video_add")}}',
                        data: data.field,
                        success: function(msg){
                            if( msg.code == 1 ){
                                window.location.href= history.go(-1);
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

@endsection


