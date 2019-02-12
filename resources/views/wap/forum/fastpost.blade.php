<div id="post_new"></div>
<div class="replyCom cfix">
	<form method="post" autocomplete="off" id="fastpostform" action="{{url('wap/forum_list_detail/'.$forum->forum_id)}}">
	{{csrf_field()}}
	<ul class="fastpost">
		<!--{if $_G[forum_thread][special] == 5 && empty($firststand)}-->
<!--		<li class="cfix">
		<select id="stand" name="stand" >
			<option value="">{lang debate_viewpoint}</option>
			<option value="0">{lang debate_neutral}</option>
			<option value="1">{lang debate_square}</option>
			<option value="2">{lang debate_opponent}</option>
		</select>
		</li>-->
		<!--{/if}-->
                <input type="hidden" value="{{$forum->forum_id}}" name="forum_id">
		<li class="cfix">
                    <textarea class="textarea input" tabindex="3" id="fastpostmessage" name="message" autocomplete="off" cols="80" rows="2" placeholder="我也说一句" ></textarea></li>
		<!--<li><input type="text" value="{lang send_reply_fast_tip}" class="input" color="gray" name="message" id="fastpostmessage" fwin="reply"></li>-->
		<li class="cfix" id="fastpostsubmitline">
		<!--{if $secqaacheck || $seccodecheck}-->
			<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
		</li>
                <script src="{{asset('resources/wap/touch/images/js/get_face.js')}}"></script>
		<li class="faceBox cfix">
			<ul>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/01.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_41:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/02.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_42:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/03.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_43:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/04.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_44:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/05.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_45:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/06.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_46:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/07.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_47:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/08.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_48:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/09.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_49:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/10.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_50:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/11.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_51:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/12.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_52:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/13.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_53:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/14.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_54:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/15.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_55:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/16.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_56:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/17.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_57:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/18.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_58:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/19.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_59:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/20.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_60:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/21.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_61:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/22.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_62:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/23.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_63:}')" /></li>
				<li><img src="{{asset('resources/wap/static/image/smiley/grapeman/24.gif')}}" width="30" height="30" onClick="addface('fastpostmessage', '{:3_64:}')" /></li>
			</ul>
			
		</li>
		<li class="cfix">
			<div class="rePostIcon z wp50">
				<a class="faceBtn" href="javascript:void(0);"></a>
				<a class="itBtn" href="{{url('wap/forum_reply?forum_id='.$forum->forum_id)}}"></a>
			</div>
			<input type="button" value="回复" class="btn1 y wp35" name="replysubmit" id="fastpostsubmit" />
			<!--{hook/viewthread_fastpost_button_mobile}-->
		</li>
	</ul>
    </form>
</div>
<div class="btViewpost">
    <a class="viewBtn Jq_viewBtn" href="javascript:void(0);">我也要说两句</a>
    <table>
        <tr>
            <td>
                <div class="viewA vCom">
                        <span><em><i>{{count($data)}}</i></em></span>
                        评论
                </div>
            </td>
<!--            <td>
                <a href="{{url('wap/favorite?id='.$forum->forum_id)}}" class="viewA vFav">
                        <span><em><i>12</i></em></span>
                        收藏
                </a>
            </td>
            <td>
                <a class="viewA vZan" id="recommend_add" href="{{url('wap/like')}}">
                <span><em><i>12</i></em></span>
                赞
                </a>					
            </td>-->
        </tr>
    </table>
</div>
<div class="btRepPost" style="display:none;">
    <a href="">
        <span class="inp z">我也要说两句</span>
        <span class="btn1 y">回复</span>
    </a>
</div>
<script type="text/javascript">
    
	(function() {
            layui.use(['layer','form','code'], function(){
                var form = layui.form
              ,layer = layui.layer;
		var form = $('#fastpostform');
		@if( empty(session('userinfo')) || (!empty(session('userinfo')) && $forum->allowpostreply==0) )
		$('#fastpostmessage').on('focus', function() {
                        @if(empty(session('userinfo')))
				popup.open('请先登录', 'confirm', "{{url('wap/login')}}");
			@else
				popup.open('已暂停回复', 'alert');
			@endif
			this.blur();
		});
		@else
		$('#fastpostmessage').on('focus', function() {
			var obj = $(this);
			if(obj.attr('color') == 'gray') {
				obj.attr('value', '');
				obj.removeClass('grey');
				obj.attr('color', 'black');
				$('#fastpostsubmitline').css('display', 'block');
			}
		})
		.on('blur', function() {
			var obj = $(this);
			if(obj.attr('value') == '') {
				obj.addClass('grey');
				obj.attr('value', '回复');
				obj.attr('color', 'gray');
			}
		});
		@endif
		$('#fastpostsubmit').on('click', function() {
			var msgobj = $('#fastpostmessage');
			if(msgobj.val() == '回复') {
				msgobj.attr('value', '');
			}
                        var index = layer.load(1);
			$.ajax({
				type:'POST',
				url:form.attr('action'),
				data:form.serialize(),
				dataType:'json'
			})
			.success(function(s) {
				//evalscript(s.lastChild.firstChild.nodeValue);
				window.location.reload();
			})
			.error(function() {
				window.location.href = obj.attr('href');
				popup.close();
			});
			return false;
		});

		$('#replyid').on('click', function() {
			$(document).scrollTop($(document).height());
			$('#fastpostmessage')[0].focus();
		});

	})})();

	function succeedhandle_fastpost(locationhref, message, param) {
		var pid = param['pid'];
		var tid = param['tid'];
		if(pid) {
			$.ajax({
				type:'POST',
				url:'forum.php?mod=viewthread&tid=' + tid + '&viewpid=' + pid + '&mobile=2',
				dataType:'xml'
			})
			.success(function(s) {
				$('#post_new').append(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				window.location.href = 'forum.php?mod=viewthread&tid=' + tid;
				popup.close();
			});
		} else {
			if(!message) {
				message = '{lang postreplyneedmod}';
			}
			popup.open(message, 'alert');
		}
		$('#fastpostmessage').attr('value', '');
		if(param['sechash']) {
			$('.seccodeimg').click();
		}
	}

	function errorhandle_fastpost(message, param) {
		popup.open(message, 'alert');
	}
</script>
<script type="text/javascript">
$(".vCom").toggle(function(){
		$("html,body").animate({scrollTop:$("#reComments").offset().top},500);},
	function(){
		$("html,body").animate({scrollTop:0},500);}
);
$(".Jq_viewBtn").click(function(){
	$(".replyCom").slideDown("fast");
	//$(".textarea")[0].focus();
	return false;
});
$(".replyCom form").bind("click",function(){
	$(".replyCom").css("display","block");
	event.stopPropagation();
});
$(".replyCom").bind("click",function(){
	$(this).slideUp("fast");
});
$(".faceBtn").click(function(){
	$(".faceBox").toggle();},
	//$(".fastpost .textarea")[0].focus();
	function(){
	$(".faceBox").toggle();}
	//$(".fastpost  .textarea")[0].focus();
);
</script>

