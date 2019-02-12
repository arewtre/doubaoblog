BASE_URL = '/';//根目录

/**去除2边函数**/
function str_trim(str){ //删除左右两端的空格
	return str.replace(/(^[\s\,\-\+\，\/\\]*)|([\s\,\-\+\，\/\\]*$)/g, "");
}
//去除数组相同的值
function array_merge(thisarray){
	var h = {};    //定义一个hash表
	var arr = [];  //定义一个临时数组

	for(var i = 0; i < thisarray.length; i++){    //循环遍历当前数组
		//对元素进行判断，看是否已经存在表中，如果存在则跳过，否则存入临时数组
		if(!h[thisarray[i]]){
			//存入hash表
			h[thisarray[i]] = true;
			//把当前数组元素存入到临时数组中
			arr.push(thisarray[i]);
		}
	}
	return arr;
}
//实现hashtable去掉重复项
function array_unique(arr){
	var result = [], hash = {};
	for(var i = 0, elem; (elem = arr[i]) != null; i++){
		if(!hash[elem]){
			result.push(elem);
			hash[elem] = true;
		}
	}
	return result;
	//http://www.cnblogs.com/sosoft/
}
//判断数组是不是重复项
function isUnique(arr){
	var hash = {};
	for(var i in arr){
		if(hash[arr[i]])
			return true;
		hash[arr[i]] = true;
	}
	return false;
}


/**
 * Created by Administrator on 2016/8/12.
 * 公共函数库
 */
//截取中文
function mSubstr(str, size){
	var totalCount = 0;
	var newStr = "";
	for(var i = 0; i < str.length; i++){
		var c = str.charCodeAt(i);
		if((c >= 0x0001 && c <= 0x007e) || (0xff60 <= c && c <= 0xff9f)){
			totalCount++;
		}else{
			totalCount += 2;
		}
		if(totalCount < size){
			newStr = str.substring(0, i + 1);
		}else{
			return newStr + "...";
		}
	}
	return newStr;
}

/**添加select option**/
//function addOption(obj,arr){
//    var obj=document.getElementById(obj);
//    for(var key in arr){
//        obj.options.add(new Option(arr[key][1],arr[key][0]));
//    }
//
//}
//判断数组是不是存在
function in_array(search, array){
	for(var i in array){
		if(array[i] == search){
			return true;
		}
	}
	return false;
}

/**jquery添加select option**/
function jqueryAddOption(obj, arr, othisobj){
	$.each(arr, function(key, value){
		$('#' + othisobj).find("#" + obj).append($("<option/>", {
			value: value['value'],
			text: value['text']
		}));
	});
}


/**radio的选择*/
function radio_checked(m, myvalue){
	for(var i = 0; i < m.length; i++){
		if(m[i].value == myvalue){
			m[i].checked = true;
		}
	}
}
/**
 * js nl2br
 * @param str
 * @param is_xhtml
 * @returns {string}
 */
function nl2br(str, is_xhtml){
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

/**
 *简单提示
 **/
var checktip_t = '';
var isIE6 = !!window.ActiveXObject && !window.XMLHttpRequest;
function checktip(tipinfo){
	var inp_message = $("#inp_message");
	if(inp_message.length <= 0){
		$("body").append('<div class="Pro_message" id="inp_message" style="z-index:66666;"></div>');
	}
	inp_message.html(tipinfo);
	clearInterval(checktip_t);
	var screenX = $(window).width();
	var screenH = $(window).height();
	var scrollTop = $(window).scrollTop();

	var lWidth = inp_message.width();
	var lHeight = inp_message.height();
	var iLeft = parseInt((screenX - lWidth) / 2) + "px";
	var iTop = parseInt((screenH - lHeight) / 2) + "px";
	var ie6TOP = parseInt((screenH - lHeight) / 2) + scrollTop + "px";

	inp_message.css({
		position: "fixed",
		left: iLeft,
		top: iTop
	}).show();

	//判断IE6
	if(isIE6){
		$("#inp_message").css({
			position: "absolute",
			left: iLeft,
			top: ie6TOP
		});
	}
	inp_message.click(function(){
		$(this).hide();
	})

	checktip_t = setInterval(function(){
		$("#inp_message").hide();
	}, 2000);
}

/**
 * 设置一下cookie
 * @param name 名称
 * @param value 值
 * @param days 保存的时间null代表关闭失效
 */
function setCookie(name, value, days){
	if(days == null){
		document.cookie = name + "=" + value + ";path=/";
	}else{
		var exp = new Date();
		exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
		document.cookie = name + "=" + value + ";path=/" + ";expires=" + exp.toGMTString();
	}
}
/**
 * 获取一个cookie
 * @param name cookie名称
 * @returns {*}
 */
function getCookie(name){
	var strArg = name + "=";
	var nArgLen = strArg.length;
	var nCookieLen = document.cookie.length;
	var nEnd;
	var i = 0;
	var j;
	while(i < nCookieLen){
		j = i + nArgLen;
		if(document.cookie.substring(i, j) == strArg){
			nEnd = document.cookie.indexOf(";", j);
			if(nEnd == -1) nEnd = document.cookie.length;
			//return decodeURIComponent(document.cookie.substring(j,nEnd));
			return document.cookie.substring(j, nEnd);
		}
		i = document.cookie.indexOf(" ", i) + 1;
		if(i == 0) break;
	}
	return null;
}
/**
 * 防重复提交
 * @param othis
 * @param form
 */
var formSubmit_nav_name = '';
function formSubmit(othis, form){
	form.submit();
	$(othis).attr('disabled', 'disabled');
	formSubmit_nav_name = $(othis).val();
	function settime(countdown){
		if(countdown == 0){
			$(othis).attr('disabled', false);
			$(othis).val(formSubmit_nav_name);
		}else{
			$(othis).val("请稍候" + countdown + "...");
			countdown--;
			setTimeout(function(){
				settime(countdown);
			}, 1000);
		}
	}

	settime(5);
}


/**
 * 检查提交表单重复插入
 * @param form
 * @returns {boolean}
 */
function checkForm(form){
	$(form).find("input[type='submit']").val('请稍候');
	$(form).find("input[type='submit']").attr('disabled', true);
	$(form).find("input[type='submit']").attr('readonly', true);
	return true;
}

