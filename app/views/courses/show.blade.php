@extends('layouts.master')

@section('content')
<div class="well">
    <h3>{{$course->name}}</h3>
    </br>
    <div class="right">
        <a href ="#">Add lesson</a>
    </div>
    {{$course->description}}
    </br>
    <?php $lessons = $course->lessons; ?>
    @foreach($lessons as $lesson)
    </br>
    <div class="coursebox">
           <div class="right">
        <a href ="#">Add file</a>
        <a href ="#">Add homework</a>
        <a href ="#">Add test</a>
    </div>
    {{$lesson->name}}
    </div>
    @endforeach
</div>
@stop