@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
            	<input class="layui-input" name="keyword" id="demoReload" placeholder="请输入广告位置关键字" autocomplete="off">
        	</div>
        	<div class="layui-inline">
        		<button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search" aria-hidden="true"></i>搜索</button>
        		<button type="reset" class="layui-btn ">重置</button>
                        <span class="layui-btn addAddr">添加</span>
<!--                 <a href="{{url('ajaxGetAdv/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a> -->
        	</div>
        	</blockquote>
        </div>
    </form>
    <table class="layui-hide" id="LAY_table_user" lay-filter="useruv"></table>
    <script type="text/html" id="barDemo">
        	<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  			<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
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
                , url: "{{url('admin/ajaxGetAddr')}}"
//                 ,cellMinWidth: 120
				,loading :true
				,height: 500 //设置高度
// 				,initSort: {
// 				    field: 'logintime' 
// 				        ,type: 'desc' 
// 				      }
                , cols: [[
                    { fixed: 'left',checkbox:true,width:"4%",}
                    , { field: 'ad_name', title: '位置名称',width:"20%",sort: true}
                    , { field: 'ad_sign', title: '位置标识',width:"15%", sort: true}
                    , { field: 'width', title: '广告宽度',width:"15%", sort: true}
                    , { field: 'height', title: '广告高度',width:"15%", sort: true}
                    , { field: 'ad_number', title: '显示条目',width:"15%",sort: true}
                    , { fixed: 'right', title: '操作',width:"16%",toolbar: "#barDemo" }
                ]]
                , id: 'testReload'
                , page: true
                , limit:15
                , height: 700
                ,done: function(res, curr, count){
                  	//console.log(res);
                }
                
            });
                        
            form.render();
            var $ = layui.$, active = {
                reload: function () {
                    table.reload('testReload', {
                        where: {
                            keyword: $('#demoReload').val(),
                        }
                    });
                }
            };

            form.on('submit(search)', function(data){
            	
            	return false;
            })
            
            form.on('submit(download)', function(data){
            	
            	return false
            })
            
            table.on('checkbox(useruv)', function (obj) {
            	console.log(obj)
            });
            
            table.on('tool(useruv)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    layer.msg('ID：' + data.id + ' 的查看操作');
                } else if (obj.event === 'del') {
                    layer.confirm('您确定要删除该广告位么', function (index) {
                        $.ajax({
                             url: "{{url('admin/adv_addr_del')}}",
                             type: "POST",
                             data: { "id": data.id },
                             dataType: "json",
                             success: function (data) {
                                 //console.log(data);
                                 if (data.code == 1) {
                                     obj.del();
                                     layer.close(index);
                                     layer.msg(data.msg, { icon: 6 });
                                 } else {
                                     layer.msg(data.msg, { icon: 5 });
                                 }
                             }

                         });
                     })

                } else if (obj.event === 'edit') {
                	layer.open({
                        title: "添加广告位置",
                        type: 2,
                        area: ['80%', '60%'],
                        maxmin: true,
                        content: "/admin/adv_addr_edit?id="+ data.id,
                    }); 
                }
            });

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
            
   	
           	$(".addAddr").click(function(){
                layer.open({
                        title: "添加广告位置",
                        type: 2,
                        area: ['80%', '60%'],
                        maxmin: true,
                        content: "/admin/adv_addr_add",
                    });  
              })
           	
        });
    </script>
    </div>
  </div>

@endsection


