@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
        <h2>{{$user->username,'(',$user->first_name,' ',$user->last_name,')'}}</h2>
        <?php $avatar = Avatar::whereId($user->avatar_id)->first();
        ?>
        <img src="{{asset('images/avatars/'.$avatar->avatar)}}" style='float:left' width='120' height='120' />
        First Name:{{$user->first_name}}
        </br>
        Last Name:{{$user->last_name}}
        </br>
        Gender:@if($user->gender == 'male')
        Male
        @else
        Female
        @endif
        </br>
        Birthday:{{$user->birthday}}
        </br>
        Last Activity :{{$user->last_activity}}
        </br>
        <?php
        $courses = $user->courses;
        ?>
        Courses:
        @foreach($courses as $course)
        {{$course->name}}
        @endforeach
        </br>
        <div class='right'>
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
</div>
@stop
