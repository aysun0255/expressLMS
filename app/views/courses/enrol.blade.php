@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
        <center> 
            {{Form::open(array('route' => array('courses.enrol', $course->id),'method'=>'post','style' =>'display:inline;'))}}
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Enrol me in this course ',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
            {{Form::close()}} 
        </center>
    </div>
</div>
@stop
