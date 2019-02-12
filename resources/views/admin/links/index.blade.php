@extends('layouts.base')
@section('content')
 <div style="margin: 15px;">
    <blockquote class="layui-elem-quote">
        <div class="layui-btn layui-btn-small add">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;添加友链
        </div>
    </blockquote>
        <div class="table-responsive">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th width="8%">排序</th>
                    <th>链接名称</th>
                    <th>链接URL</th>
                    <th>状态(点击切换)</th>
                    <th>操作</th>
                </tr>
                </thead>
                <!--内容容器-->
                <tbody id="con">
                 @foreach($data as $k=>$v)
                <tr class="a_{{$v->link_id}}">
                    <td><input type="text" class="layui-input" onchange="changeOrder(this,{{$v->link_id}})" value="{{$v->link_sort}}"></td>
                    <td>{{$v->link_name}}</td>
                    <td><a href="{$v.link_url}" target="_blank">{{$v->link_url}}</a></td>             
                    <td>
                        @if($v->status==1)
                        <a class="red" href="javascript:;" onclick="return stateyes('{{$v->link_id}}');" >
                            <div id="zt{{$v->link_id}}">
                                <button class="layui-btn layui-btn-warm layui-btn-mini">状态开启</button>
                            </div>
                        </a>
                        @else
                        <a class="red" href="javascript:;" onclick="return stateyes('{{$v->link_id}}');" >
                            <div id="zt{{$v->link_id}}">
                                <button class="layui-btn layui-btn-danger layui-btn-mini">状态禁用</button>
                            </div>
                        </a>
                        @endif
                    </td>
                    <td>
                        <span data-url="{{url('admin/links/'.$v->link_id.'/edit')}}" class="layui-btn layui-btn-mini edit">编辑</span>
                        <span onclick="return delLinks('{{$v->link_id}}')" class="layui-btn layui-btn-mini layui-btn-danger">删除</span>
                    </td>
                </tr>
                 @endforeach
                </tbody>
            </table>
            <div id="page"></div>
        </div>
</div>
<script>
    layui.use(['form', 'layer','laypage'], function() {
        var form = layui.form, layer = layui.layer;
    	laypage = layui.laypage;//分页
        //以上模块根据需要引入          
         
          //完整功能
            laypage.render({
              elem: 'page'
              ,count: {{$count}}
              ,skip: true
              ,limit:{{$limit}}
              ,curr: {{$page}} 
              ,jump: function(obj,first){
                if(!first){   
                      window.location.href = "/admin/links?page="+ obj.curr ;
                  }  
              }
            });
    });
        //删除友情链接
    function delLinks(link_id) {
        layer.confirm('您确定要删除这个链接吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/links/')}}/"+link_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status==0){
                    //location.href = location.href;
                    $(".a_"+link_id).remove();
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
//            layer.msg('的确很重要', {icon: 1});
        }, function(){

        });
    }
    function stateyes(id) {
        $.post("{{url('admin/links/changestatus')}}", {id: id}, function (data) {
            if (data.status==0) {
                if (data.info == 0) {
                    var a = '<button class="layui-btn layui-btn-danger layui-btn-mini">状态禁用</button>'
                    $('#zt' + id).html(a);
                    layer.msg(data.msg, {icon: 5});
                    return false;
                } else {
                    var b = '<button class="layui-btn layui-btn-warm layui-btn-mini">状态开启</button>'
                    $('#zt' + id).html(b);
                    layer.msg(data.msg, {icon: 6});
                    return false;
                }
            }
        });
        return false;
    }
    
    $('.add').on('click', function () {
        layer.open({
            type: 2,
            area: ['60%', '60%'],
            maxmin: true,
            content: "{{url('admin/links/create')}}",
        });
    });
    
    $('.edit').on('click', function () {
        var url = $(this).attr("data-url");
        layer.open({
            type: 2,
            area: ['60%', '60%'],
            maxmin: true,
            content: url,
        });
    }); 


    function changeOrder(obj,link_id){
        var link_order = $(obj).val();
        $.post("{{url('admin/links/changeorder')}}",{'_token':'{{csrf_token()}}','link_id':link_id,'link_sort':link_order},function(data){
            if(data.status == 0){
                layer.msg(data.msg, {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
        });
    }

</script>

@endsection
