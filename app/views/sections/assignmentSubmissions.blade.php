@extends('layouts.master')

@section('content')
<?php

function getFileTypeIcon($mimetype) {
    $image = '../../../../../../images/filetypeicons/unknown.png';
    $image = $mimetype == 'doc' || $mimetype == 'docx' ? '../../../../../images/filetypeicons/word.png' : $image;
    $image = $mimetype == 'ppt' ? '../../../../../../images/filetypeicons/ppt.png' : $image;
    $image = $mimetype == 'pptx' ? '../../../../../../images/filetypeicons/pptx.png' : $image;
    $image = $mimetype == 'gif' ? '../../../../../../images/filetypeicons/gif.png' : $image;
    $image = $mimetype == 'jpeg' ? '../../../../../../images/filetypeicons/jpeg.png' : $image;
    $image = $mimetype == 'png' ? '../../../../../../images/filetypeicons/png.png' : $image;
    $image = $mimetype == 'pdf' ? '../../../../../../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'txt' ? '../../../../../../images/filetypeicons/text.png' : $image;
    $image = $mimetype == 'zip' ? '../../../../../../images/filetypeicons/zip.png' : $image;
    $image = $mimetype == 'rar' ? '../../../../../../images/filetypeicons/rar.png' : $image;
    $image = $mimetype == 'pdf' ? '../../../../../../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'mp3' ? '../../../../../../images/filetypeicons/mp3.png' : $image;
    $image = $mimetype == 'bmp' ? '../../../../../../images/filetypeicons/bmp.png' : $image;
    $image = $mimetype == 'avi' ? '../../../../../../images/filetypeicons/avi.png' : $image;
    return $image;
}
?>
<div class="offer offer-default">
    <div class="shape">
        <div class="shape-text">
            assignment								
        </div>
    </div>
    <div class="offer-content">
        <h3 class="lead">
            Assignment:{{$assignment->name}}
        </h3>
        <p>
            {{$assignment->intro}}
        </p>
        </hr></br>
        <center>@if($assignment->submit_type == 'file')
            <?php
            $files = AssignmentFiles::whereAssignment_id($assignment->id)->get();
            ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Submissions</h3>
                    <div class="pull-right">
                        <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                            <i class="glyphicon glyphicon-filter"></i>
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Submissions" />
                </div>
                <table class="table table-hover" id="dev-table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Username</th>
                            <th>Points</th>
                            <th>Accepted</th>
                            <th>Submitted</th>
                            <th class="td-actions">Accept Submission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $file)
                        <tr>
                            <td><img src="{{getFileTypeIcon($file->mimetype)}}" width="35" height="35"/><a href="{{route('assignment.download',array($courseId,$sectionId,$assignment->id))}}"<b>{{$file->filename}}</b></a>
                            </td>
                            <td>{{User::whereId($file->user_id)->first()->username}}</td>
                            <td>{{$file->points}}</td>
                            <td>{{$file->accepted}}</td>
                            <td>{{$file->created_at}}</td>
                            <td>
                            {{Form::open(array('route' => array('assignment.acceptSubmission',$courseId,$sectionId,$assignment->id),'style' =>'display:inline;'))}}                           
                            Points:{{Form::input('text','points',null,['style'=>'width:35px;'])}}/{{$assignment->max_points}}
                            {{Form::input('hidden','submit_type',$assignment->submit_type)}}
                            {{Form::input('hidden','submission_id',$file->id)}}
                            {{Form::submit('Accept',['type' => 'button','class' => 'btn btn-info'])}}
                            {{Form::close()}}
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table></div>
            @elseif($assignment->submit_type == 'text')
            <h3>Submissions</h3>
            <?php
            $answers = AssignmentAnswers::whereAssignment_id($assignment->id)->whereUser_id(Auth::user()->id)->get();
            ?>
            @foreach($answers as $answer)
            <div class="answer" style="overflow: hidden;">
                {{$answer->answer}}
                </br>
                <b>Username:</b>{{User::whereId($answer->user_id)->first()->username}} 
                <b>Points:</b>{{$answer->points}} 
                <b>Accepted:</b>{{$answer->accepted}}
                <b>Submitted:</b>{{$answer->created_at}}
                <b>Accept:</b>{{Form::open(array('route' => array('assignment.acceptSubmission',$courseId,$sectionId,$assignment->id),'style' =>'display:inline;'))}}                           
                            Points:{{Form::input('text','points',null,['style'=>'width:35px;'])}}/{{$assignment->max_points}}
                            {{Form::input('hidden','submit_type',$assignment->submit_type)}}
                            {{Form::input('hidden','submission_id',$answer->id)}}
                            {{Form::submit('Accept',['type' => 'button','class' => 'btn btn-info'])}}
                            {{Form::close()}}
            </div>
            </br>
            @endforeach
                        @endif
                        </center>
                        </div>
                        </div>
                        @stop