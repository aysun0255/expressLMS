<?php

class AdminCPController extends BaseController {

    protected $avatar;

    public function __construct(Avatar $avatar) {
        $this->avatar = $avatar;
        $this->beforeFilter('auth');
    }

    public function index() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            return View::make('admin.index');
        } else {
            Session::flash('error', 'You don\'t have permission to view selected page!');
            return Redirect::route('home');
        }
    }

    public function reports() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $registeredUsers = count(User::get());
            $courses = count(Course::get());
            $categories = count(CourseCategory::get());
            return View::make('admin.reports', ['registeredUsers' => $registeredUsers, 'courses' => $courses, 'categories' => $categories]);
        } else {
            Session::flash('error', 'You don\'t have permission to view selected page!');
            return Redirect::route('home');
        }
    }

    public function config() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $config = SiteConfig::get();
            return View::make('admin.config', ['config' => $config]);
        } else {
            Session::flash('error', 'You don\'t have permission to view selected page!');
            return Redirect::route('home');
        }
    }

    public function configUpdate() {
        if ($this->hasPermission(Auth::user()->id, 'is_admin') == 'yes') {
            $config = SiteConfig::get();
            foreach ($config as $conf) {
                $sConfig = SiteConfig::whereRule($conf->rule)->first();
                $sConfig->value = Input::get($conf->rule);
                $sConfig->save();
                Session::flash('success', 'You have saved new settings successfully!');
                return Redirect::route('admincp');
            }
        } else {
            Session::flash('error', 'You don\'t have permission to view selected page!');
            return Redirect::route('home');
        }
    }

}
