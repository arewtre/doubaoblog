@extends('layouts.wap')
@section('content')
<script src="{{asset('resources/wap/js/mobile/jquery-1.8.3.min.js')}}" type="text/javascript"></script>
<header class="header">
    <a class="topShare fr" href="#viewShare">分享</a>
    <a class="goBack fl" href="{{url('wap/imageXc')}}">返回</a>
    <h1>{{$xc->xc_name}}</h1>
</header>
<div class="container">
    <div class="postlist">
	<div class="forumListHeader">
            <h2>
            [{{$xc->xc_name}}]
            </h2>
            <div class="postUserAttr cfix">
                    <span class="h_avatar"><img src="{{asset($xc->userface)}}" /></span>
                    <a class="fl" href="">{{$xc->nickname}}</a>
                    <span class="fl">{{word_time($xc->created_at,1)}}</span> 
            </div>
	</div>
       <div class="postListItem" href="#replybtn_" id="pid{{$xc->xc_id}}">
        <div class="postListCon" style="padding-bottom:20px">
               @foreach($images as $v)
                <img src="{{$v->image_url}}?imageView2/0/w/414" style="width:100%;margin-bottom:10px">
               @endforeach
        </div>


<!-- 标签开始 -->

<div class="tag">
<!--<span></span>

<a title="$var[1]" href="" target="_blank">豆宝网</a>-->

</div>

<!-- 标签结束 -->

	</div>

<!-- 广告图片开始 -->
<div class="adPic pb">
此处广告
</div>	
<!-- 广告图片结束 -->
	<h3 class="postListHd" id="reComments">回复评论</h3>
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
               <font size="2"><a href="" target="_blank"><font color="#999999">{{$v->child->nickname}} 发表于 {{word_time($v->child->created_at,1)}}</font></a></font>
               <br /> {{mb_substr(strip_tags(discuzcode(@nl2br($v->child->content))),0,54,'utf-8')}}
              </blockquote>
             </div>
             @endif
             <br /> {!! discuzcode(nl2br($v->content)) !!}
            </div> 
            <div id="replybtn_9276" class="replybtn" display="true"> 
             <input type="button" class="redirect button" href="{{url('wap/image_reply?xc_id='.$xc->xc_id.'&rep_id='.$v->repid)}}" value="回复" /> 
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
   
        @include('wap/images/fastpost')

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
//	$('#viewShare').mmenu({
//		autoHeight	: true,
//		navbar		: {
//			title 	: false
//		},
//		offCanvas	: {
//			position	: "bottom",
//			zposition	: "front",
//			modal		: true
//		}
//	});
        $(".postListCon img").click(function(){
            window.location.href="{{url('wap/imageAlbumXc/'.$xc->xc_id)}}";
        })
});
$(function() {
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
</script>
@endsection