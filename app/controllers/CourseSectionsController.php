<?php

class CourseSectionsController extends BaseController {

    protected $section;

    public function __construct(Section $section) {
        $this->section = $section;
        $this->beforeFilter('auth');
    }

    public function create($id) {
        //Get info for user permission for creating a new course
        //$user = new User;
        //$canAddSections = $user->whereId(Auth::user()->id)->first()->usergroup->can_add_sections;
        $canAddSections = $this->hasPermission(Auth::user()->id, 'can_add_sections');
        if ($canAddSections == 'yes') {
            //If user have permission show create form
            return View::make('sections.create', ['courseId' => $id]);
        } else {
            Session::flash('error', 'You don\'t have permission to add new section!');
            return Redirect::route('courses.show', $id);
        }
    }

    public function store() {
        //Get info for user permission for creating a new course
        $canAddSections = $this->hasPermission(Auth::user()->id, 'can_add_sections');
        //Check for users permission to create course
        if ($canAddSections == 'yes') {
            $this->section->name = Input::get('name');
            $this->section->description = Input::get('description');
            $this->section->visible = Input::get('visible');
            $this->section->course_id = Input::get('course_id');
            $this->section->save();
            Session::flash('success', 'You have successfully added new section!');
            return Redirect::route('courses.index');
        } else {
            Session::flash('error', 'You don\'t have permission to add new section!');
            return Redirect::route('courses.index');
        }
    }

    public function edit($courseId, $sectionId) {
        //show section edit form
        //check for user permissions

        $canEditSections = $this->hasPermission(Auth::user()->id, 'can_edit_sections');
        if ($canEditSections == 'yes') {
            // Locate the model and store it in a variable:
            $course = Course::whereId($courseId)->first();
            $section = $course->sections()->whereId($sectionId)->first();
            // Then pass it to view:   
            return View::make('sections.edit', ['course' => $course])->with(compact('section'));
        } else {
            //Return page with error message
            Session::flash('error', 'You don\'t have permission to edit this section!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function update() {
        //Get info for user permission for creating a new course
        $canEditSections = $this->hasPermission(Auth::user()->id, 'can_edit_sections');
        //Check for users permission to create course
        if ($canEditSections == 'yes') {
            $section = $this->section->whereId(Input::get('section_id'))->first();
            $section->name = Input::get('name');
            $section->description = Input::get('description');
            $section->visible = Input::get('visible');
            $section->course_id = Input::get('course_id');
            $section->save();
            Session::flash('success', 'You have successfuly edited selected section!');
            return Redirect::route('courses.show', Input::get('course_id'));
        } else {
            Session::flash('error', 'You don\'t have permission to edit selected section !');
            return Redirect::route('courses.show', Input::get('course_id'));
        }
    }

    public function destroy($courseId, $sectionId) {
        $canDeleteSections = $this->hasPermission(Auth::user()->id, 'can_delete_sections');
        if ($canDeleteSections == 'yes') {
            $section = $this->section->whereId($sectionId)->first();
            $section->delete();
            Session::flash('success', 'You have deleted selected section!');
            return Redirect::route('courses.index');
        } else {
            Session::flash('error', 'You don\'t have permission to delete selected section!');
            return Redirect::route('courses.index');
        }
    }

}