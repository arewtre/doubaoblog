@extends('layouts.admin')
@section('content')
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmypass">确认修改</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
        layui.use(['layer','form'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                form = layui.form;
                form.on('submit(setmypass)', function(data) {
                    var loadIndex = layer.load(2, {
                        shade: [0.3, '#333']
                    });
                    $.post("{{url('admin/pass')}}", data.field, function(res) {
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