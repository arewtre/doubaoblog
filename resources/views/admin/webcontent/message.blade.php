@extends('layouts.base')
@section('content')
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
      <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
          <li class="layui-this">全部消息</li>
          <li>通知<span class="layui-badge">6</span></li>
          <li>私信</li>
        </ul>
        <div class="layui-tab-content">
        
          <div class="layui-tab-item layui-show">
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="all" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-all" lay-filter="LAY-app-message-all"></table>
          </div>
          <div class="layui-tab-item">
          
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="notice" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-notice" lay-filter="LAY-app-message-notice"></table>
          </div>
          <div class="layui-tab-item">
          
            <div class="LAY-app-message-btns" style="margin-bottom: 10px;">
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="direct" data-events="del">删除</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="direct" data-events="ready">标记已读</button>
              <button class="layui-btn layui-btn-primary layui-btn-sm" data-type="direct" data-events="readyAll">全部已读</button>
            </div>
            
            <table id="LAY-app-message-direct" lay-filter="LAY-app-message-direct"></table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


