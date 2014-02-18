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
            Route::post('courses/{id}/unroll', array('as' => 'courses.unroll', 'uses' => 'CoursesController@unroll'));
            Route::get('courses/{id}/users', array('as' => 'courses.users', 'uses' => 'CoursesController@users'));
            Route::resource('courses.sections', 'CourseSectionsController');
            Route::get('/courses/{id}/sections/{sectionId}/addfile', array('as' => 'sections.addfile', 'uses' => 'SectionContentController@addFile'));
            Route::post('/courses/{id}/sections/{sectionId}/addfile', array('as' => 'sections.addFileDBEntry', 'uses' => 'SectionContentController@addFileDBEntry'));
            Route::get('/courses/{id}/downloadfile/{fileId}', array('as' => 'files.download', 'uses' => 'FilesController@downloadFile'));
            Route::get('/courses/{id}/sections/{sectionId}/removefile/{fileId}', array('as' => 'files.remove', 'uses' => 'SectionContentController@removeFileDBEntry'));
            Route::get('/courses/{id}/sections/{sectionId}/addcontent', array('as' => 'content.add', 'uses' => 'SectionContentController@addContent'));
            Route::post('/courses/{id}/sections/{sectionId}/addcontent', array('as' => 'content.addToDB', 'uses' => 'SectionContentController@addContentToDB'));
            Route::get('/courses/{id}/sections/{sectionId}/showcontent/{contentId}', array('as' => 'content.show', 'uses' => 'SectionContentController@showContent'));
            Route::get('/courses/{id}/sections/{sectionId}/removecontent/{contentId}', array('as' => 'content.remove', 'uses' => 'SectionContentController@removeContent'));
            Route::get('/courses/{id}/sections/{sectionId}/editcontent/{contentId}', array('as' => 'content.edit', 'uses' => 'SectionContentController@editContent'));
            Route::post('/courses/{id}/sections/{sectionId}/editcontent/{contentId}', array('as' => 'content.editDBEntry', 'uses' => 'SectionContentController@editContentDBEntry'));
            Route::get('/courses/{id}/sections/{sectionId}/addwebsite', array('as' => 'website.add', 'uses' => 'SectionContentController@addWebsite'));
            Route::post('/courses/{id}/sections/{sectionId}/addwebsite', array('as' => 'website.addDBEntry', 'uses' => 'SectionContentController@addWebsiteDBEntry'));
            Route::get('/courses/{id}/sections/{sectionId}/editwebsite/{websiteId}', array('as' => 'website.edit', 'uses' => 'SectionContentController@editWebsite'));
            Route::post('/courses/{id}/sections/{sectionId}/editwebsite/{websiteId}', array('as' => 'website.editDBEntry', 'uses' => 'SectionContentController@editWebsiteDBEntry'));           
            Route::get('/courses/{id}/sections/{sectionId}/removewebsite/{websiteId}', array('as' => 'website.remove', 'uses' => 'SectionContentController@removeWebsite'));
            Route::get('/courses/{id}/sections/{sectionId}/addassignment', array('as' => 'assignment.add', 'uses' => 'SectionContentController@addAssignment'));
            Route::post('/courses/{id}/sections/{sectionId}/addassignment', array('as' => 'assignment.addDBEntry', 'uses' => 'SectionContentController@addAssignmentDBEntry'));
            Route::get('/courses/{id}/sections/{sectionId}/showassignment/{assignmentId}', array('as' => 'assignment.show', 'uses' => 'SectionContentController@showAssignment'));
            Route::get('/courses/{id}/sections/{sectionId}/showassignment/{assignmentId}/downloadfile', array('as' => 'assignment.download', 'uses' => 'FilesController@downloadAssignmentFile')); 
            Route::get('/courses/{id}/sections/{sectionId}/editassignment/{assignmentId}', array('as' => 'assignment.edit', 'uses' => 'SectionContentController@editAssignment'));
            Route::post('/courses/{id}/sections/{sectionId}/editassignment/{assignmentId}', array('as' => 'assignment.editDBEntry', 'uses' => 'SectionContentController@editAssignmentDBEntry'));
            Route::post('/courses/{id}/sections/{sectionId}/submitfile/{assignmentId}', array('as' => 'assignment.submitFile', 'uses' => 'FilesController@submitAssignmentFile'));
            Route::post('/courses/{id}/sections/{sectionId}/assignmnet/{assignmentId}/submitanswer', array('as' => 'assignment.submitAnswer', 'uses' => 'SectionContentController@submitAssignmentAnswer'));          
            Route::get('/courses/{id}/files', array('as' => 'files', 'uses' => 'FilesController@index'));
            Route::post('/courses/{id}/files/upload', array('as' => 'files.upload', 'uses' => 'FilesController@uploadFile'));
            Route::delete('/courses/{id}/files', array('as' => 'files.destroy', 'uses' => 'FilesController@destroy'));
            Route::get('api/search', 'SearchController@index');
            Route::get('api/search/user', 'SearchController@user');
            Route::get('/calendar', array('as' => 'calendar', 'uses' => 'CalendarController@index'));
            Route::get('/calendar/events', array('as' => 'calendar.getEvents', 'uses' => 'CalendarController@getEvents'));
            Route::get('messages/outgoing', array('as' => 'messages.outgoing', 'uses' => 'MessagesController@outgoing'));
            Route::resource('messages', 'MessagesController');
            Route::get('/password/remind/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'remind', 'uses' => 'RemindersController@getRemind'));
            Route::post('/password/remind/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'remind.post', 'uses' => 'RemindersController@postRemind'));
            Route::get('/password/reset/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'reset', 'uses' => 'RemindersController@getReset'));
            Route::post('/password/reset/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'reset.post', 'uses' => 'RemindersController@postReset'));
            Route::get('/password/{_missing}', array('as' => 'missing', 'uses' => 'RemindersController@missingMethod'));
        }
);