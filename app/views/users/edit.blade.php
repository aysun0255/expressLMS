@extends('layouts.master')

@section('content')
<center><h1>{{$title}}</h1></center>
{{Form::model($user,array('route'=>'users.updateInfo'))}}

    <div class="col-xs-6" style="border:1px solid;">
        <center>
            <h4>User Settings</h4>
            <?php $avatar = Avatar::whereId($user->avatar_id)->first(); ?>
            <a href="{{URL::route('avatars')}}">
                <img src="{{asset('images/avatars/'.$avatar->avatar)}}"  width='120' height='120' /></br>
                <small> Change Avatar </small>
            </a>
            </br></br>
            {{Form::label('email','Email:'),
            Form::input('text','email',null,['class' => 'form-control'])}}
            {{$errors->first('email');}}
            </br>
            {{Form::label('password','Password:'),
            Form::input('password','password',null,['class' => 'form-control'])}}
            {{$errors->first('password');}}
            </br>
        </center>
    </div>
    <div class="col-xs-6" style="border:1px solid;">
        <center>
            <h4>Personal Information</h4>
            </br>
            {{Form::label('first_name','First Name:'),
            Form::input('text','first_name',null,['class' => 'form-control'])}}
            {{$errors->first('first_name');}}
            </br>
            {{Form::label('last_name','Last Name:'),
            Form::input('text','last_name',null,['class' => 'form-control'])}}
            {{$errors->first('last_name');}}
            </br>
            {{Form::label('gender','Gender:'),
            Form::radio('gender', 'male'),'Male ',
            Form::radio('gender', 'female'),'Female ';}}
            {{$errors->first('gender');}}
            </br>
            {{Form::label('birthday','Birth date:'),
            Form::input('text','birthday',null,['class' => 'input-append date form-control'])}}
            {{$errors->first('birthday');}}
            <script type="text/javascript">
                $(function() {
                    $("#birthday").datepicker({format: 'yyyy-mm-dd'});
                });
            </script>
            </br>
            {{Form::label('country','Country:'),
            Form::input('text','country',null,['class' => 'form-control'])}}
            {{$errors->first('country');}}
            </br>
            {{Form::label('city','City:'),
            Form::input('text','city',null,['class' => 'form-control'])}}
            {{$errors->first('city');}}
            </br>
            {{Form::label('about_me','About Me:'),
            Form::textarea('about_me',null,['class' => 'form-control'])}}
            {{$errors->first('about_me');}}
            </br>
        </center>
    </div>

<div class="clearfix"></div>
</br>
<div style="border:1px solid;">
    <center>
        <h4>Social Profiles</h4>
        </br>
        {{Form::label('website','Website:'),
        Form::input('text','website',null,['class' => 'form-control'])}}
        {{$errors->first('website');}}
        </br>
        {{Form::label('skype','Skype:'),
        Form::input('text','skype',null,['class' => 'form-control'])}}
        {{$errors->first('skype');}}
        </br>
        {{Form::label('twitter','Twitter:'),
        Form::input('text','twitter',null,['class' => 'form-control'])}}
        {{$errors->first('twitter');}}
        </br>
        {{Form::label('facebook','Facebook:'),
        Form::input('text','facebook',null,['class' => 'form-control'])}}
        {{$errors->first('facebook');}}
        </br>
        {{Form::label('linked_in','LinkedIn:'),
        Form::input('text','linked_in',null,['class' => 'form-control'])}}
        {{$errors->first('linked_in');}}
        </br>
        {{Form::label('google_plus','Google Plus:'),
        Form::input('text','google_plus',null,['class' => 'form-control'])}}
        {{$errors->first('google_plus');}}
        </br>
        {{Form::submit('Update Profile',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block']),
        Form::input('hidden','username',$user->username),
        Form::input('hidden','user_id',$user->id)}}
    </center>
</div>
{{Form::close()}}

@stop