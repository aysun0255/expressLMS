@extends('layouts.master')

@section('content')
<?php

?><div class="well">
<center>
    <h1>Add Content</h1></center>
    {{Form::open(array('route'=>array('content.addToDB',$courseId,$sectionId)))}}
        {{Form::label('title','Unit Name:'),
        Form::input('text','title',null,['class' => 'form-control'])}}
        {{$errors->first('title');}}
        </br>
        {{Form::label('content','Content:'),
        Form::textarea('content',null,['class' => 'form-control tinyMCE'])}}
        {{$errors->first('content');}}
             
        </br>
        {{Form::input('hidden','section_id',$sectionId)}}
        {{Form::submit('Add Content',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop