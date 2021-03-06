@extends('layouts.master')

@section('content')
<div class="well">
    <h1>List Of all Courses</h1>

    @foreach($courses as $course)
    <div class="offer offer-default">
        <div class="shape">
            <div class="shape-text"> course </div>
        </div>
        <div class="offer-content">
            <h3 class="lead"> <a href="{{ route('courses.show', $course->id) }}">{{$course->name}}</a></h3>

            <div class="right">
                {{$course->description}}

            </div>

            </br>

        </div></div>
    @endforeach

    {{$courses->links()}}

    <?php
    $usergroupId = Auth::user()->usergroup_id;
    $usergroup = Usergroup::whereId($usergroupId)->first();
    $canCreateCourses = $usergroup->can_create_course;
    ?>
    @if($canCreateCourses == 'yes')
    <center><a href="{{route('courses.create')}}">Add new course</a></center>
    @endif
</div>
@stop