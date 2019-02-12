@extends('layouts.base')
@section('content')
<div class="layui-fluid layadmin-maillist-fluid">
    <div class="layui-field-box">
            <div id="zyupload" class="zyupload"></div>  		   
    </div>        
  </div>

<!-- 引用控制层插件样式 -->
<link rel="stylesheet" href="{{asset('resources/upload/css/zyupload-1.0.0.min.css')}}" type="text/css">		
<!--<script type="text/javascript" src="__PUBLIC__/upload/js/zyupload-1.0.0.min.js"></script>-->
<script type="text/javascript" src="{{asset('resources/upload/js/jquery-1.7.2.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/upload/js/zyupload-1.0.0.min.js')}}"></script>
<!-- 引用控制层插件 -->

<script>
//    layui.use(['form','layer'],function(){
//        var form = layui.form(),
//            layer = parent.layer === undefined ? layui.layer : parent.layer,
//            $ = layui.jquery;
//    })
    	

    $(function(){
                // 初始化插件
        $("#zyupload").zyUpload({
            width            :   "650px",                 // 宽度
            height           :   "400px",                 // 宽度
            itemWidth        :   "140px",                 // 文件项的宽度
            itemHeight       :   "115px",                 // 文件项的高度
            url              :   "{{url('admin/upload_add_image')}}?xc_id="+"{{$xc_id}}",              // 上传文件的路径
            fileType         :   ["jpg","png","PNG","JPG","JPEG","txt","gif","GIF","js"],// 上传文件的类型
            fileSize         :   51200000000,                // 上传文件的大小
            multiple         :   true,                    // 是否可以多个文件上传
            dragDrop         :   true,                    // 是否可以拖动上传文件
            tailor           :   true,                    // 是否可以裁剪图片
            del              :   true,                    // 是否可以删除文件
            finishDel        :   false,  				  // 是否在上传文件完成后删除预览
            /* 外部获得的回调接口 */
            onSelect: function(selectFiles, allFiles){    // 选择文件的回调方法  selectFile:当前选中的文件  allFiles:还没上传的全部文件
                console.info("当前选择了以下文件：");
                console.info(selectFiles);
            },
            onDelete: function(file, files){              // 删除一个文件的回调方法 file:当前删除的文件  files:删除之后的文件
                console.info("当前删除了此文件：");
                console.info(file.name);
            },
            onSuccess: function(file, response){          // 文件上传成功的回调方法
                console.info("此文件上传成功：");
                console.info(file.name);
                console.info("此文件上传到服务器地址：");
                console.info(response);
                
            },
            onFailure: function(file, response){          // 文件上传失败的回调方法
    // 		console.info("此文件上传失败：");
    // 		console.info(file.name);
            },
            onComplete: function(response){           	  // 上传完成的回调方法
    // 		console.info("文件上传完成");
    // 		console.info(response);

                setTimeout(function(){
                    //parent.layer.closeAll();
                    parent.location.reload();
                },2000)

            }
        });
    });
		

  </script>
@endsection


