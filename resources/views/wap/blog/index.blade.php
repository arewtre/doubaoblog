@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_portal_list.css')}}">
<style id="diy_style" type="text/css">
    #frametEB409 {  border:0px none !important;}
    #portal_block_57 {  border:0px none !important;}
    #frameC18y9Y {  border:0px none !important;}
    #portal_block_58 {  border:0px none !important;}
    #ct .mn {width: 910px;}
    #ct .sd {width: 280px;}
    .forumName{color:#4895d0 !important}
    .layui-laypage .layui-laypage-curr .layui-laypage-em {
    position: absolute;
    left: -1px;
    top: -1px;
    padding: 1px;
    height: 100%;
    background-color: #FF7F84;
}
</style>
<div id="pt" class="bm cl"> 
   <div class="z"> 
    <a href="./" class="nvhm" title="首页">新锐创想轻主题模板</a> 
    <em>›</em> 
    <a href="{{url('/')}}">首页</a> 
    <em>›</em>技术博客
   </div> 
   <div class="y"> 
    <a href="" class="rss" target="_blank" title="RSS">订阅</a>
   </div> 
  </div>
  <div class="wp"> 
   <div id="fullAd" class="area"></div>
  </div> 
  <div id="ct" class="ct2 wp cl"> 
   <div class="mn">
    <div id="listcontenttop" class="area"></div>
    <div class="xrArticleList bp"> 
     <div class="title"> 
      <h1>技术博客</h1> 
     </div> 
     <div class="aList newMod"> 
      <ul>
      @foreach($data as $v)
          <li> 
        <div class="atc">
         <a href="{{url('blog_'.idEncryption($v->art_id).'.html')}}" target="_blank">
             <img src="{{$v->art_thumb}}" alt="{{$v->art_title}}" class="tn" /></a>
        </div> 
        <h3>
            <a class="forumName" href="{{url('blog?cid='.$v->id)}}">[{{$v->defectsname}}]</a>
            <a href="{{url('blog_'.idEncryption($v->art_id).'.html')}}" target="_blank" style="">{{$v->art_title}}</a> 
        </h3> 
        <div class="info">
        {{$v->art_description}}
        </div> 
        <div class="attr cl"> 
         <!--<span class="xg1">{{word_time($v->updated_at,1)}}</span>--> 
            <div class="z"> 
            <span class="author"> {{$v->update_editor}}</span> 
            <span class="dateline">{{word_time($v->updated_at,1)}}</span> 
           </div> 
           <div class="y"> 
            <span class="view"> {{$v->art_view}}</span> 
            <span class="rep"> {{$v->art_rep}}</span> 
           </div> 
        </div> 
       </li>
       @endforeach
      </ul> 
       @if($count>0)
         <div id="demo1"  class="jquery_pagnation" style="text-align:center"></div>
         @else
          <div style="text-align:center;height:200px;line-height:200px;font-size:20px">很抱歉,暂无内容!</div>
         @endif
     </div> 
     <div id="listloopbottom" class="area"></div>
    </div> 
    <div id="diycontentbottom" class="area"></div>
   </div> 
   <div class="sd pph"> 
    <div class="sdBtn bp"> 
     <a href="" target="_blank" class="signin">马上签到</a> 
    </div> 
    <div class="drag"> 
     <div id="diyrighttop" class="area"></div>
    </div> 
    <div class="bp colu"> 
     <div class="blocktitle title"> 
      <span class="titletext">相关分类</span> 
     </div> 
     <div class="dxb_bc" style="padding-bottom:20px;"> 
      <ul class="module cl xl xl2 cl">
       @foreach($cates as $v)
          <li @if($cid==$v->id) class="cur" @endif> <a href="{{url('blog?cid='.$v->id)}}">{{$v->defectsname}}</a></li> 
       @endforeach
      </ul> 
     </div> 
    </div> 
    <div class="hotPost bp"> 
     <div id="diy12" class="area">
      <div id="frameC18y9Y" class="cl_frame_bm frame move-span cl frame-1">
       <div id="frameC18y9Y_left" class="column frame-1-c">
        <div id="frameC18y9Y_left_temp" class="move-span temp"></div>
        <div id="portal_block_58" class="cl_block_bm block move-span">
         <div class="blocktitle title">
          <span style="float:;margin-left:px;font-size:;color: !important;" class="titletext">热帖推荐</span>
         </div>
         <div id="portal_block_58_content" class="dxb_bc">
          <div class="module cl xl xl1"> 
           <ul>
            <li><a href="thread-11-1-1.html" title="不做饭，这些漂亮的食物也值得看|豌豆荚设计奖-厨房故事" target="_blank">不做饭，这些漂亮的食物也值得看|豌豆荚设</a></li>
           </ul> 
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div> 
    <div class="hotAct bp"> 
     <div id="diy10" class="area">
      <div id="frametEB409" class="cl_frame_bm frame move-span cl frame-1">
       <div id="frametEB409_left" class="column frame-1-c">
        <div id="frametEB409_left_temp" class="move-span temp"></div>
        <div id="portal_block_57" class="cl_block_bm block move-span">
         <div class="blocktitle title">
          <span style="float:;margin-left:px;font-size:;color: !important;" class="titletext">热门文章</span>
         </div>
         <div id="portal_block_57_content" class="dxb_bc">
          <div class="module cl ml"> 
           <ul>
            @foreach($hot as $v)
            <li style="width: 250px;"> <a href="{{url('blog_'.idEncryption($v->art_id).'.html')}}" target="_blank">
               <img src="{{$v->art_thumb}}" width="250" height="150" alt="{{$v->art_title}}”" /></a> 
                <div class="actItem"> 
                 <h3>{{$v->art_title}}</h3> 
                 <p><i>{{$v->art_view}}</i> 人关注</p> 
                </div> 
            </li>
            @endforeach
           </ul> 
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div> 
    <div class="drag"> 
     <div id="diy2" class="area"></div>
    </div> 
   </div> 
  </div> 
  <div class="wp mtn"> 
   <div id="diy3" class="area"></div>
  </div>
<script>
jQuery("#nv li").removeClass("a");
jQuery("#mn_N6e20").addClass("a");

layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,form = layui.form
  ,layer = layui.layer;

//完整功能
  laypage.render({
    elem: 'demo1'
    ,count: {{$count}}
    ,skip: true
    ,limit:{{$limit}}
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      if(!first){   
            window.location.href="/blog?page="+obj.curr+"&cid="+"{{$cid}}";
        }  
    }
  });
  
});

</script>
@endsection