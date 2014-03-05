@extends('layouts.master')

@section('content')
<?php

function getFileTypeIcon($mimetype) {
    $image = '../../../../../images/filetypeicons/unknown.png';
    $image = $mimetype == 'doc' || $mimetype == 'docx' ? '../../../../../images/filetypeicons/word.png' : $image;
    $image = $mimetype == 'ppt' ? '../../../../../images/filetypeicons/ppt.png' : $image;
    $image = $mimetype == 'pptx' ? '../../../../../images/filetypeicons/pptx.png' : $image;
    $image = $mimetype == 'gif' ? '../../../../../images/filetypeicons/gif.png' : $image;
    $image = $mimetype == 'jpeg' ? '../../../../../images/filetypeicons/jpeg.png' : $image;
    $image = $mimetype == 'png' ? '../../../../../images/filetypeicons/png.png' : $image;
    $image = $mimetype == 'pdf' ? '../../../../../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'txt' ? '../../../../../images/filetypeicons/text.png' : $image;
    $image = $mimetype == 'zip' ? '../../../../../images/filetypeicons/zip.png' : $image;
    $image = $mimetype == 'rar' ? '../../../../../images/filetypeicons/rar.png' : $image;
    $image = $mimetype == 'pdf' ? '../../../../../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'mp3' ? '../../../../../images/filetypeicons/mp3.png' : $image;
    $image = $mimetype == 'bmp' ? '../../../../../images/filetypeicons/bmp.png' : $image;
    $image = $mimetype == 'avi' ? '../../../../../images/filetypeicons/avi.png' : $image;
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
            </br>
        <h3>Due date:{{$assignment->timedue}}</h3>
        </p>
        <center>@if($assignment->submit_type == 'file' && $userRole == 'student')
            @if((date('Y-m-d') <= $assignment->timedue))
            <h3>Submit File </h3>
            <form action="{{route('assignment.submitFile',array($courseId,$sectionId,$assignment->id))}}" class="dropzone" id="my-awesome-dropzone"></form>
            @else
            <h3>Assignment is overdue.You can't submit answer!</h3></br>
            @endif
            <?php
            $files = AssignmentFiles::whereAssignment_id($assignment->id)->whereUser_id(Auth::user()->id)->first();
            ?>
            <h3>Your Submission</h3>
            @if(count($files) > 0)
            <img src="{{getFileTypeIcon($files->mimetype)}}" width="35" height="35"/><a href="{{route('assignment.download',array($courseId,$sectionId,$assignment->id))}}"<b>{{$files->filename}}</b></a>
            </br>
            @if($files->accepted == 'no')
            <h4>Your answer is not accepted yet.<h4>
                    @else
                    <h4>Your answer is accepted. You have {{$files->points}}/{{$assignment->max_points}} points.</h4>
                    @endif
                    <small><i>Note:When you upload new file it replaces the previous uploaded file<i></small>
                                @else
                                You haven't submitted answer!
                                @endif
                                @elseif ($assignment->submit_type == 'text' && $userRole == 'student')
                                @if((date('Y-m-d') <= $assignment->timedue))
                                <h3>Submit Answer</h3>
                                {{Form::open(array('route'=>array('assignment.submitAnswer',$courseId,$sectionId,$assignment->id)))}}
                                {{Form::label('answer','Answer:'),
                        Form::textarea('answer',null,['class' => 'form-control tinyMCE'])}}
                                {{$errors->first('answer');}}            
                                </br>
                                {{Form::submit('Submit Answer',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
                                {{Form::close()}}
                                @else
                                <h3>Assignment is overdue.You can't submit answer!</h3></br>
                                @endif
                                </br>
                                <h3>Your Answer</h3>
                                <?php
                                $answers = AssignmentAnswers::whereAssignment_id($assignment->id)->whereUser_id(Auth::user()->id)->first();
                                ?>
                                @if(count($answers) > 0)
                                <div class="answer" style="overflow: hidden;">
                                    {{$answers->answer}}
                                    </br>
                                    @if($answers->accepted == 'no')
                                    <h4>Your answer is not accepted yet.<h4>
                                            @else
                                            <h4>Your answer is accepted. You have {{$answer->points}}/{{$assignment->max_points}} points.</h4>
                                            @endif
                                            </div>
                                            </br>
                                            <small><i>Note:When you submit new answer it replaces the previous submitted answer<i></small>
                                                        @else
                                                        You haven't submitted answer!
                                                        @endif
                                                        @elseif ($userRole == 'teacher')
                                                        <a href="{{route('assignment.submissions',array($courseId,$sectionId,$assignment->id))}}">View Submissions</a>                          
                                                        @endif
                                                        </center>
                                                        </div>
                                                        </div>
                                                        @stop