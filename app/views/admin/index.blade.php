@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div id="adminpanel" style="width:100%;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Admin Control Panel</h3>
                </div>
                </br>
                <div class="panel-bodyy">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="{{route('admincp.config')}}" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <br/>Config</a>
                          <a href="{{route('courses.create')}}" class="btn btn-warning btn-lg" role="button"><span class="glyphicon glyphicon-book"></span> <br/>New Course</a>
                          <a href="{{route('admincp.reports')}}" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-signal"></span> <br/>Reports</a>
                          </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="{{route('users.index')}}" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-user"></span> <br/>Users</a>
                          <a href="{{route('admincp.categories')}}" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-list"></span> <br/>Categories</a>
                          <a href="{{route('users.create')}}" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-plus-sign"></span> <br/>New User</a>
                          </div>
                    </div>
                    <a href="{{route('home')}}" class="btn btn-success btn-lg btn-block" role="button"><span class="glyphicon glyphicon-home"></span> Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop