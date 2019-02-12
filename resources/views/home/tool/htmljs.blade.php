@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/htmljs.png')}}" alt="HTML/JS转换工具" />
    </div>
    <h1>HTML/JS转换工具</h1>
    <div class="zuozhe">
     简单易用的html代码和js代码互转工具
    </div>
   </div>
   <div class="content-a">
    <div class="toolcode">
     <!-- /工具开始 -->
     <script language="JavaScript">     function rechange(){
     document.getElementById('re').value=document.getElementById('oresult').value.replace(/document.writeln\("/g,"").replace(/"\);/g,"").replace(/\\\"/g,"\"").replace(/\\\'/g,"\'").replace(/\\\//g,"\/").replace(/\\\\/g,"\\")
     }
     function change(){
     document.getElementById('oresult2').value="document.writeln(\""+document.getElementById('osource').value.replace(/\\/g,"\\\\").replace(/\\/g,"\\/").replace(/\'/g,"\\\'").replace(/\"/g,"\\\"").split('\n').join("\");\ndocument.writeln(\"")+"\");"
     }
 </script>
     <h2>HTML转JS代码工具</h2>
     <h3>请将Html源代码粘贴到下面表单中:</h3>
     <textarea class="toolarea" id="osource" onfocus="change()" onkeyup="change()"></textarea>
     <h3>下面表单中是相应的Js代码:</h3>
     <textarea class="toolarea" id="oresult2"></textarea>
     <br />
     <h2>JS转HTML代码工具</h2>
     <h3>请将Js源代码粘贴到下面表单中:</h3>
     <textarea class="toolarea" id="oresult" onfocus="rechange()" onkeyup="rechange()"></textarea>
     <h3>下面表单中是相应的Html代码:</h3>
     <textarea class="toolarea" id="re"></textarea>
    </div>
   </div>
  </div>
       @include('home/tool/right') 
   </div>
  </div>


 <script type="text/javascript" src="{{asset('resources/home/tools/js/tools/jsformat.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/home/tools/js/tools/htmlformat.js')}}"></script> 
<script>
    jQuery("#nv li").removeClass("a");
    jQuery("#mn_tool").addClass("a");

</script>

@endsection