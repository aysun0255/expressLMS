@extends('layouts.master')

@section('content')
<div class="well">
    @if(Session::has('success'))
    <div class="alert alert-success">
        <h2>{{ Session::get('success') }}</h2>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <h2>{{ Session::get('error') }}</h2>
    </div>
    @endif
    <div class="span7">   
        <div class="widget stacked widget-table action-table">
            <div class="widget-header">
                <center><h3>Course Users</h3></center>



            </div> <!-- /widget-header -->

            <div class="widget-content">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Last activity</th>
                            <th class="td-actions">Operations</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($courseUsers as $user)
                        <tr>
                            <td>{{$user->username}}</td>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->city}}</td>
                            <td>{{$user->country}}</td>
                            <td>{{$user->last_activity}}</td>
                            <td> 
                                <?php
                                $usergroupId = Auth::user()->usergroup_id;
                                $usergroup = Usergroup::whereId($usergroupId)->first();
                                $canRemoveCourseUsers = $usergroup->can_remove_course_users;
                                ?>
                                @if($canRemoveCourseUsers =='yes')
                                {{Form::open(array('route' => array('courses.unroll',$course->id),'style' =>'display:inline;'))}}
                                {{Form::input('hidden','user_id',$user->id)}}
                                {{Form::submit('Remove',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                                {{Form::close()}} 
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->      </div>

    </br>
    {{Form::open(array('route'=>array('courses.enrol',$course->id)))}}
    <h3>Enrol users</h3>
    <label for="select-tools">Select :</label>
    <select class="selectized"  name ="users[]" style="display: none;" tabindex="-1" multiple="multiple" id="select-tools" placeholder="Choose recievers..."></select>
    <div class="selectize-control multi">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#select-tools').selectize({
                    plugins: ['remove_button'],
                    valueField: 'class_id',
                    labelField: 'name',
                    searchField: ['name'],
                    maxOptions: 10,
                    options: [],
                    create: false,
                    render: {
                        option: function(item, escape) {
                            return '<div><img src="' + item.icon + '" width="50" height="50">' + escape(item.name) + '</div>';
                        }
                    },
                    optgroups: [
                        {value: 'user', label: 'Users'}

                    ],
                    optgroupField: 'class',
                    optgroupOrder: ['user'],
                    load: function(query, callback) {
                        if (!query.length)
                            return callback();
                        $.ajax({
                            url: root + '/api/search/user',
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                q: query
                            },
                            error: function() {
                                callback();
                            },
                            success: function(res) {
                                callback(res.data);
                            }
                        });
                    }
                });
            });
        </script>
        </br>
        {{Form::input('hidden','course_id',$course->id)}}
        {{Form::submit('Enrol',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
    </div>





</div>
@stop