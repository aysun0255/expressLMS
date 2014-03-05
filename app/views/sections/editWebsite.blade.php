@extends('layouts.master')

@section('content')
<?php

?><div class="well">
<center>
    <h1>Edit Web Content</h1></center>
    {{Form::model($website,array('route'=>array('website.editDBEntry',$courseId,$sectionId,$websiteId),'method' =>'post'))}}
        {{Form::label('title','Unit Name:'),
        Form::input('text','title',null,['class' => 'form-control'])}}
        {{$errors->first('title');}}
        </br>
        {{Form::label('link','Web address (URL):'),
        Form::input('text','link',null,['class' => 'form-control'])}}
        {{$errors->first('link');}}
        </br>
        {{Form::input('hidden','section_id',$sectionId)}}
        {{Form::submit('Edit Web Content',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop