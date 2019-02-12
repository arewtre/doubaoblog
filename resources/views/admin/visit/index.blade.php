@extends('layouts.base')
@section('content')
<style>

    
</style>
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
            	<input class="layui-input" name="ip" id="demoReload" placeholder="请输入ip" autocomplete="off">
        	</div>
        	<div class="layui-inline">
                    <button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
                    <button type="reset" class="layui-btn">重置</button> 
<!--                <a href="{{url('ajaxGetNews/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a> -->
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
                , url: "{{url('admin/visitLog')}}"
		,loading :true
                , cols: [[
//                    { fixed: 'left',checkbox:true,width:"4%",}
                    { field: 'clientip', title: 'IP地址',width:"10%", sort: true}
                    , { field: 'province', title: '地址',width:"10%",templet:"<div>@{{d.province}} @{{d.city}} </div>"}
                    , { field: 'nettype', title: '运营商',width:"6%"}
                    , { field: 'os', title: '操作系统',width:"12%"}
                    , { field: 'client_info', title: '浏览器',width:"18%"}
                    , { field: 'url', title: '访问地址',width:"28%",templet:"<div><a href='@{{d.url}}' target='_blank' >@{{d.url}}</a></div>"}
                    , { field: 'created_at', title: '访问时间',width:"16%",sort: true}
//                    , { fixed: 'right', title: '操作',width:"16%",toolbar: "#barDemo" }
                ]]
                , id: 'testReload'
                , page: true
                , limit:15
                , height: 700
                ,done: function(res, curr, count){
                }
                
            });
                        
            form.render();
            var $ = layui.$, active = {
                reload: function () {
                    table.reload('testReload', {
                        where: {
                            cilentip: $('#demoReload').val(),
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
            	//console.log(obj)
            });
            
            table.on('tool(useruv)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    layer.msg('ID：' + data.art_id + ' 的查看操作');
                } else if (obj.event === 'del') {
                	//ttp();
                    layer.confirm('您确定要删除该资讯么', function (index) {
                        console.log(data);
                        $.ajax({
                            url: "{{url('admin/news_del')}}",
                            type: "POST",
                            data: { id: data.art_id,'_token':"{{csrf_token()}}"},
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
						title: "编辑资讯",
                        type: 2,
                        area: ['80%', '80%'],
                        maxmin: true,
                        content: "/admin/news_edit?id="+ data.art_id,
                    });
                }
            });

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });           
           	
        });
    </script>
    </div>
  </div>

@endsection


