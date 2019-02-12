@extends('layouts.base')
@section('content')
<!-- <div class="layui-col-md10"> -->
<div class="layui-fluid" id="LAY-app-message">
    <div class="layui-card">
        {!! discuzcode(@nl2br($forumRep->content)) !!}
            
    </div>


</div>

@endsection


