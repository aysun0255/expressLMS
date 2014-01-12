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
            return View::make('pages.message', ['error' => 'You dont have permission to add a lesson!']);
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
            return View::make('pages.message', ['success' => 'You have successfully added new section!']);
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to add a section!']);
        }
    }

    public function edit() {
        //ddddd
    }

    public function update() {
        
    }

    public function destroy($courseId,$sectionId) {
        $canDeleteSections = $this->hasPermission(Auth::user()->id, 'can_delete_sections');
        if ($canDeleteSections == 'yes') {
            $section = $this->section->whereId($sectionId)->first();
            $section->delete();
            return View::make('pages.message', ['success' => 'You have deleted selected course!']);
        } else {
            return View::make('pages.message', ['error' => 'You dont have permission to delete a section!']);
        }
    }

}