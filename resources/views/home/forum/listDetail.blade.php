@extends('layouts.home3')
@section('content')
<script src="{{asset('resources/home/js/jquery-1.11.0.min.js')}}" type="text/javascript"></script> 
<script src="{{asset('resources/home/js/common.js')}}" type="text/javascript"></script> 
<script src="{{asset('resources/home/js/forum.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_common.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_viewthread.css')}}" />
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
.cont img{
    max-width:100%;margin-top:25px;
}
</style>
<div id="wp" class="wp"> 
   <script type="text/javascript">var fid = parseInt('46'), tid = parseInt('12');</script> 
   <script src="{{asset('resources/home/js/forum_viewthread.js')}}" type="text/javascript"></script> 
   <script type="text/javascript">zoomstatus = parseInt(1);var imagemaxwidth = '900';var aimgcount = new Array();</script> 
   <style id="diy_style" type="text/css"></style> 
   <!--[diy=diynavtop]-->
   <div id="diynavtop" class="area"></div>
   <!--[/diy]--> 
   <div id="pt" class="bm cl gray"> 
    <div class="z"> 
     <a href="{{url('forum')}}" title="论坛首页">{{Site::get('webname')}}论坛首页</a> 
     <em>›</em> 
     <a href="{{url('forum_list/'.$mod->id)}}">{{$mod->defectsname}}</a> 
     <em>›</em> 
     <a href="#">{{$forum->title}}</a> 
    </div> 
   </div>  
   <div id="ct" class="wp cl"> 
    <div id="pgt" class="pgs mbm cl ">  
     <span class="y pgb" id="visitedforums" >
         <a href="{{url('forum_list/'.$mod->id)}}" style="margin-top:12px">返回列表</a></span> 
         <a href="{{url('forumAdd')}}" title="发新帖">
            <!--<img src="{{asset('resources/home/images/pn_post.png')}}" alt="发新帖" />-->
            <button type="button" class="pn pnc vm" id="fastpostsubmit" value="replysubmit" tabindex="5"><strong>发表新帖</strong></button>
         </a>
    </div> 
    <div id="postlist" class="pl xr_view"> 
     @if($page==1)
     <table cellspacing="0" cellpadding="0"> 
      <tbody>
       <tr> 
        <td class="pls ptn pbn"> 
         <div class="hm ptn"> 
          <span class="xg1">查看:</span> 
          <span class="xi1">{{$forum->views}}</span>
          <span class="pipe">|</span>
          <span class="xg1">回复:</span> 
          <span class="xi1">{{$forum->reps}}</span> 
         </div> </td> 
        <td class="plc ptm pbn vwthd"> 
        <div class="y"> 
        <!--<a href="" title="打印" target="_blank"><img src="{{asset('resources/home/images/forum/print.png')}}" alt="打印" class="vm" /></a>--> 
        <a href="" title="上一主题"><img src="{{asset('resources/home/images/forum/thread-prev.png')}}" alt="上一主题" class="vm" /></a> 
        <a href="" title="下一主题"><img src="{{asset('resources/home/images/forum/thread-next.png')}}" alt="下一主题" class="vm" /></a> 
        </div> 
            <h1 class="ts"> <a href="">[{{$forum->defectsname}}]</a> 
                <span id="thread_subject">{{$forum->title}}</span> 
            </h1> 
            <span class="xg1"> &nbsp;
<!--            <img src="{{asset('resources/home/images/forum/recommend_3.gif')}}" alt="" title="评价指数 57" /> &nbsp;
            <img src="{{asset('resources/home/images/forum/hot_3.gif')}}" alt="" title="热度: 204" /> -->
            <input type="hidden" id="url" value="{{url()->current()}}">
            <!--<a href="javascript:;" onclick="myCopy()">[复制链接]</a> </span> </td>--> 
       <script>
    function myCopy(){
        var url = document.getElementById("url").value;
        window.clipboardData.setData("Text",url);
        alert("复制链接成功！");
    }
</script>
       </tr> 
      </tbody>
     </table> 

     <div id="post_{{$forum->forum_id}}}">
      <table id="pid13" class="plhin" summary="pid13" cellspacing="0" cellpadding="0"> 
       <tbody>
        <tr> 
         <td class="pls" rowspan="2"> 
          <div id="favatar13" class="pls favatar"> 
           <div class="p_pop blk bui card_gender_0" id="userinfo13" style="display: none; margin-top: -11px;"> 
            <div class="m z"> 
             <div id="userinfo13_ma"></div> 
            </div> 
            <div class="i y"> 
             <div> 
              <strong><a href="" target="_blank" class="xi2">{{$forum->nickname}}</a></strong> 
              <em>当前离线</em> 
             </div>
             <dl class="cl"> 
              <dt>
               积分
              </dt>
              <dd>
               <a href="" target="_blank" class="xi2">{{$forum->score}}</a>
              </dd> 
             </dl>
<!--             <div class="imicn"> 
              <a href="javascript:;" target="_blank" title="查看详细资料"><img src="{{asset('resources/home/images/forum/userinfo.gif')}}" alt="查看详细资料" /></a> 
              <a href="javascript:;" id="a_showip_li_13" class="xi2" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/showip.small.gif')}}" alt="" /> 窥视卡</a> 
              <a href="javascript:;" id="a_repent_13" class="xi2" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/checkonline.small.gif')}}" alt="" /> 雷达卡</a> 
             </div> -->
             <div id="avatarfeed">
              <span id="threadsortswait"></span>
             </div> 
            </div> 
           </div> 
           <div> 
            <div class="avatar" onmouseover="showauthor(this, 'userinfo13')">
             <a href="" class="avtm" target="_blank"><img src="{{asset($forum->userface)}}" /></a>
            </div> 
           </div> 
           <div class="authi">
            <a href="" target="_blank" class="xw1">{{$forum->nickname}}</a> 
           </div> 
           <p>该用户从未签到</p>
           <div class="tns xg2">
            <table cellspacing="0" cellpadding="0">
             <tbody>
              <tr>
               <!--<th><p><a href="" class="xi2">11</a></p>主题</th>-->
               <th><p><a href="" class="xi2">{{$forum->forumNum}}</a></p>帖子</th>
               <td><p><a href="" class="xi2">{{$forum->score}}</a></p>积分</td>
              </tr>
             </tbody>
            </table>
           </div> 
           <p><em><a href="JavaScript:;" target="_blank">论坛元老</a></em></p> 
           <p><span id="g_up13" onmouseover="showMenu({'ctrlid':this.id, 'pos':'12!'});">
                   <img src="{{asset('resources/home/images/forum/star_level3.gif')}}" alt="Rank: 8" />
                   <img src="{{asset('resources/home/images/forum/star_level3.gif')}}" alt="Rank: 8" /></span></p> 
           <div id="g_up13_menu" class="tip tip_4" style="display: none;">
            <div class="tip_horn"></div>
            <div class="tip_c">
             论坛元老, 积分 {{$forum->score}}, 距离下一级还需 {{1000 - $forum->score}} 积分
            </div>
           </div> 
           <p><span class="pbg2" id="upgradeprogress_13" onmouseover="showMenu({'ctrlid':this.id, 'pos':'12!', 'menuid':'g_up13_menu'});">
                   <span class="pbr2" style="width:2%;"></span></span></p> 
           <div id="g_up13_menu" class="tip tip_4" style="display: none;">
            <div class="tip_horn"></div>
            <div class="tip_c">
             论坛元老, 积分 {{$forum->score}}, 距离下一级还需 {{1000 - $forum->score}}积分
            </div>
           </div> 
           <dl class="pil cl"> 
            <dt>
             积分
            </dt>
            <dd>
             <a href="JavaScript:;" target="_blank" class="xi2">{{$forum->score}}</a>
            </dd> 
           </dl> 
           <p class="md_ctrl"><a href="">
                   <img id="md_13_1" src="{{asset('resources/home/images/forum/medal1.gif')}}" alt="最佳新人" title="" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_1_menu', 'pos':'12!'})" />
                   <img id="md_13_2" src="{{asset('resources/home/images/forum/medal2.gif')}}" alt="活跃会员" title="" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_2_menu', 'pos':'12!'})" />
                   <img id="md_13_3" src="{{asset('resources/home/images/forum/medal3.gif')}}" alt="热心会员" title="" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_3_menu', 'pos':'12!'})" /></a></p> 
           <dl class="pil cl"></dl>
           <ul class="xl xl2 o cl"> 
            <!--<li class="addflw"> <a href="" id="followmod_3" title="收听TA" class="xi2" onclick="showWindow('followmod', this.href, 'get', 0);">收听TA</a> </li>--> 
            <!--<li class="pm2"><a href="" onclick="showWindow('sendpm', this.href);" title="发消息" class="xi2">发消息</a></li>--> 
           </ul> 
          </div> </td> 
         <td class="plc"> 
          <div class="pi"> 
           <strong class="y" style="margin:-5px 0 0 20px;"> <a href="javascript:;" id="postnum13" class="ma_flow ma_flow_1"> 楼主</a> </strong> 
<!--           <div id="fj" class="y"> 
            <label class="z">电梯直达</label> 
            <input type="text" class="px p_fre z" size="2" onkeyup="$('fj_btn').href='forum.php?mod=redirect&amp;ptid=12&amp;authorid=0&amp;postno='+this.value" onkeydown="if(event.keyCode==13) {window.location=$('fj_btn').href;return false;}" title="跳转到指定楼层" /> 
            <a href="javascript:;" id="fj_btn" class="z" title="跳转到指定楼层">
                <img src="{{asset('resources/home/images/forum/fj_btn.png')}}" alt="跳转到指定楼层" class="vm" /></a> 
           </div> -->
           <div class="pti"> 
            <div class="pdbt"> 
            </div> 
            <div class="authi"> 
             <img class="authicn vm" id="authicon13" src="{{asset('resources/home/images/forum/online_member.gif')}}" /> 
             <em id="authorposton13">发表于 {{word_time($forum->created_at,1)}}</em> 
             <span class="pipe">|</span> 
<!--             <a href="" rel="nofollow">只看该作者</a> 
             <span class="pipe">|</span>
             <a href="">只看大图</a> 
             <span class="none"><img src="{{asset('resources/home/images/forum/arw_r.gif')}}" class="vm" alt="回帖奖励" /></span> 
             <span class="pipe show">|</span>
             <a href="" class="show">倒序浏览</a> 
             <span class="pipe show">|</span>-->
             <a href="javascript:;" onclick="readmode($('thread_subject').innerHTML, 13);" class="show">阅读模式</a> 
            </div> 
           </div> 
          </div>
          <div class="pct">
           <style type="text/css">.pcb{margin-right:0}</style> 
           <div class="pcb"> 
            <div class="t_fsz"> 
             <table cellspacing="0" cellpadding="0">
              <tbody>
               <tr>
                <td class="t_f" id="postmessage_13"> <script type="text/javascript">replyreload += ',' + 13;</script>
                 <div align="center"> 
                  <ignore_js_op> 
                   <img id="aimg_14" aid="14" src="" zoomfile="" file="" class="zoom" onclick="zoom(this, this.src, 0, 0, 0)" width="900" inpost="1" onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})" initialized="true" /> 
                   <div class="tip tip_4 aimg_tip" id="aimg_14_menu" style="position: absolute; z-index: 301; left: 592px; top: 227px; display: none;" disautofocus="true" initialized="true"> 
                    <div class="xs0"> 
                     <p><strong>f636afc379310a55d0b07e10b54543a9832610b9.jpg</strong> <em class="xg1">(421.49 KB, 下载次数: 53)</em></p> 
                     <p> <a href="" target="_blank">下载附件</a> </p> 
                     <p class="xg1 y">2015-8-10 18:23 上传</p> 
                    </div> 
                    <div class="tip_horn"></div> 
                   </div> 
                  </ignore_js_op> 
                 </div>
                 @if($is_show==1)
                 <span class="cont">{!! nl2br($forum->content) !!}</span>
                 
                 @else
                 <div class="locked">
                  游客，如果您要查看本帖隐藏内容请
                  <a href="{{url('qqLogin')}}" >回复</a>
                 </div><br /> <br />
                 @endif
                </td>
               </tr>
              </tbody>
             </table> 
            </div> 
            <div id="comment_13" class="cm"> 
            </div> 
            <div id="post_rate_div_13"></div> 
           </div> 
          </div> </td>
        </tr> 
        <tr>
         <td class="plc plm"> 
          <!--分享--> 
          <div class="mtw"> 
           <span class="z xs2 mtm">分享到：</span> 
           <div class="bdsharebuttonbox bdshare-button-style0-32" data-bd-bind="1532077656101"> 
            <a href="#" class="bds_more" data-cmd="more"></a> 
            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a> 
            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a> 
            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a> 
            <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a> 
            <a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a> 
            <a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a> 
            <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a> 
            <a href="#" class="bds_twi" data-cmd="twi" title="分享到Twitter"></a> 
            <a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a> 
            <a href="#" class="bds_linkedin" data-cmd="linkedin" title="分享到linkedin"></a> 
           </div> 
           <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script> 
          </div> 
<!--          <div id="p_btn" class="mtw mbm hm cl"> 
           <a href="" id="k_favorite" onclick="showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('favoritenumber').innerHTML + ' 人收藏'" title="收藏本帖"><i><img src="{{asset('resources/home/images/forum/fav.gif')}}" alt="收藏" />收藏<span id="favoritenumber">23</span></i></a> 
           <a class="followp" href="" onclick="showWindow('relaythread', this.href, 'get', 0);" title="转播求扩散"><i><img src="{{asset('resources/home/images/forum/rt.png')}}" alt="转播" />转播<span id="relaynumber" style="display:none">1</span></i></a> 
           <a class="sharep" href="" onclick="showWindow('sharethread', this.href, 'get', 0);" title="分享推精华"><i><img src="{{asset('resources/home/images/forum/oshr.png')}}" alt="分享" />分享</i></a> 
           <a href="" id="k_collect" onclick="showWindow(this.id, this.href);return false;" onmouseover="this.title = $('collectionnumber').innerHTML + ' 人淘帖'" title="淘好帖进专辑"><i><img src="{{asset('resources/home/images/forum/collection.png')}}" alt="分享" />淘帖<span id="collectionnumber" style="display:none">0</span></i></a> 
           <a id="recommend_add" href="" onclick="showWindow('login', this.href)" onmouseover="this.title = $('recommendv_add').innerHTML + ' 人顶'" title="顶一下"><i><img src="{{asset('resources/home/images/forum/rec_add.gif')}}" alt="顶" />顶<span id="recommendv_add">57</span></i></a> 
           <a id="recommend_subtract" href="" onclick="showWindow('login', this.href)" onmouseover="this.title = $('recommendv_subtract').innerHTML + ' 人踩'" title="踩一下"><i><img src="{{asset('resources/home/images/forum/rec_subtract.gif')}}" alt="踩" />踩<span id="recommendv_subtract" style="display:none">0</span></i></a> 
          </div> -->
         </td> 
        </tr> 
        <tr id="_postposition13"></tr> 
        <tr> 
         <td class="pls"></td> 
         <td class="plc" style="overflow:visible;"> 
          <div class="po hin"> 
           <div class="pob cl"> 
            <em> <a class="fastre" href="" onclick="showWindow('reply', this.href)">回复</a> </em> 
            <!--<p> <a href="javascript:;" id="mgc_post_13" onmouseover="showMenu(this.id)" class="showmenu">使用道具</a> <a href="javascript:;" onclick="showWindow('miscreport13', 'misc.php?mod=report&amp;rtype=post&amp;rid=13&amp;tid=12&amp;fid=46', 'get', -1);return false;">举报</a> </p>--> 
            <ul id="mgc_post_13_menu" class="p_pop mgcmn" style="display: none;"> 
             <li><a href="" id="a_bump" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/bump.small.gif')}}" />提升卡</a></li> 
             <li><a href="" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/stick.small.gif')}}" />置顶卡</a></li> 
             <li><a href="" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/close.small.gif')}}" />沉默卡</a></li> 
             <li><a href="" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/open.small.gif')}}" />喧嚣卡</a></li> 
             <li><a href="" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/highlight.small.gif')}}" />变色卡</a></li> 
             <li><a href="" id="a_jack" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/jack.small.gif')}}" />千斤顶</a></li> 
             <li><a href="" id="a_namepost_13" onclick="showWindow(this.id, this.href)"><img src="{{asset('resources/home/images/forum/namepost.small.gif')}}" />照妖镜</a></li>
             <li> </li>
            </ul> 
            <script type="text/javascript" reload="1">checkmgcmn('post_13')</script> 
           </div> 
          </div> </td> 
        </tr> 
        <tr class="ad"> 
         <td class="pls"> </td> 
         <td class="plc"> </td> 
        </tr> 
       </tbody>
      </table> 
     </div>
        @endif
     @if(count($data)>0)
     @foreach($data as $k=>$v)
     <div id="post_{{$v->forum_id}}">
      <table id="pid25" class="plhin" summary="pid25" cellspacing="0" cellpadding="0"> 
       <tbody>
        <tr> 
         <td class="pls" rowspan="2"> 
          <div id="favatar25" class="pls favatar"> 
           <div class="p_pop blk bui card_gender_0" id="userinfo25" style="display: none; margin-top: -11px;"> 
            <div class="m z"> 
             <div id="userinfo25_ma"></div> 
            </div> 
            <div class="i y"> 
             <div> 
              <strong><a href="" target="_blank" class="xi2">{{$v->nickname}}</a></strong> 
              <em>当前离线</em> 
             </div>
             <dl class="cl"> 
              <dt>
               积分
              </dt>
              <dd>
               <a href="" target="_blank" class="xi2">1178</a>
              </dd> 
             </dl>
             <div class="imicn"> 
              <a href="" target="_blank" title="查看详细资料"><img src="{{asset('resources/home/images/forum/userinfo.gif')}}" alt="查看详细资料" /></a> 
              <a href="" id="a_showip_li_25" class="xi2" onclick="showWindow(this.id, this.href)">
                  <img src="{{asset('resources/home/images/forum/showip.small.gif')}}" alt="" /> 窥视卡</a> 
              <a href="" id="a_repent_25" class="xi2" onclick="showWindow(this.id, this.href)">
                  <img src="{{asset('resources/home/images/forum/checkonline.small.gif')}}" alt="" /> 雷达卡</a> 
             </div> 
             <div id="avatarfeed">
              <span id="threadsortswait"></span>
             </div> 
            </div> 
           </div> 
           <div> 
            <div class="avatar" onmouseover="showauthor(this, 'userinfo25')">
             <a href="" class="avtm" target="_blank"><img src="{{asset($v->userface)}}" /></a>
            </div> 
           </div> 
           <div class="authi">
            <a href="" target="_blank" class="xw1">{{$v->nickname}}</a> 
           </div> 
           <p>该用户从未签到</p>
           <div class="tns xg2">
            <table cellspacing="0" cellpadding="0">
             <tbody>
              <tr>
               <!--<th><p><a href="" class="xi2">9</a></p>主题</th>-->
               <th><p><a href="" class="xi2">{{$v->forumNum?$v->forumNum:0}}</a></p>帖子</th>
               <td><p><a href="" class="xi2">{{$v->score}}</a></p>积分</td>
              </tr>
             </tbody>
            </table>
           </div> 
           <p><em><a href="" target="_blank">管理员</a></em></p> 
           <p><span>
                   <img src="{{asset('resources/home/images/forum/star_level3.gif')}}" alt="Rank: 9" />
                   <img src="{{asset('resources/home/images/forum/star_level3.gif')}}" alt="Rank: 9" />
                   <img src="{{asset('resources/home/images/forum/star_level1.gif')}}" alt="Rank: 9" />
               </span></p> 
           <dl class="pil cl"> 
            <dt>
             积分
            </dt>
            <dd>
             <a href="" target="_blank" class="xi2">{{$v->score}}</a>
            </dd> 
           </dl> 
           <dl class="pil cl"></dl>
<!--           <ul class="xl xl2 o cl"> 
            <li class="addflw"> <a href="" id="followmod_1" title="收听TA" class="xi2" onclick="showWindow('followmod', this.href, 'get', 0);">收听TA</a> </li> 
            <li class="pm2"><a href="" onclick="showWindow('sendpm', this.href);" title="发消息" class="xi2">发消息</a></li> 
           </ul> -->
          </div> </td> 
         <td class="plc"> 
          <div class="pi"> 
           <strong class="y" style="margin:-5px 0 0 20px;"> 
               <a href="" id="postnum25" class="ma_flow ma_flow_-1" onclick="setCopy(this.href, '帖子地址复制成功');return false;">  
                   @if($k==0)
                     沙发
                     @elseif($k==1)
                     板凳
                     @elseif($k==2)
                     地板
                     @else
                     {{$k+1}}楼
                     @endif
               </a> 
           </strong> 
           <div class="pti"> 
            <div class="pdbt"> 
            </div> 
            <div class="authi"> 
             <img class="authicn vm" id="authicon25" src="{{asset('resources/home/images/forum/online_admin.gif')}}" /> 
             <em id="authorposton25">发表于 {{word_time($v->created_at,1)}}</em> 
             <span class="pipe">|</span> 
             <a href="" rel="nofollow">只看该作者</a> 
            </div> 
           </div> 
          </div>
          <div class="pct"> 
           <div class="pcb"> 
            <div class="t_fsz"> 
             <table cellspacing="0" cellpadding="0">
              <tbody>
               <tr>
                <td class="t_f" id="postmessage_25 "> 
                    @if($v->child)
                    <div class="quote">
                        <blockquote>
                            <font size="2">
                                <a href="" target="_blank">
                                <font color="#999999">{{$v->child->nickname}} 发表于 {{word_time($v->child->created_at,1)}}</font>
                                </a>
                            <br>
                                   
                                   <br>
                        </blockquote>
                    </div>
                    <br>
                    @endif
                <!--<span class="cont">{!! nl2br($v->content) !!}</span>-->
                <span class="cont conts" data-val="{{$v->content}}">{!! discuzcode(@nl2br($v->content)) !!}</span>
                 <!--<span class="conts" data-val = "{!! nl2br($v->content) !!}" ></span>-->
                </td>
               </tr>
              </tbody>
             </table> 
            </div> 
            <div id="comment_25" class="cm"> 
            </div> 
            <div id="post_rate_div_25"></div> 
           </div> 
          </div> </td>
        </tr> 
        <tr>
         <td class="plc plm"> </td> 
        </tr> 
        <tr id="_postposition25"></tr> 
        <tr> 
         <td class="pls"></td> 
         <td class="plc" style="overflow:visible;"> 
          <div class="po hin"> 
           <div class="pob cl"> 
            <em> <a class="fastre" href="" onclick="showWindow('reply', this.href)">回复</a> 
                <a class="replyadd" href="" onclick="showWindow('login', this.href)" onmouseover="this.title = ($('review_support_25').innerHTML ? $('review_support_25').innerHTML : 0) + ' 人 支持'">支持 <span id="review_support_25">2</span></a> <a class="replysubtract" href="" onclick="showWindow('login', this.href)" onmouseover="this.title = ($('review_against_25').innerHTML ? $('review_against_25').innerHTML : 0) + ' 人 反对'">反对 <span id="review_against_25">0</span></a> </em> 
            <!--<p> <a href="javascript:;" id="mgc_post_25" onmouseover="showMenu(this.id)" class="showmenu" initialized="true">使用道具</a> <a href="javascript:;" onclick="showWindow('miscreport25', 'misc.php?mod=report&amp;rtype=post&amp;rid=25&amp;tid=12&amp;fid=46', 'get', -1);return false;">举报</a> </p>--> 
<!--            <ul id="mgc_post_25_menu" class="p_pop mgcmn" style="position: absolute; z-index: 301; left: 1416.94px; top: 1975px; display: none;" initialized="true"> 
             <li><a href="" id="a_namepost_25" onclick="showWindow(this.id, this.href)" class="">
                     <img src="{{asset('resources/home/images/forum/namepost.small.gif')}}" />照妖镜</a></li>
             <li> </li>
            </ul> -->
            <script type="text/javascript" reload="1">checkmgcmn('post_25')</script> 
           </div> 
          </div> </td> 
        </tr> 
        <tr class="ad"> 
         <td class="pls"> </td> 
         <td class="plc"> </td> 
        </tr> 
       </tbody>
      </table> 
     </div>
     @endforeach
     @endif
     <div id="postlistreply" class="pl">
      <div id="post_new" class="viewthread_table" style="display: none"></div>
     </div> 
    </div> 
    <form method="post" autocomplete="off" name="modactions" id="modactions"> 
     <input type="hidden" name="formhash" value="de8683cb" /> 
     <input type="hidden" name="optgroup" /> 
     <input type="hidden" name="operation" /> 
     <input type="hidden" name="listextra" value="page%3D1" /> 
     <input type="hidden" name="page" value="1" /> 
    </form> 
    <div class="pgs mtm mbm cl"> 
     <div class="pg">
      <div id="demo8"></div>
     </div>
     <span class="y pgb" id="visitedforums" onmouseover="$('visitedforums').id = 'visitedforumstmp';this.id = 'visitedforums';showMenu({'ctrlid':this.id,'pos':'34'})">
         <a href="" style="margin-top:12px">返回列表</a></span>
     <!--<a id="newspecialtmp"  href="{{url('forumAdd')}}" title="发新帖"><img src="{{asset('resources/home/images/pn_post.png')}}" alt="发新帖" /></a>--> 
    </div> 
    <!--[diy=diyfastposttop]-->
    <div id="diyfastposttop" class="area"></div>
    <!--[/diy]--> 
    <div id="f_pst" class="pl bm bmw"> 
         @if(!session('userinfo.id'))
     <form method="post" autocomplete="off" id="fastpostform" action="" onsubmit="return fastpostvalidate(this)"> 
      <table cellspacing="0" cellpadding="0"> 
       <tbody>
        <tr> 
         <td class="pls"> </td> 
         <td class="plc"> <span id="fastpostreturn"></span> 
          <div class="cl"> 
           <div id="fastsmiliesdiv" class="y">
            <div id="fastsmiliesdiv_data">
             <div id="fastsmilies"></div>
            </div>
           </div>
           <div class="hasfsl" id="fastposteditor"> 
            <div class="tedt mtn"> 
             <div class="bar"> 
              <span class="y"> <a href="" onclick="return switchAdvanceMode(this.href)">高级模式</a> </span>
              <script src="{{asset('resources/home/js/seditor.js')}}" type="text/javascript"></script> 
              <div class="fpd"> 
               <a href="javascript:;" title="文字加粗" class="fbld">B</a> 
               <a href="javascript:;" title="设置文字颜色" class="fclr" id="fastpostforecolor">Color</a> 
               <a id="fastpostimg" href="javascript:;" title="图片" class="fmg">Image</a> 
               <a id="fastposturl" href="javascript:;" title="添加链接" class="flnk">Link</a> 
               <a id="fastpostquote" href="javascript:;" title="引用" class="fqt">Quote</a> 
               <a id="fastpostcode" href="javascript:;" title="代码" class="fcd">Code</a> 
               <a href="javascript:;" class="fsml" id="fastpostsml">Smilies</a> 
               <script type="text/javascript" reload="1">smilies_show('fastpostsmiliesdiv', 8, 'fastpost');</script>
               
              </div>
             </div> 
                
                <div class="area"> 
                   <div class="pt hm">
                        您需要登录后才可以回帖 
                       <a href="{{url('login')}}" class="xi2">登录</a> | 
                       <!--<a href="{{url('regester')}}" class="xi2">立即注册</a>--> 
                       <!--<a href="javascript:;" onclick="showWindow('', '')">-->
                           <!--<img src="{{asset('resources/home/images/forum/wechat_login.png')}}" class="vm" /></a>--> 
                       <a href="{{url('qqLogin')}}"><img src="{{asset('resources/home/images/forum/qq_login.gif')}}" class="vm" /></a> 
                  </div> 
             </div> 
            </div> 
           </div> 
          </div> 
          <div id="seccheck_fastpost"> 
          </div> <input type="hidden" name="formhash" value="de8683cb" /> 
          <input type="hidden" name="usesig" value="" /> 
          <input type="hidden" name="subject" value="  " /> <p class="ptm pnpost"> 
              <!--<a href="" class="y" target="_blank">本版积分规则</a>--> 
              <button type="button" onclick="showWindow('login', 'member.php?mod=logging&amp;action=login&amp;guestmessage=yes')" onmouseover="checkpostrule('seccheck_fastpost', 'ac=reply');this.onmouseover=null" name="replysubmit" id="fastpostsubmit" class="pn pnc vm" value="replysubmit" tabindex="5"><strong>发表回复</strong></button> 
              <!--<label class="lb"><input type="checkbox" name="adddynamic" class="pc" value="1" />回帖并转播</label> <label for="fastpostrefresh"><input id="fastpostrefresh" type="checkbox" class="pc" />回帖后跳转到最后一页</label>--> 
              <script type="text/javascript">if(getcookie('fastpostrefresh') == 1) {$('fastpostrefresh').checked=true;}</script> </p> </td> 
        </tr> 
       </tbody>
      </table> 
     </form> 
           @else
           <form class="layui-form" method="post" autocomplete="off" id="fastpostform" action=""> 
               {{csrf_field()}} 
      <table cellspacing="0" cellpadding="0"> 
       <tbody>
        <tr> 
         <td class="pls"> </td> 
         <td class="plc"> <span id="fastpostreturn"></span> 
          <div class="cl"> 
           <div id="fastsmiliesdiv" class="y">
            <div id="fastsmiliesdiv_data">
             <div id="fastsmilies"></div>
            </div>
           </div>
           <div class="hasfsl" id="fastposteditor"> 
            <div class="tedt mtn"> 
             <div class="bar"> 
              <!--<span class="y"> <a href="" onclick="return switchAdvanceMode(this.href)">高级模式</a> </span>-->
              <script src="{{asset('resources/home/js/seditor.js')}}" type="text/javascript"></script> 
              <div class="fpd"> 
               <a href="javascript:;" title="文字加粗" class="fbld" onclick="seditor_insertunit('fastpost', '[b]', '[/b]');doane(event);">B</a>
                <a href="javascript:;" title="设置文字颜色" class="fclr" id="fastpostforecolor" onclick="showColorBox(this.id, 2, 'fastpost');doane(event);">Color</a>
                <a id="fastpostimg" href="javascript:;" title="图片" class="fmg" onclick="seditor_menu('fastpost', 'img');doane(event);">Image</a>
                <a id="fastposturl" href="javascript:;" title="添加链接" class="flnk" onclick="seditor_menu('fastpost', 'url');doane(event);">Link</a>
                <a id="fastpostquote" href="javascript:;" title="引用" class="fqt" onclick="seditor_menu('fastpost', 'quote');doane(event);">Quote</a>
                <a id="fastpostcode" href="javascript:;" title="代码" class="fcd" onclick="seditor_menu('fastpost', 'code');doane(event);">Code</a>
                <a href="javascript:;" class="fsml" id="fastpostsml" onclick="showMenu({'ctrlid':this.id,'evt':'click','layer':2});return false;">Smilies</a>
                 <span class="pipe z">|</span><span id="spanButtonPlaceholder">上传</span>
              </div>
             </div> 
                <script type="text/javascript" reload="1">smilies_show('fastpostsmiliesdiv', 8, 'fastpost');</script>
             <div class="area"> 
                   <textarea rows="6" cols="80" name="message" id="fastpostmessage" onkeydown="seditor_ctlent(event, 'fastpostvalidate($(\'fastpostform\'))');" tabindex="4" class="pt"></textarea>  
             </div> 
            </div> 
           </div> 
          </div> 
          <div id="seccheck_fastpost"> 
          </div> 
             <p class="ptm pnpost"> 
              <!--<a href="" class="y" target="_blank">本版积分规则</a>--> 
              <input type="hidden" name="forum_id" value="{{$forum->forum_id}}">
              <button lay-submit lay-filter="admin-form" type="button" name="replysubmit" id="fastpostsubmit" class="pn pnc vm" value="replysubmit" ><strong>发表回复</strong></button> 
              <!--<label class="lb"><input type="checkbox" name="adddynamic" class="pc" value="1" />回帖并转播</label> <label for="fastpostrefresh"><input id="fastpostrefresh" type="checkbox" class="pc" />回帖后跳转到最后一页</label> <script type="text/javascript">if(getcookie('fastpostrefresh') == 1) {$('fastpostrefresh').checked=true;}</script> </p> </td>--> 
        </tr> 
       </tbody>
      </table> 
     </form>
                 
        @endif      
    </div> 
    
   </div> 
   <div class="wp mtn"> 
    <!--[diy=diy3]-->
    <div id="diy3" class="area"></div>
    <!--[/diy]--> 
   </div> 

  </div> 
<script src="{{asset('resources/home/js/bbcode.js')}}" type="text/javascript"></script>
    <script>
//    jQuery(function(){
//        var ht = jQuery(".conts").each(function(){
//            var hht = jQuery(this).attr('data-val');
//            var hhht = bbcode2html(hht);
//             console.log(hhht);
//            jQuery(this).html(hhht);
//        })
//        
//      
//       
//    })

    </script>
  <script>
  jQuery("#nv li").removeClass("a");
jQuery("#mn_forum").addClass("a");
  </script>
  <script>
layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer
  ,form = layui.form;
  
  form.on('submit(admin-form)', function(data){
        //console.log(data.field);//return;
        //var message = html2bbcode(data.field.message);
        //console.log(message);return;
        jQuery.ajax({
        type: "POST",
        url: "{{url('forum_rep')}}",
        data: data.field,
        success: function(msg){
            if( msg.code == 1 ){
                window.location.reload();
                layer.msg(msg.msg, {time:1500});
            }else{
                parent.layer.msg(msg.msg, {
                    icon: 5,
                    shade: [0.6, '#393D49'],
                    time:1500
                }); 
            }
        }
    });
    return false;
});
  
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
            window.location.href="/forum_list_detail/{{$forum->forum_id}}/{{$forum->pid}}?page="+obj.curr;
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
            window.location.href="/forum_list_detail/{{$forum->forum_id}}/{{$forum->pid}}?page="+obj.curr;
        }  
    }
  });
});
</script>
<script src="{{asset('resources/home/js/upload.js')}}" type="text/javascript"></script><script type="text/javascript">
//$(function(){
    

    var upload = new SWFUpload({
    upload_url: "{{url('wap/upload_add_qiniu')}}",
    post_params: {"uid" : "{{session('userinfo.id')}}", "_token":"{{csrf_token()}}"},
    file_size_limit : "1000",
    file_types : "*.chm;*.pdf;*.zip;*.rar;*.tar;*.gz;*.bzip2;*.gif;*.jpg;*.jpeg;*.png",
    file_types_description : "All Support Formats",
    file_upload_limit : 0,
    file_queue_limit : 0,
    swfupload_preload_handler : preLoad,
    swfupload_load_failed_handler : loadFailed,
    file_dialog_start_handler : fileDialogStart,
    file_queued_handler : fileQueued,
    file_queue_error_handler : fileQueueError,
    file_dialog_complete_handler : fileDialogComplete,
    upload_start_handler : uploadStart,
    upload_progress_handler : uploadProgress,
    upload_error_handler : uploadError,
    upload_success_handler : uploadSuccess,
    upload_complete_handler : uploadComplete,
    button_image_url : "/resources/home/image/uploadbutton_small.png",
    button_placeholder_id : "spanButtonPlaceholder",
    button_width: 17,
    button_height: 25,
    button_cursor:SWFUpload.CURSOR.HAND,
    button_window_mode: "transparent",
    custom_settings : {
        progressTarget : "attachlist",
        uploadSource: 'forum',
        uploadType: 'attach',
        uploadFrom: 'fastpost'
    },
    debug: false
    });
//    })
</script>
@endsection