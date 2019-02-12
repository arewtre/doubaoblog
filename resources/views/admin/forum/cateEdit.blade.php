@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 模块名称</label>
                <div class="layui-input-block">
                    <input type="text" name="defectsname" value="{{$data->defectsname}}" lay-verify="required" placeholder="请输入模块名称" class="layui-input">
                    <input type="hidden" name="id" value="{{$data->id}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 模块标识</label>
                <div class="layui-input-block">
                    <input type="text" name="new_sign" value="{{$data->new_sign}}" lay-verify="required" placeholder="请输入模块标识" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color:red">*</span> 父级模块</label>
                <div class="layui-input-block">
                    <select name="pid" lay-verify="required">
                        <option value="0" @if($data->pid==0) selected @endif>顶级模块</option>
                        @foreach($CategoryList as $vo)
                            <option value="{{$vo->id}}" @if($data->pid== $vo->id) selected @endif @if($data->id== $vo->id) disabled @endif >{{$vo->defectsname}}</option>
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
            <!-- <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">模块URL</label>
                <div class="layui-input-block">
                    <input type="text" name="href" value="{:(isset($detail['href'])?$detail['href']:'')}" placeholder="请输入模块URL" class="layui-input">
                </div>
            </div>-->
            <div class="layui-form-item">
                    <label class="layui-form-label">缩略图</label>
                    <div class="layui-input-block">
                         <div class="layui-inline">
                    		<div class="layui-input-inline" style="width:400px;">
								<input type="text" readonly="readonly" value="{{$data->img}}" name="img" id="upload-image-url" class="layui-input" style="width:400px" autocomplete="off">
								<input type="hidden" class="layui-input" value="{{$data->img}}" name="img" id="upload-image-url">
							</div>
						</div>
						<div class="layui-inline">
                    		<div class="layui-input-inline">
								<button type="button" class="layui-btn" id="upload-image">上传图片</button>
							</div>
						</div>
						<div id="upload-image-preview" style="margin-top:10px;">
	                    		
	                    		<img src="@if(!empty($data->img)){{asset($data->img)}} @else {{asset('resources/admin/images/nopic.jpeg')}} @endif" style="width:112px;height:80px">
                		</div>     
                    </div>
                </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">模块描述</label>
                <div class="layui-input-block">
                    <textarea name="dec" placeholder="请输入模块描述" class="layui-input" style="height:100px">{{$data->dec}}</textarea>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">模块链接</label>
                <div class="layui-input-block">
                    <input type="text" name="url" value="{{$data->url}}" placeholder="请输入链接地址" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">模块排序</label>
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
$(function(){		
	KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id', {
        	uploadJson : "{{url('admin/upload_add')}}",
	        fileManagerJson : "{{url('admin/upload_manage')}}",
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
			uploadJson : "{{url('admin/upload_add')}}",
	        fileManagerJson : "{{url('admin/upload_manage')}}",
			allowFileManager : true,
			afterUpload : function(url, data) {
			}
		});
		$("#upload-image").click(function() {
			editor.loadPlugin("image", function() {
				editor.plugin.imageDialog({
					tabIndex : 1,
					imageUrl : $("#upload-image-url").val(),
					clickFn : function(url) {
						editor.hideDialog();
						$("#upload-image-url").val(url);
						$("#upload-image-preview").html('<li class="imgbox" style="list-type:none">'+
							'<a class="item_close" href="javascript:;" onclick="deletepic(this);" title="删除"></a>'+
							'<span class="item_box"> <img src="'+url+'"></span>'+
							'<input type="hidden" name="img" value="'+url+'" />'+
							'</li>');
						}
					});
				});
			});
			
		});
    function deletepic(obj){
		if (confirm("确认要删除？")) {
			var $thisob=$(obj);
			var $liobj=$thisob.parent();
			var picurl=$liobj.children('input').val();
			$.post("{{url('admin/upload_del')}}",{pic:picurl},function(m){
				if(m=='1') {
					$liobj.remove();
					$("#upload-image-url").val("");
				} else {
					alert("删除失败");
				}
			},"html");	
		}
	}
	</script>
	<script>
	layui.use(['form','upload'], function(){
		  var form = layui.form,upload = layui.upload;
		  //普通图片上传
		  var uploadInst = upload.render({
		    elem: '#test1'
		    ,url: "{{url('User/Upload')}}"
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
		      $('#demo1').attr('src', res.data.src);
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
                url: '{{url("admin/forum_mod_edit")}}',
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


