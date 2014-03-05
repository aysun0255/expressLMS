@extends('layouts.master')

@section('content')

<div id="wrapper">
    <div class="demo">
        <h2>Send Message</h2>
        {{Form::open(array('route'=>'messages.store'))}}
        <div class="control-group">
            <label for="select-tools">Recievers:</label>
            <select class="selectized"  name ="recievers[]" style="display: none;" tabindex="-1" multiple="multiple" id="select-tools" placeholder="Choose recievers..."></select>
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
                                {value: 'user', label: 'Users'},
                                {value: 'course', label: 'Courses'}
                            ],
                            optgroupField: 'class',
                            optgroupOrder: ['user', 'course'],
                            load: function(query, callback) {
                                if (!query.length)
                                    return callback();
                                $.ajax({
                                    url: root + '/api/search',
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
            </div>
        </div>
        </br>
        {{Form::label('subject','Subject:'),
        Form::input('text','subject',null,['class' => 'form-control'])}}
        {{$errors->first('subject');}}
        </br>
        {{Form::label('message','Message:'),
        Form::textarea('message',null,['class' => 'form-control'])}}
        {{$errors->first('message');}}
        </br>
        {{Form::submit('Send Message',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
    

		
        @stop
