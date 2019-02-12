@extends('layouts.wap')
@section('content')
<!-- 引入jQuery -->
<script src="{{asset('resources/wap/js/Eleditor/webuploader.min.js')}}"></script>
<!-- 插件核心 -->
<script src="{{asset('resources/wap/js/Eleditor/Eleditor.min.js')}}"></script>
<script>
	var ua = navigator.userAgent.toLowerCase();	;

	if( ua.indexOf('android') >= 0 || ua.indexOf('iphone') >= 0 || ua.indexOf('ipad') >= 0 || $(window).width() <= 500 ){
		$('.viewTit').hide();
		$('body').css('padding-top', 0);
	}
</script>
<style>
    #contentEditor{
        width: 100%;
        min-height: 300px;
        box-sizing: border-box;
        padding: 10px;
        color: #444;
        background:#fff
    }
    #contentEditor p{
        letter-spacing: 0.25px;
        font: 16px/25px Tahoma, Verdana, 宋体;
        margin: 20px 0px;
    }
    #contentEditor h4 {
        font-weight: bold;
        line-height: 1.333em;
        margin: 10px 0 20px;
        padding: 25px 0 0;
    }
    #contentEditor img{
        width: 100%;
        height: auto;
        box-sizing: border-box;
    }
    video{
        width:100%;
        max-height:300px;
    }
</style>
<header class="header">
    <a href="javascript:history.go(-1);" class="goBack fl">返回</a>
    <h1>发帖</h1>
</header>
<div class="post_from">
<ul class="cl">
<li>
<input type="text" tabindex="1" class="inp" id="needsubject" size="30" autocomplete="off" value="" name="subject" placeholder="标题" fwin="login">
</li>
<li class="cfix">
    <div id="contentEditor"></div>
</li>

</ul>

</div>
<div class="bt_btn">
<button id="postsubmits" class="btn_pn btn_pn_blue">发表</button>
</div>
<script>
    layui.use(['form','upload'], function(){
var contentEditor = new Eleditor({
    el: '#contentEditor',
    upload: {
        server: "{{url('wap/upload_add_qiniu')}}",
        // headers: {
        // 	'token': '123123'
        // },
        compress: false,
        fileSizeLimit: 100
    },
    /*初始化完成钩子*/
    mounted: function() {

        /*以下是扩展插入视频的演示*/
        var _videoUploader = WebUploader.create({
            auto: true,
            server: "{{url('wap/upload_add_qiniu_video')}}",
            /*按钮类就是[Eleditor-你的自定义按钮id]*/
            pick: $('.Eleditor-insertVideo'),
            duplicate: true,
            resize: false,
//            accept: {
//                title: 'Images',
//                extensions: 'mp4,MOV,mov',
//                mimeTypes: 'video/mp4,video/MOV'
//            },
            fileVal: 'video',
        });
        _videoUploader.on('uploadStart',function(_file, _percentage) {
            var index = layer.load(1);
        })
        
        _videoUploader.on('uploadSuccess',
        function(_file, _call) {

            if (_call.status == 0) {
                return window.alert(_call.msg);
            }
            console.log(_call);
            console.log(_file);
            layer.closeAll('loading');
            /*保存状态，以便撤销*/
            contentEditor.saveState();
            contentEditor.getEditNode().after(` <div class = 'Eleditor-video-area' > <video src = "${_call.url}"controls = "controls" poster="${_call.url}?vframe/jpg/offset/2/h/270" > </video>
									</div>`);
            contentEditor.hideEditorControllerLayer();
        });
    },
    changer: function() {
        console.log('文档修改');
        
    },
    /*自定义按钮的例子*/
    toolbars: ['insertText', 'editText', 'insertImage', 'insertLink', 'insertHr', 'delete',
    //自定义一个视频按钮
    {
        id: 'insertVideo',
        // tag: 'p,img', //指定P标签操作，可不填
        name: '插入视频',
        handle: function(select, controll) { //回调返回选择的dom对象和控制按钮对象
            /*因为上传要提前绑定按钮到webuploader，所以这里不做上传逻辑，写在mounted*/

            /*!!!!!!返回false编辑面板不会关掉*/
            return false;
        }
    },
    'undo', 'cancel']
    //placeHolder: 'placeHolder设置占位符'
});

$("#postsubmits").click(function(){
    var _content = contentEditor.getContent();
    var title = $("#needsubject").val();
    //console.log(_content);
    $(this).attr("disabled",true);
    if(title==""){
        alert("请填写标题!");
        return;
    }
    if(_content==""){
        alert("请填写内容!");
        return;
    }
    $.ajax({  
          type : "post",  
          url : "/wap/sendForum",  
          data : {content:_content,title:title,pid:"{{$id}}",'_token':"{{csrf_token()}}"},   
          async : false,  
          success : function(res){
            if(res.code==1){
                window.location.href="{{url('wap/forum_list_detail')}}/"+res.fid;
            }
            $(this).attr("disabled",true);
          }
	});
})})
</script>
   {{-- @include('layouts/footer')--}} 
@endsection