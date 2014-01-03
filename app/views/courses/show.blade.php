@extends('layouts.master')

@section('content')
<div class="well">
    <h3>{{$course->name}}</h3>
    </br>
    <div class="right">
        <a href ="#">Add lesson</a>
        <a href ="{{route('courses.edit', $course->id)}}" class ="btn btn-info">Edit course</a>
        <?php
            $usergroupId = Auth::user()->usergroup_id;
            $usergroup = Usergroup::whereId($usergroupId)->first();
            $canDeleteCourses = $usergroup->can_delete_courses;
            $canEditCourses = $usergroup->can_edit_courses;
            ?>
            @if($canEditCourses =='yes')
            @endif
            @if($canDeleteCourses =='yes')

                {{Form::open(array('route' => array('courses.destroy', $course->id),'method'=>'delete','style' =>'display:inline;'))}}
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                {{Form::close()}} 
            @endif
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
        <a href ="#">Add url</a>
        <a href ="#">Delete</a>
    </div>
    {{$lesson->name}}
    </div>
    @endforeach
</div>
@stop