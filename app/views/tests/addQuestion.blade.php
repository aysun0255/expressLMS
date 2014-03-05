@extends('layouts.master')

@section('content')
<?php

?><div class="well">
<center>
    <h1>Add Question</h1></center>
    {{Form::open(array('route'=>array('test.addQuestionDBEntry',$courseId,$sectionId,$testId)))}}
        {{Form::label('question','Question:'),
        Form::textarea('question',null,['class' => 'form-control tinyMCE'])}}
        {{$errors->first('question');}}
        </br>
        {{Form::label('answer_type','Answer type:')}}
        <select name="answer_type" class="form-control">
            <option value="select">Select</option>
            <option value="text">Text</option>
            <option value="multiple">Multiple select</option>
        </select>
        </br>
        <script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 1;
 
    $("#addButton").click(function () {
 
	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}   
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);
 
	newTextBoxDiv.after().html('<label>Answer #'+ counter + ' : </label>' +
	      '<input type="text" name="answer[' + counter + 
	      ']" id="answer[' + counter + ']" value="" class="form-control" >'+'Correct:<input type="checkbox"  name="answer_correct['+counter+']" value="yes"/>'+'Points: <input type="text" style="width:35px;" name="points['+counter+']" />');
 
	newTextBoxDiv.appendTo("#answers");
 
 
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Answer #" + i + " : " + $('#answer[' + i+']').val();
	}
    	  alert(msg);
     });
  });
</script>
    <div id ="answers">
<div id="TextBoxDiv0">
		<label>Answer #1 : </label><input type='text'name="answer[0]" id='answer[0]' class="form-control" >Correct:<input type="checkbox"  name="answer_correct[0]" value="yes"/> Points: <input type="text" style="width:35px;" name="points[0]" />
	</div>
        
</div>
<input type='button' value='Add Answer Field' class="btn" id='addButton'>
<input type='button' value='Remove Button'  class="btn" id='removeButton'>
        {{Form::input('hidden','test_id',$testId)}}
        {{Form::submit('Add Question',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
    {{Form::close()}}
</center></div>
@stop