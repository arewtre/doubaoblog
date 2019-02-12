@extends('layouts.home')
@section('content')
<script src="{{asset('resources/home/js/jquery-1.11.0.min.js')}}" type="text/javascript"></script> 
    <!--<script src="{{asset('resources/home/js/common.js')}}" type="text/javascript"></script>--> 
    <link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_common.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/admin/kindeditor/themes/default/default.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('resources/admin/kindeditor/themes/default/upload.css')}}" type="text/css">
  <script src="{{asset('resources/admin/kindeditor/kindeditor-all-min.js')}}"></script>
  <style> 
  .layui-input-block {
     margin-left: 0px; 
    min-height: 36px;
}
  </style>
<div id="wp" class="wp">
<div id="pt" class="bm cl">
<div class="z">
<a href="{{url('/')}}" class="nvhm" title="首页">豆宝网首页</a><em>&#187;</em>
<a href="{{url('guide')}}">导读</a> <em>&#8250;</em> 
<a href="">发表新帖</a></div>
</div>
<div class="boardnav">
<div id="ct" class="wp cl">
<div class="xr_guide mn bp cl">

<div class="xr_guide_tit mbw cl">
<h1 class="xs2">发表新帖</h1>
</div>
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
<div class="layui-form-item">
    <!--<label class="layui-form-label"><span style="color:red">*</span类别</label>-->
    <div class="layui-input-block">
        <select name="type" lay-verify="required">
            <option value="">请选择发帖类型</option>
            @foreach($ftype as $v)
                <option value="{{$v['ft_id']}}">{{$v['name']}}</option>
           @endforeach
        </select>
    </div>
</div>
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
        <textarea style="height:500px;width:100%;margin-bottom:200px" id="editor_id" class="span7 richtext-clone layui-input" name="content" cols="70"></textarea>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">回复可见?</label>
    <div class="layui-input-block">
        <input type="checkbox" name="rep_view" lay-skin="switch" lay-text="是|否">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-inline">
        <button class="layui-btn" lay-submit lay-filter="admin-form" style="background:#FF7F84">发表帖子</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
</div>

</div>
</div>
</div>
</div>   
<!--  <script>
  jQuery("#nv li").removeClass("a");
  jQuery("#mn_N2905").addClass("a");
  </script>-->
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
        jQuery("#nv li").removeClass("a");
jQuery("#mn_forum").addClass("a");
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
							'<input type="hidden" name="art_thumb" value="'+url+'" />'+
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
			$.post("{{url('upload_del')}}",{pic:picurl},function(m){
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
            layui.use('form', function(){
                var form = layui.form;
                form.on('submit(admin-form)', function(data){
                	//console.log(data);return;
                    $.ajax({
                        type: "POST",
                        url: '{{url("forumAdd")}}',
                        data: data.field,
                        success: function(msg){
                            if( msg.code == 1 ){
                                window.location.reload();
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