@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
  <form class="layui-form layui-form-pane" action="">
  <div class="demoTable">
        <blockquote class="layui-elem-quote">
<!--            <div class="layui-inline">
            <input class="layui-input" name="keyword" id="demoReload" autocomplete="off">
            </div>
            <div class="layui-inline" style="margin-top:5px"> 
                <label class="layui-form-label">会员名</label> 
                <div class="layui-input-inline"> 
                 <input class="layui-input" name="username" id="username" autocomplete="off">
                </div>  
             </div>
            <div class="layui-inline">
                    <button lay-filter="search" class="layui-btn search" data-type="reload" lay-submit><i class="fa fa-search" aria-hidden="true"></i>搜索</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a href="{{url('ajaxGetNews/1')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>导出</button></a>
            </div>-->
            <a lay-href="{{url('admin/webcontent_add')}}" ><button type="button" class="layui-btn layui-btn-primary"><i class="fa fa-cloud-download"></i>添加内容</button></a>
            </blockquote>
        </div>
    </form>
    <table class="layui-hide" id="LAY_table_user" lay-filter="useruv"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  	<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
		function Format(datetime,fmt) {
		    if (parseInt(datetime)==datetime) {
		      if (datetime.length==10) {
		        datetime=parseInt(datetime)*1000;
		      } else if(datetime.length==13) {
		        datetime=parseInt(datetime);
		      }
		    }
		    datetime=new Date(datetime);
		    var o = {
		    "M+" : datetime.getMonth()+1,                 //月份   
		    "d+" : datetime.getDate(),                    //日   
		    "h+" : datetime.getHours(),                   //小时   
		    "m+" : datetime.getMinutes(),                 //分   
		    "s+" : datetime.getSeconds(),                 //秒   
		    "q+" : Math.floor((datetime.getMonth()+3)/3), //季度   
		    "S"  : datetime.getMilliseconds()             //毫秒   
		    };   
		    if(/(y+)/.test(fmt))   
		    fmt=fmt.replace(RegExp.$1, (datetime.getFullYear()+"").substr(4 - RegExp.$1.length));   
		    for(var k in o)   
		    if(new RegExp("("+ k +")").test(fmt))   
		    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
		    return fmt;
		  }
		
		$.fn.stringifyArray = function(array) {
	        return JSON.stringify(array)
	    }

	    $.fn.parseArray = function(array) {
	        return JSON.parse(array)
	    }
	      
	</script>
    <script>
        layui.use(['table','form','laydate'], function () {
            var table = layui.table,form=layui.form,laydate=layui.laydate;
            laydate.render({
              elem: '#daterange'
              ,range: true
              ,range: '~'
            });
          
            laydate.render({
                elem: '#logintime'
                ,range: true
                ,range: '~'
              });
            form.render();
            table.render({
                elem: '#LAY_table_user'
                , url: "{{url('admin/ajaxGetWebContent')}}"
//                 ,cellMinWidth: 120
				,loading :true
// 				,initSort: {
// 				    field: 'logintime' 
// 				        ,type: 'desc' 
// 				      }
                , cols: [[
                    { fixed: 'left',checkbox:true,width:"4%",}
                    , { field: 'img', title: '缩略图',width:"15%", sort: true,templet:"<div><img src='@{{d.img}}' /></div>"}
                    , { field: 'title', title: '标题',width:"10%", sort: true}
                    , { field: 'sign', title: '标签',width:"10%", sort: true}
                    , { field: 'created_at', title: '发布时间',width:"15%",sort: true}
                    , { field: 'editorvalue', title: '内容',width:"30%", sort: true}
                    , { fixed: 'right', title: '操作',width:"16%",toolbar: "#barDemo" }
                ]]
                , id: 'testReload'
                , page: true
                , limit:30
                , height: 700
                ,done: function(res, curr, count){
                    //console.log(res);
                    Format("1523717984","yyyy-MM-dd hh:mm:ss");
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
                    layer.confirm('您确定要删除该内容么', function (index) {
                        console.log(data);
                        $.ajax({
                            url: "{{url('admin/webcontent_del')}}",
                            type: "POST",
                            data: { id: data.id },
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
                	layer.open({
			title: "编辑内容",
                        type: 2,
                        area: ['80%', '80%'],
                        maxmin: true,
                        content: "/admin/webcontent_edit?id="+ data.id,
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
            
            $(document).on("click", ".layui-table-body table.layui-table tbody tr", function () {
            	var obj = event ? event.target : event.srcElement;
            	var tag = obj.tagName;
            	var index = $(this).attr('data-index');
            	var tableBox = $(this).parents(".layui-table-box");
            	//存在固定列
            	if (tableBox.find('.layui-table-fixed.layui-table-fixed-l').length > 0) {
            		tableDiv = tableBox.find('.layui-table-fixed.layui-table-fixed-l');
            	} else {
            		tableDiv = tableBox.find('.layui-table-body.layui-table-main');
            	}
            	var checkCell = tableDiv.find('tr[data-index=' + index + ']').find("td div.laytable-cell-checkbox div.layui-form-checkbox I");
            	if (checkCell.length > 0) {
	            	//if(tag == 'DIV') {
	            	checkCell.click();
	            	//}
	            }
           	});

           	$(document).on("click", "td div.laytable-cell-checkbox div.layui-form-checkbox", function (e) {
           		e.stopPropagation();
           	});
           	
           	$(".sendSms").click(function(){
           		$.ajax({
           			url:"{:U('Crm/sendSms')}",
           			data:{},
           			dataType:"json",
           			function(res){
            	        if(res.code > 0){
            	            layer.msg(res.msg,{time:1800},function(){
            	            });
            	        }else{
            	            layer.msg(res.msg,{time:1800});
            	        }
            	    }
           			
           		})
           		
           	})
           	
           	$(".sendEmail").click(function(){
           		$.ajax({
           			url:"{{url('Crm/sendEmail')}}",
           			data:{},
           			dataType:"json",
           			function(res){
            	        if(res.code > 0){
            	            layer.msg(res.msg,{time:1800},function(){
            	            });
            	        }else{
            	            layer.msg(res.msg,{time:1800});
            	        }
            	    }
           			
           		})
           		
           	})
           	
        });
    </script>
    </div>
  </div>

@endsection


