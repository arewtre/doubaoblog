@extends('layouts.wap')
@section('content')
<form method="post" id="postform">
<!-- header start -->
<header class="header">
	<input type="hidden" name="" value="yes">
	<a href="" class="goBack fl">返回</a>
	<h1>发帖</h1>
</header>
<!-- header end -->

<!-- main postbox start -->

	<div class="post_from">
		<ul class="cl">
			<li>
			<!--{if $_GET['action'] != 'reply'}-->
			<!--<input type="text" tabindex="1" class="inp" id="needsubject" size="30" autocomplete="off" value="$postinfo[subject]" name="subject" placeholder="{lang thread_subject}" fwin="login">-->
			<!--{else}-->
				RE: {{$forum->title}}
				<!--{if $quotemessage}$quotemessage{/if}-->
			<!--{/if}-->
                        @if(!empty($forumRep))
                        <div class="grey quote"><blockquote>引用: <font color="#999999">{{$forumRep->nickname}} 发表于 {{word_time($forumRep->created_at,1)}}</font><br>
                            <font color="#999999">{{$forumRep->content}}</font></blockquote>
                        </div>
                        @endif
			</li>
			<!--{if $isfirstpost && !empty($_G['forum'][threadtypes][types])}-->
<!--			<li>
				<div class="login_select">
					<span class="login-btn-inner">
						<span class="login-btn-text">
							<span class="span_question">选择主题分类</span>
						</span>
						<span class="icon-arrow">&nbsp;</span>
					</span>
					<select id="typeid" name="typeid" class="sel_list">
						<option value="0" selected="selected">{lang select_thread_catgory}</option>
						{loop $_G['forum'][threadtypes][types] $typeid $name}
						{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}
						<option value="$typeid"{if $thread['typeid'] == $typeid || $_GET['typeid'] == $typeid} selected="selected"{/if}>{echo strip_tags($name);}</option>
						{/if}
						{/loop}
					</select>
				</div>				
			</li>-->
			<!--{/if}-->
			<!--{if $_GET[action] == 'edit' && $isorigauthor && ($isfirstpost && $thread['replies'] < 1 || !$isfirstpost) && !$rushreply && $_G['setting']['editperdel']}-->
			<li>
				<!--<input type="checkbox" name="delete" id="delete" class="inp" value="1" title="{lang post_delpost}{if $thread[special] == 3}{lang reward_price_back}{/if}"> {lang delete_check}-->
			</li>
			<!--{/if}-->
			<li class="cfix">
			<textarea class="textarea" id="needmessage" tabindex="3" autocomplete="off" id="{$editorid}_textarea" name="$editor[textarea]" cols="80" rows="2" placeholder="内容" fwin="reply"></textarea>
			</li>
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
				<script src="{{asset('resources/wap/touch/images/js/get_face.js')}}"></script>
			</li>
			<!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
			<li><!--{subtemplate common/seccheck}--></li>
			<!--{/if}-->
			
		</ul>
		<ul id="imglist" class="post_imglist cfix">
			<li class="faceBtn">
				<a href="javascript:;"></a>
			</li>
			<li class="first">
				<a href="javascript:;">
					<input type="file" name="Filedata" id="filedata"/>
				</a>
			</li>
		</ul>
		
		<!--{hook/post_bottom_mobile}-->
	</div>

	<div class="bt_btn">
		<button id="postsubmit" class="btn_pn btn_pn_grey" disable="true">
                        回复
		</button>
	</div>
<!-- main postbox end -->
</form>
<!--{else}-->
<!--	<div class="box xg1">
	{if $special == '2'}
	{lang send_special_trade_error}
    {elseif $special == '4'}
	{lang send_special_activity_error}
	{elseif $isfirstpost && $sortid}
	{lang threadsort_error}
    {/if}
    </div>-->
<!--{/if}-->
    <script src="{{asset('resources/home/js/jquery-2.1.3.min.js')}}" type="text/javascript"></script> 
<script type="text/javascript">
	(function() {
		var needsubject = needmessage = false;

//		<!--{if $_GET[action] == 'reply'}-->
			needsubject = true;
//		<!--{elseif $_GET[action] == 'edit'}-->
//			needsubject = needmessage = true;
//		<!--{/if}-->

//		<!--{if $_GET[action] == 'newthread' || ($_GET[action] == 'edit' && $isfirstpost)}-->
		$('#needsubject').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needsubject = true;
				if(needmessage == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needsubject = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
//		<!--{/if}-->
		$('#needmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needmessage = true;
				if(needsubject == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needmessage = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});

		$('#needmessage').on('scroll', function() {
			var obj = $(this);
			if(obj.scrollTop() > 0) {
				obj.attr('rows', parseInt(obj.attr('rows'))+2);
			}
		}).scrollTop($(document).height());
	 })();
</script>
<script type="text/javascript" src="{{asset('resources/wap/js/mobile/ajaxfileupload.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/wap/js/mobile/buildfileupload.js')}}"></script>
<script type="text/javascript">
	var imgexts = typeof imgexts == 'undefined' ? 'jpg, jpeg, gif, png' : imgexts;
	var STATUSMSG = {
		'-1' : '{lang uploadstatusmsgnag1}',
		'0' : '{lang uploadstatusmsg0}',
		'1' : '{lang uploadstatusmsg1}',
		'2' : '{lang uploadstatusmsg2}',
		'3' : '{lang uploadstatusmsg3}',
		'4' : '{lang uploadstatusmsg4}',
		'5' : '{lang uploadstatusmsg5}',
		'6' : '{lang uploadstatusmsg6}',
		'7' : '{lang uploadstatusmsg7}(' + imgexts + ')',
		'8' : '{lang uploadstatusmsg8}',
		'9' : '{lang uploadstatusmsg9}',
		'10' : '{lang uploadstatusmsg10}',
		'11' : '{lang uploadstatusmsg11}'
	};
	var form = $('#postform');
	$(document).on('change', '#filedata', function() {
			popup.open('<img src="' + IMGDIR + '/imageloading.gif">');

			uploadsuccess = function(data) {
				if(data == '') {
					popup.open('{lang uploadpicfailed}', 'alert');
				}
				var dataarr = data.split('|');
				if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
					popup.close();
					$('#imglist').append('<li><span aid="'+dataarr[3]+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_'+dataarr[3]+'" title="'+dataarr[6]+'" src="{$_G[setting][attachurl]}forum/'+dataarr[5]+'" /></a></span><input type="hidden" name="attachnew['+dataarr[3]+'][description]" /></li>');
				} else {
					var sizelimit = '';
					if(dataarr[7] == 'ban') {
						sizelimit = '{lang uploadpicatttypeban}';
					} else if(dataarr[7] == 'perday') {
						sizelimit = '{lang donotcross}'+Math.ceil(dataarr[8]/1024)+'K)';
					} else if(dataarr[7] > 0) {
						sizelimit = '{lang donotcross}'+Math.ceil(dataarr[7]/1024)+'K)';
					}
					popup.open(STATUSMSG[dataarr[2]] + sizelimit, 'alert');
				}
			};

			if(typeof FileReader != 'undefined' && this.files[0]) {//note 支持html5上传新特性
				
				$.buildfileupload({
					uploadurl:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
					files:this.files,
					uploadformdata:{uid:"$_G[uid]", hash:"<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"},
					uploadinputname:'Filedata',
					maxfilesize:"$swfconfig[max]",
					success:uploadsuccess,
					error:function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});

			} else {

				$.ajaxfileupload({
					url:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
					data:{uid:"$_G[uid]", hash:"<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"},
					dataType:'text',
					fileElementId:'filedata',
					success:uploadsuccess,
					error: function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});

			}
	});

	<!--{if 0 && $_G['setting']['mobile']['geoposition']}-->
//	geo.getcurrentposition();
	<!--{/if}-->
	$('#postsubmit').on('click', function() {
		var obj = $(this);
		if(obj.attr('disable') == 'true') {
			return false;
		}

		obj.attr('disable', 'true').removeClass('btn_pn_blue').addClass('btn_pn_grey');
		popup.open('<img src="' + IMGDIR + '/imageloading.gif">');

		var postlocation = '';
		if(geo.errmsg === '' && geo.loc) {
			postlocation = geo.longitude + '|' + geo.latitude + '|' + geo.loc;
		}

		$.ajax({
			type:'POST',
			url:form.attr('action') + '&geoloc=' + postlocation + '&handlekey='+form.attr('id')+'&inajax=1',
			data:form.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});

	$(document).on('click', '.del', function() {
		var obj = $(this);
		$.ajax({
			type:'GET',
			url:'forum.php?mod=ajax&action=deleteattach&inajax=yes&aids[]=' + obj.attr('aid'),
		})
		.success(function(s) {
			obj.parent().remove();
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});

</script>

<script type="text/javascript">
	(function() {
		$(document).on('change', '.sel_list', function() {
			var obj = $(this);
			$('.span_question').text(obj.find('option:selected').text());
		});
	 })();
</script>

<script type="text/javascript">
$(".faceBtn").toggle(function(){
	$(".faceBox").show();
	$(".textarea")[0].focus();},
	function(){
	$(".faceBox").hide();
	$(".textarea")[0].focus();
});
</script>



