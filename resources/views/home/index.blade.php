@extends('layouts.home')
@section('content')
<style>
    .jb{color: #fff !important;
        height: 30px;
        width: 150px;
        position: absolute;
        left: -40px;
        top:12px;
        text-align: center;
        line-height: 30px;
        font-family: "黑体";
        background-color: #FF7F84;
        -moz-transform:rotate(-35deg);
        -webkit-transform:rotate(-35deg);
        -o-transform:rotate(-35deg);
        -ms-transform:rotate(-35deg);
        transform:rotate(-35deg);
        z-index:999; 
    }
    
</style>
   <div class="wp cl"> 
    <div class="cl" style="margin-bottom:15px;"> 
     <!--[diy=diy13]-->
     <div id="diy13" class="area">
      <div id="frameb52G5g" class="cl_frame_bm frame move-span cl frame-1">
       <div id="frameb52G5g_left" class="column frame-1-c">
        <div id="frameb52G5g_left_temp" class="move-span temp"></div>
        <div id="portal_block_53" class="cl_block_bm block move-span">
         <div id="portal_block_53_content" class="dxb_bc">
          <div class="portal_block_summary">
           @if($advtop)
              <a href="/" target="_blank"><img src="{{$advtop->pic_url}}" width="100%" /></a>
              @endif
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <!--[/diy]--> 
    </div> 
    <div class="col2 y"> 
     <div class="sdBtn bp"> 
      <a href="{{url('forumAdd')}}" class="post_btn">发表新帖</a> 
      <!--<a href="{{url('sign')}}" target="_blank" class="signin">马上签到</a>--> 
     </div> 
     <div class="colu bp">
      <!--[diy=diy3]-->
      <div id="diy3" class="area">
       <div id="framerFYjF2" class="cl_frame_bm frame move-span cl frame-1">
        <div id="framerFYjF2_left" class="column frame-1-c">
         <div id="framerFYjF2_left_temp" class="move-span temp"></div>
         <div id="portal_block_48" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span class="titletext">版块导航</span>
          </div>
          <div id="portal_block_48_content" class="dxb_bc">
           <div class="module cl xl xl2"> 
            <ul>
             @foreach($fmod as $v)
                <li><a href="{{url('forum_list/'.$v->id)}}" title="{{$v->defectsname}}" target="_blank">{{$v->defectsname}}</a></li>
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
       <div id="framefmWLIN" class="cl_frame_bm frame move-span cl frame-1">
        <div id="framefmWLIN_left" class="column frame-1-c">
         <div id="framefmWLIN_left_temp" class="move-span temp"></div>
         <div id="portal_block_51" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span style="float:;margin-left:px;font-size:;color: !important;" class="titletext">热门文章</span>
          </div>
          <div id="portal_block_51_content" class="dxb_bc">
           <div class="module cl ml"> 
            <ul>
             @foreach($hot as $v)
             <li style="width: 250px;"> <a href="{{url('news_'.$v->art_id.'.html')}}" target="_blank">
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
       <div id="frameiR37N3" class="cl_frame_bm frame move-span cl frame-1">
        <div id="frameiR37N3_left" class="column frame-1-c">
         <div id="frameiR37N3_left_temp" class="move-span temp"></div>
         <div id="portal_block_49" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span  class="titletext">热心居民</span>
          </div>
          <div id="portal_block_49_content" class="dxb_bc">
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
     <div class="hotTag bp"> 
      <div class="blocktitle title">
       热门标签
      </div> 
      <div class="tagMod cl">
        @foreach($tags as $v)
            <a href="{{url('blog?tags='.$v->tagname)}}" target="_blank">{{$v->tagname}}</a>
        @endforeach

      </div> 
     </div> 
     <div class="mbm">
      <!--[diy=diy6]-->
      <div id="diy6" class="area">
       <div id="frameyS7SZT" class="cl_frame_bm frame move-span cl frame-1">
        <div id="frameyS7SZT_left" class="column frame-1-c">
         <div id="frameyS7SZT_left_temp" class="move-span temp"></div>
         <div id="portal_block_56" class="cl_block_bm block move-span">
          <div id="portal_block_56_content" class="dxb_bc">
           <div class="portal_block_summary">
            <!--<img src="./index_files/ads.jpg" width="100%" />-->
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <!--[/diy]-->
     </div> 
     <div class="mbm">
      <!--[diy=diy7]-->
      <div id="diy7" class="area"></div>
      <!--[/diy]-->
     </div> 
    </div> 
    <div class="col1 z"> 
     <div class="bp"> 
      <div class="pSlide">
       <!--[diy=diy1]-->
       <div id="diy1" class="area">
        <div id="framevUVqTt" class="cl_frame_bm frame move-span cl frame-1">
         <div id="framevUVqTt_left" class="column frame-1-c">
          <div id="framevUVqTt_left_temp" class="move-span temp"></div>
          <div id="portal_block_46" class="cl_block_bm block move-span">
           <div id="portal_block_46_content" class="dxb_bc">
            <div class="module cl slideBox"> 
             <div class="tempWrap" style="overflow:hidden; position:relative; width:880px">
              <ul class="slideshow">
               @foreach($adv as $v)
                <li style="min-height: 340px; float: left; width: 100%"> 
                   @if($v->url)
                    <a href="{{url($v->url)}}" target="_blank"> 
                    @else
                    <a href="javascript:;" target="_blank">
                    @endif 
                       <img src="{{$v->pic_url}}" width="{{$v->width}}" height="{{$v->height}}" />
                   </a> 
                   <h3 style="display: none;">{{$v->title}}</h3> 
               </li>
               @endforeach
              </ul>
             </div> 
             <ul class="slidebar">
               @foreach($adv as $k=>$v)
                 <li class="">{{$k+1}}</li>
                 @endforeach
             </ul> 
             <span class="next"></span> 
             <span class="prev prevStop"></span> 
            </div> 
            <script type="text/javascript">
                jQuery(".slideBox").slide({titCell:".slidebar li",mainCell:".slideshow",effect:"left",autoPlay:true});
                jQuery(".slideshow li").hover(function(){
                jQuery(".slideshow li").find("h3").slideDown();
                }, function(){jQuery(".slideshow li").find("h3").slideUp();});
            </script> 
           </div>
          </div>
         </div>
        </div>
       </div>
       <!--[/diy]-->
      </div> 
      <div class="txtRoll">
       <!--[diy=diy14]-->
       <div id="diy14" class="area">
        <div id="frameSJ6uDf" class="cl_frame_bm frame move-span cl frame-1">
         <div id="frameSJ6uDf_left" class="column frame-1-c">
          <div id="frameSJ6uDf_left_temp" class="move-span temp"></div>
          <div id="portal_block_55" class="cl_block_bm block move-span">
           <div id="portal_block_55_content" class="dxb_bc">
            <div class="txtBtn y">
             <span class="prev"></span>
             <span class="next"></span>
            </div> 
            <div class="txtSlide"> 
             <h3>站点公告：</h3> 
             <div class="tempWrap" style="overflow:hidden; position:relative; height:30px">
              <ul style="position: relative; padding: 0px; margin: 0px; top: 0px;">
               @if($tips)
                  @foreach($tips as $v)
                   @if(strtotime($v->created_at)>(time()-3*24*60*60))
                    <li style="height: 30px;"><a style="font-weight: 900;color: #FF0000 !important;" href="{{$v->url ? url($v->url) : 'javascript:;'}}" title="{{$v->content}}">{{$v->content}}（{{word_time($v->created_at,1)}}）</a></li>
                    @else
                  <li style="height: 30px;"><a href="{{$v->url ? url($v->url) : 'javascript:;'}}" title="{{$v->art_title}}">{{$v->content}}（{{word_time($v->created_at,1)}}）</a></li>
                    @endif
                  @endforeach
               @endif
               
              </ul>
             </div> 
            </div> 
            <script>jQuery(".txtRoll").slide({mainCell:".txtSlide ul", effect:"top", autoPlay:true});</script>
           </div>
          </div>
         </div>
        </div>
       </div>
       <!--[/diy]-->
      </div> 
     </div> 
     <div class="tFocus bp"> 
      <!--[diy=diy2]-->
      <div id="diy2" class="area">
       <div id="frameezu62F" class="cl_frame_bm frame move-span cl frame-1">
        <div id="frameezu62F_left" class="column frame-1-c">
         <div id="frameezu62F_left_temp" class="move-span temp"></div>
         <div id="portal_block_47" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span class="titletext">热帖推荐</span>
          </div>
          <div id="portal_block_47_content" class="dxb_bc">
           <div class="module cl xl xl1"> 
            <ul>
              @foreach($forum as $v)
                <li>
                    <a href="{{url('forum_list_detail/'.$v->forum_id.'?&pid='.$v->pid)}}" title="{{$v->title}}" target="_blank">
                        @if(strtotime($v->created_at)>(time()-3*24*60*60))
                        <font style="font-weight: 900;color: #FF7F84;">{{$v->title}}</font>
                        @else
                        {{$v->title}}
                        @endif
                    </a>
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
     <div class="essEnce bp"> 
      <!--[diy=diy11]-->
      <div id="diy11" class="area">
       <div id="frameGqirHq" class="cl_frame_bm frame move-span cl frame-1">
        <div id="frameGqirHq_left" class="column frame-1-c">
         <div id="frameGqirHq_left_temp" class="move-span temp"></div>
         <div id="portal_block_52" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span class="titletext">精选图文</span>
          </div>
          <div id="portal_block_52_content" class="dxb_bc">
           <div class="module cl xld esModBox"> 
            <div class="hd"> 
             <ul> 
              @for($i=1;$i<=(ceil(count($article)/4));$i++)
              <li @if($i==1) class="on" @endif >{{$i}}</li> 
              @endfor
             </ul> 
            </div> 
            <span class="next"></span> 
            <span class="prev prevStop"></span> 
            <div class="bd"> 
             <div class="tempWrap" style="overflow:hidden; position:relative; width:892px">
              <ul style="width: 2676px; position: relative; overflow: hidden; padding: 0px; margin: 0px; left: 0px;">
               @foreach($article as $v)
                <li style="float: left; width: 211px;"> 
                    @if($v->type==1)
                        <a href="{{url('news_'.$v->art_id.'.html')}}" target="_blank">
                    @else
                        <a href="{{url('blog_'.$v->art_id.'.html')}}" target="_blank">
                    @endif
                   
                   <img src="{{$v->art_thumb}}" width="211" height="268" alt="{{$v->art_title}}" />
               </a> 
                <div class="esInfo"> 
                 <h3>
                     @if($v->type==1)
                        <a href="{{url('news_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @else
                        <a href="{{url('blog_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @endif
                         {{$v->art_title}} 
                     </a></h3> 
                 <p> </p> 
                </div> 
               </li>
                @endforeach
              </ul>
             </div> 
            </div> 
           </div> 
           <script type="text/javascript">
            jQuery(".esModBox").slide({ mainCell:".bd ul", effect:"left", delayTime:800,vis:4,scroll:4,pnLoop:false,trigger:"click",easing:"easeOutCubic" });
            jQuery(".esMod li").hover(function(){
            jQuery(this).find(".esInfo").animate({height:'100px'}, 200);
            },function(){
            jQuery(this).find(".esInfo").animate({height:'40px'}, 200);
            })
            </script>
          </div>
         </div>
        </div>
       </div>
      </div>
      <!--[/diy]--> 
     </div> 
     <div class="news_portal bp"> 
      <!--[diy=diy9]-->
      <div id="diy9" class="area">
       <div id="frameWH66L6" class="cl_frame_bm frame move-span cl frame-1">
        <div id="frameWH66L6_left" class="column frame-1-c">
         <div id="frameWH66L6_left_temp" class="move-span temp"></div>
         <div id="portal_block_50" class="cl_block_bm block move-span">
          <div class="blocktitle title">
           <span class="titletext">最新发布</span>
          </div>
          <div id="portal_block_50_content" class="dxb_bc">
           <div id="newest" class="newMod"> 
            <ul>
             @foreach($data as $v)
                <li style="position: relative;overflow:hidden"> 
                    <span class="jb">{{$v->defectsname}}</span>
              <div class="pic"> 
                @if($v->type==1)
                        <a href="{{url('news_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @else
                        <a href="{{url('blog_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @endif
              <img src="{{$v->art_thumb}}" width="300" height="180" alt="{{$v->art_title}}" /></a> 
              </div> 
               <h3>
                  <!--<a class="forumName" href="{{url('news_'.idEncryption($v->art_id).'.html')}}">-->
                  @if($v->type==1)
                        <a class="forumName" href=" {{url('news?cid='.$v->cate_id)}}" > 
                    @else
                        <a class="forumName" href=" {{url('blog?cid='.$v->cate_id)}}" > 
                    @endif
                   
                      [{{$v->defectsname}}]
                  </a>
                   @if($v->type==1)
                        <a href="{{url('news_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @else
                        <a href="{{url('blog_'.$v->art_id.'.html')}}" title="{{$v->art_title}}" target="_blank">
                    @endif
                      {{$v->art_title}}
                  </a>
              </h3> 
              <div class="infos" style="overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:4;">
                {{$v->art_description}}
              </div> 
              <div class="attr cl"> 
               <div class="z"> 
                <span class="author"> {{$v->nickname}}</span> 
                <span class="dateline">{{word_time($v->created_at,1)}}</span> 
               </div> 
               <div class="y"> 
                <span class="view"> {{$v->art_view}}</span> 
                <span class="rep"> {{$v->art_rep}}</span> 
               </div> 
              </div> </li>
             @endforeach
            </ul> 
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <!--[/diy]--> 
      <div class="jquery_pagnation">
       <div class="pages cl">

       </div>
      </div> 
      <script src="{{asset('resources/home/js/jquery.pagnation.js')}}" type="text/javascript"></script> 
      <script type="text/javascript">
        (function(dfsj_jq){
        var dfsj_items = dfsj_jq('.newMod li');
        var dfsj_items2 = 10;
        var total = dfsj_items.size();
        total>0 && dfsj_jq('.jquery_pagnation').pagination({pagetotal:total,target:dfsj_items,perpage:dfsj_items2});
        })(jQuery);
        </script> 
     </div> 
    </div> 
   </div> 
   <div class="cl wp bp xrLinks"> 
    <!--[diy=diy12]-->
    <div id="diy12" class="area">
     <div id="framecXy5YX" class="cl_frame_bm frame move-span cl frame-1">
      <div id="framecXy5YX_left" class="column frame-1-c">
       <div id="framecXy5YX_left_temp" class="move-span temp"></div>
       <div id="portal_block_54" class="cl_block_bm block move-span">
        <div class="blocktitle title">
         <span class="titletext">友情链接</span>
        </div>
        <div id="portal_block_54_content" class="dxb_bc">
         <div class="x cl"> 
          <ul class="cl mbm">
           @foreach($link as $v)
           <li><a href="{{$v->link_url}}" target="_blank">{{$v->link_name}}</a></li>
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
@endsection