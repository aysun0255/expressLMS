<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Courses Controller
 *
 * @author User
 */
class CoursesController extends BaseController {

    protected $course;

    public function __construct(Course $course) {
        $this->course = $course;
        $this->beforeFilter('auth');
    }

    public function index() {
        // list of all courses
        $courses = $this->course->all();
        return View::make('courses.index', ['courses' => $courses]);
    }

    public function show($id) {
        //show the selected course page
        $course = $this->course->whereId($id)->first();
        return View::make('courses.show',['course' => $course]);
    }

    public function create() {
        //Get info for user permission for creating a new course
        $user = new User;
        $canCreateCourse = $user->whereId(Auth::user()->id)->first()->usergroup->can_create_course;
        //Check for users permission to create course
        if ($canCreateCourse == 'yes') {
            //If user have permission show create form
            return View::make('courses.create');
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to create a new course!']);
        }
    }

    public function store() {
        //Get info for user permission for creating a new course
        $user = new User;
        $canCreateCourse = $user->whereId(Auth::user()->id)->first()->usergroup->can_create_course;
        //Check for users permission to create course
        if ($canCreateCourse == 'yes') {
            $this->course->name = Input::get('name');
            $this->course->description = Input::get('description');
            $this->course->save();
            return View::make('pages.message', ['success' => 'You have successfully created new course!']);
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to create a new course!']);
        }
    }

    public function edit($id) {
        //edit course details
    }

}

