@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
    <h1>List Of all Courses</h1>
    
    @foreach($courses as $course)
    <div class="alert alert-info">
        <a href="{{ route('courses.show', $course->id) }}"><h3>{{$course->name}}</h3></a>
        </br>
        {{$course->description}}
    </div>
    @endforeach
    </div>
    {{$courses->links()}}
    
    <center><a href="{{route('courses.create')}}">Add new course</a></center>
        </div>
@stop