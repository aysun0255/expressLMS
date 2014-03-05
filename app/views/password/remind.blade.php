@extends('layouts.master')

@section('content')
    <center><h1>Need to reset your password?</h1></center>

    {{ Form::open() }}
        <div>
            {{ Form::label('email', 'Email Address:') }}
            {{ Form::email('email',null,['class'=>'form-control']) }}
        </div>
    </br>
        <div>
            {{ Form::submit('Reset',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block']) }}
        </div>
    {{ Form::close() }}

    @if (Session::has('error'))
        <p style="color: red;">{{ Session::get('error') }}</p>
    @elseif (Session::has('status'))
        <p>{{ Session::get('status') }}</p>
    @endif
@stop

