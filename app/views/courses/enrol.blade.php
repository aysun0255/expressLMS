@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
        <center> 
            @if($course->allow_self_enrolment == 'yes')
            {{Form::open(array('route' => array('courses.enrol', $course->id),'method'=>'post','style' =>'display:inline;'))}}
                @if($course->use_key == 'yes')
                    {{Form::label('enrolment_key','Enrolment key:'),Form::input('text','enrolment_key')}}
                     {{$errors->first();}}
                    </br>
                @endif
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Enrol me in this course ',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
            {{Form::close()}} 
            @else
            You can not enrol yourself in this course.
            </br>
            <a href="{{route('home')}}">Continue</a>
            @endif
        </center>
    </div>
</div>
@stop
