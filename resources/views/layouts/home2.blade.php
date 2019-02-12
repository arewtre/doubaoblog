<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" charset="utf-8">
    <title>{{$detail->art_title}}</title>
    <!--<link rel="canonical" href="http://linxinran.cn/" />--> 
    <meta name="_token" content="{{ csrf_token() }}" /> 
    <meta name="keywords" content="{{$detail->keywords}}" /> 
    <meta name="description" content="{{$detail->art_description}}_{{Site::get('webname')}} " /> 
    <meta name="generator" content="DouCMS1.0" /> 
    <meta name="author" content="九月一十八" /> 
    <meta name="copyright" content="2017-2018 Comsenz Inc." /> 
    <meta name="MSSmartTagsPreventParsing" content="True" /> 
    <meta http-equiv="MSThemeCompatible" content="Yes" /> 
    <meta name="application-name" content="豆宝官网" /> 
    <meta name="msapplication-tooltip" content="豆宝官网" /> 
    <!--<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />-->
    <script type="text/javascript">var STYLEID = '2', STATICURL = 'resources/wap/static/', IMGDIR = 'resources/wap/static/image/common', VERHASH = 'pCV', charset = 'utf8', discuz_uid = '1', cookiepre = 'OZJL_2132_', cookiedomain = '', cookiepath = '/', showusercard = '1', attackevasive = '0', disallowfloat = 'newthread', creditnotice = '1|威望|,2|金钱|,3|贡献|', defaultstyle = '', REPORTURL = '', SITEURL = 'http://linxinran.cn/', JSPATH = 'resoruces/home/js';</script>
    <!--<meta name="msapplication-task" content="name=首页;action-uri={{Site::get('webaddress')}};icon-uri=favicon.ico">-->
    <link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_common.css')}}" />
    <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
    <script src="{{asset('resources/home/js/jquery-1.11.0.min.js')}}" type="text/javascript"></script> 
    <script src="{{asset('resources/home/js/common.js')}}" type="text/javascript"></script> 
    <script src="{{asset('resources/home/js/portal.js')}}" type="text/javascript"></script> 
    <script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>
       <script src="{{asset('resources/home/js/jquery.SuperSlide.js')}}" type="text/javascript"></script> 
    <script type="text/javascript"> jQuery.noConflict();</script>
     {!! Site::get("statistics_code") !!}
  <script>
jQuery(document).ready(function(){
    jQuery("#hd").removeClass("fixed");
    jQuery(window).bind("scroll",function(){
    var mTop = jQuery(".xr_hd").offset().top;
    console.log(mTop);
    if(jQuery(window).scrollTop()>=mTop){
        jQuery("#hd").addClass("fixed");
    }else{
        jQuery("#hd").removeClass("fixed");
    }
    });
});
</script> 
<style>
    .layui-laypage a, .layui-laypage span {
    display: inline-block;
    vertical-align: middle;
    padding: 0 12px;
    height: 24pk;
    line-height: 24px;
    margin: 0 -1px 5px 5px;
    background-color: #fff;
    color: #333;
    font-size: 12px;
}
.layui-laypage .layui-laypage-curr .layui-laypage-em {
    position: absolute;
    left: 0px;
    top: 0px;
    padding: 2px 4px;
    width: 24px;
    height: 24px;
    background-color: #FF7F84;
}
.layui-laypage a, .layui-laypage span {
    display: inline-block;
    vertical-align: middle;
    padding: 0 12px;
    height: 24pk;
    line-height: 24px;
    margin: 0 -1px 5px 5px;
    /*background-color: #E3E5E8;*/
    color: #333;
    font-size: 12px;
}
.deandenglu {
    float: right;
    width: 280px;
    padding-right: 10px;
    margin-top:14px;
}
.deanunlogin {
    float: right;
    padding-top: 3px;
}
.deanunlogin li {
    float: left;
    margin-left: 2px;
}
.deanqqlogin a {
    width: 17px;
    height: 30px;
    display: block;
    background: url(http://discuz091.yhpu.cn/template/df_yxk/deancss/qq.png) 0 6px no-repeat;
}
.deanregister a {
    color: #e99605;
    line-height: 28px;
    padding-left: 15px;
    padding-right: 15px;
    display: block;
    border-radius: 3px;
    font-size: 14px;
    font-family: microsoft yahei;
}
.deanlogin a {
    color: #7b7b7b;
    line-height: 28px;
    padding-left: 15px;
    padding-right: 15px;
    display: block;
    border-radius: 3px;
    font-size: 14px;
    font-family: microsoft yahei;
}
#xinrui_mobilereg_menu li{float:left;margin:0 5px;}
#xinrui_mobilereg_menu li a{ line-height: 36px;height:36px;}
#xinrui_login_menu li{clear:both}
#xinrui_login_menu li a{ line-height: 18px; padding: 3px 5px;}
#xinrui_qq_menu li{clear:both}
#xinrui_qq_menu li a{ line-height: 18px; padding: 3px 5px;}
#toptb .qq_login .showmenu{padding-right: 15px;}
</style>
 </head> 
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
      <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
<style>

</style> 
 </head> 
<body id="nv_portal" class="pg_index" onkeydown="if(event.keyCode==27) return false;" style=""> 
  <div id="append_parent"></div>
  <div id="ajaxwaitid"></div> 
  <div id="toptb"></div>
  <!--<div style="clear:both"></div>-->
  <div id="qmenu_menu" class="p_pop blk" style="display: none;"> 
   <div class="ptm pbw hm">
     请 
    <a href="javascript:;" class="xi2" onclick="lsSubmit()"><strong>登录</strong></a> 后使用快捷导航
    <br />没有帐号？
    <a href="" class="xi2 xw1">立即注册</a> 
   </div> 
   <div id="fjump_menu" class="btda"></div>
  </div>
  <div class="xr_hd"> 
   <div id="hd" class="fixed"> 
    <div class="wp cl">
    <a href="{{url('/')}}" title="{{Site::get('webname')}}">
        <h1 class="logo z">
             <!--<img style="height:50px;margin-top:3px" src="{{Site::get('webimg')}}" alt="{{Site::get('webname')}}" border="0" />-->
             Doubao
        </h1> 
    </a>

     <div id="nv" class="z"> 
      <ul>
       <li class="a" id="mn_portal"><a href="{{url('/')}}" hidefocus="true" title="Portal">首页<span>Portal</span></a></li>
       <li id="mn_N6e26" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'hover','duration':2})">
           <a href="{{url('news')}}" hidefocus="true">资讯</a>
       </li>
       <li id="mn_N6e20" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'hover','duration':2})">
           <a href="{{url('blog')}}" hidefocus="true">博客</a>
       </li>
       <li id="mn_forum" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'hover','duration':2})">
           <a href="{{url('forum')}}" hidefocus="true" title="BBS">论坛</span></a>
       </li>
       <li id="mn_tool" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'hover','duration':2})">
           <a href="{{url('tool')}}" hidefocus="true">工具</a>
       </li>
       <li id="mn_N2905"><a href="{{url('guide')}}" hidefocus="true">导读</a></li>
       <li id="mn_Nb67d"><a href="{{url('imageXc')}}" hidefocus="true">照片墙</a></li>
       <li id="mn_video"><a href="{{url('forum_list/80')}}" hidefocus="true">视频</a></li>
       <!--<li id="mn_im"><a href="javascript:;"title="联系客服" style="color: yellow" onclick="showIm()" class="scrolltopa">联系客服</a></li>-->
       <!--<li id="mn_N03aa"><a href="{{url('wap')}}" hidefocus="true" target="_blank" style="color: yellow">手机版</a></li>-->
      </ul> 
     </div> 
     <style type="text/css">.h_avatar,.xr_tl td.o{vertical-align:top}.xr_tl td.o input{margin-top:10px;}.xr_videoList{margin:5px 0;}.xrVideoInfo{color:#999;line-height:22px;font-size:13px;margin-bottom:5px;}.xrVideo li{float:left; margin-right:10px; margin-top:6px;}.xrVideo li,.xrOneVideo li {display:block;width:380px;height:280px;text-align:center;position:relative;}.pct .pcb td li{list-style:none;margin:0;} </style> 
     <style type="text/css">.h_avatar,.xr_tl td.o{vertical-align:top}.xr_tl td.o input{margin-top:10px;}.xinruiOneImg span{display:block;}.tl_picList{margin:5px 0;}.xinruiInfo{color:#999;line-height:22px;font-size:13px;}.xinruiPic li{width:92px;height:92px;float:left; margin-right:10px; margin-top:6px;}.xinruiPic span,.xinruiOneImg li span{display:block;width:90px;height:90px;background:#fff;border:solid 1px #eee; border-radius:3px; overflow:hidden; text-align:center; position:relative; cursor:url(source/plugin/xinrui_list_pic/images/cur_zin.cur),pointer; _cursor:url(source/plugin/xinrui_list_pic/images/cur_zin.cur),pointer;} .xinruiOneImg li img, .xinruiPic li img{position:absolute; top:0;left:50%;max-height:100%; transform: translate(-50%);} .xinruiOneImg,.xinruiOneImg ul{float:left;}.xinruiOneImg li{margin-top:0;margin-right:10px;width:90px;height:90px;float:left;}</style>
     <style type="text/css">.h_avatar,.xr_tl td.o{vertical-align:top}.xr_tl td.o input{margin-top:10px;}.xr_musicList{margin:5px 0;}.xrMusicInfo{color:#999;line-height:22px;font-size:13px;margin-bottom:5px;}.xrMusic li{float:left; margin-right:3px; margin-top:5px;}.xrMusic li,.xrOneMusic li {display:block;width:310px;height:80px;text-align:center;position:relative;}.pct .pcb td li{list-style:none;margin:0;} </style>
     <ul class="p_pop h_pop" id="mn_N6e26_menu" style="display: none;">
      @foreach($ncate as $v)
          <li> <a href="{{url('news?cid='.$v->id)}}" hidefocus="true">{{$v->defectsname}}</a></li> 
       @endforeach
     </ul>
     <ul class="p_pop h_pop" id="mn_N6e20_menu" style="display: none;">
      @foreach($cates as $v)
          <li> <a href="{{url('blog?cid='.$v->id)}}" hidefocus="true">{{$v->defectsname}}</a></li> 
       @endforeach
     </ul>
     <ul class="p_pop h_pop" id="mn_forum_menu" style="display: none;">
        @foreach($fcate as $v)
            <li><a href="{{url('forum_list/'.$v->id)}}" hidefocus="true">{{$v->defectsname}}</a></li>
        @endforeach
     </ul>
     <div class="p_pop h_pop" id="mn_userapp_menu" style="display: none;"></div>
     <div class="deandenglu">
        <ul class="deanunlogin">
           @if(session('userinfo'))
                <li class="deanqqlogin deannavThisJs"><img style="width:30px;border-radius:50% 50%" src="{{session('userinfo.userface')}}" /></li>
                <li class="deanlogin deannavThisJs"><a href="">{{session('userinfo.nickname')}}</a></li>
                <li class="deanregister deannavThisJs"><a href="{{url('logout')}}">退出</a></li>
           @else
           <li class="deannavThisJs" onmouseover="layer.tips('Hi，我是tips', '吸附元素选择器，如#id');"><a href="{{url('qqLogin')}}"><i class="layui-icon layui-icon-login-qq" style="color:#FF7F84;font-size:28px;"></i></a></li>
<!--                <li class="deanlogin deannavThisJs"><a href="{{url('login')}}" onclick="showWindow('login', this.href)">登录</a></li>
                <li class="deanregister deannavThisJs"><a href="{{url('register')}}">注册</a></li>-->
           @endif
           <div class="clear"></div>
       </ul>
    </div>
     <ul id="scbar_type_menu" class="p_pop" style="display: none;">
      <li><a href="javascript:;" rel="news" class="curtype">资讯</a></li>
      <li><a href="javascript:;" rel="blog">博客</a></li>
      <li><a href="javascript:;" rel="forum">帖子</a></li>
      <!--<li><a href="javascript:;" rel="user">用户</a></li>-->
     </ul> 
     <script type="text/javascript">
//initSearchmenu('scbar', '');
</script> 
     <!--<a href="javascript:;" class="z qNv" id="qmenu" onmouseover="delayShow(this, function () {showMenu({'ctrlid':'qmenu','pos':'34!','ctrlclass':'a','duration':2});showForummenu(0);})">快捷导航</a>--> 
    </div> 
   </div> 
  </div> 
  <div id="wp" class="wp"> 
    @yield('content')
</div> 
  <div id="ft"> 
   <div class="wp cl"> 
    <div class="cl"> 
     <div id="flk" class="y"> 
      <dl> 
       <dt>
        联系本站
       </dt> 
       <dd class="tel">
        {{Site::get('qq')}}
        <span class="xs1">周一至周日：08:30 - 21:00</span>
       </dd> 
       <dd>
        地址：{{Site::get('area_name')}}
       </dd> 
      </dl> 
      <ul class="ft_sns cl mtw"> 
       <li class="wb"> <a href="">微博</a> </li> 
       <li class="qq"> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2505451091&site=qq&menu=yes">在线客服</a> </li> 
       <li class="wx"> <a href="javascript:void(0);"> 微信 <p><img style="width:150px"src="{{asset(Site::get('qrcode'))}}" /></p> </a> </li> 
      </ul> 
     </div> 
     <div id="frt"> 
      <p><img height="50" src="{{Site::get('webimg')}}" /></p> 
      <p>{{Site::get('homedescription')}}</p> 
      <p class="xs0 mtm">Powered by <a href="{{Site::get('webaddress')}}" target="_blank">九月一十八!</a> <em>X1.0</em> </p> 
      <p class="xs0 mtm"><a href="http://www.miitbeian.gov.cn/" target="_blank">{{Site::get('bottominfo')}}</a><span>{{Site::get('copyright')}}</span></p>
      <p class="xs0 mtm"><a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=32010202010476" ><img src="{{asset('resources/home/images/gov.png')}}" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">苏公网安备 32010202010476号</p></a></p>
		 
     </div>
    
        
        
    </div> 
    <div class="xr_ft"> 
<!--     <p> <a href="" target="_blank" title="QQ">
             <img src="{{asset('resources/home/images/site_qq.jpg')}}" alt="QQ" /></a>
         <span class="pipe">|</span>
         <a href="">手机版</a>
         <span class="pipe">|</span>
         ( <a href="http://www.miitbeian.gov.cn/" target="_blank">{{Site::get('bottominfo')}}</a> )&nbsp;
     </p> -->
     <p class="xs0"> <span id="showday"></span><span id="debuginfo"> , Processed in {{microtime(true)-LUMEN_START}} second(s) . </span> </p> 
    </div> 
   </div> 
  </div> 
  <div id="scrolltop" style="left: auto; right: 0px; visibility: visible;"> 
   <span hidefocus="true"><a title="返回顶部" onclick="window.scrollTo('0','0')" class="scrolltopa"><b>返回顶部</b></a></span> 
  </div> 
  <!--<script type="text/javascript">_attachEvent(window, 'scroll', function () { showTopLink(); });checkBlind();</script>--> 
  <div id="discuz_tips" style="display:none;"></div>
  <script>
function run(){
 var time = new Date();//获取系统当前时间
 var year = time.getFullYear();
 var month = time.getMonth()+1;
 var date= time.getDate();//系统时间月份中的日
 var day = time.getDay();//系统时间中的星期值
 var weeks = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
 var week = weeks[day];//显示为星期几
 var hour = time.getHours();
 var minutes = time.getMinutes();
 var seconds = time.getSeconds();
 //console.log(seconds);
 if(month<10){
 month = "0"+month; 
 }
 if(date<10){
 date = "0"+date; 
 }
 if(hour<10){
 hour = "0"+hour; 
 }
 if(minutes<10){
 minutes = "0"+minutes; 
 }
 if(seconds<10){
 seconds = "0"+seconds; 
 }
 //var newDate = year+"年"+month+"月"+date+"日"+week+hour+":"+minutes+":"+seconds;
 document.getElementById("showday").innerHTML = year+"年"+month+"月"+date+"日"+week+hour+":"+minutes+":"+seconds;
 setTimeout('run()',1000);
 }
  
 run();
 </script>
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https'){
   bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
  }
  else{
  bp.src = 'http://push.zhanzhang.baidu.com/push.js';
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
</body>
</html>
