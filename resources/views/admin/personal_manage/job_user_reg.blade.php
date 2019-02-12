@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
                    <input style="min-width:260px" class="layui-input" name="keyword" id="demoReload" placeholder="请输入用户名或者手机号码" autocomplete="off">
        	</div>
<!--	        <div class="layui-inline">
                <select name="cate_id">
	        	<option value="">请选择分类</option>
	        	
	        </select>
	        </div>-->
        	<div class="layui-inline">
        		<button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
        		<button type="reset" class="layui-btn layui-btn-primary">重置</button>
                 <!--<a href="{{url('ajaxGetJobUserReg/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a>--> 
        	</div>
        	</blockquote>
        </div>
    </form>
<!--    <div class="layui-card-body">
        <div class="layui-btn-group test-table-operate-btn" style="margin-bottom: 10px;">
          <button class="layui-btn" data-type="getCheckData">获取选中行数据</button>
          <button class="layui-btn" data-type="getCheckLength">获取选中数目</button>
          <button class="layui-btn" data-type="isAll">验证是否全选</button>
        </div>
    </div>-->
    <table class="layui-hide" id="LAY_table_user" lay-filter="useruv"></table>
    <script type="text/html" id="barDemo">
        	<a class="layui-btn layui-btn-xs" lay-event="edit">注册信息</a>
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
                , url: "{{url('admin/ajaxGetJobUserReg')}}"
		,loading :true
                , cols: [[
                    { fixed: 'left',checkbox:true,width:"4%",}
                    , { field: 'uid', title: '用户ID',width:"8%", sort: true}//,templet:"<div><img src='@{{d.art_thumb}}' /></div>"
                    , { field: 'username', title: '用户名',width:"18%"}
                    , { field: 'mobile', title: '手机号码',width:"15%"}
                    , { field: 'email', title: '注册邮箱',width:"18%"}
                    , { field: 'regtime', title: '注册时间',width:"18%",sort: true}
//                    , { field: '', title: '账户绑定',width:"15%",sort: true}
                    , { fixed: 'right', title: '操作',width:"19%",toolbar: "#barDemo" }
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
            
            table.on('checkbox(useruv)', function (obj) {
            });
            var $ = layui.$, active = {
                reload: function () {
                    table.reload('testReload', {
                        where: {
                            keyword: $('#demoReload').val(),
                        }
                    });
                }
                ,getCheckData: function(){ //获取选中数据
                var checkStatus = table.checkStatus('testReload')
                ,data = checkStatus.data;
                layer.alert(JSON.stringify(data));
              }
              ,getCheckLength: function(){ //获取选中数目
                var checkStatus = table.checkStatus('testReload')
                ,data = checkStatus.data;
                layer.msg('选中了：'+ data.length + ' 个');
              }
              ,isAll: function(){ //验证是否全选
                var checkStatus = table.checkStatus('testReload');
                layer.msg(checkStatus.isAll ? '全选': '未全选')
              }

            };
            $('.test-table-operate-btn .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
              });
            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
            form.on('submit(search)', function(data){
            	
            	return false;
            })
            
            form.on('submit(download)', function(data){
            	
            	return false
            })
            
            
            table.on('tool(useruv)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    layer.msg('ID：' + data.uid + ' 的查看操作');
                } else if (obj.event === 'del') {
                	//ttp();
                    layer.confirm('您确定要删除该用户么', function (index) {
                        //console.log(data);
                        $.ajax({
                            url: "{{url('admin/job_user_del')}}/"+data.uid,
                            type: "GET",
                            data: {'_token':"{{csrf_token()}}"},
                            dataType: "json",
                            success: function (data) {
                                if (data.status == 0) {
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
			title: "编辑用户注册信息",
                        type: 2,
                        area: ['80%', '80%'],
                        maxmin: true,
                        content: "{{url('admin/job_user_mod')}}?id="+ data.uid,
                    });
                }
            });

         	
        });
    </script>
    </div>
  </div>

@endsection


