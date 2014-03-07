<?php

class TestsController extends BaseController {

    protected $test;

    public function __construct(Test $test) {
        $this->test = $test;
        $this->beforeFilter('auth');
    }

    public function create($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('tests.create', ['courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\'t have permission to add new test!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function store($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $test = $this->test;
            $input = Input::all();
            if (!$test->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($test->errors);
            }
            $test->name = Input::get('name');
            $test->description = Input::get('description');
            $test->section_id = Input::get('section_id');
            $test->course_id = Input::get('course_id');
            $test->timedue = Input::get('timedue');
            $test->max_attempts = Input::get('max_attempts');
            $test->save();
            Session::flash('success', 'You have successfully added new test!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\'t have permission to add new test!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function edit($courseId, $sectionId, $testId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);

        if ($userRole == 'teacher') {
            $test = $this->test->whereId($testId)->first();
            return View::make('tests.edit', ['courseId' => $courseId, 'sectionId' => $sectionId, 'testId' => $testId])->with(compact('test'));
        } else {
            Session::flash('error', 'You don\t have permission to edit selected test!');
            return Redirect::route('test.show', array($courseId, $sectionId, $testId));
        }
    }

    public function editDBEntry($courseId, $sectionId, $testId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $test = $this->test->whereId($testId)->first();
            $input = Input::all();
            if (!$test->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($test->errors);
            }
            $test->name = Input::get('name');
            $test->description = Input::get('description');
            $test->section_id = Input::get('section_id');
            $test->timedue = Input::get('timedue');
            $test->max_attempts = Input::get('max_attempts');
            $test->save();
            Session::flash('success', 'You have successfully edited selected test!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\'t have permission to edit selected test!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function show($courseId, $sectionId, $testId) {
        $test = $this->test->whereId($testId)->first();
        if ($test->max_attempts > count(TestResult::whereUser_id(Auth::user()->id)->whereTest_id($testId)->get())) {
            return View::make('tests.showTest', ['test' => $test, 'sectionId' => $sectionId, 'courseId' => $courseId]);
        } else {
            return View::make('tests.showTestResult', ['test' => $test, 'sectionId' => $sectionId, 'courseId' => $courseId]);
        }
    }

    public function showAttempt($courseId, $sectionId, $testId, $attempt) {
        $test = $this->test->whereId($testId)->first();
        return View::make('tests.showTestResult', ['test' => $test, 'sectionId' => $sectionId, 'courseId' => $courseId, 'attempt' => $attempt]);
    }

    public function destroy($courseId, $sectionid, $testId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $this->test->whereId($testId)->first()->delete();
            Session::flash('success', 'You have deleted selected test successfuly!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to delete this test!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addQuestion($courseId, $sectionId, $testId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('tests.addQuestion', ['courseId' => $courseId, 'sectionId' => $sectionId, 'testId' => $testId]);
        } else {
            Session::flash('error', 'You don\'t have permission to add question!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addQuestionDBEntry($courseId, $sectionId, $testId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $question = new Question;
            $input = Input::all();
            if (!$question->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($question->errors);
            }
            $question->question = Input::get('question');
            $question->test_id = Input::get('test_id');
            $question->answer_type = Input::get('answer_type');
            $question->save();
            $answers = Input::get('answer');
            $isCorrect = Input::get('answer_correct');
            $points = Input::get('points');
            foreach ($answers as $key => $val) {
                $answer = new QuestionAnswers;
                $answer->answer = $val;
                $answer->question_id = $question->id;
                $answer->correct = 'no';
                if (!empty($isCorrect[$key]) && $isCorrect[$key] == 'yes') {
                    $answer->correct = 'yes';
                }
                $answer->points = $points[$key];
                $answer->save();
            }
            Session::flash('success', 'You have successfully added new question!');
            return Redirect::route('test.show', array($courseId, $sectionId, $testId));
        }
        Session::flash('error', 'You don\'t have permission to add question!');
        return Redirect::route('courses.show', $courseId);
    }

    public function evaluateTest($courseId, $sectionId, $testId) {
        $questionM = new Question;
        $answerM = new QuestionAnswers;
        $userResult = new TestResult;

        $questions = Input::get('question');
        $points = 0;
        $maxpoints = 0;
        $attempts = count(TestResult::whereUser_id(Auth::user()->id)->get());
        $attempt = $attempts + 1;
        foreach ($questions as $key => $answer) {
            $questionM = $questionM->whereId($key)->first();
            if ($questionM->answer_type == 'select') {
                $answerM = $answerM->whereId($answer)->first();
                if ($answerM->correct == 'yes') {
                    $points += $answerM->points;
                }
                $userAnswer = new UserTestAnswer;
                $userAnswer->question_id = $key;
                $userAnswer->answer_id = $answer;
                $userAnswer->user_id = Auth::user()->id;
                $userAnswer->attempt = $attempt;
                $userAnswer->save();
                $answerMM = $answerM->whereQuestion_id($key)->whereCorrect('yes')->get();
                foreach ($answerMM as $answ) {
                    $maxpoints += $answ->points;
                }
            } elseif ($questionM->answer_type == 'multiple') {
                foreach ($answer as $ans) {
                    $answerM = $answerM->whereId($ans)->first();
                    if ($answerM->correct == 'yes') {
                        $points += $answerM->points;
                    }
                    $userAnswer = new UserTestAnswer;
                    $userAnswer->question_id = $key;
                    $userAnswer->answer_id = $ans;
                    $userAnswer->user_id = Auth::user()->id;
                    $userAnswer->attempt = $attempt;
                    $userAnswer->save();
                    $answerMM = $answerM->whereQuestion_id($key)->whereCorrect('yes')->get();
                }
                foreach ($answerMM as $ans) {
                    $maxpoints += $ans->points;
                }
            } elseif ($questionM->answer_type == 'text') {
                $answerM = $answerM->whereQuestion_id($key)->first();
                if ($answer == $answerM->answer) {
                    $points += $answerM->points;
                }
                $userAnswer = new UserTestAnswer;
                $userAnswer->question_id = $key;
                $userAnswer->answer = $answer;
                $userAnswer->user_id = Auth::user()->id;
                $userAnswer->attempt = $attempt;
                $userAnswer->save();
                $answerMM = $answerM->whereQuestion_id($key)->whereCorrect('yes')->get();
                foreach ($answerMM as $ans) {
                    $maxpoints += $ans->points;
                }
            }
        }
        $userResult->test_id = $testId;
        $userResult->user_id = Auth::user()->id;
        $userResult->points = $points;
        $userResult->max_points = $maxpoints;
        $userResult->attempt = $attempt;
        $userResult->save();
        Session::flash('success', 'You have successfuly submitted your answers!');
        return Redirect::route('courses.show', $courseId);
    }

}
