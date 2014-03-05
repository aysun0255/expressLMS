@extends('layouts.master')

@section('content')
    {{Form::open(array('class' => 'form-signin'))}}
        {{Form::label('username',Lang::get('login.username')),
                Form::input('text','username',null,['class'=>'form-control'])}}
                </br>
                {{Form::label('password',Lang::get('login.password')),
                Form::input('password','password',null,['class'=>'form-control'])}}
                </br>
                {{Form::checkbox('remember','remember_me'),
                Form::label('remember',Lang::get('login.rememberme'))}}
                </br>
                {{$errors->first('error')}}
                </br>
                {{Form::submit(Lang::get('login.login'),['class' => 'btn btn-lg btn-primary btn-block'])}}
                </br>
                {{Lang::get('login.forget')}}
    {{Form::close()}}
@stop