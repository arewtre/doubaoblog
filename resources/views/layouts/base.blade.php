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
  <script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>  
  <script src="{{asset('resources/admin/js/public.js')}}"></script>
  
  <link rel="stylesheet" href="{{asset('resources/admin/kindeditor/themes/default/default.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('resources/admin/kindeditor/themes/default/upload.css')}}" type="text/css">
  <script src="{{asset('resources/admin/kindeditor/kindeditor-all-min.js')}}"></script>
<!--  <link rel="stylesheet" href="{{asset('resources/home/default/css/public.css')}}">
<link rel="stylesheet" href="{{asset('resources/home/vendor/org/style/font/css/font-awesome.min.css')}}">-->
<!--<link rel="stylesheet" href="{{asset('resources/home/default/css/admin/adminPublic.css')}}">-->
  <script>
  /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
  </script>
  <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
  <style>
.layui-card{
	padding:15px;
}
a {
    text-decoration: none !important;
}
.layui-btn {
    display: inline-block;
/*    height: 28px;
    line-height: 28px;
    padding: 0 14px;*/
    /*background-color: #009688;*/
    color: #fff;
    white-space: nowrap;
    text-align: center;
    font-size: 14px;
    border: none;
    border-radius: 2px;
    cursor: pointer;
}
.layui-form-checkbox[lay-skin=primary] i {
    top: 1px;
}
.main_box {
    position: fixed;
    left: 20px;
    /*right: 0px;*/
    top: 20px;
    bottom: 35px;
}
.main_box .con .conMain {
    float: left;
    width: 100%;
    margin-top: 0px;
    max-width: 100%;
}
.layui-input{
/*    width: 350px;*/
    margin-right: 5px;
    padding: 0px 5px;
    /*line-height: 38px !important;*/
    /*height: 38px !important;*/
    font-size: 12px;
}
label{
    margin-right: 0 !important;
}
.layui-elem-quote {
    margin-bottom: 10px;
    padding: 15px;
    line-height: 22px;
    border-left: 5px solid #009688;
    border-radius: 0 2px 2px 0;
    background-color: #fff;
}
  </style>
  <script src="{{asset('resources/home/js/jquery-2.1.3.min.js')}}"></script>
  <script>
        function Format(datetime,fmt) {
            if (parseInt(datetime)==datetime) {
              if (datetime.length==10) {
                datetime=parseInt(datetime)*1000;
              } else if(datetime.length==13) {
                datetime=parseInt(datetime);
              }
            }
            datetime=new Date(datetime);
            var o = {
            "M+" : datetime.getMonth()+1,                 //月份   
            "d+" : datetime.getDate(),                    //日   
            "h+" : datetime.getHours(),                   //小时   
            "m+" : datetime.getMinutes(),                 //分   
            "s+" : datetime.getSeconds(),                 //秒   
            "q+" : Math.floor((datetime.getMonth()+3)/3), //季度   
            "S"  : datetime.getMilliseconds()             //毫秒   
            };   
            if(/(y+)/.test(fmt))   
            fmt=fmt.replace(RegExp.$1, (datetime.getFullYear()+"").substr(4 - RegExp.$1.length));   
            for(var k in o)   
            if(new RegExp("("+ k +")").test(fmt))   
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
            return fmt;
          }

        $.fn.stringifyArray = function(array) {
        return JSON.stringify(array)
    }

    $.fn.parseArray = function(array) {
        return JSON.parse(array)
    }
layui.use(['table','form','layer'], function () {
            var table = layui.table,form=layui.form,layer=layui.layer;
        });
    function ajaxRequest(url,data){
        //console.log(data);
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            cache: false,
            data: {data:data},
            success:function(s){
               if(s.code==1) {
                layer.msg(s.msg, { icon: 6 ,time:1500});
                setTimeout(function(){
                    location.reload(); 
                 },1500)
             }else{
                layer.msg("操作失败", { icon: 6 }); 
             }
           }
      })
      return false;
    }

</script>
</head>
<body onbeforeunload="checkLeave()">
@yield('content')
  <script>
  layui.config({
    base: "{{asset('resources/admin/layuiadmin/')}}" //静态资源所在路径 
  }).extend({
    index: '/lib/index' //主入口模块
  }).use(['index','console']);
  function checkLeave(){
      document.onreadystatechange = subSomething;
      var index = layer.load(1, {
            shade: [0.5,'#fff'] //0.1透明度的白色背景
          });

  }
  function subSomething() 
    { 
       if(document.readyState == "loading"){ //当页面加载状态 
            var index = layer.load(1, {
            shade: [0.5,'#fff'] //0.1透明度的白色背景
          });
       } 
       if(document.readyState == "complete"){
       
               layer.close(index);
       }
    }
  </script>  
</body>
</html>