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
Route::filter('language', function() {
    if (!empty(Auth::user()->language) && Auth::user()->language != App::getLocale()) {
        App::setLocale(Auth::user()->language);
    }
});
Route::group(array('before' => array('activity', 'language')), function() {
    Route::get('/users/avatars', array('as' => 'avatars', 'uses' => 'AvatarsController@avatar'));

    Route::post('/users/avatars/upload', array('as' => 'avatars.upload', 'uses' => 'AvatarsController@uploadAvatar'));

    Route::post('/users/avatars/delete', array('as' => 'avatars.delete', 'uses' => 'AvatarsController@deleteAvatar'));

    Route::post('/users/avatars/use', array('as' => 'avatars.use', 'uses' => 'AvatarsController@useAvatar'));

    Route::post('/users/update', array('as' => 'users.updateInfo', 'uses' => 'UsersController@updateUserInfo'));

    Route::resource('users', 'UsersController');

    Route::get('/login', array('as' => 'login', 'uses' => 'AuthController@login'));

    Route::post('/login', 'AuthController@authUser');

    Route::get('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

    Route::get('/', array('as' => 'home', 'uses' => 'PagesController@home'));

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

      Route::get('/courses/{id}/sections/{sectionId}/removeassignment/{assignmentId}', array('as' => 'assignment.remove', 'uses' => 'SectionContentController@removeAssignment'));
    
    Route::post('/courses/{id}/sections/{sectionId}/editassignment/{assignmentId}', array('as' => 'assignment.editDBEntry', 'uses' => 'SectionContentController@editAssignmentDBEntry'));

    Route::post('/courses/{id}/sections/{sectionId}/submitfile/{assignmentId}', array('as' => 'assignment.submitFile', 'uses' => 'FilesController@submitAssignmentFile'));

    Route::post('/courses/{id}/sections/{sectionId}/assignmnet/{assignmentId}/submitanswer', array('as' => 'assignment.submitAnswer', 'uses' => 'SectionContentController@submitAssignmentAnswer'));

    Route::get('/courses/{id}/sections/{sectionId}/assignment/{assignmentId}/submissions', array('as' => 'assignment.submissions', 'uses' => 'SectionContentController@assignmentSubmissions'));

    Route::post('/courses/{id}/sections/{sectionId}/assignment/{assignmentId}/acceptsubmission', array('as' => 'assignment.acceptSubmission', 'uses' => 'SectionContentController@acceptAssignmentSubmission'));

    Route::get('/courses/{id}/sections/{sectionId}/addtest', array('as' => 'test.add', 'uses' => 'TestsController@create'));

    Route::post('/courses/{id}/sections/{sectionId}/addtest', array('as' => 'test.addDBEntry', 'uses' => 'TestsController@store'));

    Route::get('/courses/{id}/sections/{sectionId}/edittest/{testId}', array('as' => 'test.edit', 'uses' => 'TestsController@edit'));

    Route::post('/courses/{id}/sections/{sectionId}/edittest/{testId}', array('as' => 'test.editDBEntry', 'uses' => 'TestsController@editDBEntry'));

    Route::get('/courses/{id}/sections/{sectionId}/removetest/{testId}', array('as' => 'test.remove', 'uses' => 'TestsController@destroy'));

    Route::get('/courses/{id}/sections/{sectionId}/showtest/{testId}', array('as' => 'test.show', 'uses' => 'TestsController@show'));

    Route::get('/courses/{id}/sections/{sectionId}/showtest/{testId}/attempt/{attempt}', array('as' => 'test.showAttemptResult', 'uses' => 'TestsController@showAttempt'));

    
    Route::get('/courses/{id}/sections/{sectionId}/test/{testId}/addquestion', array('as' => 'test.addQuestion', 'uses' => 'TestsController@addQuestion'));

    Route::post('/courses/{id}/sections/{sectionId}/test/{testId}/addquestion', array('as' => 'test.addQuestionDBEntry', 'uses' => 'TestsController@addQuestionDBentry'));

    Route::post('/courses/{id}/sections/{sectionId}/test/{testId}/evaluate', array('as' => 'test.evaluate', 'uses' => 'TestsController@evaluateTest'));
    
    Route::get('/courses/{id}/files', array('as' => 'files', 'uses' => 'FilesController@index'));

    Route::post('/courses/{id}/files/upload', array('as' => 'files.upload', 'uses' => 'FilesController@uploadFile'));

    Route::delete('/courses/{id}/files', array('as' => 'files.destroy', 'uses' => 'FilesController@destroy'));

    Route::get('api/search', 'SearchController@index');

    Route::get('api/search/user', 'SearchController@user');

    Route::get('/calendar', array('as' => 'calendar', 'uses' => 'CalendarController@index'));

    Route::get('/calendar/events', array('as' => 'calendar.getEvents', 'uses' => 'CalendarController@getEvents'));

    Route::get('/setlanguage/{langCode}', array('as' => 'setLanguage', 'uses' => 'LanguageController@setLanguage'));

    Route::get('messages/outgoing', array('as' => 'messages.outgoing', 'uses' => 'MessagesController@outgoing'));

    Route::resource('messages', 'MessagesController');

    Route::get('/password/remind/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'remind', 'uses' => 'RemindersController@getRemind'));

    Route::post('/password/remind/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'remind.post', 'uses' => 'RemindersController@postRemind'));

    Route::get('/password/reset/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'reset', 'uses' => 'RemindersController@getReset'));

    Route::post('/password/reset/{one?}/{two?}/{three?}/{four?}/{five?}', array('as' => 'reset.post', 'uses' => 'RemindersController@postReset'));

    Route::get('/password/{_missing}', array('as' => 'missing', 'uses' => 'RemindersController@missingMethod'));

    Route::get('/admincp', array('as' => 'admincp', 'uses' => 'AdminCPController@index'));
    
    Route::get('/admincp/config', array('as' => 'admincp.config', 'uses' => 'AdminCPController@config'));
    
    Route::post('/admincp/config', array('as' => 'admincp.configUpdate', 'uses' => 'AdminCPController@configUpdate'));
    
    Route::get('/admincp/reports', array('as' => 'admincp.reports', 'uses' => 'AdminCPController@reports'));
    
    Route::get('/admincp/categories', array('as' => 'admincp.categories', 'uses' => 'CourseCategoriesController@index'));
    
    Route::get('/admincp/categories/create', array('as' => 'admincp.categories.create', 'uses' => 'CourseCategoriesController@create'));
    
    Route::post('/admincp/categories/create', array('as' => 'admincp.categories.store', 'uses' => 'CourseCategoriesController@store'));
    
    Route::get('/admincp/categories/{categoryId}/remove', array('as' => 'admincp.categories.remove', 'uses' => 'CourseCategoriesController@destroy'));
    
    Route::get('/admincp/categories/{categoryId}/edit', array('as' => 'admincp.categories.edit', 'uses' => 'CourseCategoriesController@edit'));
    
    Route::post('/admincp/categories/{categoryId}/edit', array('as' => 'admincp.categories.editDBEntry', 'uses' => 'CourseCategoriesController@editDBEntry'));
}
);
