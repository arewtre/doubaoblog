@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/utf-8.png')}}" alt="UTF-8编码转换工具" />
    </div>
    <h1>UTF-8编码转换工具</h1>
    <div class="zuozhe">
     可实现UTF-8编码转换
    </div>
   </div>
   <div class="content-a">
    <div class="toolcode">
     <!-- /工具开始 -->
     <h3>UTF-8编码在线转工具可以帮助你把中文转换成UTF-8编码，同时也支持把UTF-8编码过的还原成中文：</h3>
     <textarea id="contents" name="contents" class="toolarea">请把你需要转换的内容粘贴在这里。</textarea>
     <input class="bt-green" type="button" value="中文 转换 UTF-8 ↓" onclick="ConvUtf(contents,this);" />
     <input class="bt-blue" type="button" value="UTF-8 还原 中文 ↑" onclick="ResChinese(result,this);" />
     <input class="bt-grey" type="button" value="清空结果" onclick="jQuery('#result').val('');" />
     <textarea id="result" name="result" class="toolarea"></textarea>
     <script type="text/javascript">
         function ConvUtf(obj,btn) { 
            document.getElementById("result").value = obj.value.replace(/[^\u0000-\u00FF]/g,function ($0) { 
                return escape($0).replace(/(%u)(\w { 4 })/gi, "&#x$2; ") 
            }); 
        }
        function ResChinese(obj,btn) { 
            document.getElementById("contents").value = unescape(obj.value.replace(/&#x/g, '%u').replace(/; /g, ''));
        }
</script>
     <!-- /工具结束 -->
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