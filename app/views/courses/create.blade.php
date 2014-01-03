@extends('layouts.master')

@section('content')
    <h1>Create New Course</h1>
    {{Form::open(array('route'=>'courses.store','class' => 'form-signin'))}}
        {{Form::label('name','Course Name:'),
        Form::input('text','name')}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('description','Description:'),
        Form::textarea('description')}}
        {{$errors->first('description');}}
        </br>
        {{Form::submit('Create Course',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
@stop