@extends('layouts.master')

@section('content')
<div class="well">
    <h3>Upload File </h3>
    <form action="{{ url('courses/$courseId/files/upload')}}" class="dropzone" id="my-awesome-dropzone"><input type="hidden" name="course_id" value="{{$courseId}}" /></form></br>
    <script>
        $dropzone.on('complete', function() {
            location.reload();
        });
    </script>
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
                <center><h3>Uploaded Files</h3></center>



            </div> <!-- /widget-header -->

            <div class="widget-content">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th class="td-actions">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        function formatSizeUnits($bytes) {
                            if ($bytes >= 1073741824) {
                                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                            } elseif ($bytes >= 1048576) {
                                $bytes = number_format($bytes / 1048576, 2) . ' MB';
                            } elseif ($bytes >= 1024) {
                                $bytes = number_format($bytes / 1024, 2) . ' KB';
                            } elseif ($bytes > 1) {
                                $bytes = $bytes . ' bytes';
                            } elseif ($bytes == 1) {
                                $bytes = $bytes . ' byte';
                            } else {
                                $bytes = '0 bytes';
                            }

                            return $bytes;
                        }
                        ?>
                        @foreach($files as $file)
                        <tr>
                            <td>{{$file->filename}}</td>
                            <td>{{$file->mimetype}}</td>
                            <td class="td-actions">{{formatSizeUnits($file->filesize)}}</td>
                            <td>{{$file->created_at}}</td>
                            <td> 
                                {{Form::open(array('route' => array('files.destroy',$file->course_id),'method' => 'delete'))}}
                                {{Form::input('hidden','file_id',$file->id)}}
                                {{Form::input('hidden','filepath',$file->filepath)}}
                                {{Form::input('hidden','filename',$file->filename)}}
                                {{Form::input('hidden','course_id',$file->course_id)}}
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