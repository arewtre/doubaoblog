@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/geshihua.png')}}" alt="JS/HTML格式化工具" />
    </div>
    <h1>JS/HTML格式化工具</h1>
    <div class="zuozhe">
     简单易用的JS/HTML格式化工具
    </div>
   </div>
   <!--<script type="text/javascript" src="{{asset('resources/home/tools/js/tools/base.js')}}"></script>-->
   <script type="text/javascript" src="{{asset('resources/home/tools/js/tools/jsformat.js')}}"></script>
   <script type="text/javascript" src="{{asset('resources/home/tools/js/tools/htmlformat.js')}}"></script>
   <script type="text/javascript">function do_js_beautify() {
        document.getElementById('beautify').disabled = true;
        js_source = document.getElementById('content').value.replace(/^\s+/, '');
        tabsize = document.getElementById('tabsize').value;
        tabchar = ' ';
        if (tabsize == 1) {
            tabchar = '\t';
        }
        if (js_source && js_source.charAt(0) === '<') {
            document.getElementById('content').value = style_html(js_source, tabsize, tabchar, 80);
        } else {
            document.getElementById('content').value = js_beautify(js_source, tabsize, tabchar);
        }
        document.getElementById('beautify').disabled = false;
        return false;
    }
    function pack_js(base64) {
        var input = document.getElementById('content').value;
        var packer = new Packer;
        if (base64) {
            var output = packer.pack(input, 1, 0);
        } else {
            var output = packer.pack(input, 0, 0);
        }
        document.getElementById('content').value = output;
    }
    function Empty() {
        document.getElementById('content').value = '';
        document.getElementById('content').select();
    }
    function GetFocus() {
        document.getElementById('content').focus();
    }
</script>
   <div class="content-a">
    <div class="toolcode">
     <h3>请在下框输入您要转换的内容:</h3>
     <form>
      <textarea class="toolarea" id="content" name="content">/* 粘贴你代码到这里并点击格式化按钮 */ /* 例如格式化以下这段代码 */ if('this_is'==/an_example/){do_something();}else{var a=b?(c%d):e[f];} </textarea>
      <select id="tabsize" name="tabsize"><option value="1">制表符缩进</option><option value="2">2个空格缩进</option><option selected="selected" value="4">4个空格缩进</option><option value="8">8个空格缩进</option></select>
      <input id="beautify" class="bt-green" onclick="return do_js_beautify()" value="格式化代码" type="button" />
      <input class="bt-blue" onclick="pack_js(0)" value="普通压缩" type="button" />
      <input class="bt-blue" onclick="pack_js(1)" value="加密压缩" type="button" />
      <input class="bt-grey" onclick="Empty();" value="清空结果" type="button" />
     </form>
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