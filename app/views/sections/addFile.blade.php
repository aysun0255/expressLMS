@extends('layouts.master')

@section('content')

<div class="well">
        <h2>Add File</h2>

        {{Form::open(array('route'=>array('sections.addFileDBEntry',$courseId,$sectionId)))}}
        {{Form::label('name','Unit Name:'),
        Form::input('text','title',null,['class' => 'form-control'])}}
        {{$errors->first('title');}}
        </br>
        {{Form::label('description','Description:'),
        Form::textarea('description',null,['class' => 'form-control'])}}
        {{$errors->first('description');}}
        </br>
        {{Form::label('file','File:'),
        Form::select('file',array('not' => 'Select document from your course files',Files::lists('filename', 'id')),null,['class' => 'form-control'])}}
        {{$errors->first('file');}}
        </br>
        </br>
        {{Form::submit('Add File',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
        {{Form::close()}}
</div>
        @stop
