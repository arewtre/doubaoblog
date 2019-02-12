<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>404 页面不存在</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
  <link href="{{asset('resources/admin/layuiadmin/style/admin.css')}}" rel="stylesheet">
</head>
<style>
    .layadmin-tips h3 {
    font-size: 50px;
    line-height: 50px;
    color: #009688;
}
.layadmin-tips .layui-text2 {
    width: 900px;
    margin: 30px auto;
    padding-top: 20px;
    border-top: 5px solid #009688;
    font-size: 16px;
}
</style>
<body>
<div class="layui-fluid">
  <div class="layadmin-tips">
    <i class="layui-icon" face>&#xe664;</i>
    <div class="layui-text">
      <h1>
        <span class="layui-anim layui-anim-loop layui-anim-">4</span> 
        <span class="layui-anim layui-anim-loop layui-anim-rotate">0</span> 
        <span class="layui-anim layui-anim-loop layui-anim-">4</span>
      </h1>
    </div>
    <h3>
        <span class="layui-anim layui-anim-loop layui-anim-">@if(!empty($info)) {{$info}} @endif</span> 
      </h3>
  </div>
</div>

<script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>
  <script>
window.onload = function(){

    setTimeout("history.back()", 40000);

}
  </script>
  
</body>
</html>