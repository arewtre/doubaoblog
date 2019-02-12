@extends('layouts.home')
@section('content')


  
<script>
layui.use('layim', function(layim){
  //先来个客服模式压压精
  layim.config({
    brief: true //是否简约模式（如果true则不显示主面板）
  }).chat({
    name: '强哥客服'
    ,type: 'friend'
    ,avatar: "{{session('userinfo.userface')}}"
    ,id: -2
  });
});
</script>
@endsection