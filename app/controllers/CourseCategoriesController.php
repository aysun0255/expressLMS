<?php

class CourseCategoriesController extends BaseController {

    protected $category;

    public function __construct(CourseCategory $category) {
        $this->category = $category;
        $this->beforeFilter('auth');
    }

    public function index() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $categories = $this->category->paginate(5);
            return View::make('admin.categories', ['categories' => $categories]);
        } else {
            Session::flash('error', 'You don\'t have permission to view selected page!');
            return Redirect::route('home');
        }
    }

    public function create() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            return View::make('admin.addCategory');
        } else {
            Session::flash('error', 'You don\'t have permission to add new category!');
            return Redirect::route('home');
        }
    }

    public function store() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $category = $this->category;
            $category->name = Input::get('name');
            $category->save();
            Session::flash('success', 'You have successfully created new category!');
            return Redirect::route('admincp.categories');
        } else {
            Session::flash('error', 'You don\'t have permission to add new category!');
            return Redirect::route('home');
        }
    }

    public function edit($categoryId) {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $category = $this->category->whereId($categoryId)->first();
            return View::make('admin.editCategory')->with(compact('category'));
        } else {
            Session::flash('error', 'You don\t have permission to edit selected category!');
            return Redirect::route('home');
        }
    }

    public function editDBEntry($categoryId) {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $category = $this->category->whereId($categoryId)->first();
            $category->name = Input::get('name');
            $category->save();
            Session::flash('success', 'You have successfully edited selected category!');
            return Redirect::route('admincp.categories');
        } else {
            Session::flash('error', 'You don\'t have permission to edit selected category!');
            return Redirect::route('home');
        }
    }

    public function destroy($categoryId) {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $category = $this->category->whereId($categoryId);
            $category->delete();
            Session::flash('success', 'You have successfully deleted selected category!');
            return Redirect::route('admincp.categories');
        } else {
            Session::flash('error', 'You don\'t have permission to delete selected category!');
            return Redirect::route('home');
        }
    }

}
