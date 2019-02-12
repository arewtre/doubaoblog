@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <style>
      .tools_list{
          /*padding:0 40px;*/
      }
  </style>
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left">
        <div class="title">
            <div class="icon"><img src="{{asset('resources/home/tools/images/cssformat.png')}}" alt="css格式化工具"></div>
            <h1>CSS代码格式化工具</h1>
            <div class="zuozhe">可实现CSS代码格式化和CSS在线压缩</div>
        </div>
        <div class="content-a">
            <div class="toolcode">
            <!-- /工具开始 -->
                <h3>请将CSS代码复制到下面表单中:</h3>
                <textarea class="toolarea" id="code"></textarea>
                <input class="bt-green" onclick="$('code').value = CSSencode($('code').value);" value="横向排列" type="button">
                <input class="bt-blue" onclick="$('code').value = CSSdecode($('code').value);" value="竖向排列" type="button">
                <input class="bt-grey" onclick="Empty();" value="清空结果" type="button">
            </div>
        </div>
    </div>
       @include('home/tool/right') 
   </div>
  </div>

<script>
    jQuery("#nv li").removeClass("a");
    jQuery("#mn_tool").addClass("a");

        function $() { 
                var elements = new Array(); 
                for (var i = 0; i < arguments.length; i++) { 
                        var element = arguments[i]; 
                        if (typeof element == 'string') 
                        element = document.getElementById(element); 
                        if (arguments.length == 1)  
                        return element;    
                        elements.push(element); 
                }    
                return elements; 
        }  

        function CSSencode(code){ 
                code = code.replace(/\r\n/ig,''); 
                code = code.replace(/(\s){2,}/ig,'$1'); 
                code = code.replace(/\t/ig,''); 
                code = code.replace(/\n\}/ig,'\}'); 
                code = code.replace(/\n\{\s*/ig,'\{'); 
                code = code.replace(/(\S)\s*\}/ig,'$1\}'); 
                code = code.replace(/(\S)\s*\{/ig,'$1\{'); 
                code = code.replace(/\{\s*(\S)/ig,'\{$1'); 
                return code; 
        } 

        function CSSdecode(code){ 
                code = code.replace(/(\s){2,}/ig,'$1'); 
                code = code.replace(/(\S)\s*\{/ig,'$1 {'); 
                code = code.replace(/\*\/(.[^\}\{]*)}/ig,'\*\/\n$1}'); 
                code = code.replace(/\/\*/ig,'\n\/\*'); 
                code = code.replace(/;\s*(\S)/ig,';\n\t$1'); 
                code = code.replace(/\}\s*(\S)/ig,'\}\n$1'); 
                code = code.replace(/\n\s*\}/ig,'\n\}'); 
                code = code.replace(/\{\s*(\S)/ig,'\{\n\t$1'); 
                code = code.replace(/(\S)\s*\*\//ig,'$1\*\/'); 
                code = code.replace(/\*\/\s*([^\}\{]\S)/ig,'\*\/\n\t$1'); 
                code = code.replace(/(\S)\}/ig,'$1\n\}'); 
                code = code.replace(/(\n){2,}/ig,'\n'); 
                code = code.replace(/:/ig,':'); 
                code = code.replace(/  /ig,' '); 
                return code; 
        } 

        function Empty() {
        document.getElementById('code').value = '';
        document.getElementById('code').select();
    }
</script>

@endsection