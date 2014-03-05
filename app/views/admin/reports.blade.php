@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div id="adminpanel" style="width:100%;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-signal"></span> Reports</h3>
                </div>
                </br>
                <div class="panel-bodyy">
                    <b>Registered users:</b>{{$registeredUsers}}
                    </br>
                    <b>Course Categories:</b>{{$categories}}
                    </br>
                    <b>Courses:</b>{{$courses}}
                    </br>
                     </div>
            </div>
        </div>
    </div>
</div>

@stop