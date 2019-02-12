@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
                    <input style="min-width:350px" class="layui-input" name="keyword" id="demoReload" placeholder="请输入姓名、手机号码、简历id或求职意向" autocomplete="off">
        	</div>
	        <div class="layui-inline">
                <select name="type" id="type">
	        	<option value="">不限</option>
                        <option value="0" @if($type==0)selected @endif>未审核(处理)简历</option>
                        <option value="1">完全公开简历</option>
                        <option value="2">不公开简历</option>
                        <option value="3">完全保密简历</option>
                        <option value="4">已删除简历</option>
                        <option value="5">驳回简历</option>
	        </select>
	        </div>
        	<div class="layui-inline">
        		<button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
        		<button type="reset" class="layui-btn layui-btn-primary">重置</button>
                 <!--<a href="{{url('ajaxGetJobUserReg/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a>--> 
        	</div>
        	</blockquote>
        </div>
    </form>
    <div class="layui-card-body">
        <div class="layui-btn-group test-table-operate-btn" style="margin-bottom: 10px;">
          <button class="layui-btn" data-type="getCheckPass">通过审核</button>
          <button class="layui-btn" data-type="deleteResume">删除简历</button>
          <button class="layui-btn" data-type="getCheckUnpass">驳回简历</button>
        </div>
    </div>
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
                , url: "{{url('admin/ajaxGetAuditResume')}}"
		,loading :true
                , cols: [[
                    { fixed: 'left',checkbox:true,width:"4%",}
                    , { field: 'id', title: 'ID',width:"8%", sort: true}
                    , { field: 'name', title: '姓名',width:"11%", sort: true}//,templet:"<div><img src='@{{d.art_thumb}}' /></div>"
                    , { field: 'birthday', title: '出生日期',width:"12%"}
                    , { field: 'education', title: '最高学历',width:"6%"}
                    , { field: 'mobile', title: '手机号码',width:"13%"}
                    , { field: 'regtime', title: '添加时间',width:"15%",sort: true}
                    , { field: 'intentionjobs', title: '寻求职位',width:"15%",sort: true}
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
                            type: $('#type').val(),
                        }
                    });
                }
                ,getCheckPass: function(){ //通过审核
                var checkStatus = table.checkStatus('testReload')
                ,data = checkStatus.data;
                //layer.alert(JSON.stringify(data));
                if(data.length==0){
                    layer.msg('请先勾选简历');
                    return;
                }
                //console.log(data);
                layer.confirm('您确定要审核通过么', function (index) {
                    ajaxRequest("{{url('admin/approved')}}",data);
                })
                }
              ,deleteResume: function(){ //删除
                var checkStatus = table.checkStatus('testReload')
                ,data = checkStatus.data;
                if(data.length==0){
                    layer.msg('请先勾选简历');
                    return;
                }
                layer.confirm('您确定要删除么', function (index) {
                    ajaxRequest("{{url('admin/batch_del_resume')}}",data);
                })
                
              }
              ,getCheckUnpass: function(){ //驳回
                var checkStatus = table.checkStatus('testReload')
                ,data = checkStatus.data;
                //layer.msg(checkStatus.isAll ? '全选': '未全选')
                if(data.length==0){
                    layer.msg('请先勾选简历');
                    return;
                }
                layer.confirm('您确定要驳回么', function (index) {
                    ajaxRequest("{{url('admin/dismissed_resume')}}",data);
                })
              }
            };
            $('.test-table-operate-btn .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
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
                    layer.msg('ID：' + data.uid + ' 的查看操作');
                } else if (obj.event === 'del') {
                	//ttp();
                    layer.confirm('您确定要删除该简历么', function (index) {
                        //console.log(data);
                        $.ajax({
                            url: "{{url('admin/del_resume')}}",
                            type: "POST",
                            data: {id:data.id,'_token':"{{csrf_token()}}"},
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
                        content: "/admin/job_user_mod?id="+ data.uid,
                    });
                }
            });

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

            function ttp(){
            	layer.open({
                    type: 1
                    ,title: false 
                    ,closeBtn: false
                    ,area: '300px;'
                    ,shade: 0.8
                    ,id: '' 
                    ,btn: ['我明白']
                    ,btnAlign: 'c'
                    ,moveType: 1 
                    ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">亲！<br>本平台暂不开放编辑/删除等操作<br><br>后期敬请期待 ^_^</div>'
                    ,success: function(layero){
//                       var btn = layero.find('.layui-layer-btn');
//                       btn.find('.layui-layer-btn0').attr({
//                         href: ''
//                         ,target: '_blank'
//                       });
                    }
                  });
            }
            function EidtUv(data, value, index, obj) {
                $.ajax({
                    url: "",
                    type: "POST",
                    data: { "id": data.id, "uv": value },
                    dataType: "json",
                    success: function (data) {
                        if (data == 1) {
                            layer.close(index);
                            obj.update({
                                uv: value
                            });
                            layer.msg("修改成功", { icon: 6 });
                        } else {
                            layer.msg("修改失败", { icon: 5 });
                        }
                    }

                });
            }
           	
        });
    </script>
    </div>
  </div>

@endsection


