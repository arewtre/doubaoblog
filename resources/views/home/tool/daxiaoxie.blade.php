@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/daxiaoxie.png')}}" alt="字母大小写转换工具" />
    </div>
    <h1>字母大小写转换工具</h1>
    <div class="zuozhe">
     简单易用的英文字母大小写转换工具
    </div>
   </div>
    <script>
        function strtoup() {
    var cons = document.getElementById('con').value;
    if (!cons) {
        alert('请输入需要转换的内容!');
        return false;
    };
    var con = document.getElementById("con");
    con.value = con.value.toUpperCase();
}
function strtolow() {
    var cons = document.getElementById('con').value;
    if (!cons) {
        alert('请输入需要转换的内容!');
        return false;
    };
    var con = document.getElementById("con");
    con.value = con.value.toLowerCase();
}
function Empty() {
    document.getElementById('con').value = '';
    document.getElementById('con').select();
} 
    </script>
   <div class="content-a">
    <div class="toolcode">
     <textarea class="toolarea" id="con" name="content" style="padding:4px;color:#333;font-size:18px">
        http://linxinran.cn
     </textarea>
     <input class="bt-green" onclick="strtolow()" value="转换成小写" type="button" />
     <input class="bt-blue" onclick="strtoup()" value="转换成大写" type="button" />
     <input class="bt-grey" onclick="Empty();" value="清空结果" type="button" />
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

@endsection