<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/style/admin.css')}}" media="all">
  <link id="layuicss-layer" rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/modules/layer/default/layer.css')}}" media="all">
  <script>
  /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
  </script>
  <script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>
  <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body class="layui-layout-body" layadmin-themealias="default" style="">
@yield('content')
  <script>
  layui.config({
    base: "{{asset('resources/admin/layuiadmin/')}}" //静态资源所在路径 
  }).extend({
    index: '/lib/index' //主入口模块
  }).use(['index','console','message']);
  function tips(msg,s,e,href){
    if(e!=1){
         layer.msg(msg, {
         icon: 5,
         shade: [0.6, '#393D49'],
         time:s
     });
        return;
    }else{
        layer.msg(msg, {time:s});
    }
    if(href!=""){
        setTimeout(function(){
           window.location.href = href;
        },s);
    }
    return false;
 }
  </script>
</body>
</html>