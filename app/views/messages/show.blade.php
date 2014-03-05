@extends('layouts.master')

@section('content')
<div class="well">
    <div class="row">

    <div class="span12">
        <div class="row" style="margin-top: 5px;">
            <div class="span2" style="text-align:center; float:left;">
                <?php
                $sender = $message->users()->where('message_user.user_role', 'sender')->get()->first();
                $avatar = Avatar::whereId($sender->avatar_id)->first();
                ?>
                <img class="avatar-square" src="{{asset('images/avatars/'.$avatar->avatar)}}"  width='120' height='120' title="From A. Sedatov" alt="From A. Sedatov" style="float:left;">
                <p><span title="A. Sedatov">{{$sender->username}}</span></p>
            </div>        
            <div class="span8" style="margin-left: 10px; float:left;">
                <div><h2>{{$message->subject}}</h2></div>
                <div style="margin-top: 5px;">{{$message->message}}</div>
            </div>
            <div class="span2" style="margin-top:5px; float:right;">{{$message->created_at}}</div>
        </div>
        <div class="row">
            <div class="span9 offset2">
                <div class="form-actions">
                    <span class="help-inline"><a href="{{ URL::previous() }}">Go back</a></span>
                </div>
            </div>
        </div>

    </div>
    </div>
    
    
</div>
@stop