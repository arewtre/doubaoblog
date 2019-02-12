@extends('layouts.home')
@section('content')
<script src="{{asset('resources/home/js/jquery-1.11.0.min.js')}}" type="text/javascript"></script> 
    <script src="{{asset('resources/home/js/common.js')}}" type="text/javascript"></script> 
    <!--<script src="{{asset('resources/home/js/forum.js')}}" type="text/javascript"></script>-->
    <link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_common.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_guide.css')}}" />
<style>
    .layui-laypage a, .layui-laypage span {
    display: inline-block;
    vertical-align: middle;
    padding: 0 12px;
    height: 24pk;
    line-height: 24px;
    margin: 0 -1px 5px 5px;
    background-color: #E3E5E8;
    color: #333;
    font-size: 12px;
}
</style>
<div id="wp" class="wp">
<style type="text/css">
.xl2 { background: url(static/image/common/vline.png) repeat-y 50% 0; }
.xl2 li { width: 49.9%; }
.xl2 li em { padding-right: 10px; }
.xl2 .xl2_r em { padding-right: 0; }
.xl2 .xl2_r i { padding-left: 10px; }
</style>
<div id="pt" class="bm cl">
<div class="z">
<a href="{{url('/')}}" class="nvhm" title="首页">豆宝网首页</a><em>&#187;</em>
<a href="{{url('guide')}}">导读</a> <em>&#8250;</em> 
<!--<a href="">最新回复</a>-->
</div>
</div>
<div class="boardnav">
<div id="ct" class="wp cl">
<div class="xr_guide mn bp cl">

<div class="xr_guide_tit mbw cl">
<!--<span class="y">
<a href="" class="fa_rss" target="_blank" title="RSS">订阅</a>
</span>-->
<!--<h1 class="xs2">
最新回复</h1>-->
</div>
<!--<div class="bm_c cl pbm">
<div style=";" id="forum_rules_1163">
<div class="ptn xg2"></div>
</div>
</div>-->
<div id="pgt" class="pgs cl">
<div class="xr_tl">
<!--分页-->

</div>
<!--<a id="newspecialtmp" onclick="showWindow('nav', this.href, 'get', 0)" href="{{url('forumAdd')}}">
    <img src="./guide_files/pn_post.png" alt="发新帖"></a>
</div>-->
<div class="sdBtn bp"> 
<a href="http://linxinran.cn/forumAdd" class="post_btn">发表新帖</a> 
<!--<a href="http://linxinran.cn/sign" target="_blank" class="signin">马上签到</a>--> 
</div>
<ul id="thread_types" class="ttp bm cl">
<li @if($fil=="views") class="xw1 a" @endif><a href="{{url('guide?filter=views')}}">最新热门</a></li>
<li @if($fil=="reps") class="xw1 a" @endif><a href="{{url('guide?filter=reps')}}">最新精华</a></li>
<li @if($fil=="lastrepcreated_at") class="xw1 a" @endif><a href="{{url('guide?filter=lastrepcreated_at')}}">最新回复</a></li>
<li @if($fil=="created_at") class="xw1 a" @endif><a href="{{url('guide?filter=created_at')}}">最新发表</a></li>
<!--<li><a href="">抢沙发</a></li>-->
@if(session("userinfo"))
<li><a id="filter_special" href="" onmouseover="showMenu(this.id)" initialized="true">我的帖子</a></li>
@endif
</ul>
<div id="threadlist" class="xr_tl">
<div class="tl">
<div id="forumnew" style="display:none"></div>
<table cellspacing="0" cellpadding="0">				
    @if(count($data)>0)
    @foreach($data as $v)
    <tbody id="normalthread_5692">
        <tr>
            <td class="h_avatar">
                <a href=""><img src="{{$v['userface']}}"></a>
            </td>
            <th class="common">
                <div class="tl_tit cl">
                    <span class="views y">
                    {{$v['views']}}</span>
                    <h3>
                        <em>[<a href="{{url('forum_list/'.$v['pid'])}}" target="_blank">{{$v['defectsname']}}</a>]</em>
                         <a href="{{url('forum_list_detail/'.$v['forum_id'].'?pid='.$v['pid'])}}" target="_blank" class="xst">{{$v['title']}}</a>
                         @if(count(html2imgs($v['content']))>0)
                            <img src="{{asset('resources/home/images/image_s.gif')}}" alt="attach_img" title="图片附件" align="absmiddle" /> 
                         @endif
                         @if($v['reps']>5 && $v['reps']<=10)
                        <img src="{{asset('resources/home/images/recommend_1.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v['reps']}}" />
                        @elseif($v['reps']>10 && $v['reps']<=20)
                        <img src="{{asset('resources/home/images/recommend_2.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v['reps']}}" /> 
                        @elseif($v['reps']>20)
                        <img src="{{asset('resources/home/images/recommend_3.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v['reps']}}" /> 
                        @endif
                        @if($v['views']>5 && $v['views']<=10)
                        <img src="{{asset('resources/home/images/hot_1.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v['views']}}" /> 
                        @elseif($v['views']>10 && $v['views']<=20)
                        <img src="{{asset('resources/home/images/hot_2.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v['views']}}" /> 
                        @elseif($v['views']>20)
                        <img src="{{asset('resources/home/images/hot_3.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v['views']}}" /> 
                        @endif
                         
                    </h3>
                </div>
                <div class="tl_txt cl">
                    <span class="replies y"><a href="" class="xi2">{{$v['reps']}}</a></span>
                    <p class="publisher">
                        <a href="" c="1" mid="card_4739">{{$v['nickname']}}</a> 于
                        <span>{{word_time($v['created_at'],1)}}</span> 发布
                    </p>
                    @if(isset($v['lastrepname']) && !empty($v['lastrepname']))
                    <p class="replyer">
                        <a href="" c="1" mid="card_3137">{{$v['lastrepname']}}</a>最后回复
                        <a href=""><span title="{{$v['lastrepcreated_at']}}">{{word_time($v['lastrepcreated_at'],1)}}</span></a>
                    </p>
                    @endif
                </div>
            </th>
            <td class="w1"></td>
            <td class="w1"></td>
            <td class="w1"></td>
            <td class="w1"></td>
        </tr>
    </tbody>
    @endforeach
    @endif
</table>
</div>
</div>
<div class="bm bw0 pgs cl">
<!--分页-->
</div>
</div>
</div>
</div>
</div>  
</div>
  <script>
  jQuery("#nv li").removeClass("a");
jQuery("#mn_N2905").addClass("a");
  </script>
  <script>
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  
  
  
  //完整功能
  laypage.render({
    elem: 'demo7'
    ,count: {{$count}}
    ,layout: ['prev', 'page', 'next', 'skip']
    ,skip: true
    ,limit:12
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      //console.log(obj)
      if(!first){   
            window.location.href="/guide?page="+obj.curr+"&keywords={{$keywords}}";
        }  
    }
  });
  laypage.render({
    elem: 'demo8'
    ,count: {{$count}}
    ,layout: ['prev', 'page', 'next', 'skip']
    ,skip: true
    ,limit:12
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      //console.log(obj)
      if(!first){   
            window.location.href="/guide?page="+obj.curr+"&keywords={{$keywords}}";
        }  
    }
  });
});
</script>
@endsection