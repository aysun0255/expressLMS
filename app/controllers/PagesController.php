<?php




class PagesController extends BaseController {
    
    public function home() {
        $courses = Course::paginate(5);
        return View::make('pages.home',['courses' => $courses]);
    }
    
}
