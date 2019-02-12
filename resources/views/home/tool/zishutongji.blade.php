@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/zishutongji.png')}}" alt="字数统计工具" />
    </div>
    <h1>字数统计工具</h1>
    <div class="zuozhe">
     可快速在线统计字数
    </div>
   </div>
        <script type = "text/javascript" >
function strtoup() {
    var str = document.getElementById('con').value;
    var hzreg = /[\u4E00-\u9FA5]/g;
    var zmreg = /[a-zA-Z]/g;
    var szreg = /[0-9]/g;
    if (hzreg.test(str)) {
        document.getElementById('hz').innerHTML = str.match(hzreg).length;
    } else {
        document.getElementById('hz').innerHTML = 0;
    }
    if (zmreg.test(str)) {
        document.getElementById('zm').innerHTML = str.match(zmreg).length;
    } else {
        document.getElementById('zm').innerHTML = 0;
    }
    if (szreg.test(str)) {
        document.getElementById('sz').innerHTML = str.match(szreg).length;
    } else {
        document.getElementById('sz').innerHTML = 0;
    }
    document.getElementById('zs').innerHTML = str.length;
};
function Empty() {
    document.getElementById('con').value = '';
    document.getElementById('con').select();
} </script>
   <div class="content-a">
    <div class="toolcode">
     <h3>这是一个快速计算字数和字符数的小工具（小说作者和或编辑必备工具）：</h3>
     <textarea id="con" name="content" class="toolarea">在线字数统计 工欲善其事，必先利其器。 显而易见，最高的效率就是对现有材料的最佳利用。学会偷懒，并懒出境界是提高工作效率最有效的方法！ js代码网为网页前端人员提供建站常用的网页js代码,js特效代码,收集互联网最新最全的js特效代码,内容涵盖焦点图,导航菜单,jQuery代码,jQuery特效,相册代码,图片特效,在线客服,返回顶部,网站模板,网页模板,html5,css3等js特效代码大全。 js代码 http://www.jsdaima.com/ 2016 </textarea>
     <input onclick="strtoup()" type="button" value="字数统计" class="bt-green" />
     <input class="bt-grey" onclick="Empty();" value="清空结果" type="button" />
     <br /> 汉字：
     <span id="hz" class="num">0</span> 个
     <br /> 英文：
     <span id="zm" class="num">0</span> 个 （含英文状态下的数字、符号、标点）
     <br /> 数字：
     <span id="sz" class="num">0</span> 个
     <br /> 字符总数：
     <span id="zs" class="num">0</span> 个字符
     <br />
     <br />
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