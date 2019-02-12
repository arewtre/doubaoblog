@extends('layouts.wap3')
@section('content')
<!--<script src="{{asset('resources/home/js/jquery-2.1.3.min.js')}}" type="text/javascript"></script>-->
<script src="{{asset('resources/wap/js/mobile/jquery-1.8.3.min.js')}}" type="text/javascript"></script>
<style>
    video{
        max-width:100%;
    }
    img{
        /*width:100%;*/
    }
    .postListCon img{
      margin-top:10px;  
    }
</style>
<header class="header" style="overflow:hidden">
    <!--<a class="topShare fr" href="#viewShare">分享</a>-->
    <!--<a class="goBack fl" href="{{url('wap/forum_list/'.$forum->pid)}}">返回</a>-->
    <a class="goBack fl" href="{{url('wap/forum_list/'.$forum->pid)}}">返回</a>
    <h1>{{getCateName($forum->pid)}}</h1>
</header>
<div class="container">
    <div class="postlist">
	<div class="forumListHeader">
            <h2>
            [{{$forum->title}}]
            </h2>
            <div class="postUserAttr cfix">
                    <span class="h_avatar"><img src="{{asset($forum->userface)}}" /></span>
                    <a class="fl" href="">{{$forum->nickname}}</a>
                    <span class="fl">{{word_time($forum->created_at,1)}}</span> 
            </div>
	</div>
       <div class="postListItem" href="#replybtn_{{$forum->forum_id}}" id="pid{{$forum->forum_id}}">
			<!--{/if}-->
        <div class="postListCon" style="padding-bottom:20px">
                {!! nl2br($forum->content) !!}


        </div>


<!-- 标签开始 -->
<!--{if $post['first'] && ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}-->
			<div class="tag">
			<!--<span></span>-->
				<!--{if $post[tags]}-->
					<!--{eval $tagi = 0;}-->
					<!--{loop $post[tags] $var}-->
						<!--<a title="$var[1]" href="" target="_blank">豆宝网</a>-->
						<!--{eval $tagi++;}-->
					<!--{/loop}-->
				<!--{/if}-->
<!--				{if $relatedkeywords}<span>relatedkeywords</span>{/if}-->
			</div>
		<!--{/if}-->
<!-- 标签结束 -->

	</div>
<!--{if $post['first']}-->
<!-- 广告图片开始 -->
<!--<div class="adPic pb">
此处广告
</div>	-->
<!-- 广告图片结束 -->
<!--{/if}-->
	 <!--{if $post['first']}-->
	<h3 class="postListHd" id="reComments">评论</h3>
        @if($data)
        @foreach($data as $k=>$v)
        <div class="postListItem" href="#replybtn_9276" id="pid9276"> 
            <div class="postListTit"> 
             <span class="h_avatar"><img src="{{asset($v->userface)}}" /></span> 
             <h4> 
                 <em class="y"> 
                     
                     @if($k==0)
                     沙发
                     @elseif($k==1)
                     板凳
                     @elseif($k==2)
                     地板
                     @else
                     {{$k+1}}
                     @endif
                     <sup>#</sup>
                 </em> 
                 <a href="" class="blue">{{$v->nickname}}</a> </h4> 
             <div class="postListAttr">
               {{word_time($v->created_at,1)}}
             </div> 
            </div> 
            <div class="postListCon"> 
             @if(isset($v->child))
             <div class="grey quote">
              <blockquote>
               回复: 
               <font size="2"><a href="" target="_blank"><font color="#999999">{{$v->child->nickname}} 发表于 {{word_time($v->child->created_at,1)}} 的评论</font></a></font>
               <br /> 
               <span>
              </blockquote>
             </div>
             @endif
             <br /> 
             @if($v->rep_id>0)
             {!! nl2br($v->content) !!}
             @else
             {!! discuzcode(@nl2br($v->content)) !!}
             @endif
            </div> 
            <div id="replybtn_9276" class="replybtn" display="true"> 
             <input type="button" class="redirect button" href="{{url('wap/forum_reply?forum_id='.$forum->forum_id.'&rep_id='.$v->repid)}}" value="回复" /> 
            </div> 
            <!--signature start--> 
            @if($v->sign)
            <div class="sign">
             <div style="max-height:120px;maxHeightIE:120px;overflow:hidden;">
             {{$v->sign}}
             </div>
             <span></span>
            </div> 
            @endif
            <!--signature end--> 
           </div>
        @endforeach
   @else
	<div class="comShaFa">
		暂无评论，赶紧抢沙发吧
	</div>
   @endif
   
        @include('wap/forum/fastpost')

</div>
<!-- main postlist end -->

<!--{hook/viewthread_bottom_mobile}-->

<script type="text/javascript">
	$('.favbtn').on('click', function() {
		var obj = $(this);
		$.ajax({
			type:'POST',
			url:obj.attr('href') + '&handlekey=favbtn&inajax=1',
			data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
			dataType:'xml',
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			window.location.href = obj.attr('href');
			popup.close();
		}); 
		return false;
	});
</script>
<a href="javascript:;" title="返回顶部" class="scrolltop bottom"></a>

</div>

<div id="viewShare" class="viewShare" style="display:none">
    <div class="bdsharebuttonbox">
        <div class="wxShare"><a class="jiathis_button_weixin" href="#">微信</a></div>
        <!-- JiaThis Button BEGIN -->		
        <div class="jiathis_style_m"></div>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_m.js" charset=gbk></script>
        <!-- JiaThis Button END -->
    </div>
</div>
<div class="popMask" style="display:none">
	<img src="{{asset('resources/wap/touch/images/img/share.png')}}" />
</div>
<script type="text/javascript">
$(function() {
    layui.use(['layer','form','code'], function(){
        var form = layui.form
      ,layer = layui.layer
      ,$ = layui.jquery;
        $(".postListCon img").click(function(){
            window.location.href="{{url('wap/imageAlbum/'.$forum->forum_id)}}";
        })


	$("#mm-blocker").click(function(){
		$("html").removeClass();
		$(".viewShare").attr("class","viewShare mm-menu mm-offcanvas mm-bottom mm-front mm-autoheight");
	});
	$('.jiathis_button_weixin').click(function(){
		$(".popMask").show();
		$("#mm-blocker").trigger("click");
		return false;
	});
	$('.popMask').click(function(){
		$(this).hide();
		window.location.reload();
	})
    });
});
</script>
@endsection