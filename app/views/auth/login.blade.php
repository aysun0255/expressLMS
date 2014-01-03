@extends('layouts.master')

@section('content')
    {{Form::open(array('class' => 'form-signin'))}}
        {{Form::label('username','Username:'),
                Form::input('text','username',null,['class'=>'form-control'])}}
                </br>
                {{Form::label('password','Password:'),
                Form::input('password','password',null,['class'=>'form-control'])}}
                </br>
                {{Form::checkbox('remember','remember_me'),
                Form::label('remember','Remember me')}}
                </br>
                {{$errors->first('error')}}
                </br>
                {{Form::submit('Login',['class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
@stop