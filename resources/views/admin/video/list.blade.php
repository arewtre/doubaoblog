@extends('layouts.base')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('resources/video/css/normalize.css')}}" />
<link rel="stylesheet" href="{{asset('resources/video/css/main.css')}}">
<style>
    .layui-table-cell {
     height: 100%; 
     line-height: 100%; 
    padding: 0 15px;
    position: relative;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    box-sizing: border-box;
}
    .laytable-cell-1-pic{  /*最后的pic为字段的field*/
      height: 100%;
      max-width: 100%;
    } 
   .layui-table img {
    max-width: 100%;
} 
.vd{width:100%;height:100%;position:relative}
.bf{font-size:30px;position:absolute;left:42%;top:40%;z-index:99;color:#fff}
</style>
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote" style="text-align:left">
	        <div class="layui-inline">
            	<input class="layui-input" name="keyword" id="demoReload" placeholder="请输入视频关键字" autocomplete="off">
        	</div>
	        <div class="layui-inline">
            <select name="cate_id">
	        <option value="">请选择分类</option>
	        @foreach($CategoryList as $vo)
                    <option value="{{$vo['id']}}">{{$vo['showName']}}</option>
                @endforeach
	        </select>
	        </div>
        	<div class="layui-inline">
                    <button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
                    <button type="reset" class="layui-btn">重置</button> 
<!--                <a href="{{url('ajaxGetNews/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a> -->
                    <a href="{{url('admin/video_add')}}"><span class="layui-btn">上传视频</span></a>
        	</div>
        	</blockquote>
        </div>
    </form>
    <table class="layui-hide" id="LAY_table_user" lay-filter="useruv"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  	<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script src="{{asset('resources/video/dist/BigPicture.js')}}"></script>
    <script>

          function getVideo(obj,url){
            BigPicture({
                   el: obj,
                   vidSrc: url
             });
        }
        
        layui.use(['table','form','laydate'], function () {
            var table = layui.table,form=layui.form,laydate=layui.laydate;
            laydate.render({
              elem: '#daterange'
              ,range: true
              ,range: '~'
            });
           
            form.render();
            table.render({
                elem: '#LAY_table_user'
                , url: "{{url('admin/video_list')}}"
		,loading :true
                , cols: [[
//                    { fixed: 'left',checkbox:true,width:"4%",}
                    { field: 'v_pic', title: '缩略图',width:"15%", event:'getVideo',sort: true,style:'height:100px;',templet:'<div class="vd"><a href="javascript:;" onclick =\"getVideo(this,\'@{{d.v_url}}\')\"><i class="bf layui-icon layui-icon-play" ></i></a><img class="htmlvid"  src="@{{d.v_url}}?vframe/jpg/offset/2/w/160/h/90" /></div>'}
                    , { field: 'v_name', title: '视频标题',width:"15%", sort: true}
                    , { field: 'defectsname', title: '分类',width:"12%", sort: true}
                    , { field: 'v_view_num', title: '点击数',width:"10%", sort: true}
                    , { field: 'created_at', title: '发布时间',width:"15%",sort: true}
                    , { fixed: 'right', title: '操作',width:"16%",toolbar: "#barDemo" }
                ]]
                , id: 'testReload'
                , page: true
                , limit:15
                , height: 700
                ,done: function(res, curr, count){
                }
                
            });
                 
            
            
            var $ = layui.$, active = {
                reload: function () {
                    table.reload('testReload', {
                        where: {
                            keyword: $('#demoReload').val(),
                            pid:$("[name='cate_id']").val(),
                        }
                    });
                }
            };
            
            
         
          function getVideo(obj,url){
            console.log($(obj));
            BigPicture({
                   el: obj.target,
                   vidSrc: url
             });
        }
 
      form.render();
            form.on('submit(search)', function(data){
            	
            	return false;
            })
            
            form.on('submit(download)', function(data){
            	
            	return false
            })
            
            table.on('checkbox(useruv)', function (obj) {
            	//console.log(obj)
            });
            
            table.on('tool(useruv)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    layer.msg('ID：' + data.art_id + ' 的查看操作');
                } else if (obj.event === 'del') {
                	//ttp();
                    layer.confirm('您确定要删除该视频么', function (index) {
                        console.log(data);
                        $.ajax({
                            url: "{{url('admin/video_del')}}",
                            type: "POST",
                            data: { id: data.v_id,'_token':"{{csrf_token()}}"},
                            dataType: "json",
                            success: function (data) {
                                if (data.code == 1) {
                                    obj.del();
                                    layer.close(index);
                                    layer.msg(data.msg, { icon: 6 });
                                } else {
                                    layer.msg(data.msg, { icon: 5 });
                                }
                            }

                        });
                    });

                } else if (obj.event === 'edit') {
                	//ttp();
                	layer.open({
						title: "编辑视频",
                        type: 2,
                        area: ['80%', '80%'],
                        maxmin: true,
                        content: "/admin/video_edit?id="+ data.v_id,
                    });
                } else if(obj.event === 'getVideo'){
                    

                   
                }
            });

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });           
           	
            
        });
        $(function(){
          function getVideo(obj,url){
            console.log($(obj));
            BigPicture({
                   el: obj.target,
                   vidSrc: url
             });
        }
      })  
        
    </script>
    </div>
  </div>

@endsection


