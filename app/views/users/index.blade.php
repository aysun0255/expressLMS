@extends('layouts.master')

@section('content')
<div class="well">
    <div class="container">
        <h1>List Of all users</h1>
        @foreach(array_chunk($users->getCollection()->all(),4) as $row)
        <div class='row'>
            @foreach($row as $user)
            <a href="{{route('users.show', $user->username)}}">
                <div class="col-md-5">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-sm-5 col-md-4">
                                <?php $avatar = Avatar::whereId($user->avatar_id)->first();
                                ?>
                                <img src="{{asset('images/avatars/'.$avatar->avatar)}}" alt="" width ="120" height="120" class="img-rounded img-responsive" />
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <h4>
                                    {{$user->username}}</h4>
                                <small>{{$user->first_name.' '.$user->last_name}}</small>
                                <p>
                            </div>
                            

                        </div>
                    </div></div>
            </a>
            @endforeach
        </div>
        @endforeach
        {{$users->links()}}
    </div>
    @stop

