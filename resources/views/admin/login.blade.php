<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="Bookmark" href="">
<link rel="Shortcut Icon" href="">
<title>{{Site::get('webname')}}</title>
<link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
<link href="{{asset('resources/home/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css'>
<link href="{{asset('resources/admin/login/normalize.css')}}" rel="stylesheet">
<link href="{{asset('resources/admin/login/demo.css')}}" rel="stylesheet">
<link href="{{asset('resources/admin/login/component.css')}}" rel="stylesheet">
<link href="{{asset('resources/admin/login/loginH5.css')}}" rel="stylesheet">
<link id="layuicss-layer" rel="stylesheet" href="{{asset('resources/admin/login/layer.css')}}" media="all">
<!--[if IE]>
    <script src="/test/static/kitadmin/plugins/sideshow/js/html5.js"></script>
<![endif]-->

</head>
<body class="kit-login-bg" style="">
    <div class="container demo-1">
        <div class="content">
            <div id="large-header" class="large-header" style="height: 949px;">
                <canvas id="demo-canvas" width="1035" height="949"></canvas>
                <div class="kit-login-box">
                    <header>
                        <h1>{{Site::get('webname')}} LOGIN</h1>
                    </header>
                    <div class="kit-login-main">
                        <form action="" class="layui-form" method="post" id="loginForm" novalidate="novalidate">
                            <div class="layui-form-item">
                                <label class="kit-login-icon">
                                    <i class="layui-icon"></i>
                                </label>
                                {{csrf_field()}} 
                                <input type="text" name="user_name" value="" lay-verify="required|username" placeholder="这里输入用户名." class="layui-input required" aria-required="true">
                            </div>
                            <div class="layui-form-item">
                                <label class="kit-login-icon">
                                    <i class="layui-icon"></i>
                                </label>
                                <input type="password" name="user_pass" lay-verify="required|password" autocomplete="off" placeholder="这里输入密码." class="layui-input required" aria-required="true">
                            </div>
                            <div class="layui-form-item">
                                <label class="kit-login-icon">
                                    <i class="layui-icon"></i>
                                </label>
                                <input type="text" name="code" lay-verify="required" autocomplete="off" placeholder="输入右侧验证码." class="layui-input required" aria-required="true">
                                <span class="form-code"  style="position:absolute;right:2px; top:2px;">
                                    <img src="{{url('admin/code')}}" style="height:34px" id="changeCode" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                                </span>
                            </div>
                            <div class="layui-form-item">
                                <div class="kit-pull-left kit-login-remember">
                                    <input type="checkbox" name="rememberMe" value="true" lay-skin="primary" checked="" title="记住帐号?"><div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary"><span>记住帐号?</span><i class="layui-icon"></i></div>
                                </div>
                                <div class="kit-pull-right">
                                    <span class="layui-btn layui-btn-primary" lay-submit="" lay-filter="login">
                                        <i class="fa fa-sign-in" aria-hidden="true"></i> 登录
                                    </span>
                                </div>
                                <div class="kit-clear">

                                </div>
                            </div>
                        </form>
                    </div>
                    <footer>
                        <p><a href="{{Site::get('webaddress')}}" style="color:white; font-size:14px;" target="_blank">{{Site::get('copyright')}}</a></p>
                        <p style="color:white; font-size:14px;">{{Site::get('bottominfo')}}</p>
                        <div style="margin-left: 100px;">
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <!-- /container -->

    <script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>
    <script src="{{asset('resources/admin/login/TweenLite.min.js')}}"></script>
    <script src="{{asset('resources/admin/login/EasePack.min.js')}}"></script>
    <script src="{{asset('resources/admin/login/rAF.js')}}"></script>
    <script src="{{asset('resources/admin/login/demo-1.js')}}"></script>

    <script src="{{asset('resources/admin/login/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/admin/login/jquery.validate.js')}}" type="text/javascript"></script>
    <script src="{{asset('resources/admin/login/validate-methods.js')}}" type="text/javascript"></script>
    <script>
        // 如果在框架或在对话框中，则弹出提示并跳转到首页
        if(self.frameElement && self.frameElement.tagName == "IFRAME" || $('#left').length > 0 || $('.jbox').length > 0){
                alert('未登录或登录超时。请重新登录，谢谢！');
                top.location = "/admin/login";
        }
    
        layui.use(['layer','form'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                form = layui.form;

            var index = layer.load(2, {shade: [0.3, '#333']});
            $(window).on('load', function() {
                layer.close(index);
                $("#loginForm").validate({
                    rules: {
                        validateCode: {remote: "/test/validateCodeServlet"}
                    },
                    messages: {
                        username: {required: "请填写用户名."},
                        password: {required: "请填写密码."},
                        validateCode: {remote: "验证码不正确.", required: "请填写验证码."}
                    },
                    errorLabelContainer: "#messageBox",
                    errorPlacement: function(error, element) {
                         if (element.is(":checkbox")||element.is(":radio")||element.parent().is(".input-append")){
                            error.appendTo(element.parent().parent());
                         } else {
                            error.insertAfter(element);
                         }
                    }
                });
                form.verify({
                    username: function(value, item){ //value：表单的值、item：表单的DOM对象
                        if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                            return '用户名不能有特殊字符';
                        }
                        if(/(^\_)|(\__)|(\_+$)/.test(value)){
                            return '用户名首尾不能出现下划线\'_\'';
                        }
                        if(/^\d+\d+\d$/.test(value)){
                            return '用户名不能全为数字';
                        }

                    }
                    //我们既支持上述函数式的方式，也支持下述数组的形式
                    //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
                    ,password: [/^[\S]{5,12}$/,'密码必须5到12位，且不能出现空格']
                });
                form.on('submit(login)', function(data) {
                    var loadIndex = layer.load(2, {
                        shade: [0.3, '#333']
                    });
                    $.post("{{url('admin/login')}}", data.field, function(res) {
                         if (res.code!=1) {
                             layer.msg(res.msg, {
                                 icon: 2
                             });
                             loadIndex && layer.close(loadIndex);
                             $('#changeCode').click(); //刷新验证码
                         } else {
                            layer.msg(res.msg);
                            loadIndex && layer.close(loadIndex);
                            setTimeout(function() {
                                window.top.location.href = "{{url('admin/index')}}"
                            }, 1500);
                         }
                    }, 'json');
                    //return false;
                });
            }());
        });
    </script>
    <div class="layui-layer-move">    
    </div>
</body>
</html>