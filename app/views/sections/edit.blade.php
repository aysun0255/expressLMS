@extends('layouts.master')

@section('content')
<center>
    <h1>Edit Section</h1></center>
    {{Form::model($section,array('route'=>array('courses.sections.update',$course->id,$section->id), 'method' =>'put'))}}
        {{Form::label('name','Section Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('description','Description:'),
        Form::textarea('description',null,['class' => 'form-control'])}}
        {{$errors->first('description');}}
        </br>
        <center>
        {{Form::label('visible','Visible:'),
        Form::radio('visible', 'yes'),'Yes ',
        Form::radio('visible', 'no'),'No ';}}
        {{$errors->first('visible');}}
        </br>
        {{Form::input('hidden','course_id',$course->id)}}
        {{Form::input('hidden','section_id',$section->id)}}
        {{Form::submit('Edit Section',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center>
@stop