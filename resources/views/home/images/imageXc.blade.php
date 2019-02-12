@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_forumdisplay.css')}}" />
<style>
    .jb{color: #fff !important;
        height: 30px;
        width: 100px;
        position: absolute;
        left: -100px;
        top:20px;
        text-align: center;
        line-height: 20px;
        font-family: "黑体";
        background-color: #FF7F84;
        -moz-transform:rotate(-35deg);
        -webkit-transform:rotate(-35deg);
        -o-transform:rotate(-35deg);
        -ms-transform:rotate(-35deg);
        transform:rotate(-35deg);
    }
    
</style>
<!--[diy=diynavtop]--><div id="diynavtop" class="area"></div><!--[/diy]-->
<div id="pt" class="bm cl">
<div class="z">
<a href="{{url('/')}}" class="nvhm" title="首页">首页</a><em>&#187;</em>
<a href="{{url('imageXc')}}">豆宝相册</a></div>
<span class="y">
<!--<a href="" target="_blank" title="RSS">订阅</a>--> 

</span>
</div>        
<div class="boardnav">
<div id="ct" class="xr_list wp cl">

<div class="mn">
<div class="bp">
<div class="listTit cl">
    <div class="forumIcon z">
        <img src="./public/uploads/images/201806260951th_5b319c2e5d229.png" alt="豆宝相册">
    </div>
    <div class="xr_tit_c z" style="width:620px;">	
        <div class="cl">
            <h1 class="z">相册瀑布流</h1>
            <!--<a class="favBtn z" href="" id="a_favorite" onclick="showWindow(this.id, this.href, &#39;get&#39;, 0);">+ 关注</a>-->
        </div>
        <p class="xg2">图片生活记录,活动交流、团建</p>
    </div>

    <div class="xr_tit_r z">
        <!--<a class="post_btn z" href="{{url('imageAdd')}}">上传相册</a>-->
        <div class="xr_stat y">
            <ul class="cl">
                <li>
                    今日上传
                    <span>{{$todayf}}</span>
                </li>
                <li>相册数<span>{{$xcnum}}</span></li>
                <!--<li>排名<span title="上次排名:9">9</span></li>-->
                <li class="last">照片数<span id="number_favorite_num">{{$counts}}</span></li>
            </ul>
        </div>

    </div>
</div>
<div class="cl mtm xs2">						
    <div id="forum_rules_46" style=";">
        <div class="ptn xg2">本版规则： 本版采用瀑布流展示相册,图片,登录注册后享有免费上传发布个人相册权限,照片永久有效,大小限制10M以内</div>
    </div>
</div> 
  
<ul id="thread_types" class="ttp cl cttp" style="height: auto;">
    <li id="ttp_all" @if($cid=="") class="a" @endif >
        <a href="{{url('imageXc')}}">全部
        <span class="num">{{$counts}}</span>
    </a>
    </li>
    @foreach($ixcate as $v)
    <li @if($cid==$v->id) class="a" @endif ><a href="{{url('imageXc?pid='.$v->id)}}">{{$v->defectsname}}</a></li>
    @endforeach
</ul>
@if(!empty($ixcateson) && count($ixcateson)>0)
<ul id="thread_types" class="ttp cl cttp" style="height: auto;">
    @foreach($ixcateson as $v)
    <li @if($sid==$v->id) class="a" @endif ><a href="{{url('imageXc?sid='.$v->id."&pid=".$v->pid)}}">{{$v->defectsname}}<span class="num">{{$v->num}}</span></a></li>
    @endforeach
</ul>
@endif  
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
                <a href="{{url('imageXc?sid='.$sid."&pid=".$cid."&filter=created_at")}}" class="lastpost_ico xi2">最新</a>
                <a href="{{url('imageXc?sid='.$sid."&pid=".$cid."&filter=xc_view")}}" class="hotpost_ico xi2">热帖</a>
                <a href="{{url('imageXc?sid='.$sid."&pid=".$cid."&filter=is_top")}}" class="digestpost_ico xi2">精华</a>
                <a id="filter_dateline" href="javascript:;" class="showmenu xi2" onclick="showMenu(this.id)">更多</a>
                <span id="clearstickthread" style="display: none;">
                <span class="pipe">|</span>
                <a href="javascript:;" onclick="clearStickThread()" class="xi2" title="显示置顶">显示置顶</a>
                </span>
            </div>
        </th>
        </tr>
        </tbody>
    </table>
</div>
<div class="tl">
<div id="forumnew" style="display:none"></div>
<form method="post" autocomplete="off" name="moderate" id="moderate" action="">
<input type="hidden" name="formhash" value="3d712fdc">
<input type="hidden" name="listextra" value="page%3D1">
<table summary="forum_46" cellspacing="0" cellpadding="0" id="threadlisttableid">
 
</table>
<div class="xrWaterFall">
@if(count($xc)>0)
 <ul id="waterfall" class="ml waterfall cl" style="height: auto; width: 1166px;">
    @foreach($xc as $v)
    <li class="list-item" style="width: 282px; position: absolute; left: 0px; top: 0px;">
        <div class="c cl" style="position: relative;">
            <span class="jb">{{$v->num}} P</span>
        <a href="{{url('imageList/'.$v->xc_id)}}" onclick="atarget(this)" title="{{$v->xc_name}}" class="z">
            <img src="{{asset($v->fengm)}}?imageView2/0/w/350" alt="{{$v->xc_name}}" width="270">
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
            <img src="{{asset($v->userface)}}"> 
            {{$v->nickname}} 
        </a>
        <p class="y">{{word_time($v->created_at,1)}}</p>
        </div>
    </li>
    @endforeach  
</ul>
@endif
</div>
<div id="tmppic" style="display: none;"></div>
 <script src="{{asset('resources/home/js/forum.js')}}" type="text/javascript"></script>
<script src="{{url('resources/home/js/redef.js')}}" type="text/javascript"></script>
<script type="text/javascript" reload="1">
    var wf = {};
    _attachEvent(window, "load", function () {
        if(jQuery("waterfall")) {
            wf = waterfall();
        }
    });

    </script>
</form>
</div>
<div id="pgbtn" class="pgbtn" data-pindex="{{$page}}" style="text-align:right">
<!--    <a href="javascript:;" hidefocus="true" class="load-more" onclick="loadMore({{$page}})" data-page="{{$page}}">下一页 &#187;</a>-->
</div>

<div class="bm bw0 pgs cl">
<span id="visitedforumstmp" onmouseover="" class="pgb y"><a href="{{url('/')}}">返&nbsp;回</a></span>
<!--<a href="{{url('imageAdd')}}" id="newspecialtmp" onmouseover="" onclick="" title="上传相册">
    <img src="./pubu_files/pn_post.png" alt="上传相册"></a>-->
</div>

</div>

<div id="filter_special_menu" class="p_pop" style="display:none" change="location.href=&#39;forum.php?mod=forumdisplay&amp;fid=46&amp;filter=&#39;+$(&#39;filter_special&#39;).value">
<ul>
<li><a href="">全部主题</a></li>
<!--<li><a href="">投票</a></li>-->
</ul>
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
<li><a href="{{url('forumAdd')}}">上传图片</a></li>
<!--<li class="poll"><a href="">发起投票</a></li>-->
</ul>
<div id="visitedforums_menu" class="p_pop blk cl" style="display: none;">
<table cellspacing="0" cellpadding="0">
<tbody><tr>
<td id="v_forums">
<h3 class="mbn pbn bbda xg1">浏览过的版块</h3>
<ul class="xl xl1">
<!--<li><a href="">OPPO资讯</a></li>-->
</td>
</tr>
</tbody></table>
</div>
<div class="wp mtn">
<!--[diy=diy11]--><div id="diy11" class="area"></div><!--[/diy]-->
</div>
  <script>
  jQuery("#nv li").removeClass("a");
  jQuery("#mn_Nb67d").addClass("a");
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
//完整功能
    laypage.render({
      elem: 'pgbtn'
      ,count: {{$count}}
      ,skip: true
      ,limit:{{$limit}}
      ,curr: {{$page}} 
      ,jump: function(obj,first){
        if(!first){   
              window.location.href='/imageXc?sid='+"{{$sid}}"+'&pid='+"{{$cid}}"+'&page='+obj.curr
          }  
      }
    });
  });
//  function loadMore(){     
//      var pindex = jQuery('#pgbtn').attr('data-pindex');
//      jQuery.ajax({  
//          type : "get",  
//          url : location.href,  
//          data : "page=" + pindex,   
//          async : false,  
//          success : function(html){
//            if (html.indexOf("list-item") > -1) {
//                var con = jQuery(html).find("#waterfall").html();
//                console.log(con);
//                jQuery("#waterfall").append(con);
//                jQuery('#pgbtn').attr('data-pindex', pindex*1+1*1);
//            } else {				
//                jQuery("#pgbtn").html('<a href="javascript:;" class="load-more" ka="article-list-load-more">没有更多了</a>');
//            }
//			
//          }
//	});
//    }
//    
//    jQuery(window).scroll(function() {
//        if (jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height()) {
//           //loadMore(); 
//        }
//    });
  
  </script>
@endsection