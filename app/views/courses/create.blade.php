@extends('layouts.master')

@section('content')
    <h1>Create New Course</h1>
    {{Form::open(array('route'=>'courses.store'))}}
        {{Form::label('name','Course Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('description','Description:'),
        Form::textarea('description',null,['class' => 'form-control'])}}
        {{$errors->first('description');}}
        </br>
        {{Form::label('category','Category:'),
        Form::select('category',array('not' => 'Not Selected',CourseCategory::lists('name', 'id')),['class' => 'form-control'])}}
        {{$errors->first('category');}}
        </br>
        {{Form::label('allow_guest_access','Allow guest access:'),
        Form::radio('allow_guest_access', 'yes'),'Yes ',
        Form::radio('allow_guest_access', 'no'),'No ';}}
        {{$errors->first('allow_guest_access');}}
        </br>
        {{Form::label('use_key','Use key:'),
        Form::radio('use_key', 'yes'),'Yes ',
        Form::radio('use_key', 'no'),'No ';}}
        {{$errors->first('use_key');}}
        </br>
        {{Form::label('enrolment_key','Enrolment key:'),
        Form::text('enrolment_key',null,['class' => 'form-control'])}}
        {{$errors->first('enrolment_key');}}
        </br>
        {{Form::submit('Create Course',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
@stop