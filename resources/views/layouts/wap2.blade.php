<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" charset="utf-8">
    <title>{{Site::get('webname')}}</title>
    <meta name="_token" content="{{ csrf_token() }}" /> 
    <meta name="keywords" content="首页" /> 
    <meta name="description" content="首页 " /> 
    <meta name="generator" content="DouCMS1.0" /> 
    <meta name="author" content="九月一十八" /> 
    <meta name="copyright" content="2017-2018 Comsenz Inc." /> 
    <meta name="MSSmartTagsPreventParsing" content="True" /> 
    <meta http-equiv="MSThemeCompatible" content="Yes" /> 
    <meta name="application-name" content="豆宝主题官网" /> 
    <meta name="msapplication-tooltip" content="豆宝主题官网" /> 
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <script src="{{asset('resources/home/js/jquery-2.1.3.min.js')}}" type="text/javascript"></script> 
     <!--<script src="{{asset('resources/wap/js/mobile/jquery-1.8.3.min.js')}}" type="text/javascript"></script>--> 
    <script type="text/javascript">var STYLEID = '2', STATICURL = 'resources/wap/static/', IMGDIR = 'resources/wap/static/image/common', VERHASH = 'pCV', charset = 'utf8', discuz_uid = '1', cookiepre = 'OZJL_2132_', cookiedomain = '', cookiepath = '/', showusercard = '1', attackevasive = '0', disallowfloat = 'newthread', creditnotice = '1|威望|,2|金钱|,3|贡献|', defaultstyle = '', REPORTURL = '', SITEURL = 'http://linxinran.cn/', JSPATH = 'resoruces/wap/js/mobile';</script>

    <!--<script src="{{asset('resources/wap/js/mobile/common.js')}}"></script>-->
    <script src="{{asset('resources/wap/touch/images/js/common.js?ver=1.0')}}"></script>
    <!--<link rel="stylesheet" href="{{asset('resources/wap/touch/images/style.css?t=11231103')}}" type="text/css">-->
    <!---手动修改配色(橙色t1，粉色t2，浅绿色t3，蓝色t4，黄色t5，紫色t6，黑色t7，红色t8)
    <link rel="stylesheet" href="./template/xinrui_iuni_mobile/touch/style/t5/style.css" type="text/css">--->
    <!--jquery.mmenu -->
    <link rel="stylesheet" href="{{asset('resources/wap/touch/images/style.css?pCV')}}" type="text/css" /> 
    <link rel="stylesheet" href="{{asset('resources/wap/touch/images/media50px.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('resources/wap/touch/images/mmenu/jquery.mmenu.all.css')}}" type="text/css">
    <script src="{{asset('resources/wap/touch/images/mmenu/jquery.mmenu.min.all.js')}}"></script>
    <script src="{{asset('resources/admin/layuiadmin/layui/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('resources/admin/layuiadmin/layui/css/layui.css')}}" media="all">
    <style>
        video{
        width:100%
        }
    </style>
 </head> 
<style>

</style> 
 </head> 
<body class="bg" style="">
  <div id="page">  
   <style style="text/css">.xinruimobileurl img{max-width:100%;}</style>
   <style type="text/css">.xr_videoList{padding:5px 10px;}.xrVideoInfo{font-size:13px;line-height:22px;}.xrVideo li,.xrOneVideo li{width:100%;height:260px;float:left;margin-top:10px;}.threadlist .threadlist .xr_videoList{padding:5px 0 0;}.threadlist .threadlist .xrVideoInfo{color:#999;}.display.pi .message li{list-style: none;margin:0;height:260px;}.postListItem .postListCon li{list-style: none;}.video_mobile{width:100%;height:260px;}</style>
   <style type="text/css">.tl_picList{padding:5px 10px;}.xinruiInfo{font-size:13px;line-height:22px;}.xinruiPic li{display:block;width:33.3%;height:90px;float:left;margin-top:6px;border:none;}.xinruiPic span,.xinruiOneImg span{display:block;margin:0 3px;background:#fff;border:solid 1px #eee;border-radius:3px;height:90px;overflow:hidden;text-align:center;position:relative;} .xinruiOneImg{float:left;margin-right:10px;border:none;} .xinruiOneImg li{width:92px;height:92px; border:none;}.xinruiOneImg span{margin:0;}.xinruiOneImg li img,.xinruiPic li img{position:absolute;top:0;left:50%;max-height:100%;max-width:none;transform: translate(-50%);} .threadlist .threadlist .tl_picList{padding:5px 0 0;}.threadlist .threadlist .xinruiInfo{color:#999;}</style>
   <style type="text/css">.xr_musicList{padding:5px 10px;}.xrMusicInfo{font-size:13px;line-height:22px;}.xrMusic li,.xrOneMusic li{width:100%;height:80px;float:left;margin-top:10px;}.threadlist .threadlist .xr_musicList{padding:5px 0 0;}.threadlist .threadlist .xrMusicInfo{color:#999;}.display.pi .message li{list-style: none;margin:0;height:80px;}.postListItem .postListCon li{list-style: none;}</style>
   @yield('content')

   <div id="mask" style="display:none;"></div> 
   <div class="footer"> 
    <div> 
    @if (!session('userinfo'))
        <a href="{{url('wap/login')}}" title="登录">登录</a> | <a href="javascript:;" style="color:#D7D7D7;" title="注册">注册</a>
    @else
        <a href="{{url('wap/profile')}}">{{session('userinfo.nickname')}}</a> , <a href="{{url('wap/logout')}}" title="退出" class="dialog">退出</a>
    @endif
    </div> 
<!--    <div> 
     <a href="">标准版</a> | 
     <a href="javascript:;" style="color:#D7D7D7;">触屏版</a> | 
     <a href="">电脑版</a> 
    </div> -->
    <p>&copy; linxinran.cn</p> 
   </div> 
     <nav id="mainNv" class="mainNv mm-menu mm-theme-dark mm-effect-listitems-slide mm-offcanvas mm-iconpanel">
   <div class="mm-panels">
    <div class="menuWarp mm-panel mm-opened mm-current mm-iconpanel-0" id="mm-0">
     <a href="#mm-0" class="mm-subblocker"></a>
     <div class="mm-navbar">
      <a class="mm-title">Menu</a>
     </div> 
     <div class="userInfo cfix">
        @if (!session('userinfo'))
        <a href="{{url('wap/login')}}">
            <div class="avatar fl">
                <img src="{{asset('resources/wap/touch/images/img/noavatar.gif')}}">
            </div>
            <p>点击登录</p>
            <!--<p>登录更多精彩功能！</p>--> 
        </a>
        @else
        <a href="{{url('wap/profile')}}">
                <div class="avatar fl">
                        <img  src="{{session('userinfo.userface')}}">
                </div>
                <h3>欢迎:  {{session('userinfo.nickname')}}</h3>
                <p>新手上路</p>
        </a>
        @endif
     </div> 
     <ul class="mm-listview"> 
      <li class="nv1"><a href="{{url('wap')}}">首页</a></li> 
      <li class="nv2"><a href="{{url('wap/forum')}}">论坛板块</a></li> 
      <li class="nv3"><a href="{{url('wap/news')}}">资讯/博客</a></li> 
      <li class="nv4"><a href="{{url('wap/imageXc')}}">豆宝相册</a></li> 
      <li class="nv5"><a href="{{url('wap/guide')}}">导读</a></li> 
      <li class="nv9"><a href="{{url('wap/tags')}}">标签</a></li> 
      <li class="nv6"><a href="{{url('wap/search')}}">搜索</a></li> 
      @if (!session('userinfo'))
        <li class="nv7"><a href="{{url('wap/login')}}">登录</a></li> 
      @else
        <li class="nv7"><a href="{{url('wap/logout')}}">退出</a></li> 
      @endif
     </ul> 
    </div>
   </div>
  </nav> 
  </div>
<script>
jQuery(function(){
	jQuery(window).scroll(function(){
          height = jQuery(window).scrollTop();
   	  	  if(height > 50){
			 jQuery('.header').addClass("header_fixed fadeInDown");
   	  	  }else{
			 jQuery('.header').removeClass("header_fixed fadeInDown");
   	  	  };
        });
});
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
   $(function(){ 
    wx.config({
            debug:false,   
            appId: "{{$signPackage['appId']}}",
            timestamp: "{{$signPackage['timestamp']}}",
            nonceStr: "{{$signPackage['nonceStr']}}",
            signature: "{{$signPackage['signature']}}",
            jsApiList: [
                   'checkJsApi',
                   'onMenuShareTimeline',
                   'onMenuShareAppMessage',
                   'onMenuShareQQ',
                   'onMenuShareWeibo'
                 ]
             });             
           wx.ready(function () {
               wx.checkJsApi({
                 jsApiList: [
                   'getNetworkType',
                   'previewImage',
                    'onMenuShareTimeline',
                   'onMenuShareAppMessage',
                   'onMenuShareQQ',
                   'onMenuShareWeibo'
                 ],            
               });
               @if(isset($detail->art_title))
                   var title = "{{$detail->art_title}}";
                   var desc = "{{$detail->art_description}}";
                   var imgUrl = "{{asset($detail->art_thumb)}}";
                   var link = "";
               @elseif(isset($forum->title))
                   var title = "{{$forum->title}}";
                   var desc = "{{$forum->dess}}";
                   var imgUrl = '{{$forum->video}}';
                   var link = "";
                   //console.log(imgUrl);
                @elseif(isset($xc->xc_name))
                    var title = "{{$xc->xc_name}}";
                    var desc = "{{$xc->xc_desc}}";
                    var imgUrl = "{{$xc->fengm}}";;
                    var link = "";
               @else 
                   var title = "豆宝网";
                   var desc = "豆宝网是一个记录豆豆宝成长的个人博客网站";
                   var imgUrl = "http://linxinran.cn/dd.jpg";
                   var link = "http://linxinran.cn";
               @endif
               var link = link;
             var shareData = {
                 title: title, 
                 desc: desc,
                 link: link,
                 imgUrl: imgUrl, 
                 type: '', 
                 dataUrl: '', 
                 success: function () { 

                 },
                 cancel: function () { 

               }

             };
             wx.onMenuShareAppMessage(shareData);
             wx.onMenuShareTimeline(shareData);
             wx.onMenuShareQQ(shareData);
             wx.onMenuShareWeibo(shareData);
           });
      });  
</script>
 </body>
</html>
