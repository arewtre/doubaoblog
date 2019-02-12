@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
<!--           <div class="layui-card-header">编辑广告</div> -->
            <form class="layui-form layui-form-pane" id="formid" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>广告标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" required value="" lay-verify="required" placeholder="请输入广告名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>有效周期</label>
                    <div class="layui-inline">
                        <input type="text" id="timestart" name="start_time" required value="" lay-verify="required" placeholder="请输入开始时间" class="layui-input">
                    </div>
                     <div class="layui-inline">
                        -
                    </div>
                     <div class="layui-inline">
                        <input type="text" id="timeend" name="end_time" required value="" lay-verify="required" placeholder="请输入结束时间" class="layui-input">
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>轮播图</label>
                    <div class="layui-input-block">
                         <div class="layui-inline">
                            <div class="layui-input-inline" style="width:400px;">
                                <input type="text" readonly="readonly" value="" name="pic_url" id="upload-image-url" class="layui-input fengm" style="width:400px" autocomplete="off">
                                <!--<input type="hidden" class="layui-input" value="" name="pic_url" id="upload-image-url">-->
                            </div>
                        </div>
<!--			<div class="layui-inline">
                            <div class="layui-input-inline">
                                <button type="button" class="layui-btn" id="upload-image">上传图片</button>
                            </div>
                        </div>
			<div id="upload-image-preview" style="margin-top:10px;">
	                    <img src="{{asset('resources/admin/images/nopic.jpeg')}}" style="width:112px;height:80px">
                	</div>     -->
                        <div class="layui-inline">
                        <div class="layui-input-inline">
								<!--<button type="button" class="layui-btn" id="upload-image">上传图片</button>-->
                                                <button type="button" class="layui-btn" id="test1">上传图片</button>
                                        </div>
                                </div>
                                <div id="upload-image-preview" style="margin-top:10px;">
	                    		<img src="{{asset('resources/admin/images/nopic.jpeg')}}" style="width:112px;height:80px" class="yulan">
                		</div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>链接类型</label>
                    <div class="layui-input-block">
                        <select name="url_type" lay-verify="required">
                            <option value="0">无链接</option>
                            <option value="1">URL地址</option>
                            <option value="2">文章</option>
                            <option value="3">相册</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>连接地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="url" required value="@if(isset($url)) {{$url}} @else  / @endif " @if(isset($url_type) && $url_type==3) disabled @endif lay-verify="required" placeholder="请输入广告链接地址(不跳转请先写'/')" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>广告站点</label>
                    <div class="layui-input-block">
                        <select name="ad_site" lay-verify="required">
                            @foreach($ad_site as $v) 
                                <option value="{{$v->id}}">{{$v->site_name}}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>广告位置</label>
                    <div class="layui-input-block">
                        <select name="ad_slots" lay-verify="required">
                            @foreach($as_slots as $v) 
            	        	  <option value="{{$v->id}}">{{$v->ad_name}}</option>
            	        	@endforeach 
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否显示</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="status" checked lay-skin="switch" lay-text="是|否">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">广告说明</label>
                    <div class="layui-input-block">
                        <textarea name="explanation" value="" style="height:100px;"class="layui-input"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">广告排序</label>
                    <div class="layui-input-block">
                       <input type="text" name="sort" required value="0" lay-verify="required" placeholder="请输入广告链接地址" class="layui-input">
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
							'<input type="hidden" name="pic_url" value="'+url+'" />'+
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
	layui.use(['form','upload','laydate'], function(){
		  var form = layui.form,upload = layui.upload,laydate = layui.laydate;
		  //普通图片上传
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
                        console.log(res);
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
                laydate.render({ 
                    elem: '#timestart'
                    ,type: 'date'
                  });
                  
                  laydate.render({ 
                    elem: '#timeend'
                    ,type: 'date'
                  });
                form.on('submit(admin-form)', function(data){
                	//console.log(data.field);//return;
                	$.ajax({
                        type: "POST",
                        url: '{{url("admin/adv_add")}}',
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


