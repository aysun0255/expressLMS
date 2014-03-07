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
        <center>
            @if(!empty($attempt)
            <h4>Your Result:{{TestResult::whereUser_id(Auth::user()->id)->whereAttempt($attempt)->whereTest_id($testId)->first()->points}}/{{TestResult::whereUser_id(Auth::user()->id)->whereAttempt($attempt)->whereTest_id($testId)->first()->max_points}}</h4>
            @else
            <h4>Your Result:{{TestResult::whereUser_id(Auth::user()->id)->whereTest_id($testId)->orderBy('attempt', 'DESC')->first()->points}}/{{TestResult::whereUser_id(Auth::user()->id)->whereTest_id($testId)->first()->max_points}}</h4>
            @endif
            <h4>Your Answers:</h4>
        </center><ol>
            @foreach($questions as $question)
            <?php
            if (!empty($attempt)) {
                $userAnswer = UserTestAnswer::whereUser_id(Auth::user()->id)->whereQuestion_id($question->id)->whereAttempt($attempt)->first();
            } else {
                $userAnswer = UserTestAnswer::whereUser_id(Auth::user()->id)->whereQuestion_id($question->id)->orderBy('attempt', 'DESC')->first();
            }
            ?>
            <b><li>{{$question->question}}</li></b>
            @if($question->answer_type == 'select')
            <?php
            $answers = $question->answers;
            ?>
            <ol type="a">
                @foreach($answers as $answer)
                @if($userAnswer->answer_id == $answer->id)
                <li> <b>{{$answer->answer}}</b>
                    @if($answer->correct == 'yes')
                    <img src="{{asset('images/correct.png')}}" width="25" height="25" alt="Correct" />
                    @else
                    <img src="{{asset('images/incorrect.png')}}" width="25" height="25" alt="Incorrect" />
                    @endif
                </li>
                @else
                <li> {{$answer->answer}}</li>
                @endif
                @endforeach
            </ol>
            @elseif($question->answer_type == 'text')
            <?php
            $answer = $question->answers()->first();
            ?>
            <b>{{$userAnswer->answer}}</b>
            @if($userAnswer->answer == $answer->answer)
            <img src="{{asset('images/correct.png')}}" width="25" height="25" alt="Correct" />
            @else
            <img src="{{asset('images/incorrect.png')}}" width="25" height="25" alt="Incorrect" />
            @endif

            @elseif($question->answer_type == 'multiple')
            <?php $answers = $question->answers; ?>
            <ol type="a">
                @foreach($answers as $answer)
                @if($userAnswer->answer_id == $answer->id)
                <li> <b>{{$answer->answer}}</b>
                    @if($answer->correct == 'yes')
                    <img src="{{asset('images/correct.png')}}" width="25" height="25" alt="Correct" />
                    @else
                    <img src="{{asset('images/incorrect.png')}}" width="25" height="25" alt="Incorrect" />
                    @endif
                </li>
                @else
                <li> {{$answer->answer}}</li>
                @endif
                @endforeach
            </ol>
            @endif

            @endforeach
        </ol>
        </br>
        </p>

    </div>
</div>
@stop