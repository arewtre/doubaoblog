@extends('layouts.wap')
@section('content')
<header class="header">
    <a href="javascript:history.go(-1);" class="goBack fl">返回</a>
    <h1>选择您要发帖的板块</h1>
</header>
<div class="forumSelect cfix">
    <ul>
       @foreach($mod as $v)
        <li><a href="{{url('wap/sendForum?id='.$v->id)}}">{{$v->defectsname}}</a></li>
        @endforeach
    </ul>
</div>
   @include('layouts/footer') 
@endsection