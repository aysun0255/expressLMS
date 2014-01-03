@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
        <center> 
            {{Form::open(array('route' => array('courses.enrol', $course->id),'method'=>'post','style' =>'display:inline;'))}}
                @if($course->use_key == 'yes')
                    {{Form::label('key','Enrolment key:'),Form::input('text','key')}}
                @endif
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Enrol me in this course ',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
            {{Form::close()}} 
        </center>
    </div>
</div>
@stop
