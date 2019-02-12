@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_forumdisplay.css')}}" />
<!--[diy=diynavtop]--><div id="diynavtop" class="area"></div><!--[/diy]-->
<div id="pt" class="bm cl">
<div class="z">
<a href="" class="nvhm" title="首页">首页</a><em>&#187;</em><a href="">论坛</a> <em>&#8250;</em> 
<a href="">O粉娱乐</a><em>&#8250;</em> 
<a href="">图片瀑布流</a></div>
<span class="y">
<a href="" target="_blank" title="RSS">订阅</a> 

</span>
</div>        
<div class="wp">
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>
<div class="boardnav">
<div id="ct" class="xr_list wp cl">

<div class="mn">
<div class="bp">
<div class="listTit cl">
<div class="forumIcon z">
<img src="" alt="图片瀑布流">
</div>

<div class="xr_tit_c z" style="width:620px;">	
<div class="cl">
<h1 class="z">图片瀑布流</h1>
<a class="favBtn z" href="" id="a_favorite" onclick="showWindow(this.id, this.href, &#39;get&#39;, 0);">+ 关注</a>
</div>
<p class="xg2">图片生活记录和拍照技巧分享、组织的摄影等活动交流、团建</p></div>

<div class="xr_tit_r z">
<a class="post_btn z" href="">发表新帖</a>
<div class="xr_stat y">
<ul class="cl">
<li>
今日
<span>0</span>
</li>
<li>主题<span>96</span></li>
<li>排名<span title="上次排名:9">9</span></li>
<li class="last">关注<span id="number_favorite_num">34</span></li>
</ul>
</div>

</div>
</div>
<div class="cl mtm xs2">
						
<div id="forum_rules_46" style=";">
<div class="ptn xg2">本版规则： 瀑布流，又称瀑布流式布局。是比较流行的一种网站页面布局，视觉表现为参差不齐的多栏布局，随着页面滚动条向下滚动，这种布局还会不断加载数据块并附加至当前尾部。最早采用此布局的网站是Pinterest，逐渐在国内流行开来。国内大多数清新站基本为这类风格。</div>
</div>
</div> 
  

<ul id="thread_types" class="ttp cl cttp" style="height: auto;"><li class="fold">收起</li>
<li id="ttp_all" class="a">
<a href="">全部
<span class="num">96</span>
</a>
</li>
<li><a href="">自然风景<span class="num">45</span></a></li>
</ul>
<script type="text/javascript">showTypes('thread_types');</script>

</div>



<div class="drag">
<!--[diy=diy12]--><div id="diy12" class="area"></div><!--[/diy]-->
</div>




<div id="threadlist" class="xr_tl bp" style="position: relative;">
<div class="th">
<table cellspacing="0" cellpadding="0">
<tbody><tr>
<th colspan="2">
<div class="tf">
<a id="filter_special" href="javascript:;" class="allpost_ico xi2" onclick="showMenu(this.id)">
<span class="showmenu">全部主题</span>
</a>

<a href="" class="lastpost_ico xi2">
最新
</a>
<a href="" class="hotpost_ico xi2">
热帖
</a>

<a href="" class="digestpost_ico xi2">
精华
</a>
<a id="filter_dateline" href="javascript:;" class="showmenu xi2" onclick="showMenu(this.id)">更多</a>

<span id="clearstickthread" style="display: none;">
<span class="pipe">|</span>
<a href="javascript:;" onclick="clearStickThread()" class="xi2" title="显示置顶">显示置顶</a>
</span>
 
</div>
</th>
<td class="by">
<a href="" class="chked y" title="图片模式浏览帖子">图片模式</a>
</td>
</tr>
</tbody></table>
</div>
<div class="tl">
<div id="forumnew" style="display:none"></div>
<form method="post" autocomplete="off" name="moderate" id="moderate" action="">
<input type="hidden" name="formhash" value="3d712fdc">
<input type="hidden" name="listextra" value="page%3D1">
<table summary="forum_46" cellspacing="0" cellpadding="0" id="threadlisttableid">
 
</table><!-- end of table "forum_G[fid]" branch 2/3 -->
<div class="xrWaterFall">
<ul id="waterfall" class="ml waterfall cl" style="height: 2185px; width: 1166px;">
    @if(count($xc)>0)
    @foreach($xc as $v)
    <li style="width: 282px; position: absolute; left: 0px; top: 0px;">
        <div class="c cl">
        <a href="" onclick="atarget(this)" title="{{$v->xc_name}}" class="z">
            <img src="{{asset($v->fengm)}}" alt="{{$v->xc_name}}" width="270">
        </a>
        </div>
        <h3 class="xw0">
        <a href="" style="font-weight: bold;color: #2897C5;" onclick="atarget(this)" title="{{$v->xc_name}}">{{$v->xc_name}}</a>
        </h3>
        <div class="wfDesc">
        <em>{{$v->xc_view}}</em>  人气 /
        <em>{{$v->xc_zan}}</em> 喜欢 / 
        <em>{{$v->xc_rep}}</em> 回复
        </div>
        <div class="wfAuth cl">
        <a class="z" href="" c="1" mid="card_3735">
            <img src=""> 
            梦想的自由 
        </a>
        <p class="y">{{word_time($v->created_at,1)}}</p>
        </div>
    </li>
    @endforeach
@endif
</ul>
</div>
<div id="tmppic" style="display: none;"></div>
<script src="./pubu_files/redef.js" type="text/javascript"></script>
<script type="text/javascript" reload="1">
var wf = {};

_attachEvent(window, "load", function () {
if($("waterfall")) {
wf = waterfall();
}

var page = 1 + 1,
maxpage = Math.min(1 + 10,5 + 1),
stopload = 0,
scrolltimer = null,
tmpelems = [],
tmpimgs = [],
markloaded = [],
imgsloaded = 0,
loadready = 0,
showready = 1,
nxtpgurl = 'forum.php?mod=forumdisplay&fid=46&filter=&orderby=lastpost&page=',
wfloading = "<img src=\"static/image/common/loading.gif\" alt=\"\" width=\"16\" height=\"16\" class=\"vm\" /> 加载中...",
pgbtn = $("pgbtn").getElementsByTagName("a")[0];

function loadmore() {
var url = nxtpgurl + page + '&t=' + parseInt((+new Date()/1000)/(Math.random()*1000));
var x = new Ajax("HTML");
x.get(url, function (s) {
s = s.replace(/\n|\r/g, "");
if(s.indexOf("id=\"pgbtn\"") == -1) {
$("pgbtn").style.display = "none";
stopload++;
window.onscroll = null;
}

s = s.substring(s.indexOf("<ul id=\"waterfall\""), s.indexOf("<div id=\"tmppic\""));
s = s.replace("id=\"waterfall\"", "");
$("tmppic").innerHTML = s;
loadready = 1;
});
}

window.onscroll = function () {
if(scrolltimer == null) {
scrolltimer = setTimeout(function () {
try {
if(page < maxpage && stopload < 2 && showready && ((document.documentElement.scrollTop || document.body.scrollTop) + document.documentElement.clientHeight + 500) >= document.documentElement.scrollHeight) {
pgbtn.innerHTML = wfloading;
loadready = 0;
showready = 0;
loadmore();
tmpelems = $("tmppic").getElementsByTagName("li");
var waitingtimer = setInterval(function () {
stopload >= 2 && clearInterval(waitingtimer);
if(loadready && stopload < 2) {
if(!tmpelems.length) {
page++;
pgbtn.href = nxtpgurl + Math.min(page, 5);
pgbtn.innerHTML = "下一页 &raquo;";
showready = 1;
clearInterval(waitingtimer);
}
for(var i = 0, j = tmpelems.length; i < j; i++) {
if(tmpelems[i]) {
tmpimgs = tmpelems[i].getElementsByTagName("img");
imgsloaded = 0;
for(var m = 0, n = tmpimgs.length; m < n; m++) {
tmpimgs[m].onerror = function () {
this.style.display = "none";
};
markloaded[m] = tmpimgs[m].complete ? 1 : 0;
imgsloaded += markloaded[m];
}
if(imgsloaded == tmpimgs.length) {
$("waterfall").appendChild(tmpelems[i]);
wf = waterfall({
"index": wf.index,
"totalwidth": wf.totalwidth,
"totalheight": wf.totalheight,
"columnsheight": wf.columnsheight
});
}
}
}
}
}, 40);
}
} catch(e) {}
scrolltimer = null;
}, 320);
}
};

});

</script>
</form>
</div>
<div id="pgbtn" class="pgbtn"><a href="" hidefocus="true">下一页 &#187;</a></div>

<div class="bm bw0 pgs cl">
<span id="visitedforumstmp" onmouseover="$(&#39;visitedforums&#39;).id = &#39;visitedforumstmp&#39;;this.id = &#39;visitedforums&#39;;showMenu({&#39;ctrlid&#39;:this.id,&#39;pos&#39;:&#39;21&#39;})" class="pgb y"><a href="http://iuni.xinruiweb.com/forum.php">返&nbsp;回</a></span>
<a href="javascript:;" id="newspecialtmp" onmouseover="$(&#39;newspecial&#39;).id = &#39;newspecialtmp&#39;;this.id = &#39;newspecial&#39;;showMenu({&#39;ctrlid&#39;:this.id})" onclick="location.href=&#39;forum.php?mod=post&amp;action=newthread&amp;fid=46&#39;;return false;" title="发新帖"><img src="./pubu_files/pn_post.png" alt="发新帖"></a></div>

</div>

<div id="filter_special_menu" class="p_pop" style="display:none" change="location.href=&#39;forum.php?mod=forumdisplay&amp;fid=46&amp;filter=&#39;+$(&#39;filter_special&#39;).value">
<ul>
<li><a href="">全部主题</a></li>
<li><a href="">投票</a></li></ul>
</div>
<div id="filter_reward_menu" class="p_pop" style="display:none" change="forum.php?mod=forumdisplay&amp;fid=46&amp;filter=specialtype&amp;specialtype=reward&amp;rewardtype=&#39;+$(&#39;filter_reward&#39;).value">
<ul>
<li><a href="">全部悬赏</a></li>
<li><a href="">进行中</a></li></ul>
</div>
<div id="filter_dateline_menu" class="p_pop" style="display:none">
<ul class="pop_moremenu">
<li>排序: 
<a href="">发帖时间</a><span class="pipe">|</span>
<a href="">回复/查看</a><span class="pipe">|</span>
<a href="">查看</a>
</li>
<li>时间: 
<a href="" class="xw1">全部时间</a><span class="pipe">|</span>
<a href="">一天</a><span class="pipe">|</span>
<a href="">两天</a><span class="pipe">|</span>
<a href="">一周</a><span class="pipe">|</span>
<a href="">一个月</a><span class="pipe">|</span>
<a href="">三个月</a>
</li>
</ul>
</div>
<div id="filter_orderby_menu" class="p_pop" style="display:none">
<ul>
<li><a href="">默认排序</a></li>
<li><a href="">发帖时间</a></li>
<li><a href="">回复/查看</a></li>
<li><a href="">查看</a></li>
<li><a href="">最后发表</a></li>
<li><a href="">热门</a></li>
</ul>
</div>
<!--[diy=diyfastposttop]--><div id="diyfastposttop" class="area"></div><!--[/diy]-->

<!--[diy=diyforumdisplaybottom]--><div id="diyforumdisplaybottom" class="area"></div><!--[/diy]-->
</div>

</div>
</div>
<ul class="p_pop" id="newspecial_menu" style="display: none">
<li><a href="">发表帖子</a></li>
<li class="poll"><a href="">发起投票</a></li></ul>
<div id="visitedforums_menu" class="p_pop blk cl" style="display: none;">
<table cellspacing="0" cellpadding="0">
<tbody><tr>
<td id="v_forums">
<h3 class="mbn pbn bbda xg1">浏览过的版块</h3>
<ul class="xl xl1">
<li><a href="">OPPO资讯</a></li>
</td>
</tr>
</tbody></table>
</div>
<script type="text/javascript">document.onkeyup = function(e){keyPageScroll(e, 0, 1, 'forum.php?mod=forumdisplay&fid=46&filter=&orderby=lastpost&', 1);}</script>
<div class="wp mtn">
<!--[diy=diy11]--><div id="diy11" class="area"></div><!--[/diy]-->
</div>
  <script>
  jQuery("#nv li").removeClass("a");
jQuery("#mn_forum").addClass("a");
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  //完整功能
  laypage.render({
    elem: 'demo7'
    ,count: {{$count}}
    ,layout: ['prev', 'page', 'next', 'skip']
    ,skip: true
    ,limit:1
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      //console.log(obj)
      if(!first){   
            window.location.href="/image_list/{{$id}}?page="+obj.curr;
        }  
    }
  });
  });
  </script>
@endsection