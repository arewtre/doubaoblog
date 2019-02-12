@extends('layouts.home')
@section('content')
 <div class="f_c"> 
   <div class="bm" id="main_message"> 
    <div id="loggingbox" class="loggingbox">
     <div class="loging_tit cl"> 
      <div class="z avt" style="display:block;"> 
       <img src="{{session('qquserinfo.figureurl_qq_1')}}" width="48" height="48" /> 
      </div>
      <div class="z">
       <p class="welcome mbn cl" style="clear:both; width:100%; "><strong>Hi</strong>, <strong>{{session('userinfo.nickname')}}</strong><span class="xg2">欢迎使用QQ帐号登录</span></p> 
       <ul class="tb cl z">
        <li id="connect_tab_1" class="a"><a id="loginlist" href="javascript:;" onclick="connect_switch(1);this.blur();" tabindex="900">创建新帐号</a></li>
        <li id="connect_tab_2" class=""><a id="loginlist2" href="javascript:;" onclick="connect_switch(2);this.blur();" tabindex="900">已有本站帐号</a></li>
       </ul>
      </div>
     </div>
    </div> 
    <p id="returnmessage4" class=""></p> 
    <form class="layui-form" method="post" autocomplete="off" name="register" id="loginform" enctype="multipart/form-data" action="" onsubmit="return false" style="display: block;"> 
     <input type="hidden" name="type" value="1">
        <div id="layer_reg" class="bm_c"> 
      {{csrf_field()}} 
      <div class=""> 
       <div id="reginfo_a"> 
        <div class="rfm"> 
         <table> 
          <tbody>
           <tr> 
            <th style="width: 9em;"><label for="newusername">创建新的账号:</label></th> 
            <td><input type="text" id="newusername" name="newusername" size="30" class="px p_fre" tabindex="1" /></td> 
            <td class="tipcol"></td> 
           </tr> 
           <tr> 
            <th><label for="newpassword">请输入密码:</label></th> 
            <td><input type="password" id="newpassword" name="newpassword" size="30" class="px p_fre" tabindex="1" /></td> 
            <td class="tipcol"></td> 
           </tr> 
           <tr> 
            <th><label for="confirmpassword">确认密码:</label></th> 
            <td><input type="password" id="confirmpassword" name="confirmpassword" size="30" class="px p_fre" tabindex="2" /></td> 
            <td class="tipcol"></td> 
           </tr> 
          </tbody>
         </table> 
        </div> 
       </div> 
      </div> 
     </div> 
     <div id="layer_reginfo_b"> 
      <div class="rfm mbw bw0"> 
       <table width="100%"> 
        <tbody>
         <tr> 
          <th>&nbsp;</th> 
          <td> <span id="reginfo_a_btn"> <em>&nbsp;</em>
                  <button class="pn pnc" id="registerformsubmit" lay-submit="" lay-filter="login" name="regsubmit" value="true" tabindex="1"><span>完成，继续浏览</span></button><button class="pn pnc" type="button" name="regsubmit1" onclick="location.href=''" tabindex="1"><span>跳过不在提示</span></button> </span> </td> 
          <td></td> 
         </tr> 
        </tbody>
       </table> 
      </div> 
     </div> 
    </form> 
    <div class="b1lr"> 
     <form class="layui-form" id="registerform" method="post" autocomplete="off" action="" onsubmit="return false"  style="display:none;"> 
      <input type="hidden" name="type" value="2">
         <div class="c cl bm_c"> 
       {{csrf_field()}} 
       <div class="rfm"> 
        <table> 
         <tbody>
          <tr> 
           <th style="width: 10em;"><label for="oldusername">需要绑定的用户名:</label></th> 
           <td><input type="text" id="oldusername" name="oldusername" size="30" class="px p_fre" tabindex="1" /></td> 
           <td class="tipcol"></td> 
          </tr> 
          <tr> 
           <th><label for="oldpassword">需要绑定的密码:</label></th> 
           <td><input type="password" id="oldpassword" name="oldpassword" size="30" class="px p_fre" tabindex="2" /></td> 
           <td class="tipcol"></td> 
          </tr> 
         </tbody>
        </table> 
       </div> 
      </div> 
      <div class="rfm mbw bw0"> 
       <table> 
        <tbody>
         <tr> 
          <th>&nbsp;</th> 
          <td><button class="pn pnc" lay-submit="" lay-filter="login" name="loginsubmit" value="true" tabindex="1"><strong>绑定帐号</strong></button></td> 
         </tr> 
        </tbody>
       </table> 
      </div> 
     </form> 
    </div> 
    <style type="text/css">
.loggingbox { width: 760px; margin: 40px auto 0; }
.loging_tit { border-bottom: 1px solid #CCC; _overflow:hidden; }
.ie_all .loging_tit { height:66px;}
.loggingbox .fm_box { border-bottom:0; padding: 20px 0; }
.loggingbox .welcome { font-size:14px; width:100%; line-height:30px;}
.loggingbox .welcome span { font-size:12px; }
.loggingbox .avt img { margin: 0 5px 5px 0; padding:0; border:0; width:60px; height:60px; }
.loggingbox .tb{ border-bottom: 0; margin-top: 0; padding-left: 0px; }
.loggingbox .tb a { background:#F6F6F6; padding:0 20px; }
.loggingbox .tb .a a { background:#FFF; }
</style> 
    <script type="text/javascript">

function connect_switch(op) {
if(op == 1) {
$('registerform').style.display='none';$('loginform').style.display='block';
$('connect_tab_1').className = 'a';
$('connect_tab_2').className = '';
//$('connect_login_register_tip').style.display = '';
//$('connect_login_bind_tip').style.display = 'none';

} else {
$('registerform').style.display='block';$('loginform').style.display='none';
$('connect_tab_2').className = 'a';
$('connect_tab_1').className = '';
//$('connect_login_register_tip').style.display = 'none';
//$('connect_login_bind_tip').style.display = '';
}
}

</script> 
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
        jQuery.post("{{url('loginSetUname')}}", data.field, function(res) {
             if (res.code!=1) {
                 layer.msg(res.msg, {
                     icon: 2
                 });
                 loadIndex && layer.close(loadIndex);
             } else {
                layer.msg(res.msg);
                loadIndex && layer.close(loadIndex);
                setTimeout(function() {
                    window.top.location.href = res.url
                }, 1500);
             }
        }, 'json');
        //return false;
    });

  
});

</script>
@endsection