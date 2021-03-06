<?php

/**
 * Controller for users.For creating ,editing,deleting users and to show list of users.
 */
class UsersController extends BaseController {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
        $this->beforeFilter('auth', array('except' => array('create', 'store')));
    }

    public function index() {
        $users = $this->user->paginate(6);
        return View::make('users.index', ['users' => $users]);
    }

    public function show($username) {
        $user = $this->user->whereUsername($username)->first();
        return View::make('users.show', ['user' => $user]);
    }

    public function create() {
        //Check if user has been loged in
        if (Auth::check() && $this->hasPermission(Auth::user()->id, 'is_admin') != 'yes') {
            //If user has loged in redirect to home page
            return Redirect::route('home');
        }
     
        //Show signup form
        return View::make('users.create');
    }

    public function store() {
        //get the input data
        $input = Input::all();
        //Check if the input data is valid
        if (!$this->user->isValid($input)) {
            return Redirect::back()->withInput()->withErrors($this->user->errors);
        }

        $this->user->fill($input);
        $this->user->password = Hash::make(Input::get('password'));
        $this->user->save();
        //Redirect to the login page
            return Redirect::route('login');
    }

    public function edit($username) {
        //show user edit form
        //check for user permissions
        $canEditUsers = $this->hasPermission(Auth::user()->id, 'can_edit_users');
        if (Auth::user()->username == $username || $canEditUsers == 'yes') {
            // Locate the model and store it in a variable:
            $user = $this->user->whereUsername($username)->first();
            $formTitle = Auth::user()->username == $username ? 'Profile Settings' : 'Edit User Profile';
            // Then pass it to view:   
            return View::make('users.edit', ['title' => $formTitle])->with(compact('user'));
        } else {
            //Return page with error message
            Session::flash('error', 'You don\'t have permission to edit this user profile!');
            return Redirect::route('users.show', $username);
        }
    }

    public function updateUserInfo() {
        //Define custom rules for validation
        $rules = [
            'username' => 'required|between:3,15|alphanum',
            'email' => 'required|email|between:3,64',
            'first_name' => 'required|between:3,15|alpha',
            'last_name' => 'required|between:3,15|alpha',
            'gender' => 'required',
            'birthday' => 'required|date_format:Y-m-d',
            'facebook' => 'url',
            'twitter' => 'url',
            'website' => 'url',
            'skype' => 'max:40',
            'about_me' => 'max:500',
            'country' => 'max:70',
            'city' => 'max:70',
        ];
        //Get the input
        $input = Input::all();
        //Check if the input data is valid 
        if (!$this->user->isValid($input, $rules)) {
            return Redirect::back()->withInput()->withErrors($this->user->errors);
        }

        $username = Input::get('username');
        $user = $this->user->whereUsername($username)->first();
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $password = Input::get('password');
        if ($password != "") {
            $user->password = Hash::make($password);
        }
        $user->gender = Input::get('gender');
        $user->birthday = Input::get('birthday');
        $user->email = Input::get('email');
        $user->about_me = Input::get('about_me');
        $user->country = Input::get('country');
        $user->city = Input::get('city');
        $user->skype = Input::get('skype');
        $user->twitter = Input::get('twitter');
        $user->facebook = Input::get('facebook');
        $user->linked_in = Input::get('linked_in');
        $user->google_plus = Input::get('google_plus');
        $user->website = Input::get('website');
        $user->save();

        //Return view with succes message
        Session::flash('success', 'You have successfuly updated your profile!');
        return Redirect::route('users.show', $username);
    }

    public function destroy($userId) {
        $canDeleteUsers = $this->hasPermission(Auth::user()->id, 'can_delete_users');
        if (Auth::user()->id != $userId && $canDeleteUsers == 'yes') {
            $user = $this->user->whereId($userId)->first();
            $user->delete();
            Session::flash('success', 'You have deleted selected user!');
            return Redirect::route('users.index');
        } else {
            Session::flash('error', 'You don\'t have permission to delete this user profile!');
            return Redirect::route('users.index');
        }
    }

}
