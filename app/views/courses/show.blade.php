@extends('layouts.master')

@section('content')
<?php

function getFileTypeIcon($mimetype) {
    $image = '../images/filetypeicons/unknown.png';
    $image = $mimetype == 'doc' || $mimetype == 'docx' ? '../images/filetypeicons/word.png' : $image;
    $image = $mimetype == 'ppt' ? '../images/filetypeicons/ppt.png' : $image;
    $image = $mimetype == 'pptx' ? '../images/filetypeicons/pptx.png' : $image;
    $image = $mimetype == 'gif' ? '../images/filetypeicons/gif.png' : $image;
    $image = $mimetype == 'jpeg' ? '../images/filetypeicons/jpeg.png' : $image;
    $image = $mimetype == 'png' ? '../images/filetypeicons/png.png' : $image;
    $image = $mimetype == 'pdf' ? '../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'txt' ? '../images/filetypeicons/text.png' : $image;
    $image = $mimetype == 'zip' ? '../images/filetypeicons/zip.png' : $image;
    $image = $mimetype == 'rar' ? '../images/filetypeicons/rar.png' : $image;
    $image = $mimetype == 'pdf' ? '../images/filetypeicons/pdf.png' : $image;
    $image = $mimetype == 'mp3' ? '../images/filetypeicons/mp3.png' : $image;
    $image = $mimetype == 'bmp' ? '../images/filetypeicons/bmp.png' : $image;
    $image = $mimetype == 'avi' ? '../images/filetypeicons/avi.png' : $image;
    return $image;
}
?>
<div class="well">
   
    <div class="offer offer-default">
        <div class="shape">
            <div class="shape-text">
                course								
            </div>
        </div>
        <div class="offer-content">
            <h3 class="lead">
                {{$course->name}}
            </h3>
            <p>
            <div class="right">
                <a href ="{{route('courses.users', $course->id)}}" class ="btn btn-info">Users</a>
                <a href ="{{route('courses.sections.create', $course->id)}}" class ="btn btn-info">Add section</a>               
                <?php
                $usergroupId = Auth::user()->usergroup_id;
                $usergroup = Usergroup::whereId($usergroupId)->first();
                $canDeleteCourses = $usergroup->can_delete_courses;
                $canEditCourses = $usergroup->can_edit_courses;
                $canDeleteSections = $usergroup->can_delete_sections;
                ?>
                @if($canEditCourses =='yes')
                <a href ="{{route('courses.edit', $course->id)}}" class ="btn btn-info">Edit course</a>
                @endif
                @if($canDeleteCourses =='yes')

                {{Form::open(array('route' => array('courses.destroy', $course->id),'method'=>'delete','style' =>'display:inline;'))}}
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                {{Form::close()}} 
                @endif
            </div>
            {{$course->description}}
            </p>
        </div>
    </div>
    <?php
    $sections = $course->sections;
    ?>

    @foreach($sections as $section)
    </br>
    <?php
    $files = $section->files;
    $contents = $section->contents;
    ?>
    <div class="offer offer-radius offer-primary">
        <div class="offer-content">
            <h3 class="lead">
                {{$section->name}}
            </h3>						
            <p>
            <div class="right">
                <a href ="{{route('sections.addfile',array($course->id,$section->id))}}" class="btn btn-info">Add file</a>
                <a href ="{{route('content.add',array($course->id,$section->id))}}" class="btn btn-info">Add Content</a>
                <a href ="#" class="btn btn-info"> Add homework</a>
                <a href ="#" class="btn btn-info">Add test</a>
                <a href ="#" class="btn btn-info">Add url</a>
                <a href ="{{route('courses.sections.edit',array($course->id,$section->id))}}" class="btn btn-info">Edit</a>
                @if($canDeleteSections =='yes')
                {{Form::open(array('route' => array('courses.sections.destroy',$course->id,$section->id),'method'=>'delete','style' =>'display:inline;'))}}
                {{Form::input('hidden','course_id',$course->id)}}
                {{Form::submit('Delete',['type' => 'button','class' => 'btn btn-info','onclick' => "return confirm('Are you sure?');"])}}
                {{Form::close()}} 
                @endif
                </p>

                <p>
                    @foreach($files as $file)
                <h3>{{$file->pivot->title}}</h3>
                <p>{{$file->pivot->description}}</p></br>
                <a href="{{route('files.download',array($course->id,$file->id))}}"><img src ="{{getFileTypeIcon($file->mimetype)}}" width="35" height="35" />{{$file->filename}}</a><a href="{{route('files.remove',array($course->id,$section->id,$file->id))}}">  <img src="../images/remove.png" width="15" height="15" alt="Remove" /></a>
                @endforeach
                @foreach($contents as $content)
                </br><a href="{{route('content.show',array($course->id,$section->id,$content->id))}}"><img src ="../images/filetypeicons/content.png" width="35" height="35" />{{$content->title}}</a><img src="../images/remove.png" width="15" height="15" alt="Remove" />
                @endforeach




                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop