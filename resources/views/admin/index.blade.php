@extends('layouts.admin')
@section('content')
  <style>
    .layui-table img {
      max-width: 100px;
      height:auto;
    }
  </style>
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect="">
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect="">
            <a href="{{url('/')}}" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect="">
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        <span class="layui-nav-bar"></span></ul>
        
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          
          <li class="layui-nav-item" lay-unselect="">
            <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
              <i class="layui-icon layui-icon-notice"></i>  
              
               <!--如果有新消息，则显示小圆点--> 
              <span class="layui-badge-dot"></span>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect="">
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect="">
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect="">
              <a lay-href="{{url('admin/info')}}" lay-text="基本资料">
                        <img class="avatar" src="{{session("user.avatar")}}">
              </a>
          </li>
          <li class="layui-nav-item" lay-unselect="">
            <a href="javascript:;">
              <cite>{{session("user.user_name")}}</cite>
            <span class="layui-nav-more"></span></a>
            <dl class="layui-nav-child">
              <dd><a lay-href="{{url('admin/info')}}">基本资料</a></dd>
              <dd><a lay-href="{{url('admin/pass')}}">修改密码</a></dd>
              <hr>
              <dd class="logout" style="text-align: center;"><a>退出</a></dd>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect="">
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect="">
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="home/console.html">
            <span>{{Site::get('webname')}}</span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="home" class="layui-nav-item">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                 <dd> <a lay-href="{{url('admin/main')}}">控制台</a></dd>
                 <dd> <a lay-href="{{url('admin/menus')}}">菜单管理</a></dd>
                 <dd> <a lay-href="{{url('admin/userList')}}">管理员</a></dd>
                 <dd> <a lay-href="{{url('admin/role')}}">角色管理</a></dd>
                 <dd> <a lay-href="{{url('admin/permission')}}">权限管理</a></dd>
                 <dd> <a lay-href="{{url('admin/visitLog')}}">访问记录</a></dd>
              </dl>
            </li>
            <li data-name="user" class="layui-nav-item">
              <a href="javascript:;" lay-tips="用户" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>用户</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd>
                  <a href="javascript:;">会员<span class="layui-nav-more"></span></a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="{{url('admin/memberList')}}" lay-tips="会员用户" lay-direction="2">个人注册</a></dd>
                  </dl>
                </dd> 
              </dl>
            </li>
            <li data-name="article" class="layui-nav-item">
              <a href="javascript:;" lay-tips="新闻" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>新闻</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/news_add')}}">资讯发布</a></dd>
                <dd><a lay-href="{{url('admin/news_list')}}">新闻资讯</a></dd>
                <dd><a lay-href="{{url('admin/news_cate')}}">分类管理</a></dd>
              </dl>
            </li>
            <li data-name="article" class="layui-nav-item">
              <a href="javascript:;" lay-tips="技术" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>技术</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/blog_add')}}">技术发布</a></dd>
                <dd><a lay-href="{{url('admin/blog_list')}}">技术博客</a></dd>
                <dd><a lay-href="{{url('admin/blog_cate')}}">分类管理</a></dd>
              </dl>
            </li>
            <li data-name="article" class="layui-nav-item">
              <a href="javascript:;" lay-tips="论坛" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>论坛</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/forum_mod')}}">论坛模块</a></dd>
                <dd><a lay-href="{{url('admin/forum_card')}}">发帖管理</a></dd>
                <dd><a lay-href="{{url('admin/forum_com')}}">回复管理</a></dd>
                <dd><a lay-href="{{url('admin/forum_black')}}">黑名单</a></dd>
              </dl>
            </li>
            <li data-name="adv" class="layui-nav-item">
              <a href="javascript:;" lay-tips="相册" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>相册</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/imageXc_list')}}">相册列表</a></dd>
                <dd><a lay-href="{{url('admin/imageXc_cate')}}">相册分类</a></dd>
              </dl>
            </li>
            <li data-name="adv" class="layui-nav-item">
              <a href="javascript:;" lay-tips="视频" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>视频</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/video_list')}}">视频列表</a></dd>
                <dd><a lay-href="{{url('admin/video_cate')}}">视频分类</a></dd>
              </dl>
            </li>
            <li data-name="adv" class="layui-nav-item">
              <a href="javascript:;" lay-tips="广告" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>广告</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/adv_list')}}">广告列表</a></dd>
                <dd><a lay-href="{{url('admin/adv_addr')}}">广告位置</a></dd>
              </dl>
            </li>
            <li data-name="content" class="layui-nav-item">
              <a href="javascript:;" lay-tips="内容" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>内容</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                  <dd><a lay-href="{{url('admin/webcontent_add')}}">内容发布</a></dd>
                  <dd><a lay-href="{{url('admin/webcontent')}}">内容管理</a></dd>
                  <dd><a lay-href="{{url('admin/webcontent_cate')}}">分类管理</a></dd> 
              </dl>
            </li>
            <li data-name="app" class="layui-nav-item">
              <a href="javascript:;" lay-tips="应用" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>应用</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd><a lay-href="{{url('admin/newscenter')}}">消息中心</a></dd>
                <dd><a lay-href="{{url('admin/links')}}">友情链接</a></dd>
              </dl>
            </li>
            <li data-name="set" class="layui-nav-item">
              <a href="javascript:;" lay-tips="设置" lay-direction="2">
                <i class="layui-icon layui-icon-set"></i>
                <cite>设置</cite>
              <span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child">
                <dd>
                  <a href="javascript:;">系统设置<span class="layui-nav-more"></span></a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="set/system/website.html">菜单设置</a></dd>
                    <dd><a lay-href="{{url('admin/webconfig')}}">网站设置</a></dd>
                  </dl>
                </dd>
                <dd>
                  <a href="javascript:;">我的设置<span class="layui-nav-more"></span></a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="{{url('admin/info')}}">基本资料</a></dd>
                    <dd><a lay-href="{{url('admin/pass')}}">修改密码</a></dd>
                  </dl>
                </dd>
              </dl>
            </li>
          <span class="layui-nav-bar"></span></ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect="">
              <a href="javascript:;"><span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          <span class="layui-nav-bar"></span></ul>
        </div>
        <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="{{url('admin/main')}}" class="layui-this"><i class="layui-icon layui-icon-home"></i><i class="layui-icon layui-unselect layui-tab-close">ဆ</i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="{{url('admin/main')}}" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>
<script>
layui.use(['element','jquery'], function(){
  var element = layui.element,$ = layui.$;
  $(".logout").click(function(){
      layer.confirm('您确定要退出吗？', {
        btn: ['确定','再想想'] //按钮
      }, function(){
        var index = layer.load(1);
            $.ajax({
              type: "GET",
              url: "{{url('admin/logout')}}",
              dataType: 'json',
              cache: false,
              data: {_tocken:"{{ csrf_token() }}"},
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              },
              success:function(s){
                layer.close(index);
                if(s.code==1){
                    tips(s.msg,2000,1,"{{url('admin/login')}}");
                }else{
                    tips(s.msg,2000);
                }  
              }
            })
            return false;
      });
    }); 
})

</script>
@endsection


