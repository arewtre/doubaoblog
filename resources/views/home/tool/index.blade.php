@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <script src="{{asset('resources/home/tools/js/jquery.lazyload.mini.js')}}"  type="text/javascript"></script>
  <script src="{{asset('resources/home/tools/js/xcConfirm.js')}}" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" src="{{asset('resources/home/tools/js/common.js-v2.9.2')}}" ></script>
  <script src="{{asset('resources/home/tools/layer/layer.js')}}" ></script>
  <script type="text/javascript" src="{{asset('resources/home/tools/js/qrcode.min.js')}}"></script>
  <style>
      .tools_list{
          /*padding:0 40px;*/
      }
  </style>
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_title fl">
     <h1>&quot;工欲善其事，必先利其器。&quot;——孔子《论语&middot;卫灵公》</h1>
    </div>
    <div class="tools_list fl">
     <dl>
      <dt>
       格式化：
      </dt>
      <dd>
       <a href="{{url('css')}}"  target="_blank">
           <img src="{{asset('resources/home/tools/images/cssformat.png')}}"  alt="CSS代码格式化工具" /> CSS代码格式化工具 <span>可实现CSS代码格式化和CSS在线压缩</span></a>
      </dd>
      <dd>
       <a href="{{url('jsformat')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/geshihua.png')}}" alt="JS/HTML格式化工具" /> JS/HTML格式化工具 <span>简单易用的JS/HTML格式化工具</span></a>
      </dd>
     </dl>
    </div>
    <div class="tools_list fl">
     <dl>
      <dt>
       代码转换：
      </dt>
      <dd>
       <a href="{{url('htmljs')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/htmljs.png')}}" alt="HTML/JS转换工具" /> HTML/JS转换工具 <span>简单易用的html代码和js代码互转工具</span></a>
      </dd>
      <dd>
       <a href="{{url('timestamp')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/shijianchuo.png')}}"  alt="Unix时间戳转换工具" /> Unix时间戳转换工具 <span>在线Unix时间戳转换工具</span></a>
      </dd>
      <dd>
       <a href="{{url('utf8')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/utf-8.png')}}" alt="Unix时间戳转换工具" /> UTF-8编码转换工具 <span>可实现UTF-8编码转换</span></a>
      </dd>
     </dl>
    </div>
    <div class="tools_list fl">
     <dl>
      <dt>
       加密解密：
      </dt>
      <dd>
       <a href="{{url('md5str')}}"  target="_blank">
           <img src="{{asset('resources/home/tools/images/md5.png')}}" alt="MD5加密工具" /> MD5加密工具 <span>在线MD5加密工具</span></a>
      </dd>
      <dd>
       <a href="{{url('url')}}"  target="_blank">
           <img src="{{asset('resources/home/tools/images/url.png')}}"  alt="URL网址16进制加密工具" /> URL网址16进制加密工具 <span>在线网址URL16进制加密工具</span></a>
      </dd>
     </dl>
    </div>
    <div class="tools_list fl">
     <dl>
      <dt>
       文字处理：
      </dt>
      <dd>
       <a href="{{url('daxiaoxie')}}"  target="_blank">
           <img src="{{asset('resources/home/tools/images/daxiaoxie.png')}}" alt="字母大小写转换工具" /> 字母大小写转换工具 <span>简单易用的英文字母大小写转换工具</span></a>
      </dd>
      <dd>
       <a href="{{url('zishutongji')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/zishutongji.png')}}" alt="在线字数统计工具" /> 在线字数统计工具 <span>在线字数统计工具</span></a>
      </dd>
     </dl>
    </div>
    <div class="tools_list fl">
     <dl>
      <dt>
       其他小工具：
      </dt>
      <dd>
       <a href="{{url('jsq')}}" target="_blank">
           <img src="{{asset('resources/home/tools/images/jsq.png')}}" alt="在线科学计算器" /> 在线科学计算器 <span>在线科学计算器</span></a>
      </dd>
     </dl>
    </div>
    <div class="tools_list_blank fl"></div>
   </div>
  </div>
  
  <!-- 返回顶部 开始 -->
  <div id="elevator_item">
   <a id="elevator" onclick="return false;" title="回到顶部"></a>
  </div>
  <script type="text/javascript">
/* scroll to top */
$(function() {
  $(window).scroll(function(){
    var scrolltop=$(this).scrollTop();    
    if(scrolltop>=200){   
      $("#elevator_item").show();
    }else{
      $("#elevator_item").hide();
    }
  });   
  $("#elevator").click(function(){
    $("html,body").animate({scrollTop: 0}, 500);  
  });   
});
</script> 


  
<script>
jQuery("#nv li").removeClass("a");
jQuery("#mn_tool").addClass("a");
layui.use('layim', function(layim){
  //先来个客服模式压压精
  
});
</script>
@endsection