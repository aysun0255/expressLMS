@extends('layouts.master')

@section('content')
<div class="well">
<center>
    <h1>Edit Assignment</h1></center>
    {{Form::model($assignment,array('route'=>array('assignment.editDBEntry',$courseId,$sectionId,$assignmentId), 'method' =>'post'))}}
        {{Form::label('name','Assignment Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
        </br>
        {{Form::label('intro','Assignment description:'),
        Form::textarea('intro',null,['class' => 'form-control tinyMCE'])}}
        {{$errors->first('intro');}}            
        </br>
        {{Form::label('timedue','Time Due:'),
        Form::input('text','timedue',null,['class' => 'input-append date'])}}
        {{$errors->first('timedue');}}
             <script type="text/javascript">
$(function() {
  $("#timedue").datepicker({format:'yyyy-mm-dd'});
});
</script>
        </br>
         {{Form::label('email_teachers','Email teachers on submission:'),
        Form::radio('email_teachers', 'yes'),'Yes ',
        Form::radio('email_teachers', 'no'),'No ';}}
        {{$errors->first('visible');}}
        </br>
        {{Form::label('submission_type','Submission Type:'),
        Form::select('submission_type',array('file' => 'File','text'=>'Text'),['class' => 'form-control'])}}
        {{$errors->first('submission_type');}}
        </br>
        {{Form::label('name','Max Points:'),
        Form::input('text','max_points',null,['class' => 'form-control'])}}
        {{$errors->first('max_points');}}
        </br>
        {{Form::input('hidden','section_id',$sectionId)}}
        {{Form::submit('Edit Assignment',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop