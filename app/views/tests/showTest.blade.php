@extends('layouts.master')

@section('content')
<div class="offer offer-default">
    <div class="shape">
        <div class="shape-text">
            test								
        </div>
    </div>
    <?php
    $questions = $test->questions;
    ?>
    <div class="offer-content">
        <h3 class="lead">
            Test:{{$test->name}}
        </h3>
        <p>
            {{$test->description}}
            </br>
            <b>Max attempts:{{$test->max_attempts}}</b>
            </br>
            <b>Attempts left:{{$test->max_attempts - count(TestResult::whereUser_id(Auth::user()->id)->get())}}</b>
            </br>
            <b>Time due:{{$test->timedue}}</b>
            @if(($test->max_attempts - count(TestResult::whereUser_id(Auth::user()->id)->get())) != $test->max_attempts)
            </br>
            <b>Your last result:{{TestResult::whereUser_id(Auth::user()->id)->orderBy('attempt', 'DESC')->first()->points}}/{{TestResult::whereUser_id(Auth::user()->id)->first()->max_points}}</b>
            @endif
            </br>
        <ol>
            {{Form::open(array('route'=>array('test.evaluate',$courseId,$sectionId,$test->id)))}}
            @foreach($questions as $question)
            <b><li>{{$question->question}}</li></b>
            @if($question->answer_type == 'select')
            <?php $answers = $question->answers; ?>
            <ol type="a">
                @foreach($answers as $answer)

                <li> {{Form::radio('question['.$question->id.']', $answer->id),$answer->answer}}</li>
                @endforeach
            </ol>
            @elseif($question->answer_type == 'text')
            {{Form::input('text','question['.$question->id.']')}}

            @elseif($question->answer_type == 'multiple')
            <?php $answers = $question->answers; ?>
            <ol type="a">
                @foreach($answers as $answer)
                <li> {{Form::checkbox('question['.$question->id.']['.$answer->id.']', $answer->id),$answer->answer}}</li>
                @endforeach
            </ol>
            @endif

            @endforeach
        </ol>
        </br>
        {{Form::submit('Submit',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
        {{Form::close()}}
        </p>

    </div>
</div>
@stop