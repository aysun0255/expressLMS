@extends('layouts.master')

@section('content')
<div class="well">
    <h3>{{$course->name}}</h3>
    </br>
    <div class="right">
        <a href ="{{route('courses.sections.create', $course->id)}}">Add lesson</a>
        <a href ="{{route('courses.edit', $course->id)}}" class ="btn btn-info">Edit course</a>
        <?php
        $usergroupId = Auth::user()->usergroup_id;
        $usergroup = Usergroup::whereId($usergroupId)->first();
        $canDeleteCourses = $usergroup->can_delete_courses;
        $canEditCourses = $usergroup->can_edit_courses;
        $canDeleteSections = $usergroup->can_delete_sections;
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
    <?php
    $sections = $course->sections;
    ?>

    @foreach($sections as $section)
    </br>
    <div class="coursebox">
        <div class="right">
            <a href ="#">Add file</a>
            <a href ="#">Add homework</a>
            <a href ="#">Add test</a>
            <a href ="#">Add url</a>
            @if($canDeleteSections =='yes')
                {{Form::open(array('route' => array('courses.sections.destroy',$course->id,$section->id),'method'=>'delete','style' =>'display:inline;'))}}
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                {{Form::close()}} 
            @endif
        </div>
        {{$section->name}}
    </div>
    @endforeach
</div>
@stop