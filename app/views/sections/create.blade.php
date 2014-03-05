@extends('layouts.master')

@section('content')
<center>
    <h1>Add Section</h1></center>
    {{Form::open(array('route'=>array('courses.sections.store',$courseId)))}}
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
        {{Form::input('hidden','course_id',$courseId)}}
        {{Form::submit('Add Section',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center>
@stop