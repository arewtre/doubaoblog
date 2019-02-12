@extends('layouts.admin')
@section('content')
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">设置我的资料</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="demo">
<!--              <div class="layui-form-item">
                <label class="layui-form-label">我的角色</label>
                <div class="layui-input-inline">
                  <select name="role" lay-verify="">
                    <option value="1" selected>超级管理员</option>
                    <option value="2" disabled>普通管理员</option>
                    <option value="3" disabled>审核员</option>
                    <option value="4" disabled>编辑人员</option>
                  </select> 
                </div>
                <div class="layui-form-mid layui-word-aux">当前角色不可更改为其它角色</div>
              </div>-->
              <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-inline">
                  <input type="text" name="user_name" value="{{$info->user_name}}" readonly class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">不可修改。一般用于后台登入名</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                  <input type="text" name="nickname" value="{{$info->nickname}}" class="layui-input">
                </div>
              </div>
<!--              <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                  <input type="text" name="nickname" value="{{$info->user_name}}" lay-verify="nickname" autocomplete="off" placeholder="请输入昵称" class="layui-input">
                </div>
              </div>-->
              <div class="layui-form-item">
                <label class="layui-form-label">性别</label>
                <div class="layui-input-block">
                  <input type="radio" name="sex" value="1" title="男" @if($info->sex==1) checked @endif>
                  <input type="radio" name="sex" value="0" title="女" @if($info->sex==0) checked @endif>
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">头像</label>
                <div class="layui-input-inline">
                  <input name="avatar" lay-verify="required" disabled id="LAY_avatarSrc" placeholder="图片地址" value="{{$info->avatar}}" class="layui-input">
                </div>
                <div class="layui-input-inline layui-btn-container" style="width: auto;">
                  <button type="button" class="layui-btn layui-btn-primary" id="LAY_avatarUpload">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                  </button>
                  <!--<button class="layui-btn layui-btn-primary" layadmin-event="avartatPreview">查看图片</button >-->
                </div>
             </div>
            <div class="layui-form-item">
                 <label class="layui-form-label"></label>
                <div class="layui-input-inline">
                    <div id="upload-image-preview" style="margin-top:0px;">
                        <img id="demo1" src="@if(isset($info->avatar)){{$info->avatar}} @else {{asset('resources/admin/images/nopic.jpeg')}} @endif" style="width:112px;height:80px">
                    </div> 
                </div>
            </div>
              <div class="layui-form-item">
                <label class="layui-form-label">手机</label>
                <div class="layui-input-inline">
                  <input type="text" name="tel" value="{{$info->tel}}" lay-verify="phone" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" name="email" value="{{$info->email}}" lay-verify="email" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                  <textarea name="remarks" placeholder="请输入内容" class="layui-textarea">{{$info->remarks}}</textarea>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmyinfo">确认修改</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重新填写</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
        layui.use(['layer','form','upload'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                upload = layui.upload,
                form = layui.form;
                //普通图片上传
		  var uploadInst = upload.render({
		    elem: '#LAY_avatarUpload'
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
		      if(res.code !=1){
		        return layer.msg('上传失败');
                        layer.closeAll('loading');
		      }
                      console.log(res);
		      //上传成功
		      $('#demo1').attr('src', res.src);
                      $('#LAY_avatarSrc').val(res.src);
		      layer.msg('上传成功');
		       layer.closeAll('loading');
		    }
		  });
                form.on('submit(setmyinfo)', function(data) {
                    var loadIndex = layer.load(2, {
                        shade: [0.3, '#333']
                    });
                    $.post("{{url('admin/info')}}", data.field, function(res) {
                         if (res.code!=1) {
                             layer.msg(res.msg, {
                                 icon: 2
                             });
                             loadIndex && layer.close(loadIndex);
                         } else {
                            layer.msg(res.msg);
                            loadIndex && layer.close(loadIndex);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                         }
                    }, 'json');
                    //return false;
                });
            
        });
    </script>
@endsection