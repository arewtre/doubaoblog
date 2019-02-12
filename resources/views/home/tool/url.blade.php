@extends('layouts.home')
@section('content')
  <link href="{{asset('resources/home/tools/css/main.css-v2.9.2.css')}}" type="text/css" rel="stylesheet" />
  <div id="main" style="margin-top:20px;padding:0 40px;">
   <div class="main" style="background-color:#fff;">
    <div class="tools_left fl">
   <div class="title">
    <div class="icon">
     <img src="{{asset('resources/home/tools/images/url.png')}}" alt="URL网址16进制加密工具" />
    </div>
    <h1>URL网址16进制加密工具</h1>
    <div class="zuozhe">
     在线网址URL16进制加密工具
    </div>
   </div>
   <div class="content-a">
    <div class="toolcode">
     <!-- /工具开始 -->
     <script language="javascript">    
         function urlCrypt(){
        var str2='';
        str = jQuery('#codeText').val();
        str3 = str.substring(0,7);
        if(str3 == 'http://'){
            str2 = 'http://';
            str = str.substring(7,str.length);
        }
        for(i=0;i<str.length;i++){
            if(str.charCodeAt(i) == '47') str2 += '/';
            else if(str.charCodeAt(i) == '63') str2 += '?';
            else if(str.charCodeAt(i) == '38') str2 += '&';     
            else if(str.charCodeAt(i) == '61') str2 += '='; 
            else if(str.charCodeAt(i) == '58') str2 += ':'; 
            else str2 += '%'+str.charCodeAt(i).toString(16);
        }
        jQuery('#rsCode').val(str2);
        getid('codeText').focus();
    }
    </script>
     <p>请输入你要加密的网址：<br />
         <input type="text" class="tooltext" id="codeText" value="http://www.linxinran.cn" />
         <button onclick="urlCrypt()" class="bt-green">加 密</button>
         <textarea class="tooltext" id="rsCode" style="height:120px"></textarea>
     </p>
     <p>小贴士：加密后拷贝到地址栏回车即可看到效果~ </p>
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