<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//Activity filter. Gets current date and tima and updates users last activity info.
Route::filter('activity', function() {
            if (Auth::user()) {
                $user = Auth::user();
                $now = new DateTime();
                $user->last_activity = $now;
                $user->save();
            }
        });
Route::group(array('before' => 'activity'), function() {
            Route::get('/users/avatars', array('as' => 'avatars', 'uses' => 'AvatarsController@avatar'));
            Route::post('/users/avatars/upload', array('as' => 'avatars.upload', 'uses' => 'AvatarsController@uploadAvatar'));
            Route::post('/users/avatars/delete', array('as' => 'avatars.delete', 'uses' => 'AvatarsController@deleteAvatar'));
            Route::post('/users/avatars/use', array('as' => 'avatars.use', 'uses' => 'AvatarsController@useAvatar'));
            Route::post('/users/update', array('as' => 'users.updateInfo', 'uses' => 'UsersController@updateUserInfo'));
            Route::resource('users', 'UsersController');
            Route::get('/login', array('as' => 'login', 'uses' => 'AuthController@login'));
            Route::post('/login', 'AuthController@authUser');
            Route::get('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
            Route::get('/home', array('as' => 'home', 'uses' => 'PagesController@home'));
            Route::resource('courses', 'CoursesController');
            Route::post('courses/{id}/enrol', array('as' => 'courses.enrol', 'uses' => 'CoursesController@enrol'));
            Route::resource('courses.sections', 'CourseSectionsController');
            Route::get('/courses/{id}/files', array('as' => 'files', 'uses' => 'FilesController@index'));
            Route::post('/courses/{id}/files/upload', array('as' => 'files.upload', 'uses' => 'FilesController@uploadFile'));
            Route::get('api/search', 'SearchController@index');
            Route::resource('messages', 'MessagesController');
        }
);