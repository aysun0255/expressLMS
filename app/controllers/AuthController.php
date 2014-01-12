<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
 *
 * @author User
 */
class AuthController extends BaseController {

    public function login() {
        //Check if user has been loged in
        if (Auth::check()) {
            //If user has loged in redirect to home page
            return Redirect::route('home');
        }
        // Show the login page
        return View::make('auth.login');
    }

    public function authUser() {
        $user = array('username' => Input::get('username'),
            'password' => Input::get('password'));
        $remember = (Input::get('remember') == 'remember_me') ? true : false;

        if (Auth::attempt($user, $remember)) {
            return Redirect::intended('home');
        } else {
            //user login has errors go back and show errors
            // Redirect back to the login page.
            return Redirect::back()->withErrors(array('error' => 'Invalid username or password'))->withInput(Input::except('password'));
        }
    }

    public function logout() {
        //Log user out and redirect to home page
        Auth::logout();
        return Redirect::to('home');
    }

}

