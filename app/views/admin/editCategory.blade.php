@extends('layouts.master')

@section('content')
<div class="well">
<center>
    <h1>Edit Category</h1></center>
    {{Form::model($category,array('route'=>array('admincp.categories.editDBEntry',$category->id), 'method' =>'post'))}}
        {{Form::label('name','Category Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
        </br>
        {{Form::submit('Edit Category',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop