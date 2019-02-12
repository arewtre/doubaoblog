@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/md5.png')}}" alt="MD5加密工具" />
    </div>
    <h1>MD5加密工具</h1>
    <div class="zuozhe">
     可实现MD5在线加密
    </div>
   </div>
   <div class="content-a">
    <div class="toolcode">
     <!-- /工具开始 -->
     <h3>请输入欲加密的字符串：</h3>
     <input name="text" class="tooltext" id="test" value="www.linxinran.cn" size="69" />
     <input onclick="loadXMLDoc()" type="button" value="32位小写" class="bt-green" />
     <input onclick="loadXMLDoc2()" type="button" value="32位大写" class="bt-blue" />
     <br />
     <br />
     <h3>转换后的MD5密文:</h3>
     <textarea id="ye" name="MD5Text" class="toolarea" style="padding:4px;color:#333;display:block;font-size:24px"></textarea> 小贴士：md5加密是一种不可逆的加密算法。 
    </div>
   </div>
  </div>
       @include('home/tool/right') 
   </div>
  </div>

<script>
    jQuery("#nv li").removeClass("a");
    jQuery("#mn_tool").addClass("a");

    function loadXMLDoc(){
        var xmlhttp;
        var md5str = document.getElementById("test").value;
        if (!md5str) {
                alert('请输入需要加密的MD5字符串');
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
                document.getElementById("ye").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","{{url('md5str')}}?md5str="+md5str,true);
        xmlhttp.send();
}

function loadXMLDoc2(){
        var xmlhttp;
        var md5str2 = document.getElementById("test").value;
        if (!md5str2) {
                alert('请输入需要加密的MD5字符串');
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
                document.getElementById("ye").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","{{url('md5str')}}?md5str2="+md5str2,true);
        xmlhttp.send();
}
</script>


@endsection