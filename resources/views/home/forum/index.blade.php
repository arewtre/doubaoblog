@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_index.css')}}">
<style>
    .category_newlist img{
        max-width:22px;
    }
</style>
<div class="wp"> 
   <!--[diy=diy1]-->
   <div id="diy1" class="area"></div>
   <!--[/diy]--> 
  </div> 
  <div id="ct" class="xr_forum wp cl"> 
   <!--[diy=diy_chart]-->
   <div id="diy_chart" class="area"></div>
   <!--[/diy]--> 
   <div class="mn"> 
    <!-- index four grid --> 
    <div id="category_grid" class="xr_grid bp"> 
     <table cellspacing="0" cellpadding="0">
      <tbody>
       <tr> 
        <td valign="top" class="category_l1"> 
         <div class="newimgbox"> 
          <div class="module cl slidebox_grid slideBox" style="width:288px;height:288px;overflow:hidden;"> 
           <ul class="slideshow" style="width: 288px; position: relative; overflow: hidden; padding: 0px; margin: 0px; left: -3504.2px;">
               @foreach($adv as $v)
                <li style="height: 340px; float: left; width: 880px;"> 
                   <a href="{{$v->url}}" target="_blank"> 
                       <img src="{{$v->pic_url}}" width="{{$v->width}}" height="{{$v->height}}" />
                   </a> 
                   <h3 style="display: none;">{{$v->title}}</h3> 
               </li>
               @endforeach
              </ul>
              <script type="text/javascript">
                jQuery(".slideBox").slide({
                    titCell:".slidebar li",
                    mainCell:".slideshow",
                    effect:"left",
                    autoPlay:true
                });
                jQuery(".slideshow li").hover(function(){
                jQuery(".slideshow li").find("h3").slideDown();
                }, function(){jQuery(".slideshow li").find("h3").slideUp();});
            </script>
          </div> 
         </div> </td> 
        <td valign="top" class="category_l2"> 
         <div class="subjectbox"> 
          <h4><span class="tit_subject"></span>最新主题</h4> 
          <ul class="category_newlist">
           @foreach($newf as $v)
                @if(strtotime($v->created_at)>(time()-3*24*60*60))
                    <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" title="{{$v->title}}" target="_blank" style="color:#EE5023;font-weight:bold">{{$v->title}}</a></li> 
                @else
                    <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" title="{{$v->title}}" target="_blank">{{$v->title}}</a></li> 
                @endif
           @endforeach
          </ul> 
         </div> </td> 
        <td valign="top" class="category_l3"> 
         <div class="replaybox"> 
          <h4><span class="tit_replay"></span>最新回复</h4> 
          <ul class="category_newlist">
            @foreach($newrep as $v)
              @if(strtotime($v->created_at)>(time()-3*24*60*60))
                    <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" style="font-weight: bold;color: #2897C5" title="{{$v->content}}" target="_blank">{!! discuzcode(@nl2br($v->content)) !!}</a></li> 
              @else
                     <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" title="{{$v->content}}" target="_blank">{!! discuzcode(@nl2br($v->content)) !!}</a></li> 
              @endif
            @endforeach
          </ul> 
         </div> </td> 
        <td valign="top" class="category_l3"> 
         <div class="hottiebox"> 
          <h4><span class="tit_hottie"></span>热帖</h4> 
          <ul class="category_newlist">
           @foreach($hotrep as $v)
              @if(strtotime($v->created_at)>(time()-3*24*60*60))
                    <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" style="font-weight: bold;color: #2897C5" title="{{$v->title}}" target="_blank">{{$v->title}}</a></li> 
               @else 
                    <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?pid='.$v->pid)}}" title="{{$v->title}}" target="_blank">{{$v->title}}</a></li> 
                @endif
            @endforeach
          </ul> 
         </div> </td> 
       </tr>
      </tbody>
     </table> 
    </div> 
    <!-- index four grid end --> 
    <div id="chart" class="cl"> 
     <ul class="chart z"> 
      <li class="t">今日帖数： <em>{{$todayf}}</em></li> 
      <li class="ye">昨日帖数： <em>{{$lastdayf}}</em></li> 
      <li class="p">帖子数： <em>{{$fnum}}</em></li> 
      <li class="m">会员总数： <em>{{count($member)}}</em></li> 
     </ul> 
     <div class="y">
       欢迎新会员：
      <em><img src="{{$member[0]['userface']}}" style="width:20px"> <a href="" target="_blank" class="xi2">{{$member[0]['nickname']}}</a></em>
     </div> 
    </div>
    @foreach($mod as $v)
    <div class="xr_forum_box bp  flg cl"> 
     <div class="xr_forum_tit"> 
      <h2>{{$v['defectsname']}}</h2> 
     </div> 
     <div id="category_53" style=""> 
      <table cellspacing="0" cellpadding="0" class="fl_tb"> 
       <tbody>
        <tr>
         @if(isset($v['_child']))
        @foreach($v['_child'] as $vv)
         <td class="fl_g"> 
          <div class="fl_icn_g" style="width: 100px;"> 
           @if($vv['pid']==85)
           <a href="{{url('image_list/'.$vv['id'])}}">
           @else
           <a href="{{url('forum_list/'.$vv['id'])}}">
           @endif
              
               <img src="{{$vv['img']}}" align="left" alt="" style="width:100px;height:100px;" />
           </a>
          </div> 
          <dl style="margin-left: 100px;"> 
           <dt>
            @if($vv['pid']==85)
           <a href="{{url('image_list/'.$vv['id'])}}">
           @else
           <a href="{{url('forum_list/'.$vv['id'])}}">
           @endif
                {{$vv['defectsname']}}
            </a>
           </dt> 
           <dd class="desc">
            {{$vv['dec']}}
           </dd>
           <dd>
            <em>主题: {{$vv['zhutinum']}}</em>, 
            <em>帖数: @if($vv['tiezinum']>0){{$vv['tiezinum']}} @else 0 @endif</em>
           </dd> 
          </dl> 
         </td> 
         @endforeach
         @endif
        </tr> 
       </tbody>
      </table> 
     </div> 
    </div>
    
@endforeach
    
   </div> 
   <div class="wp mtn"> 
    <!--[diy=diy3]-->
    <div id="diy3" class="area"></div>
    <!--[/diy]--> 
   </div> 
   <div class="bp lk"> 
    <div id="category_lk" class="bm_c ptm"> 
<!--     <ul class="m mbn cl">
      <li class="lk_logo mbm bbda cl"><img src="./forum_files/logo_88_31.gif" border="0" alt="官方论坛" />
       <div class="lk_content z">
        <h5><a href="{{url('forum')}}" target="_blank">官方论坛</a></h5>
        <p>提供最新新闻、资讯、软件下载与技术交流</p>
       </div>
      </li>
     </ul> -->
     <ul class="x mbm cl"> 
       @foreach($link as $v)  
            <li><a href="{{$v->link_url}}" target="_blank" title="{{$v->link_name}}">{{$v->link_name}}</a></li>
       @endforeach
     </ul> 
    </div> 
   </div> 
  </div>
<script>
jQuery("#nv li").removeClass("a");
jQuery("#mn_forum").addClass("a");

{{--layui.use(['laypage', 'layer','form'], function(){
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
  
});--}}

</script>
@endsection