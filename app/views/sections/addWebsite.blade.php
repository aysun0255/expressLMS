@extends('layouts.master')

@section('content')
<?php

?><div class="well">
<center>
    <h1>Add Web Content</h1></center>
    {{Form::open(array('route'=>array('website.addDBEntry',$courseId,$sectionId)))}}
        {{Form::label('title','Unit Name:'),
        Form::input('text','title',null,['class' => 'form-control'])}}
        {{$errors->first('title');}}
        </br>
        {{Form::label('link','Web address (URL):'),
        Form::input('text','link',null,['class' => 'form-control'])}}
        {{$errors->first('link');}}
        </br>
        {{Form::input('hidden','section_id',$sectionId)}}
        {{Form::submit('Add Web Content',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop