@extends('layouts.base')
@section('content')
<style>
    .label-selected{
			width: 100%;
			min-height:38px;
			margin:10px 0;
			border:1px solid #ccc;
			background-color: #fff;
			position: relative;
		}
		.cell{
			display: block;
			width:90px;
			height:28px;
			line-height: 28px;
			border:3px;
			background:#009688;
			color:#fff;
			text-align: center;
		}
		.label-selected li {
		    display: inline-block;
		    height: 27px;
		    line-height: 27px;
		    font-size: .8rem;
		    padding: 0 1rem;
		    border: 1px solid #e6e6e6;
		    border-radius: 2px;
		    cursor: pointer;
		    margin: 4px 2px;
		    color: #666;
		}
		#labelItem{
			margin-bottom: 10px;
			display: none;
		}
		.label-item {
		    border: 1px solid #e6e6e6;
		    padding: 10px;
		    border-radius: 0 2px 2px 0;
		    position: relative;
		    overflow: hidden;
		    background: #fff;
		}
		.label-item li {
		    display: inline-block;
		    height: 27px;
		    line-height: 27px;
		    font-size: .8rem;
		    padding: 0 1rem;
		    border: 1px solid #e6e6e6;
		    border-radius: 2px;
		    cursor: pointer;
		    margin-bottom: 5px;
		    margin-left: 2px;
		    color: #666;
		}
		.label-item .selected{
			color:#ccc;
		}

</style>
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
<!--          <div class="layui-card-header">添加资讯</div>-->
            <form class="layui-form layui-form-pane" id="formid" action="">
                @if(isset($detail->art_id))
                    <input type="hidden" name="art_id" value="{{$detail->art_id}}">
                @endif
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>文章资讯</label>
                    <div class="layui-input-block">
                        <input type="text" name="art_title" required value="{{$detail->art_title}}" lay-verify="required" placeholder="请输入资讯名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span style="color:red">*</span>资讯类别</label>
                    <div class="layui-input-block">
                        <select name="cate_id" lay-verify="">
                            <option value="0">请选择资讯分类</option>
                            @foreach($CategoryList as $vo)
                                <option value="{{$vo['id']}}" {{$vo['level'] == 0?'disabled':''}} {{$vo['id'] == $detail->cate_id?'selected':''}}>{{$vo['showName']}}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                 <div class="layui-form-item">
                    <label class="layui-form-label">缩略图</label>
                    <div class="layui-input-block">
                         <div class="layui-inline">
                    		<div class="layui-input-inline" style="width:400px;">
								<input type="text" readonly="readonly" value="{{$detail->art_thumb}}" name="art_thumb" id="upload-image-url" class="layui-input" style="width:400px" autocomplete="off">
								<input type="hidden" class="layui-input" value="{{$detail->art_thumb}}" name="art_thumb" id="upload-image-url">
							</div>
						</div>
						<div class="layui-inline">
                    		<div class="layui-input-inline">
								<button type="button" class="layui-btn" id="upload-image">上传图片</button>
							</div>
						</div>
						<div id="upload-image-preview" style="margin-top:10px;">
	                    		
	                    		<img src="{{asset($detail->art_thumb)}}" style="width:112px;height:80px">
                		</div>     
                    </div>
                </div>
<!--                 <div class="layui-form-item"> -->
<!--                      <label class="layui-form-label"><span style="color:red">*</span> 是否发表</label>
<!--                     <div class="layui-input-block"> -->
<!--                         <input type="checkbox" name="art_publish" lay-skin="switch" lay-text="发表|暂不"> -->
<!--                     </div> -->
<!--                 </div>                -->
<!--                 <div class="layui-form-item"> -->
<!--                     <label class="layui-form-label"> 会员可见</label> -->
<!--                     <div class="layui-input-block"> -->
<!--                         <input type="checkbox" name="art_isshow" lay-skin="switch" lay-text="是|否"> -->
<!--                     </div> -->
<!--                 </div> -->
                <div class="layui-form-item">
                    <label class="layui-form-label">是否置顶</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="art_istop" {{($detail->art_istop == "1"?'checked':'')}} lay-skin="switch" lay-text="是|否">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否显示</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="is_display" lay-skin="switch" {{($detail->is_display == "1"?'checked':'')}} lay-text="是|否">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">文章描述</label>
                    <div class="layui-input-block">
                        <textarea name="art_description" style="height:100px;"class="layui-input">{{$detail->art_description}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-block">
                        <input type="text" name="keywords" required value="{{$detail->keywords}}" lay-verify="required" placeholder="请输入关键词" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">标签</label>
                    <div class="layui-input-block">
                        <div class="wrap">
                        <div class="label-selected">
                        <a href="javascript:;" class="layui-btn layui-btn-sm show-labelitem" style="float: right; margin: 4px; display: block;line-height: 30px;">展开标签库 </a>
                        <a href="javascript:;" class="layui-btn layui-btn-sm hide-labelitem" style="float: right; margin: 4px; display: none;line-height: 30px;">收起标签库 </a>
                        <input type="hidden" name="tags" value="{{$detail->tags}}">
                        @if(!empty($detail->tags))
                            @foreach(explode(",", substr($detail->tags,0,-1)) as $v)
                                <li>x {{$v}}</li>
                            @endforeach
                        @endif
                        </div>
                        <div class="layui-col-md12" id="labelItem">
                        <div class="label-item">
                        <a href="javascript:;" class="replacelable" style="position: absolute;right:1rem;bottom:.75rem;color: #1994dc" onselectstart="return false">换一批</a>
                       @foreach($tags as $v)
                        <li data="{{$v->tagname}}">x&nbsp;<span>{{$v->tagname}}</span></li>
                        @endforeach
                        </div>
                        </div>
                        <!--<a href="javascript:;" class="layui-btn" id="cell">获取</a>-->
                        </div>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">文章内容</label>
                    <div class="layui-input-block">
                       <textarea style="height:500px;width:100%;" id="editor_id" class="span7 richtext-clone layui-input" name="art_content" cols="70">{{$detail->art_content}}</textarea>
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
                	//console.log(data);return;
                    $.ajax({
                        type: "POST",
                        url: '{{url("admin/news_edit")}}',
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
<script>
        $(function(){
        $(".show-labelitem").on("click",function(){
          $(this).hide();
          $(".hide-labelitem").show();
          $("#labelItem").show();
        });
        $(".hide-labelitem").on("click",function(){
          $(this).hide();
          $(".show-labelitem").show();
          $("#labelItem").hide();
        });
        $(".label-item").on("click","li",function(){
          var id = $(this).attr("data");
          var text = $(this).children("span").html();
          var labelHTML = "<li data='"+id+"''>x "+text+"</li>";
          if($(this).hasClass("selected")){
            return false;
          }else if($(".label-selected").children("li").length >= 8){
            layer.msg("最多可以选择8个哦");
            return false;
          }
          $(".label-selected").append(labelHTML);
          val = '';
          for(var i = 0; i < $(".label-selected").children("li").length; i++){
            val += $(".label-selected").children("li").eq(i).attr("data")+',';
          }
          $("input[name='tags']").val(val);
          $(this).addClass("selected");
        });
        var val = "";
        $(".label-selected").on("click","li",function(){
          var id = $(this).attr("data");
          val = '';
          $(this).remove();
          for(var i = 0; i < $(".label-selected").children("li").length; i++){
            val += $(".label-selected").children("li").eq(i).attr("data")+',';
          }
          $("input[name='tags']").val(val);
          $(".label-item").find("li[data='"+id+"']").removeClass("selected");
        });


        //点击更换标签
        var limit = 1;
        $(".replacelable").on("click",function(){
          layer.load(1);
          limit += 1;
          console.log(limit);
          $.ajax({
            url:"{{url('admin/changeTags')}}",
            type:"post",
            datatype:"json",
            data:{
              limit:limit
            },
            success:function(data){
              if(data!=""){
                layer.closeAll('loading');
                $(".label-item").find("li").remove();//删除原先所有，本来想让数据表随机搜索的，想着有点mmp，就没搞，用的是limit
                var html = '';
                for(var i in data){
                  html += "<li data=\""+data[i].tagname+"\">x&nbsp;<span>"+data[i].tagname+"</span></li>";//拼接标签
                }
                $(".label-item").append(html);//追加至文档
              }else{
                layer.closeAll('loading');
                layer.msg("没有了");
                limit = 0;
              }
            },
            error:function(){
              layer.closeAll('loading');
              layer.msg("错误~~~");
            }
          })
        })
        
      })

        
        </script>
@endsection


