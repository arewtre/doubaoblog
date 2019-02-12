@extends('layouts.home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/home/css/style_2_forum_forumdisplay.css')}}" />
   <!--[diy=diynavtop]-->
   <div id="diynavtop" class="area"></div>
   <!--[/diy]--> 
   <div id="pt" class="bm cl"> 
    <div class="z"> 
     <a href="" class="nvhm" title="首页">首页</a>
     <em>&raquo;</em>
     <a href="{{url('forum')}}">论坛</a> 
     <em>›</em> 
<!--     <a href=""></a>
     <em>›</em> -->
     <a href="#">{{$mod->defectsname}}</a>
    </div> 
    <span class="y"> <a href="" target="_blank" title="RSS">订阅</a> </span> 
   </div> 
   <div class="wp"> 
    <!--[diy=diy1]-->
    <div id="diy1" class="area"></div>
    <!--[/diy]--> 
   </div> 
   <div class="boardnav"> 
    <div id="ct" class="xr_list wp cl ct2"> 
     <div class="mn"> 
      <div class="bp"> 
       <div class="listTit cl"> 
        <div class="forumIcon z"> 
         <img src="{{$mod->img}}" alt="{{$mod->defectsname}}" /> 
        </div> 
        <div class="xr_tit_c z"> 
         <div class="cl"> 
          <h1 class="z">{{$mod->defectsname}}</h1> 
          <a class="favBtn z" href="" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);">+ 关注</a> 
         </div> 
         <p class="xg2">{{$mod->dec}}</p>
        </div> 
        <div class="xr_tit_r z"> 
         <div class="xr_stat y"> 
          <ul class="cl"> 
           <li> 今日 <span>0</span> </li> 
           <li>主题<span>15</span></li> 
           <li>排名<span title="上次排名:7">12</span></li> 
           <li class="last">关注<span id="number_favorite_num">34</span></li> 
          </ul> 
         </div> 
        </div> 
       </div> 
      </div> 
      <div class="drag"> 
       <!--[diy=diy12]-->
       <div id="diy12" class="area"></div>
       <!--[/diy]--> 
      </div> 
      <div id="threadlist" class="xr_tl bp"> 
       <div class="th"> 
        <table cellspacing="0" cellpadding="0"> 
         <tbody>
          <tr> 
           <th colspan="2"> 
            <div class="tf"> 
             <a id="filter_special" href="javascript:;" class="allpost_ico xi2" onclick="showMenu(this.id)"> <span class="showmenu">全部主题</span> </a> 
             <a href="{{url('forum_list/'.$id.'?filter=created_at')}}" class="lastpost_ico xi2"> 最新 </a> 
             <a href="{{url('forum_list/'.$id.'?filter=views')}}" class="hotpost_ico xi2"> 热帖 </a> 
             <a href="{{url('forum_list/'.$id.'?filter=is_top')}}" class="digestpost_ico xi2"> 精华 </a> 
             <a id="filter_dateline" href="javascript:;" class="showmenu xi2" onclick="showMenu(this.id)">更多</a> 
             <a href="javascript:;" onclick="checkForumnew_btn('54')" title="查看更新" class="forumrefresh"></a> 
             <span id="clearstickthread" style="display: none;"> <span class="pipe">|</span> <a href="javascript:;" onclick="clearStickThread()" class="xi2" title="显示置顶">显示置顶</a> </span> 
            </div> </th> 
           <!--<td class="by"> <span id="atarget" onclick="setatarget(1)" class="y" title="在新窗口中打开帖子">新窗</span> </td>--> 
          </tr> 
         </tbody>
        </table> 
       </div> 
       <div class="tl"> 
        <div id="forumnew" style="display:none"></div> 
        <form method="post" autocomplete="off" name="moderate" id="moderate" action=""> 
         <input type="hidden" name="formhash" value="8a2c1533" /> 
         <input type="hidden" name="listextra" value="page%3D1" /> 
         <table summary="forum_54" cellspacing="0" cellpadding="0" id="threadlisttableid"> 
          <tbody> 
           <tr> 
            <td class="h_avatar"><img src="{{asset('resources/home/images/ann_icon.png')}}" alt="公告" /></td> 
            <th class="common"> 
             <div class="tl_tit cl"> 
              <h3>公告: <a class="xst" href="" target="_blank">豆宝网已更新上线了</a></h3> 
             </div> 
             <div class="tl_txt cl"> 
              <p class="publisher"> <a href="" c="1">admin</a> 于 <em style="color:#aaa;">2018-4-8</em> 发布 </p>
             </div> </th> 
            <td class="w1"></td> 
            <td class="w1"></td> 
            <td class="w1"></td> 
           </tr> 
          </tbody> 
          <tbody id="separatorline" class="emptb">
           <tr>
            <td class="h_avatar"></td>
            <th></th>
            <td></td>
            <td></td>
            <td></td>
           </tr>
          </tbody> 
          @if(count($data)>0)
          @foreach($data as $k=>$v)
          <tbody id="normalthread_5464"> 
           <tr> 
            <td class="h_avatar"> 
              <a href=""><img src="{{asset($v->userface)}}" /></a> 
            </td> 
            <th class="common"> 
             <div class="tl_tit cl"> 
              <span class="views y"> {{$v->views}}</span> 
              <span class="y" style="margin-top:4px;width:80px;"> 
                  <a href="javascript:;" id="content_5464" class="showcontent y" title="更多操作" onclick="CONTENT_TID='5464';CONTENT_ID='normalthread_5464';showMenu({'ctrlid':this.id,'menuid':'content_menu'})"></a> 
              </span> 
              <h3> 
                  <a href="{{url('forum_list_detail/'.$v->forum_id.'/'.$v->pid)}}" onclick="atarget(this)" class="xst" style="max-width:400px">【图片投票】{{$v->title}}</a> 
                  @if(count(html2imgs($v->content))>0)
                  <img src="{{asset('resources/home/images/image_s.gif')}}" alt="attach_img" title="图片附件" align="absmiddle" /> 
                  @endif
                  @if($v->reps>5 && $v->reps<=10)
                  <img src="{{asset('resources/home/images/recommend_1.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v->reps}}" />
                  @elseif($v->reps>10 && $v->reps<=20)
                  <img src="{{asset('resources/home/images/recommend_2.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v->reps}}" /> 
                  @elseif($v->reps>20)
                  <img src="{{asset('resources/home/images/recommend_3.gif')}}" align="absmiddle" alt="recommend" title="评价指数 {{$v->reps}}" /> 
                  @endif
                  @if($v->views>5 && $v->views<=10)
                  <img src="{{asset('resources/home/images/hot_1.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v->views}}" /> 
                  @elseif($v->views>10 && $v->views<=20)
                  <img src="{{asset('resources/home/images/hot_2.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v->views}}" /> 
                  @elseif($v->views>20)
                  <img src="{{asset('resources/home/images/hot_3.gif')}}" align="absmiddle" alt="heatlevel" title="热度: {{$v->views}}" /> 
                  @endif
                  <!--<span class="tps">&nbsp;...<a href="">2</a></span>--> 
              </h3> 
             </div> 
             <div class="tl_picList cl cfix">
              <div class="xinruiInfo">
               {{mb_substr($v->content,0,54,'utf-8')}}....
              </div>
              <div class="xinruiPic cl cfix">
               <ul>
                @foreach(html2imgs($v->content) as $vv)
                   <li><span><img id="_aimg_611" aid="611" onclick="zoom(this, this.getAttribute('zoomfile'), 0, 0, '')" zoomfile="{{asset($vv['src'])}}" src="{{asset($vv['src'])}}" alt="" title="" w="850" /></span></li>
                @endforeach
               </ul>
              </div>
             </div>
             <div class="tl_txt cl"> 
              <span class="replies y">{{$v->reps}}</span> 
              <p class="publisher"> <a href="" c="1">{{$v->nickname}}</a> 于 <span>{{word_time($v->created_at,1)}}</span> 发布 </p> 
              <p class="replyer"> <a href="" c="1">{{$v->lastrepname}}</a> 最后回复 <a href="">{{word_time($v->lastrepcreated_at,1)}}</a> </p> 
             </div> 
            </th> 
            <td class="w1"></td> 
            <td class="w1"></td> 
            <td class="w1"></td> 
           </tr> 
          </tbody> 
           @endforeach
           @else
           <tbody class="bw0_all"><tr><th colspan="5"><p class="emp">本版块或指定的范围内尚无主题</p></th></tr></tbody>
          @endif
         </table>
         <!-- end of table "forum_G[fid]" branch 1/3 --> 
        </form> 
       </div> 
       <div class="bm bw0 pgs cl"> 
        <div id="pgt" class="pgs mbm cl "> 
     <div class="pgt">
        <div class="pg">
            <div id="demo7"></div>
        </div>
     </div> 
     <span class="y pgb" id="visitedforums">
         <a href="{{url('forum')}}" style="margin-top:12px;margin-right:10px">返回列表</a></span> 
     <a id="newspecial" href="{{url('forumAdd')}}" title="发新帖">
         <img src="{{asset('resources/home/images/pn_post.png')}}" alt="发新帖" /></a>
    </div>
       </div> 
      </div> 
      <div id="filter_special_menu" class="p_pop" style="display:none" change=""> 
       <ul> 
        <li><a href="">全部主题</a></li> 
        <li><a href="">投票</a></li>
        <li><a href="">商品</a></li>
        <li><a href="">悬赏</a></li>
        <li><a href="">活动</a></li>
        <li><a href="">辩论</a></li>
       </ul> 
      </div> 
      <div id="filter_reward_menu" class="p_pop" style="display:none" change=""> 
       <ul> 
        <li><a href="">全部悬赏</a></li> 
        <li><a href="">进行中</a></li>
        <li><a href="">已解决</a></li>
       </ul> 
      </div> 
      <div id="filter_dateline_menu" class="p_pop" style="display:none"> 
       <ul class="pop_moremenu"> 
        <li>排序: <a href="">发帖时间</a><span class="pipe">|</span> 
            <a href="">回复/查看</a><span class="pipe">|</span> 
            <a href="">查看</a> </li> 
        <li>时间: <a href="" class="xw1">全部时间</a><span class="pipe">|</span> 
            <a href="">一天</a><span class="pipe">|</span> 
            <a href="">两天</a><span class="pipe">|</span> 
            <a href="">一周</a><span class="pipe">|</span> 
            <a href="">一个月</a><span class="pipe">|</span> 
            <a href="">三个月</a> </li> 
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
      <!--[diy=diyfastposttop]-->
      <div id="diyfastposttop" class="area"></div>
      <!--[/diy]--> 
      <!--[diy=diyforumdisplaybottom]-->
      <div id="diyforumdisplaybottom" class="area"></div>
      <!--[/diy]--> 
     </div> 
     <div class="sd"> 
      <div class="sdBtn bp"> 
       <a href="{{url('forumAdd')}}" class="post_btn">发表新帖</a> 
       <a href="" target="_blank" class="signin">马上签到</a> 
      </div> 
      <div class="colu bp">
       <!--[diy=diy3]-->
       <div id="diy3" class="area">
        <div id="framevDd0GO" class="cl_frame_bm frame move-span cl frame-1">
         <div id="framevDd0GO_left" class="column frame-1-c">
          <div id="framevDd0GO_left_temp" class="move-span temp"></div>
          <div id="portal_block_12" class="cl_block_bm block move-span">
           <div class="blocktitle title">
            <span class="titletext">版块导航</span>
           </div>
           <div id="portal_block_12_content" class="dxb_bc">
            <div class="module cl xl xl2"> 
             <ul>
              @foreach($fcate as $v)
                <li @if($cid==$v->id) class="cur" @endif> <a href="{{url('forum_list/'.$v->id)}}">{{$v->defectsname}}</a></li> 
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
      <div class="hotAct bp"> 
       <!--[diy=diy10]-->
       <div id="diy10" class="area">
        <div id="frameEcgDls" class="cl_frame_bm frame move-span cl frame-1">
         <div id="frameEcgDls_left" class="column frame-1-c">
          <div id="frameEcgDls_left_temp" class="move-span temp"></div>
          <div id="portal_block_16" class="cl_block_bm block move-span">
           <div class="blocktitle title">
            <span class="titletext">热门文章</span>
           </div>
           <div id="portal_block_16_content" class="dxb_bc">
            <div class="module cl ml"> 
             <ul>
              @foreach($hot as $v)
             <li style="width: 250px;"> <a href="{{url('news_'.idEncryption($v->art_id).'.html')}}" target="_blank">
              <img src="{{$v->art_thumb}}" width="250" height="150" alt="{{$v->art_title}}" /></a> 
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
      <div class="fans bp">
       <!--[diy=diy4]-->
       <div id="diy4" class="area">
        <div id="frameTK37iY" class="cl_frame_bm frame move-span cl frame-1">
         <div id="frameTK37iY_left" class="column frame-1-c">
          <div id="frameTK37iY_left_temp" class="move-span temp"></div>
          <div id="portal_block_13" class="cl_block_bm block move-span">
           <div class="blocktitle title">
            <span  class="titletext">热心居民</span>
           </div>
           <div id="portal_block_13_content" class="dxb_bc">
            <div class="module cl ml mlm"> 
             <ul>
              @foreach($member as $v)
                <li> <a href="" c="1" target="_blank" mid="card_1169">
                     <img src="{{asset($v->userface)}}" width="100" height="100" alt="{{$v->nickname}}" />
                 </a> 
                 <p><a href="" title="xinrui" target="_blank">{{$v->nickname}}</a></p> 
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
      <div class="mbm">
       <!--[diy=diy6]-->
       <div id="diy6" class="area"></div>
       <!--[/diy]-->
      </div> 
      <div class="mbm">
       <!--[diy=diy7]-->
       <div id="diy7" class="area"></div>
       <!--[/diy]-->
      </div> 
      <div class="drag"> 
       <!--[diy=diy2]-->
       <div id="diy2" class="area"></div>
       <!--[/diy]--> 
      </div> 
     </div> 
    </div> 
   </div> 
   <div id="visitedforums_menu" class="p_pop blk cl" style="display: none;"> 
    <table cellspacing="0" cellpadding="0"> 
     <tbody>
      <tr> 
       <td id="v_forums"> <h3 class="mbn pbn bbda xg1">浏览过的版块</h3> 
        <ul class="xl xl1"> 
         <li><a href="">列表图片显示</a></li>
         <li><a href="">O粉玩机</a></li>
         <li><a href="">图片瀑布流</a></li>
         <li><a href="">OPPO Find 7</a></li>
        </ul> </td> 
      </tr> 
     </tbody>
    </table> 
   </div> 
   <div class="wp mtn"> 
    <!--[diy=diy11]-->
    <div id="diy11" class="area"></div>
    <!--[/diy]--> 
   </div> 

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
    ,limit:20
    ,curr: {{$page}} 
    ,jump: function(obj,first){
      //console.log(obj)
      if(!first){   
            window.location.href="/forum_list/{{$id}}?page="+obj.curr;
        }  
    }
  });
  });
  </script>
@endsection