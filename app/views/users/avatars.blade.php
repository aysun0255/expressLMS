@extends('layouts.master')

@section('content')
<div class="well">
    <h3>Upload Avatar </h3>
    <form action="{{ url('users/avatars/upload')}}" class="dropzone" id="my-awesome-dropzone"></form></br>
    @if(Session::has('success'))
    <div class="alert alert-success">

        <h2>{{ Session::get('success') }}</h2>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <h2>{{ Session::get('success') }}</h2>
    </div>
    @endif
    <div class="span7">   
        <div class="widget stacked widget-table action-table">
            <div class="widget-header">
                <h3>Uploaded Avatars</h3>



            </div> <!-- /widget-header -->

            <div class="widget-content">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Avatar</th>
                            <th class="td-actions"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($avatars as $avatar)
                        <tr>
                            <td><img src="{{asset('images/avatars/'.$avatar->avatar)}}"  width ="50" height="50"/></td>
                            <td>{{$avatar->avatar}}</td>
                            <td class="td-actions">
    
                                {{Form::open(array('route' => 'avatars.use'))}}
                                    {{Form::input('hidden','avatar_id',$avatar->id)}}
                                    {{Form::submit('Use Avatar',['type' => 'button','class' => 'btn btn-small btn-primary'])}}
                                {{Form::close()}}

                                {{Form::open(array('route' => 'avatars.delete'))}}
                                    {{Form::input('hidden','avatar_id',$avatar->id)}}
                                    {{Form::input('hidden','avatar_file',$avatar->avatar)}}
                                    {{Form::submit('Delete Avatar',['type' => 'button','class' => 'btn btn-small btn-primary'])}}
                                {{Form::close()}}
                              
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->      </div>
    @stop