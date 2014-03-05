@extends('layouts.master')

@section('content')
<div class="well">
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <h2>{{ Session::get('success') }}</h2>
    </div>
    @endif
    <div class="span7">  
        <ul class="nav nav-tabs">
            <li >
                <a href="{{URL::to('/messages')}}">Incoming</a>
            </li >
            <li class="active">
                <a href="{{URL::to('/messages/outgoing')}}">Outgoing</a>
            <li>
        </ul>
        <a class="btn btn-primary" title="Send message" href="{{route('messages.create')}}"> + Send Message</a>
        </br>
        <div class="widget stacked widget-table action-table">
            <div class="widget-header">
                <center><h3>Messages Inbox</h3></center>



            </div> <!-- /widget-header -->

            <div class="widget-content">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td><a href="{{route('messages.show',$message->id)}}">{{$message->subject}}</a></td>
                            <?php
                            $reciever = $message->users()->where('message_user.user_role', 'reciever')->get();
                            ?>
                            <td><a href="{{URL::to('/users/'.$reciever->first()->username)}}">{{$reciever->first()->username}}</a></td>
                            <td>{{$message->created_at}}</td>
                            <td>
                                {{Form::open(array('route' => array('messages.destroy',$message->id),'method' =>'delete'))}}
                                {{Form::input('hidden','message_id',$message->id)}}
                                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-small btn-primary'])}}
                                {{Form::close()}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->      </div>
    @stop