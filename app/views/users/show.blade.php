@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">

        <h2>{{$user->username,'(',$user->first_name,' ',$user->last_name,')'}}</h2>
        <div class='col-xs-3 col-lg-2'>
            <?php $avatar = Avatar::whereId($user->avatar_id)->first();
            ?>
            <img src="{{asset('images/avatars/'.$avatar->avatar)}}" style='float:left' width='120' height='120' />
            </br>
            <div >
                </br></br></br></br></br></br>
                <?php
                $usergroupId = Auth::user()->usergroup_id;
                $usergroup = Usergroup::whereId($usergroupId)->first();
                $canDeleteUsers = $usergroup->can_delete_users;
                $canEditUsers = $usergroup->can_edit_users;
                ?>
                @if($canEditUsers =='yes')

                <a href ="{{route('users.edit', $user->username)}}" class ="btn btn-info">Edit</a>
                @endif
                @if($canDeleteUsers =='yes')

                {{Form::open(array('route' => array('users.destroy', $user->id),'method'=>'delete','style' =>'display:inline;'))}}
                {{Form::input('hidden','user_id',$user->id)}}
                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                {{Form::close()}} 
                @endif
            </div>
        </div>
        <div class='col-xs-12 col-sm-6 col-lg-8'>
            <b>First Name:</b>{{$user->first_name}}
            </br>
            <b>Last Name:</b>{{$user->last_name}}
            </br>
            <b>Gender:</b>@if($user->gender == 'male')
            Male
            @else
            Female
            @endif
            </br>
            <b>Birthday:</b>{{$user->birthday}}
            </br>
            <b>Last Activity :</b>{{$user->last_activity}}
            </br>
            <?php
            $courses = $user->courses;
            ?>
            <b>Courses:</b>
            @foreach($courses as $course)
            <a href ="{{route('courses.show', $course->id)}}">{{$course->name}}</a>
            @endforeach
            </br>
            <h5><b>Social Info:</b></h5>
            <img src={{asset('images/social_icons/website.png')}} width ="20"  height="20" alt="Website"><b>Website:</b>{{$user->website}}
            </br>
            <img src={{asset('images/social_icons/skype.jpg')}} width ="20"  height="20" alt="Skype"><b>Skype:</b>{{$user->skype}}
            </br>
            <img src={{asset('images/social_icons/facebook.jpg')}} width ="20"  height="20" alt="Facebook"><b>Facebook:</b>{{$user->facebook}}
            </br>
            <img src={{asset('images/social_icons/twitter.png')}} width ="20"  height="20" alt="Skype"><b>Twitter:</b>{{$user->twitter}}
            </br>
            <img src={{asset('images/social_icons/linkedin.png')}} width ="20"  height="20" alt="Skype"><b>LinkedIn:</b>{{$user->linked_in}}
        </div>
    </div>
</div>
@stop
