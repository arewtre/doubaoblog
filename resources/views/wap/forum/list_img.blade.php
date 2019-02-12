<style type="text/css">
    .tl_picList{padding:5px 10px;}
    .xinruiInfo{font-size:13px;line-height:22px;}
    .xinruiPic li{display:block;width:33.3%;height:92px;float:left;margin-top:6px;border:none;}
    .xinruiPic span,.xinruiOneImg span{display:block;margin:0 3px;background:#fff;border:solid 1px #eee;border-radius:3px;height:90px;overflow:hidden;text-align:center;position:relative;} 
    .xinruiOneImg{float:left;margin-right:10px;border:none;} 
    .xinruiOneImg li{width:92px;height:92px; border:none;}
    .xinruiOneImg span{margin:0;}
    .xinruiOneImg li img,.xinruiPic li img{position:absolute;top:0;left:50%;max-height:100%;max-width:none;transform: translate(-50%);}
    .threadlist .threadlist .tl_picList{padding:5px 0 0;}
    .threadlist .threadlist .xinruiInfo{color:#999;}
    video{
       width:100%;
       max-height:300px;
       background-color: rgb(0, 0, 0);   
   }
   .zwnr{font-size:20px;color:#999;width:100%;height:140px;line-height:140px;text-align:center}
</style>
	<div class="threadlist">
        <!--如果 帖子总数不为 false 或 0--> 
        <!--如果未打开图文列表-->
        <div class="threadlist"> 
         <ul id="main"> 
             @if(count($data)>0)
          @foreach($data as $v)
             <li class="list-empty"> <a href="{{url('wap/forum_list_detail/'.$v->forum_id)}}"> 
            <div class="threadListTit"> 
             <div class="h_avatar">
              <img src="{{asset($v->userface)}}" zsrc="{{asset($v->userface)}}" style="display: inline; visibility: visible;" />
             </div> 
             <h4> 
              <div class="count y"> 
               <span class="views icon">{{$v->views}}</span> 
               <span class="replies icon">{{$v->reps}}</span> 
              </div> {{$v->nickname}}</h4> 
             <p>发布于 {{word_time($v->created_at,1)}}</p> 
            </div> 
            <h3 class="threadSubject"> 
                @if($v->is_top==1)<span class="threadAttr">全局置顶</span> @endif
                <span>{{$v->title}}</span> 
            </h3> 
            <div class="tl_picList cl cfix">
             <div class="xinruiInfo">
              @if($mod->new_sign=='video')
              <div class="Eleditor-video-area">{!! nl2br($v->video) !!}</div>
              @else
              @if(!empty(mb_substr(strip_tags($v->content),0,54,'utf-8'))){{mb_substr(strip_tags($v->content),0,54,'utf-8')}}@endif
              @endif
             </div>
             <div class="xinruiPic cl cfix">
              <ul>
                  @foreach(html2imgs($v->content) as $k=>$vv)
                        @if($k<3) 
                            <li><span><img src="{{asset($vv['src'])}}" alt="{{asset($vv['src'])}}" title="" w="1419" zsrc="{{asset($vv['src'])}}" style="display: inline; visibility: visible;" /></span></li>
                        @endif
                    @endforeach
              </ul>
             </div>
            </div></a> </li> 
            @endforeach
            @else
            <li class="zwnr">抱歉,暂无内容</li>
            @endif
         </ul>
            <div class="dx" style="display:none;width:100%;"><br/><br/><center>------------------我是有底线的!------------------</center><br/><br/></div>
        </div> 
    </div>
</div>
<script>
    layui.use(['form','upload'], function(){
        var P = 1,$ = layui.jquery;
        function Dload() {           
        $.ajax({  
                type : "get",  
                url : "{{url('wap/forum_list')}}/"+"{{$id}}",  
                data : {page:P,filter:"{{$filter}}",'_token':"{{csrf_token()}}"},   
                async : false,  
                success : function(result){
                    var res = $(result).find("#main").html();
                    //console.log(res);
                    if(res && res.indexOf('list-empty') != -1) {
                        //console.log("有");
                        P == 1 ?  $('#main').html(res) : $('#main').append(res);
                    } else {
                        $('.dx').show();
                    }
                    layer.closeAll('loading');
                }
            });
       }   

       $(window).scroll(function(){
           var scrollTop = $(this).scrollTop();
           var scrollHeight = $(document).height();
           var windowHeight = $(this).height();
           if(scrollTop + windowHeight == scrollHeight){
              if($(".dx").is(':hidden')){ 
                    var index = layer.load(); 
                    P++;
                    setTimeout(function(){
                       Dload();  
                    },200);
                }
              
           }else {

           }
       });
    });
</script>
	