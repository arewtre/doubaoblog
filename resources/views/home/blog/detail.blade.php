@extends('layouts.home2')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_portal_view.css')}}" /> 
  <style id="diy_style" type="text/css">
    #frametEB409 {  border:0px none !important;}
    #portal_block_57 {  border:0px none !important;}
    #frameC18y9Y {  border:0px none !important;}
    #portal_block_58 {  border:0px none !important;}
    #ct .mn {width: 910px;}
    #ct .sd {width: 280px;}
    #article_content img{max-width:100%}
    html,body{height:100%;}
    .vw .d ol, .vw .d ul {
     margin: 0; 
}
    pre{
        font-size:14px !important;
        width:100%;
        /*color:#abb2bf !important;*/
    }
     #article_content p{
       /*padding:20px 30px*/ 
    }
    #article_content table p{
       /*color:#abb2bf !important;*/ 
       padding:0px 
    }
    .gutter{
        /*display:none;*/
        border-right:1px solid #abb2bf;
        padding:0 20px 0 20px;
        width:28px;
    }
    .code{
        padding:20px 30px !important; 
    }
    h2{
        line-height:40px
    }
    .pln{
        color:#fff !important; 
    }
    /*th,td{padding:0 10px}*/
</style> 
  <!--<script src="{{asset('resources/home/js/forum_viewthread.js')}}" type="text/javascript"></script>--> 
   
  <div id="pt" class="bm cl"> 
   <div class="z"> 
    <a href="{{url('/')}}" class="nvhm" title="首页"></a> 
    <em>›</em> 
    <a href="{{url('/')}}">首页</a> 
    <em>›</em>
    <a href="{{url('blog')}}">技术博客</a> 
    <em>›</em> 查看内容 
   </div> 
  </div> 
  <div class="wp"> 
   <!--[diy=diy1]-->
   <div id="diy1" class="area"></div>
   <!--[/diy]--> 
  </div> 
  <div id="ct" class="ct2 wp cl"> 
   <div class="mn"> 
    <div class="xrVw vw" style="background:#fff; margin-bottom:15px;"> 
     <div class="h hm"> 
         <h1 class="ph">{{$detail->art_title}}</h1> 
      <p class="xg1">{{word_time($detail->created_at,1)}}<span class="pipe">|</span> 发布者: 
          <a href="">{{$detail->nickname}}</a>
          <span class="pipe">|</span> 查看: 
          <em id="_viewnum">{{$detail->art_view}}</em><span class="pipe">|</span> 评论: 
          <a href="" title="查看全部评论"><em id="_commentnum">{{$detail->art_rep}}</em></a></p> 
     </div> 
     <!--[diy=diysummarytop]--> 
     <div id="diysummarytop" class="area"></div>
     <!--[/diy]--> 
     <div class="s">
      <div>
       <strong>摘要</strong>: {{$detail->art_description}}
      </div>
     </div> 
     <!--[diy=diysummarybottom]-->
     <div id="diysummarybottom" class="area"></div>
     <!--[/diy]--> 
     <div class="d" style="padding:0 20px"> 
      <!--[diy=diycontenttop]-->
      <div id="diycontenttop" class="area"></div>  
      <!--[/diy]--> 
      <table cellpadding="0" cellspacing="0" class="vwtb">
       <tbody>
        <tr>
         <td id="article_content"> 
<!--             <p>
                 <a href="" target="_blank"><img src="{{$detail->art_thumb}}" /></a>
             </p>-->
         {!! $detail->art_content !!}
         </td>
        </tr>
       </tbody>
      </table> 
      <!--[diy=diycontentbottom]-->
      <div id="diycontentbottom" class="area"></div>
      <!--[/diy]--> 
      <div id="click_div">
       <table cellpadding="0" cellspacing="0" class="atd"> 
        <tbody>
         <tr>
          <td><a href="javascript:;" id="click_aid_9_5" onclick="addbt(this);"data-href="{{url('biaotai/'.$detail->art_id.'/1/2')}}"> 
            <div class="atdc"> 
             <div class="ac2" style="height:{{$bt[0]*2+1}}px;"> 
              <em>{{$bt[0]}}</em> 
             </div> 
            </div> <img src="{{asset('resources/home/images/xianhua.gif')}}" alt="" /><br />鲜花</a> </td> 
          <td> <a href="javascript:;" id="click_aid_9_5" onclick="addbt(this);"data-href="{{url('biaotai/'.$detail->art_id.'/2/2')}}"> 
            <div class="atdc"> 
             <div class="ac1" style="height:{{$bt[1]*2+1}}px;"> 
              <em>{{$bt[1]}}</em> 
             </div> 
            </div> <img src="{{asset('resources/home/images/woshou.gif')}}" alt="" /><br />握手</a> </td> 
          <td> <a href="javascript:;" id="click_aid_9_5" onclick="addbt(this);"data-href="{{url('biaotai/'.$detail->art_id.'/3/2')}}"> 
            <div class="atdc"> 
             <div class="ac3" style="height:{{$bt[2]*2+1}}px;"> 
              <em>{{$bt[2]}}</em> 
             </div> 
            </div> <img src="{{asset('resources/home/images/leiren.gif')}}" alt="" /><br />雷人</a> </td> 
          <td> <a href="javascript:;" id="click_aid_9_5" onclick="addbt(this);"data-href="{{url('biaotai/'.$detail->art_id.'/4/2')}}"> 
            <div class="atdc"> 
             <div class="ac4" style="height:{{$bt[3]*2+1}}px;"> 
              <em>{{$bt[3]}}</em> 
             </div> 
            </div> <img src="{{asset('resources/home/images/luguo.gif')}}" alt="" /><br />路过</a> </td> 
          <td> <a href="javascript:;" id="click_aid_9_5" onclick="addbt(this);"data-href="{{url('biaotai/'.$detail->art_id.'/5/2')}}"> 
            <div class="atdc"> 
             <div class="ac4" style="height:{{$bt[4]*2+1}}px;"> 
              <em>{{$bt[4]}}</em> 
             </div> 
            </div> <img src="{{asset('resources/home/images/jidan.gif')}}" alt="" /><br />鸡蛋</a> </td> 
         </tr> 
        </tbody>
       </table> 
       <h3 class="mbm xs1"> 刚表态过的朋友 (<a href="javascript:;">{{count($btmember)}}) 人</a>) </h3> 
       <div id="trace_div" class="xs1"> 
        <ul id="trace_ul" class="ml mls cl">
         @foreach($btmember as $v)
         <li> 
          <div class="avt">
           <a href="" target="_blank" title="鲜花">
               <img src="{{asset($v->userface)}}" />
           </a>
          </div> 
          <p><a href="" title="wx_Dm66bl8" target="_blank">{{$v->nickname}}</a></p> 
         </li> 
        @endforeach
        </ul>  
       </div> 
      </div> 
      <!--[diy=diycontentclickbottom]-->
      <div id="diycontentclickbottom" class="area"></div>
      <!--[/diy]--> 
      <div class="bdsharebuttonbox bdshare-button-style0-24" data-bd-bind="1528708776998">
       <a href="#" class="bds_more" data-cmd="more"></a>
       <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
       <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
       <a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a>
       <a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
       <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>
      </div> 
       
     </div> 
<!--     <div class="o cl ptm pbm"> 
      <a href="" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);" class="oshr ofav">收藏</a> 
      <a href="" id="a_share" onclick="showWindow(this.id, this.href, 'get', 0);" class="oshr">分享</a> 
      <a href="" id="a_invite" onclick="showWindow('invite', this.href, 'get', 0);" class="oshr oivt">邀请</a> 
     </div> -->
     <div class="pren pbw ptw cl"> 
      @if($pre)
         <em>上一篇：<a href="{{url('blog_'.$pre->art_id.'.html')}}">{{$pre->art_title}}</a></em>
      @endif
      @if($next)
         <em>下一篇：<a href="{{url('blog_'.$next->art_id.'.html')}}">{{$next->art_title}}</a></em>
      @endif
     </div> 
    </div> 
    <!--[diy=diycontentrelatetop]-->
    <div id="diycontentrelatetop" class="area"></div>
    <!--[/diy]-->
    <div id="related_article" class="bp"> 
     <div class="blocktitle title">
      相关阅读
     </div> 
     <div class="hotPost"> 
      <div class="block" style="margin:0;"> 
       <div class="module cl xl xl1"> 
        <ul id="raid_div">
         @foreach($xg as $v)
            <li><a href="{{url('blog_'.$v->art_id.'.html')}}">{{$v->art_title}}</a></li>
         @endforeach
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
    <!--[diy=diycontentrelate]-->
    <div id="diycontentrelate" class="area"></div>
    <!--[/diy]--> 
    <div class="pComment">
     <div id="comment" class="bm"> 
      <div class="bm_h cl"> 
       <a href="javascript:;" class="y xi2" onclick="location.href=location.href.replace(/(\#.*)/, '')+'#cform';$('message').focus();return false;">发表评论</a> 
       <h3>最新评论&nbsp;(<em id="_commentnum">{{count($rep)}}</em>)</h3> 
      </div> 
      <div id="comment_ul" class="bm_c">      
       <a name="comment_anchor_49"></a> 
       @if(count($rep)>0)
        @foreach($rep as $v)
        <dl id="comment_49_li" class="ptm pbm bbda cl">
         <dt class="mbm" style="float:left;margin-right:20px"> 
             <img src="{{asset($v->userface)}}" width="40">
         </dt>
         <dt class="mbm"> 
          <!--<span class="y xw0 xi2"> <a href="javascript:;" onclick="portal_comment_requote(49, '9');">引用</a> </span>--> 
          <a href="" class="xi2 xw1" c="1" mid="card_4265">{{$v->nickname}}</a> 
          <span class="xg1 xw0">{{word_time($v->created_at,1)}}</span> 
         </dt> 
         <dd>
         {{$v->content}}
        </dd> 
       </dl>
        @endforeach
        <p class="ptm pbm"><a href="" class="xi2">查看全部评论(<em id="_commentnum">{{count($rep)}}</em>)</a></p>
       @endif

       <form id="cform" name="cform" action="{{url('addrep/'.$detail->art_id.'/2')}}" method="post" autocomplete="off">
           {{csrf_field()}} 
        <div class="tedt"> 
         <div class="area"> 
          <textarea name="content" rows="3" class="pt" id="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');"></textarea> 
         </div> 
        </div> 
        <p class="ptn">
            <button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="pn">
                <strong>评论</strong>
            </button>
        </p> 
       </form>
      </div> 
     </div>
    </div> 
    <!--[diy=diycontentcomment]-->
    <div id="diycontentcomment" class="area"></div>
    <!--[/diy]--> 
   </div> 
   <div class="sd pph"> 
<!--    <div class="sdBtn bp"> 
     <a href="" target="_blank" class="signin">马上签到</a> 
    </div> -->
    <div class="drag"> 
     <!--[diy=diyrighttop]-->
     <div id="diyrighttop" class="area"></div>
     <!--[/diy]--> 
    </div> 
    <div class="bp colu"> 
     <div class="blocktitle title"> 
      <span class="titletext">相关分类</span> 
     </div> 
     <div class="dxb_bc" style="padding-bottom:20px;"> 
      <ul class="module cl xl xl2 cl">
       @foreach($cates as $v)
          <li> <a href="{{url('blog?cid='.$v->id)}}">{{$v->defectsname}}</a></li> 
       @endforeach
      </ul> 
     </div> 
    </div> 
    <div class="hotPost bp"> 
     <!--[diy=diy12]-->
     <div id="diy12" class="area">
      <div id="frameP74r1Q" class="cl_frame_bm frame move-span cl frame-1">
       <div id="frameP74r1Q_left" class="column frame-1-c">
        <div id="frameP74r1Q_left_temp" class="move-span temp"></div>
        <div id="portal_block_60" class="cl_block_bm block move-span">
         <div class="blocktitle title">
          <span  class="titletext">热帖推荐</span>
         </div>
         <div id="portal_block_60_content" class="dxb_bc">
          <div class="module cl xl xl1"> 
           <ul>
            @if(count($hotForum)>0)
                @foreach($hotForum as $v)
                     <li><a href="{{url('forum_list_detail/'.$v->forum_id.'?&pid='.$v->pid)}}" title="{{$v->title}}" target="_blank">{{$v->title}}</a></li>
                @endforeach
               @endif
           </ul> 
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <!--[/diy]--> 
    </div> 
    <div class="hotAct bp"> 
     <!--[diy=diy10]-->
     <div id="diy10" class="area">
      <div id="frameB5kNqK" class="cl_frame_bm frame move-span cl frame-1">
       <div id="frameB5kNqK_left" class="column frame-1-c">
        <div id="frameB5kNqK_left_temp" class="move-span temp"></div>
        <div id="portal_block_59" class="cl_block_bm block move-span">
         <div class="blocktitle title">
          <span class="titletext">热门文章</span>
         </div>
         <div id="portal_block_59_content" class="dxb_bc">
          <div class="module cl ml"> 
           <ul>
            @foreach($hot as $v)
            <li style="width: 250px;"> <a href="{{url('blog_'.$v->art_id.'.html')}}" target="_blank">
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
     <!--[/diy]--> 
    </div> 
    <div class="drag"> 
     <!--[diy=diy2]-->
     <div id="diy2" class="area"></div>
     <!--[/diy]--> 
    </div> 
   </div> 
  </div> 
  <div class="wp mtn"> 
   <!--[diy=diy3]-->
   <div id="diy3" class="area"></div>
   <!--[/diy]--> 
  </div> 
  <script>
  jQuery("#nv li").removeClass("a");
  jQuery("#mn_N6e20").addClass("a");
  jQuery("pre").addClass("layui-code");
    layui.use(['layer','form','code'], function(){
      var form = layui.form
      ,layer = layui.layer;
      layui.code({
        title: '代码',
        about: false
//        ,encode: true
        ,skin: 'notepad' //如果要默认风格，不用设定该key。
      });
    })
   function addbt(obj){
          if({{$isbt}}>0){
             layer.msg("您已表过态,请勿重复操作!");
                return false; 
          }else{
              window.location.href=jQuery(obj).attr('data-href');
          }
      }
  </script>
@endsection

