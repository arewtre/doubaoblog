@extends('layouts.base')
@section('content')
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
/*    .laytable-cell-1-pic{  //最后的pic为字段的field
      height: 100%;
      max-width: 100%;
    } */
img{
    max-width:40px;
    height:40px;
}
</style>
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
        <form class="layui-form layui-form-pane" action="">
            <div class="demoTable">
                <blockquote class="layui-elem-quote">
                    <div class="layui-inline">
                        <input class="layui-input" name="keyword" id="demoReload" placeholder="请输入昵称关键字" autocomplete="off">
                    </div>
                    <div class="layui-inline">
                        <button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search"></i>搜索</button>
                        <button type="reset" class="layui-btn">重置</button> 
                        <a lay-href="{{url('admin/news_add')}}"><button class="layui-btn">添加</button></a>
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
                , url: "{{url('admin/memberList')}}"
		,loading :true
                , cols: [[
                    { field: 'userface', title: '头像',width:"6%", sort: true,templet:"<div><img src='@{{d.userface}}' /></div>"}
                    , { field: 'nickname', title: '昵称',width:"10%", sort: true}
                    , { field: 'address', title: '地址',width:"10%", sort: true}
                    , { field: 'joinip', title: '加入IP',width:"10%", sort: true}
                    , { field: 'created_at', title: '加入时间',width:"12%",sort: true}
                    , { field: 'loginip', title: '登录IP',width:"10%", sort: true}
                    , { field: 'updated_at', title: '登录时间',width:"12%",sort: true}
                    , { field: 'prevtime', title: '上次登录时间',width:"10%", sort: true}
                    , { field: 'status', title: '状态',width:"6%",sort: true,templet:@if('@d.status==1')"<div>启用</div>" @else "<div style='color:red'>禁用</div>"  @endif}
                    , { field: 'right', title: '操作',width:"12%",toolbar: "#barDemo"}
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
                            keyword: $('#demoReload').val(),
//                            cate_id:$("[name='cate_id']").val(),
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


