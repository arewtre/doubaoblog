@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/shijianchuo.png')}}" alt="Unix时间戳(timestamp)转换工具" />
    </div>
    <h1>Unix时间戳(timestamp)转换工具</h1>
    <div class="zuozhe">
     在线Unix时间戳转换工具
    </div>
   </div>
   <div class="content-a">
    <div class="toolcode">
     <!-- /工具开始 -->
     <h3>Unix时间戳(Unix timestamp) → 北京时间</h3>
     <input name="text" class="tooltext" id="timestamp" size="69" onblur="loadXMLDoc()" />
     <input type="button" value="转换为北京时间 ↓" onclick="loadXMLDoc()" class="bt-green" />
     <input type="text" name="result" class="tooltext" id="myDiv" />
    </div>
   </div>
  </div>
       @include('home/tool/right') 
   </div>
  </div>


<script>
    jQuery("#nv li").removeClass("a");
    jQuery("#mn_tool").addClass("a");

</script>
<script type="text/javascript">			
    window.onload = function(){
        var mydate = new Date();
        var timestamp = parseInt(mydate.getTime()/1000);
        document.getElementById('timestamp').value = timestamp;
    }
    function loadXMLDoc(){
        var xmlhttp;
        var timestamp = document.getElementById("timestamp").value;
        if (!timestamp) {
                alert('请输入需要转换的时间戳');
                return false;
        };
        if (isNaN(timestamp)) {
                alert('请输入正确的时间戳格式！');
                return false;
        };
        if (timestamp.length != 10) {
                alert('请输入十位数的时间戳！');
                return false;
        };
        if (window.XMLHttpRequest){
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }else{
          // code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                console.log(xmlhttp);
                document.getElementById("myDiv").value=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","{{url('timestamp')}}?timestamp="+timestamp,true);
        xmlhttp.send();
}
</script>
@endsection