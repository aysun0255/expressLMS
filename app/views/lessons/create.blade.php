@extends('layouts.master')

@section('content')
<center>
    <h1>Add Lesson</h1>
    {{Form::open(array('route'=>array('courses.lessons.store',$courseId)))}}
        {{Form::label('name','Lesson Name:'),
        Form::input('text','name')}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('description','Description:'),
        Form::input('textarea','description')}}
        {{$errors->first('description');}}
        </br>
        {{Form::label('visible','Visible:'),
        Form::radio('visible', 'yes'),'Yes ',
        Form::radio('visible', 'no'),'No ';}}
        {{$errors->first('visible');}}
        </br>
        {{Form::submit('Add Lesson',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center>
@stop