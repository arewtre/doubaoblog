@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
	        <div class="layui-inline">
            	<input class="layui-input" name="keyword" id="demoReload" placeholder="请输入广告名称关键字" autocomplete="off">
        	</div>
	        <div class="layui-inline">
            <select name="ad_site">
	        	<option value="">请选择广告站点</option>
	        	@foreach($ad_site as $v) 
	        	<option value="{{$v->id}}">{{$v->site_name}}</option>
	        	@endforeach
	        </select>
	        </div>
	        <div class="layui-inline">
            <select name="ad_slots">
	        	<option value="">请选择广告位置</option>
	        	@foreach($as_slots as $v) 
	        	<option value="{{$v->id}}">{{$v->ad_name}}</option>
	        	@endforeach 
	        </select>
	        </div>
	        <div class="layui-inline">
                <select name="status">
	        	<option value="">请选择发布状态</option>
	        	<option value="1">发布中</option>
	        	<option value="-1">屏蔽中</option>
	        </select>
	        </div>
        	<div class="layui-inline">
        		<button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search" aria-hidden="true"></i>搜索</button>
        		<button type="reset" class="layui-btn">重置</button>
                        <span class="layui-btn addAdv">添加广告</span>
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
    function getStatus(status) {
	    if(status ==1 ){
	    	return "<span style='color:#00c0ef'><b>已发布</b></span>";
	    }
	    return "<span style='color:#FF6666'><b>已屏蔽</b></span>";
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
                , url: "{{url('admin/ajaxGetAdv')}}"
//              ,cellMinWidth: 120
		,loading :true
		,height: 500 //设置高度

                , cols: [[
                    { fixed: 'left',checkbox:true,width:"4%",}
                    , { field: 'pic_url', title: '缩略图',width:"10%",templet:"<div><img src='@{{d.pic_url}}' /></div>"}
                    , { field: 'title', title: '广告名称',width:"15%"}
                    , { field: 'start_time', title: '开始时间',width:"10%", sort: true}
                    , { field: 'end_time', title: '到期时间',width:"10%", sort: true}
                    , { field: 'ad_site', title: '广告站点',width:"10%"}
                    , { field: 'ad_slots_name', title: '广告位置',width:"15%"}
                    , { field: 'status', title: '发布状态',width:"10%",templet:'<div style="color:red">@{{ getStatus(d.status)}}</div>'}
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
                            ad_site:$("[name='ad_site']").val(),
                            ad_slots:$("[name='ad_slots']").val(),
                            status:$("[name='status']").val(),
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
                	//ttp();
                     layer.confirm('您确定要删除该广告么', function (index) {
                         //console.log(data);
                         $.ajax({
                             url: "{{url('admin/adv_del')}}",
                             type: "POST",
                             data: { "id": data.id,'_token':"{{csrf_token()}}"},
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
                     });

                } else if (obj.event === 'edit') {
                	//ttp();
                	layer.open({
			title: "编辑广告",
                        type: 2,
                        area: ['80%', '90%'],
                        maxmin: true,
                        content: "/admin/adv_edit?id="+ data.id,
                    });
                }
            });

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
            
            $(".addAdv").click(function(){
              layer.open({
			title: "添加广告",
                        type: 2,
                        area: ['80%', '90%'],
                        maxmin: true,
                        content: "/admin/adv_add",
                    });  
            })
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
            

           	$(document).on("click", "td div.laytable-cell-checkbox div.layui-form-checkbox", function (e) {
           		e.stopPropagation();
           	});
           	
           	
           	
        });
    </script>
    </div>
  </div>

@endsection


