@extends('layouts.wap')
@section('content')
<style>
    #LAY_demo1{
        width:100%;
        height:100%;
        overflow: auto;
    }
    .subNv .cur{
        font-weight:600;
        font-size:16px;
        color:#FF7F84;
    }
</style>
<header class="header">
	<a class="goBack fl" href="{{url('wap/')}}">返回</a>
	<!--{if $cat[others]}--><a class="topSort fr" href="#subMenu">分类</a><!--{/if}-->
	<h1>资讯/博客</h1>
</header>
<div class="container">
	<!--{eval $list = category_get_list($cat, $wheresql, $page);}-->

	<!--{if $cat[subs]}-->
	<!--下级分类-->
	<div class="nvBar">
		<div class="subNv">
			<ul>
				{{-- @foreach($ncate as $v)
                            <li><a href="{{url('wap/news?cid='.$v->id)}}">{{$v->defectsname}}</a></li>
				@endforeach --}}
                             <li><a href="{{url('wap/news?type=1')}}" @if($type==1) class="cur" @endif>新闻资讯</a></li>
                             <li><a href="{{url('wap/news?type=2')}}" @if($type==2) class="cur" @endif>文章博客</a></li>
			</ul>
		</div>
	</div>
	<!--{/if}-->

	<div id="subMenu" class="subMenu">
            <div class="subMenuBox">
                <h3>相关分类</h3>
                <ul>
                    @foreach($ncates as $v)
                    {{--@if($v['type']==1)--}}
                    <li><a href="{{url('wap/news?cid='.$v['id'])}}">{{$v['showName']}}</a></li>
                    {{-- @else
                    <li><a href="{{url('wap/blog?cid='.$v['id'])}}">{{$v['showName']}}</a></li>                    
                    @endif --}}
                    @endforeach
                </ul>
            </div>
	</div>
	<script type="text/javascript">
		$(function() {
			$('#subMenu').mmenu({
				autoHeight	: true,
				navbar		: {
					title 	: false
				},
				offCanvas	: {
					position	: "right",
					zposition	: "front",
					modal		: true
				}
			});
		});
	</script>
	<!--{/if}-->

	<div class="xr_article_list">
		<ul id="LAY_demo1" class="flow-default">
                    @if(count($data)>0)
                    @foreach($data as $v)
				<li>
				<a href="{{url('wap/news_'.$v->art_id.'.html')}}">
					<h3>{{$v->art_title}}</h3>
					<div class="article_info">
						<!--{if $value[pic]}-->
						<div class="artPic">
							<img src="{{$v->art_thumb}}" alt="{{$v->art_title}}" class="tn" />
						</div>
						<!--{/if}-->
						<p>{{$v->art_description}}</p>
						<div class="article_attr">
							<span class="fr"> {{word_time($v->created_at,1)}}</span>
							<label>{{$v->defectsname}}</label>
						</div>
					</div>
				</a>
				</li>
			@endforeach
                        @else
                        <li class="noData">对不起，没有找到匹配结果。</li>
                        @endif
		</ul>
	</div>
	<div id="demo1" class="pgs cl" style="text-align: center"></div>

</div>
<script>
//jQuery("#nv li").removeClass("a");
//jQuery("#mn_N6e26").addClass("a");

layui.use(['laypage', 'layer','form','flow'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,laypage = layui.laypage
  ,flow = layui.flow;

//完整功能
  laypage.render({
    elem: 'demo1'
    ,count: {{$count}}
    ,skip: true
    ,limit:{{$limit}}
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      if(!first){   
            window.location.href="/wap/news?page="+obj.curr+"&cid="+"{{$cid}}"+"&type="+"{{$type}}";
        }  
    }
  });

 
 
 //文档高度
function getDocumentTop() {
    var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
    if (document.body) {
        bodyScrollTop = document.body.scrollTop;
    }
    if (document.documentElement) {
        documentScrollTop = document.documentElement.scrollTop;
    }
    scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;    return scrollTop;
}

//可视窗口高度
function getWindowHeight() {
    var windowHeight = 0;
    if (document.compatMode == "CSS1Compat") {
        windowHeight = document.documentElement.clientHeight;
    } else {
        windowHeight = document.body.clientHeight;
    }
    return windowHeight;
}

//滚动条滚动高度
function getScrollHeight() {
    var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
    if (document.body) {
        bodyScrollHeight = document.body.scrollHeight;
    }
    if (document.documentElement) {
        documentScrollHeight = document.documentElement.scrollHeight;
    }
    scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;    return scrollHeight;
}

//window.onscroll = function () {
//    //监听事件内容
//    if(getScrollHeight() == getWindowHeight() + getDocumentTop()){
//        //当滚动条到底时,这里是触发内容
//        //异步请求数据,局部刷新dom
//        $(".layui-flow-more").hide();
//  flow.load({
//    elem: '#LAY_demo1' //流加载容器
//    ,scrollElem: '#LAY_demo1' //滚动条所在元素，一般不用填，此处只是演示需要。
//    ,isAuto:true
//    ,done: function(page, next){ //执行下一页的回调      
//      var lis = [];
//        page = page*1+1*1;
//        console.log(page);
//        $.ajax({  
//          type : "get",  
//          url : "/wap/news?cid="+"{{$cid}}",  
//          data : {page:page},   
//          async : false,  
//          success : function(html){
//            //if (html.indexOf("list-item") > -1) {
//                var con = $(html).find("#LAY_demo1").html();
//                //console.log(con);
//                $("#LAY_demo1").append(con);
//                //$('#pgbtn').attr('data-pindex', pindex*1+1*1);
//            //} 
////            else {				
////                $("#pgbtn").html('<a href="javascript:;" class="load-more" ka="article-list-load-more">没有更多了</a>');
////            }
//		next(lis.join(''), page < {{$pages}}); 
////                $(".layui-flow-more").hide();
//          }
//	});
//    }
// }); 
//    }
//}
});

</script>
   @include('layouts/footer') 
@endsection