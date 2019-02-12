@extends('layouts.base')
@section('content')
<style>
    body {
    background: #f2f2f2;
    color: #333;
    font-size: 14px;
    font-family: "Microsoft Yahei", 'Simsun', "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;
}
.layui-table-cell {
    height: 40px;
    line-height: 28px;
    padding: 0 15px;
    position: relative;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    box-sizing: border-box;
}
.slt img{width:40px}
.layui-table img {
    max-width: 66px;
}
.laytable-cell-1-art_thumb,.laytable-cell-2-userface {
    width: 140px !important;
}
</style>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/news_list')}}">
                          <i class="layui-icon layui-icon-website"></i>
                          <cite>新闻</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/blog_list')}}">
                          <i class="layui-icon layui-icon-find-fill"></i>
                          <cite>技术</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/forum_card')}}">
                          <i class="layui-icon layui-icon-loading-2"></i>
                          <cite>论坛</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/imageXc_list')}}">
                          <i class="layui-icon layui-icon-chat"></i>
                          <cite>相册</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/video_list')}}">
                          <i class="layui-icon layui-icon-read"></i>
                          <cite>视频</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/adv_list')}}">
                          <i class="layui-icon layui-icon-tree"></i>
                          <cite>广告</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/webcontent')}}">
                          <i class="layui-icon layui-icon-set"></i>
                          <cite>内容</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/webconfig')}}">
                          <i class="layui-icon layui-icon-password"></i>
                          <cite>设置</cite>
                        </a>
                      </li>
                    </ul>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/newscenter')}}">
                          <i class="layui-icon layui-icon-set"></i>
                          <cite>消息</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/info')}}">
                          <i class="layui-icon layui-icon-set"></i>
                          <cite>基本资料</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="{{url('admin/pass')}}">
                          <i class="layui-icon layui-icon-set"></i>
                          <cite>修改密码</cite>
                        </a>
                      </li>
                    </ul>
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">待办事项</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/forum_card')}}?day=today" class="layadmin-backlog-body">
                          <h3>今日发帖</h3>
                          <p><cite>{{getTodayNum(1)}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/forum_com')}}?day=today" class="layadmin-backlog-body">
                          <h3>今日回帖</h3>
                          <p><cite>{{getTodayNum(4)}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/news_list')}}?day=today" class="layadmin-backlog-body">
                          <h3>今日新闻</h3>
                          <p><cite>{{getTodayNum(2)}}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="{{url('admin/blog_list')}}?day=today" class="layadmin-backlog-body">
                          <h3>今日博客</h3>
                          <p><cite>{{getTodayNum(3)}}</cite></p>
                        </a>
                      </li>
                    </ul>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="javascript:;" class="layadmin-backlog-body">
                          <h3>待回复</h3>
                          <p><cite style="color: #FF5722;">5</cite></p>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">数据概览</div>
              <div class="layui-card-body">
                <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">
                  <div carousel-item id="LAY-index-dataview">
                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                    <div></div>
                    <div></div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="layui-card">
              <div class="layui-tab layui-tab-brief layadmin-latestData">
                <ul class="layui-tab-title">
                  <li class="layui-this">热门搜索</li>
                  <li>新增会员</li>
                </ul>
                <div class="layui-tab-content">
                  <div class="layui-tab-item layui-show">
                    <table id="LAY-index-topSearch"></table>
                  </div>
                  <div class="layui-tab-item">
                    <table id="LAY-index-topCard"></table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">版本信息</div>
          <div class="layui-card-body layui-text">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>当前版本</td>
                  <td>
                    <script type="text/html" template>
                      V1.0.0                      
                    </script>
                  </td>
                </tr>
                <tr>
                  <td>基于框架</td>
                  <td>
                    <script type="text/html" template>
                      laravel+layui-v2.2.6
                    </script>
                 </td>
                </tr>
                <tr>
                  <td>主要特色</td>
                  <td>响应式 / 清爽 / 极简</td>
                </tr>
                <tr>
                  <td>快捷操作</td>
                  <td style="padding-bottom: 0;">
                    <div class="layui-btn-container">
                      <a lay-href="{{url('admin/news_add')}}" class="layui-btn">发布资讯</a>
                      <a href="javascript:;" class="layui-btn layui-btn-danger">更新缓存</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
{{--      <div class="layui-card">
          <div class="layui-card-header">效果报告</div>
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes">
              <h3>转化率（日同比 28% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="65%"></div>
            </div>
            <div class="layui-progress" lay-showPercent="yes">
              <h3>签到率（日同比 11% <span class="layui-edge layui-edge-bottom" lay-tips="下降" lay-offset="-15"></span>）</h3>
              <div class="layui-progress-bar" lay-percent="32%"></div>
            </div>
          </div>
        </div>
        
        <div class="layui-card">{
          <div class="layui-card-header">实时监控</div>{
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes">
              <h3>CPU使用率</h3>
              <div class="layui-progress-bar" lay-percent="{{$cpu_usage}}"></div>
            </div>
            <div class="layui-progress" lay-showPercent="yes">
              <h3>内存占用率</h3>
              <div class="layui-progress-bar layui-bg-red" lay-percent="{{$mem_usage}}"></div>
            </div>
          </div>
        </div>--}}
        
        <div class="layui-card">
          <div class="layui-card-header">网站动态</div>
          <div class="layui-card-body">
            <div class="layui-carousel layadmin-carousel layadmin-news" data-autoplay="true" data-anim="fade" lay-filter="news">
              <div carousel-item>
                <div><a href="javascript:;" onclick="layer.msg('等待添加')" target="_blank" class="layui-bg-green">豆宝网官方网站</a></div> 
                <div><a href="javascript:;" onclick="layer.msg('等待添加')" target="_blank" class="layui-bg-blue">豆宝网系统正式发布</a></div>
              </div>
            </div>
          </div>
        </div>

        <div class="layui-card">
          <div class="layui-card-header">
                作者心语
            <i class="layui-icon layui-icon-tips" lay-tips="要支持的噢" lay-offset="5"></i>
          </div>
          <div class="layui-card-body layui-text layadmin-text">
            <p>初步功能开发完成,后面将不断完善,感谢支持!</p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
<script></script>
@endsection


