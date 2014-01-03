@extends('layouts.master')

@section('content')
    <h1>Create New User</h1>
    {{Form::open(array('route'=>'users.store','class' => 'form-signin'))}}
        {{Form::label('username','Username:'),
        Form::input('text','username')}}
        {{$errors->first('username');}}
        </br>
        {{Form::label('password','Password:'),
        Form::input('password','password')}}
        {{$errors->first('password');}}
        </br>
        {{Form::label('password_confirmation','Repeat Password:'),
        Form::input('password','password_confirmation')}}
        {{$errors->first('password_confirmation');}}
        </br>
        {{Form::label('email','Email:'),
        Form::input('text','email')}}
        {{$errors->first('email');}}
        </br>
        {{Form::label('email_confirmation','Repeat Email:'),
        Form::input('text','email_confirmation')}}
        {{$errors->first('email_confirmation');}}
        </br>
        {{Form::label('first_name','First Name:'),
        Form::input('text','first_name')}}
        {{$errors->first('first_name');}}
        </br>
        {{Form::label('last_name','Last Name:'),
        Form::input('text','last_name')}}
        {{$errors->first('last_name');}}
        </br>
        {{Form::label('secret_question','Secret Question:'),
        Form::input('text','secret_question')}}
        {{$errors->first('secret_question');}}
        </br>
        {{Form::label('secret_answer','Secret Answer:'),
        Form::input('text','secret_answer')}}
        {{$errors->first('secret_answer');}}
        </br>
        {{Form::label('gender','Gender:'),
        Form::radio('gender', 'male'),'Male ',
        Form::radio('gender', 'female'),'Female ';}}
        {{$errors->first('gender');}}
        </br>
         {{Form::label('birthday','Birth date:'),
        Form::input('text','birthday',null,['class' => 'input-append date'])}}
        {{$errors->first('birthday');}}
             <script type="text/javascript">
$(function() {
  $("#birthday").datepicker({format:'yyyy-mm-dd'});
});
</script>
        </br>
        {{Form::submit('Create User',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
@stop