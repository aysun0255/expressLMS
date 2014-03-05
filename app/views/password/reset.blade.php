@extends('layouts.master')

@section('content')
    <center><h1>Set Your New Password</h1></center>

    {{ Form::open() }}
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            {{ Form::label('email', 'Email Address:') }}
            {{ Form::email('email',null,['class' =>'form-control']) }}
        </div>

        <div>
            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password',['class' =>'form-control']) }}
        </div>

        <div>
            {{ Form::label('password_confirmation', 'Password Confirmation:') }}
            {{ Form::password('password_confirmation',['class' =>'form-control']) }}
        </div>
        </br>
        <div>
            {{ Form::submit('Submit',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block']) }}
        </div>
    </form>

    @if (Session::has('error'))
        <p style="color: red;">{{ Session::get('error') }}</p>
    @endif
@stop