@extends('layouts.master')

@section('content')
<?php

function getFileTypeIcon($mimetype) {
    $image = asset('images/filetypeicons/unknown.png');
    $image = $mimetype == 'doc' || $mimetype == 'docx' ? '../images/filetypeicons/word.png' : $image;
    $image = $mimetype == 'ppt' ? asset('images/filetypeicons/ppt.png') : $image;
    $image = $mimetype == 'pptx' ? asset('images/filetypeicons/pptx.png') : $image;
    $image = $mimetype == 'gif' ? asset('images/filetypeicons/gif.png') : $image;
    $image = $mimetype == 'jpeg' ? asset('images/filetypeicons/jpeg.png') : $image;
    $image = $mimetype == 'png' ? asset('images/filetypeicons/png.png') : $image;
    $image = $mimetype == 'pdf' ? asset('images/filetypeicons/pdf.png') : $image;
    $image = $mimetype == 'txt' ? asset('images/filetypeicons/text.png') : $image;
    $image = $mimetype == 'zip' ? asset('images/filetypeicons/zip.png') : $image;
    $image = $mimetype == 'rar' ? asset('images/filetypeicons/rar.png') : $image;
    $image = $mimetype == 'pdf' ? asset('images/filetypeicons/pdf.png') : $image;
    $image = $mimetype == 'mp3' ? asset('images/filetypeicons/mp3.png') : $image;
    $image = $mimetype == 'bmp' ? asset('images/filetypeicons/bmp.png') : $image;
    $image = $mimetype == 'avi' ? asset('images/filetypeicons/avi.png') : $image;
    return $image;
}

if ($course->users->contains(Auth::user()->id)) {
    $userRole = $course->users()->whereId(Auth::user()->id)->first()->pivot->role;
} else {
    $userRole = 'student';
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
                {{$course->description}}
            </p>

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
    $websites = $section->websites;
    $assignments = $section->assignments;
    $tests = $section->tests;
    ?>
    <div class="offer offer-radius offer-primary">
        <div class="offer-content">
            <h3 class="lead">
                {{$section->name}}
            </h3>						
            <p>
                {{$section->description}}
            </p>
            <p>
            <div class="right">
                @if($userRole == 'teacher')
                <a href ="{{route('sections.addfile',array($course->id,$section->id))}}" class="btn btn-info">+ File</a>
                <a href ="{{route('content.add',array($course->id,$section->id))}}" class="btn btn-info">+ Content</a>
                <a href ="{{route('assignment.add',array($course->id,$section->id))}}" class="btn btn-info"> + Assignment</a>
                <a href ="{{route('test.add',array($course->id,$section->id))}}" class="btn btn-info">+ Test</a>
                <a href ="{{route('website.add',array($course->id,$section->id))}}" class="btn btn-info">+ Web content</a>
                <a href ="{{route('courses.sections.edit',array($course->id,$section->id))}}" class="btn btn-info">Edit</a>
                @endif
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
                <a href="{{route('files.download',array($course->id,$file->id))}}"><img src ="{{getFileTypeIcon($file->mimetype)}}" width="35" height="35" />{{$file->filename}}</a>
                @if($userRole == 'teacher')
                <a href="{{route('files.remove',array($course->id,$section->id,$file->id))}}"><img src="../images/remove.png" width="15" height="15" alt="Remove" /></a>
                @endif
                @endforeach
                @foreach($contents as $content)
                </br><a href="{{route('content.show',array($course->id,$section->id,$content->id))}}"><img src ="../images/filetypeicons/content.png" width="35" height="35" />{{$content->title}}</a>
                @if($userRole == 'teacher')
                <a href="{{route('content.remove',array($course->id,$section->id,$content->id))}}"><img src="../images/remove.png" width="15" height="15" alt="Remove" /></a>
                <a href="{{route('content.edit',array($course->id,$section->id,$content->id))}}"><img src="../images/edit.png" width="25" height="25" alt="Edit" /></a>
                @endif
                @endforeach
                @foreach($websites as $website)
                </br><a href="{{$website->link}}"><img src ="../images/filetypeicons/url.png" width="35" height="35" />{{$website->title}}</a>
                @if($userRole == 'teacher')
                <a href="{{route('website.remove',array($course->id,$section->id,$website->id))}}"><img src="../images/remove.png" width="15" height="15" alt="Remove" /></a>
                <a href="{{route('website.edit',array($course->id,$section->id,$website->id))}}"><img src="../images/edit.png" width="25" height="25" alt="Edit" /></a>
                @endif
                @endforeach
                @foreach($assignments as $assignment)
                </br><a href="{{route('assignment.show',array($course->id,$section->id,$assignment->id))}}"><img src ="../images/filetypeicons/assignment.gif" width="35" height="35" />{{$assignment->name}}</a>
                @if($userRole == 'teacher')
                <a href="{{route('assignment.remove',array($course->id,$section->id,$assignment->id))}}"><img src="../images/remove.png" width="15" height="15" alt="Remove" /></a>
                <a href="{{route('assignment.edit',array($course->id,$section->id,$assignment->id))}}"><img src="../images/edit.png" width="25" height="25" alt="Edit" /></a>
                <a href="{{route('assignment.submissions',array($course->id,$section->id,$assignment->id))}}">Submissions</a>
                @endif
                @endforeach
                @foreach($tests as $test)
                </br>
                <a href="{{route('test.show',array($course->id,$section->id,$test->id))}}"><img src ="../images/filetypeicons/test.png" width="45" height="45" />{{$test->name}}</a> 
                @if($userRole == 'teacher')
                <a href="{{route('test.remove',array($course->id,$section->id,$test->id))}}"><img src="../images/remove.png" width="15" height="15" alt="Remove" /></a> 
                <a href="{{route('test.edit',array($course->id,$section->id,$test->id))}}"><img src="../images/edit.png" width="25" height="25" alt="Edit" /></a>
                <a href="{{route('test.addQuestion',array($course->id,$section->id,$test->id))}}">Add question</a>
                @endif
                @endforeach
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop