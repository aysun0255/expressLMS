@extends('layouts.master')

@section('content')
    <h1>Edit Course</h1>
    {{Form::model($course,array('route'=>array('courses.update',$course->id), 'method' =>'put'))}}
        {{Form::label('name','Course Name:'),
        Form::input('text','name')}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('description','Description:'),
        Form::textarea('description')}}
        {{$errors->first('description');}}
        </br>
        {{Form::label('category','Category:'),
        Form::select('category',array('not' => 'Not Selected',CourseCategory::lists('name', 'id')))}}
        {{$errors->first('category');}}
        </br>
        {{Form::submit('Edit Course',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
@stop