@extends('layouts.master')

@section('content')
    <h1>{{$title}}</h1>
    {{Form::model($user,array('route'=>'users.updateInfo'))}}
    <h4>User Settings</h4>
    <?php $avatar = Avatar::whereId($user->avatar_id)->first();?>
    <a href="{{URL::route('avatars')}}">
        <img src="{{asset('images/avatars/'.$avatar->avatar)}}"  width='120' height='120' /></br>
        <small> Change Avatar </small>
        </a>
    </br></br>
        {{Form::label('email','Email:'),
        Form::input('text','email')}}
        {{$errors->first('email');}}
        </br>
        {{Form::label('password','Password:'),
        Form::input('password','password')}}
        {{$errors->first('password');}}
        </br>
        <h4>Personal Information</h4>
        </br>
        {{Form::label('first_name','First Name:'),
        Form::input('text','first_name')}}
        {{$errors->first('first_name');}}
        </br>
        {{Form::label('last_name','Last Name:'),
        Form::input('text','last_name')}}
        {{$errors->first('last_name');}}
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
        {{Form::label('about_me','About Me:'),
        Form::input('textarea','about_me')}}
        {{$errors->first('about_me');}}
        </br>
        <h4>Social Profiles</h4>
        </br>
        {{Form::label('website','Website:'),
        Form::input('text','website')}}
        {{$errors->first('website');}}
        </br>
        {{Form::label('skype','Skype:'),
        Form::input('text','skype')}}
        {{$errors->first('skype');}}
        </br>
        {{Form::label('twitter','Twitter:'),
        Form::input('text','twitter')}}
        {{$errors->first('twitter');}}
        </br>
        {{Form::label('facebook','Facebook:'),
        Form::input('text','facebook')}}
        {{$errors->first('facebook');}}
        </br>
        {{Form::label('linked_in','LinkedIn:'),
        Form::input('text','linked_in')}}
        {{$errors->first('linked_in');}}
        </br>
        {{Form::label('google_plus','Google Plus:'),
        Form::input('text','google_plus')}}
        {{$errors->first('google_plus');}}
        </br>
        {{Form::submit('Update Profile',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block']),
        Form::input('hidden','username',$user->username),
        Form::input('hidden','user_id',$user->id)}}
    {{Form::close()}}
@stop