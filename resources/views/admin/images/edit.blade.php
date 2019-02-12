@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
          <div class="layui-card-header">编辑相册</div>
            <form class="layui-form layui-form-pane" id="formid" action="">
                <input type="hidden" name="xc_id" value="{{$detail->xc_id}}">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>相册名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="xc_name" required value="{{$detail->xc_name}}" lay-verify="required" placeholder="请输入相册名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>资讯类别</label>
                    <div class="layui-input-block">
                        <select name="pid" lay-verify="required">
                            <option value="">请选择相册分类</option>
                            @foreach($CategoryList as $vo)
                                <option value="{{$vo['id']}}" {{$vo['pid'] == 0?'disabled':''}}  @if($detail->pid==$vo['id']) selected @endif>{{$vo['showName']}}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label class="layui-form-label">缩略图</label>
                    <div class="layui-input-block">
                         <div class="layui-inline">
                    		<div class="layui-input-inline" style="width:400px;">
								<input type="text" readonly="readonly" value="{{$detail->fengm}}" name="fengm" id="upload-image-url" class="layui-input fengm" style="width:400px" autocomplete="off">
								<!--<input type="hidden" class="layui-input" value="" name="fengm" id="upload-image-url">-->
							</div>
						</div>
						<div class="layui-inline">
                    		<div class="layui-input-inline">
								<!--<button type="button" class="layui-btn" id="upload-image">上传图片</button>-->
                                                                <button type="button" class="layui-btn" id="test1">上传图片</button>
							</div>
						</div>
						<div id="upload-image-preview" style="margin-top:10px;">
	                    		<img src="{{$detail->fengm}}" style="width:112px;height:80px" class="yulan">
                		</div>     
                    </div>
                </div>
<!--                 <div class="layui-form-item"> -->
<!--                      <label class="layui-form-label"><span style="color:red">*</span> 是否发表</label>
<!--                     <div class="layui-input-block"> -->
<!--                         <input type="checkbox" name="art_publish" lay-skin="switch" lay-text="发表|暂不"> -->
<!--                     </div> -->
<!--                 </div>                -->
                 <div class="layui-form-item"> 
                     <label class="layui-form-label"> 会员可见</label> 
                     <div class="layui-input-block"> 
                         <input type="checkbox" name="is_member" lay-skin="switch" lay-text="是|否" {{($detail->is_member == "1"?'checked':'')}} > 
                     </div> 
                 </div> 
                <div class="layui-form-item">
                    <label class="layui-form-label">是否置顶</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="is_top" lay-skin="switch" lay-text="是|否" {{($detail->is_top == "1"?'checked':'')}} >
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">相册描述</label>
                    <div class="layui-input-block">
                        <textarea name="xc_desc" style="height:100px;"class="layui-input">{{$detail->xc_desc}}</textarea>
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
		    ,url: "{{url('admin/upload_add_qiniu')}}"
		   	//,auto: false
		       //,multiple: true
		    //,bindAction: '#test9'
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
		      $('.yulan').attr('src', res.src);
                      $(".fengm").val(res.src);
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
                        url: '{{url("admin/imageXc_edit")}}',
                        data: data.field,
                        success: function(msg){
                            if( msg.code == 1 ){
                                parent.location.reload();
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


