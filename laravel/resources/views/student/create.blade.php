@extends('common.layouts')
@section('content')
    @include('common.validator')
<!-- 自定义内容区域 -->
<div class="panel panel-default">
    <div class="panel-heading">新增学生</div>
    <div class="panel-body">
        @include('student._form')
    </div>
</div>
@stop