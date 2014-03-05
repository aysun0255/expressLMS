@extends('layouts.master')

@section('content')
<div class="well">
<center>
    <h1>Add Category</h1></center>
    {{Form::open(array('route'=>'admincp.categories.store'))}}
        {{Form::label('name','Category Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
        </br>
        {{Form::submit('Add Category',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop