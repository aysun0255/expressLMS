@extends('layouts.master')

@section('content')
<?php

?><div class="well">
<center>
    <h1>Add Test</h1></center>
    {{Form::open(array('route'=>array('test.addDBEntry',$courseId,$sectionId)))}}
        {{Form::label('name','Test Name:'),
        Form::input('text','name',null,['class' => 'form-control'])}}
        {{$errors->first('name');}}
         </br>
        {{Form::label('description','Description:'),
        Form::textarea('description',null,['class' => 'form-control'])}}
        {{$errors->first('description');}}
        </br>
        {{Form::label('timedue','Time Due:'),
        Form::input('text','timedue',null,['class' => 'input-append date form-control'])}}
        {{$errors->first('timedue');}}
             <script type="text/javascript">
$(function() {
  $("#timedue").datepicker({format:'yyyy-mm-dd'});
});
</script>
        </br>
        {{Form::label('max_attempts','Max attempts:'),
        Form::input('text','max_attempts',null,['class' => 'form-control'])}}
        {{$errors->first('max_attempts');}}
        </br>
        {{Form::input('hidden','course_id',$courseId)}}
        {{Form::input('hidden','section_id',$sectionId)}}
        {{Form::submit('Add Test',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop