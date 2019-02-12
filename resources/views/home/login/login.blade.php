@extends('layouts.home')
@section('content')
 <div id="ct" class="ptm wp w cl"> 
   <div class="nfl" id="main_succeed" style="display: none"> 
    <div class="f_c altw"> 
     <div class="alert_right"> 
      <p id="succeedmessage"></p> 
      <p id="succeedlocation" class="alert_btnleft"></p> 
      <p class="alert_btnleft"><a id="succeedmessage_href">如果您的浏览器没有自动跳转，请点击此链接</a></p> 
     </div> 
    </div> 
   </div> 
   <div class="mn" id="main_message"> 
    <div class="bm"> 
     <div class="bm_h bbs"> 
      <span class="y"> <a href="{{url('register')}}" class="xi2">没有帐号？</a><a href="{{url('register')}}">立即注册</a> </span> 
      <h3 class="xs2">登录</h3> 
     </div> 
     <div> 
      <div id="main_messaqge_LRlEs"> 
       <div id="layer_login_LRlEs"> 
        <h3 class="flb"> <em id="returnmessage_LRlEs"> </em> <span></span> </h3> 
        <style type="text/css">
        .regTab1 {width:400px; margin:10px auto;}
        .tabTit1 {height:36px;line-height:36px;border-bottom:2px solid #e8e8e8;}
        .tabTit1 li{width:50%;float:left;text-align:center;font-size:14px;}
        /*.tabTit1 li a{display:block;height:36px;line-height:36px;background:url({{asset('resources/home/images/pcIcon.png')}}) no-repeat;}*/
        .tabTit1 li a{display:block;height:36px;line-height:36px;}
        .tabTit1 .tabEmail{background-position:25px 6px;}
        .tabTit1 li.a .tabEmail{background-position:25px -83px;}
        .tabTit1 .tabMobile{background-position:30px -38px;}
        .tabTit1 li.a .tabMobile{background-position:30px -126px;}
        .tabTit1 li.a a{color:#FF7F84;border-bottom:2px solid #FF7F84;}
        #fwin_content_login input.px {width:200px;}
        .pnn{
            background: #FF7F84;
            color: #fff !important;
            width: 80px;
            height: 38px;
            line-height:38px;
            border-radius: 2px;
            border: none;
            font-size: 16px;
        }
        </style> 
<script>


jQuery(function(){

jQuery('#login_connect_tab_1').on("click",function(){
    jQuery('#formlogin_LFb0o').hide();
    jQuery("#loginform_LRlEs").show();	
    jQuery(this).addClass('a');
    jQuery('#login_connect_tab_2').removeClass('a');
});

jQuery('#login_connect_tab_2').on("click",function(){
    jQuery('#formlogin_LFb0o').show();
    jQuery("#loginform_LRlEs").hide();	
    jQuery(this).addClass('a');
    jQuery('#login_connect_tab_1').removeClass('a');
});

});
</script> 
<!--        <div id="login2_box" class="regTab1"> 
         <div class="tabTit1 cl">
          <ul class="cl" style="margin:0px;">
           <li id="login_connect_tab_1" class="a"><a class="tabEmail" id="login2list" href="javascript:;" tabindex="900">用户名登录</a></li>
           <li id="login_connect_tab_2"><a class="tabMobile id=" login2list2="" href="javascript:;" tabindex="900">手机号登录</a></li>
          </ul>
         </div>
        </div>-->
        <form method="post" autocomplete="off" name="login" id="loginform_LRlEs" class="cl layui-form"  action="" onsubmit="return false;">
            <input type="hidden" name="type" value="1">
         <div class="c cl"> 
          {{csrf_field()}} 
          <div class="rfm"> 
           <table> 
            <tbody>
             <tr> 
              <th><label for="password3_LRlEs">用户名</lable>  </th>
              <td><input type="text" lay-verify="required" name="username" id="username_LRlEs" autocomplete="off" size="30" class="px p_fre" tabindex="1" value="" /></td> 
              <td class="tipcol"><a href="{{url('regester')}}">立即注册</a></td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="rfm"> 
           <table> 
            <tbody>
             <tr> 
              <th><label for="password3_LRlEs">密码:</label></th> 
              <td><input type="password" lay-verify="required" id="password3_LRlEs" name="password" size="30" class="px p_fre" tabindex="1" /></td> 
              <td class="tipcol"><a href="javascript:;" onclick="" title="找回密码">找回密码</a></td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <span id="seccode_cSgzFvDj"><input name="seccodehash" type="hidden" value="cSgzFvDj" /><input name="seccodemodid" type="hidden" value="member::logging" />
           <div class="rfm">
            <table>
             <tbody>
              <tr>
               <th>验证码: </th>
               <td><input name="vcode" lay-verify="required" id="seccodeverify_cSgzFvDj" type="text" autocomplete="off" style="width:100px" class="txt px vm" onblur="checksec('code', 'cSgzFvDj', 0, null, 'member::logging')" />
                   <a href="javascript:;" onclick="changeVcode();" class="xi2">换一个</a>
                   <span id="checkseccodeverify_cSgzFvDj">
                       <img src="{{asset('resources/home/images/none.gif')}}" width="16" height="16" class="vm" />
                   </span><br />
                   <span id="vseccode_cSgzFvDj">输入下图中的字符<br />
                       <img src="{{url('admin/code')}}" style="height:34px" id="changeCode" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                   </span>
               </td>
              </tr>
             </tbody>
            </table>
           </div></span> 
          <div class="rfm "> 
           <table> 
            <tbody>
             <tr> 
              <th></th> 
              <!--<td><label for="cookietime_LRlEs"><input type="checkbox" class="pc" name="cookietime" id="cookietime_LRlEs" tabindex="1" value="2592000" />自动登录</label></td>--> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="rfm mbw bw0"> 
           <table width="100%"> 
            <tbody>
             <tr> 
              <th>&nbsp;</th> 
              <td> <button class="pn pnc" name="loginsubmit" value="true" tabindex="1" lay-submit="" lay-filter="login"><strong>登录</strong></button> </td> 
              <!--<td> <a href="javascript:;" onclick="ajaxget('member.php?mod=clearcookies&amp;formhash=db0bcc6e', 'returnmessage_LRlEs', 'returnmessage_LRlEs');return false;" title="清除痕迹" class="y">清除痕迹</a></td>--> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="rfm bw0  mbw"> 
           <hr class="l" /> 
           <table> 
            <tbody>
             <tr> 
              <th>快捷登录:</th> 
              <td> 
<!--                <a href="javascript:;" onclick="hideWindow('login');showWindow('login_scan', 'plugin.php')">
                    <img src="wechat_login.png" class="vm" />
                </a> -->
                <a href="{{url('qqLogin')}}">
                    <img src="{{asset('resources/home/images/qq_login.gif')}}" class="vm" />
                </a> 
              </td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
         </div> 
        </form>
        <form style="display: none;" action="" method="post" autocomplete="off" name="mobilelogin2" id="formlogin_LFb0o" class="cl layui-form">
                {{csrf_field()}} 
                <input type="hidden" name="type" value="2">
         <div> 
          <div id="reginfo_a"> 
           <div class="rfm"> 
            <table> 
             <tbody>
              <tr> 
               <th> <span class="rq">*</span><label for="avBu4z">手机号:</label> </th> 
               <td> <input lay-verify="required" type="text" id="phone" name="phone" class="px" tabindex="1" value="" autocomplete="off" size="25" maxlength="11" required="" /> </td> 
               <td class="tipcol"> <a href="">立即注册</a> </td> 
              </tr> 
             </tbody>
            </table> 
           </div> 
           <div class="rfm"> 
            <table> 
             <tbody> 
              <tr> 
               <th> <span class="rq">*</span><label for="avBu4z">验证码:</label> </th> 
               <td> <input lay-verify="required" type="password" id="pwd" name="pwd" class="px" tabindex="1" value="" autocomplete="off" size="25" required="" /> </td> 
               <td class="tipcol"> <button class="pn pnn" name="" value="true" tabindex="1"><strong>发送</strong></button></td> 
              </tr> 
             </tbody> 
            </table> 
           </div> 
          </div> 
         </div> 
         <div class="rfm mbw bw0"> 
          <table width="100%"> 
           <tbody> 
            <tr> 
             <th>&nbsp; </th> 
             <td> <span id="reginfo_a_btn"><em>&nbsp;</em>
                     <button class="pn pnc" lay-submit="" lay-filter="login" name="" value="true" tabindex="1"><strong>登录</strong></button>
                 </span> 
             </td> 
             <td> </td> 
            </tr> 
           </tbody> 
          </table> 
         </div> 
         <div class="rfm bw0 mbw" id="hooks_ajaxlogin" style="">
          <hr class="l" />
          <table> 
           <tbody>
            <tr> 
             <th>快捷登录:</th> 
             <td> 
<!--                 <a href="javascript:;" onclick="hideWindow('login');showWindow('')">
                     <img src="source/plugin/xinrui_login/static/image/wechat_login.png" class="vm" />
                 </a> -->
                <a href="{{url('qqLogin')}}">
                    <img src="{{asset('resources/home/images/qq_login.gif')}}" class="vm" /> 
                </a> 
             </td> 
            </tr> 
           </tbody>
          </table>
         </div>
        </form> 
       </div> 
       <div id="layer_lostpw_LRlEs" style="display: none;"> 
        <h3 class="flb"> <em id="returnmessage3_LRlEs">找回密码</em> <span></span> </h3> 
        <form method="post" autocomplete="off" id="lostpwform_LRlEs" class="cl layui-form"  action=""> 
         <div class="c cl"> 
          {{csrf_field()}} 
          <div class="rfm"> 
           <table> 
            <tbody>
             <tr> 
              <th><span class="rq">*</span><label for="lostpw_email">Email:</label></th> 
              <td><input lay-verify="required" type="text" name="email" id="lostpw_email" size="30" value="" tabindex="1" class="px p_fre" /></td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="rfm"> 
           <table> 
            <tbody>
             <tr> 
              <th><label for="lostpw_username">用户名:</label></th> 
              <td><input lay-verify="required" type="text" name="username" id="lostpw_username" size="30" value="" tabindex="1" class="px p_fre" /></td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="rfm mbw bw0"> 
           <table> 
            <tbody>
             <tr> 
              <th></th> 
              <td><button class="pn pnc" type="submit" name="lostpwsubmit" value="true" tabindex="100"><span>提交</span></button></td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
         </div> 
        </form> 
       </div> 
      </div> 
      <div id="layer_message_LRlEs" class="f_c blr nfl" style="display: none;"> 
       <h3 class="flb" id="layer_header_LRlEs"> </h3> 
       <div class="c">
        <div class="alert_right"> 
         <div id="messageleft_LRlEs"></div> 
         <p class="alert_btnleft" id="messageright_LRlEs"></p> 
        </div> 
       </div> 
      </div>
     </div>
    </div>
   </div> 
  </div>
<script>
//jQuery("#nv li").removeClass("a");
//jQuery("#mn_N6e20").addClass("a");

layui.use(['laypage', 'layer','form'], function(){
  var laypage = layui.laypage
  ,form = layui.form
  ,layer = layui.layer;
    form.on('submit(login)', function(data) {
        var loadIndex = layer.load(2, {
            shade: [0.3, '#333']
        });
        jQuery.post("{{url('login')}}", data.field, function(res) {
             if (res.code!=1) {
                 layer.msg(res.msg, {
                     icon: 2
                 });
                 loadIndex && layer.close(loadIndex);
                 jQuery('#changeCode').click(); //刷新验证码
             } else {
                layer.msg(res.msg);
                loadIndex && layer.close(loadIndex);
                setTimeout(function() {
                    window.top.location.href = res.url
                }, 1500);
//console.log(res);
             }
        }, 'json');
        //return false;
    });
});
function changeVcode(){
    jQuery('#changeCode').click();
}
</script>
@endsection