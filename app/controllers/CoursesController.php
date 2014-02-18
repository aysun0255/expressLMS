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
        $courses = $this->course->paginate(2);
        return View::make('courses.index', ['courses' => $courses]);
    }

    public function show($id) {
        //show the selected course page
        $course = $this->course->whereId($id)->first();
        //check if user is enroled
        if ($course->users->contains(Auth::user()->id) || ($course->allow_guest_access == 'yes' && $course->use_key == 'no')) {
            //if user is enroled show course page
            return View::make('courses.show', ['course' => $course]);
        } else {
            //if user is not enroled show enrolment page
            return View::make('courses.enrol', ['course' => $course]);
        }
    }

    public function create() {
        //Get info for user permission for creating a new course
        $canCreateCourse = $this->hasPermission(Auth::user()->id, 'can_create_course');
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
        $canCreateCourse = $this->hasPermission(Auth::user()->id, 'can_create_course');
        ;
        //Check for users permission to create course
        if ($canCreateCourse == 'yes') {
            $input = Input::all();
            if (!$this->course->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($this->course->errors);
            }
            $this->course->name = Input::get('name');
            $this->course->description = Input::get('description');
            $this->course->course_category_id = Input::get('category');
            $this->course->allow_guest_access = Input::get('allow_guest_access');
            $this->course->use_key = Input::get('use_key');
            $this->course->enrolment_key = Input::get('enrolment_key');
            $this->course->save();
            $course = $this->course->whereId($this->course->id)->first();
            $course->users()->attach(Auth::user()->id ,array('role' => 'teacher'));
            return View::make('pages.message', ['success' => 'You have successfully created new course!']);
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to create a new course!']);
        }
    }

    public function edit($id) {
        //show course edit form
        //check for user permissions

        $canEditCourses = $this->hasPermission(Auth::user()->id, 'can_edit_courses');
        if ($canEditCourses == 'yes') {
            // Locate the model and store it in a variable:
            $course = $this->course->whereId($id)->first();
            // Then pass it to view:   
            return View::make('courses.edit')->with(compact('course'));
        } else {
            //Return page with error message
            return View::make('pages.message', ['error' => 'You don\'t have permission to edit this course!']);
        }
    }

    public function update($id) {
        //Get info for user permission for editing a course
        $canEditCourse = $this->hasPermission(Auth::user()->id, 'can_edit_courses');
        //Check for users permission to edit course
        if ($canEditCourse == 'yes') {
            $input = Input::all();
            if (!$this->course->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($this->course->errors);
            }
            $course = $this->course->whereId($id)->first();
            $course->name = Input::get('name');
            $course->description = Input::get('description');
            $course->course_category_id = Input::get('category');
            $course->allow_guest_access = Input::get('allow_guest_access');
            $course->use_key = Input::get('use_key');
            $course->enrolment_key = Input::get('enrolment_key');
            $course->save();
            return View::make('pages.message', ['success' => 'Your changes have been saved!']);
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to edit this course!']);
        }
    }

    public function destroy($courseId) {
        $course = $this->course->whereId($courseId)->first();
        $course->delete();
        return View::make('pages.message', ['success' => 'You have deleted selected course!']);
    }

    /*
     * Enrol user to a course.
     */

    public function enrol() {
        $courseId = Input::get('course_id');
        $course = $this->course->whereId($courseId)->first();
        $users = Input::get('users');
        if (empty($users)) {
            if (($course->use_key == 'yes' && Input::get('enrolment_key') == $course->enrolment_key) || $course->use_key == 'no') {
                $course->users()->attach(Auth::user()->id ,array('role' => 'student'));
                //Redirect to course page
                return Redirect::route('courses.show', $courseId);
            } else {
                return Redirect::back()->withErrors('You have entered wrong enrolment key!');
            }
        } else {
            foreach ($users as $user) {
                $userPos = strpos($user, 'user_');
                if ($userPos !== false) {
                    $userId = ltrim($user, "user_");
                    $course->users()->attach($userId,array('role' => 'student'));
                }
            }
            Session::flash('success', 'You added new users to course!');
            return Redirect::route('courses.users', $courseId);
        }
    }

    public function users($id) {
        $course = $this->course->whereId($id)->first();
        $courseUsers = $course->users()->get()->all();
        return View::make('courses.users', ['courseUsers' => $courseUsers, 'course' => $course]);
    }

    public function unroll($courseId) {
        $course = $this->course->whereId($courseId)->first();
        $userId = Input::get('user_id');
        $course->users()->detach($userId);
        //Redirect to course page
        return Redirect::route('courses.users', $courseId);
    }

}

