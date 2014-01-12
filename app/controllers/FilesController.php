<?php

class FilesController extends BaseController {

    protected $file;

    public function __construct(FileModel $file) {
        $this->file = $file;
        $this->beforeFilter('auth');
    }
    
    public function index($courseId){
        // get files for course
        $files = $this->file->where('course_id',$courseId)->get()->all();
        return View::make('files.files', ['files' => $files,'courseId' => $courseId]);
    }
    
    
    public function uploadFile(){
        //$input = Input::all();
        //$rules = array(
           // 'file' => 'maxsize:262144',
        //);

        //$validation = Validator::make($input, $rules);

        //if ($validation->fails()) {
          //  $errors = $validation->messages();
            //return Response::json($errors->first(), 400);
        //}

        $file = Input::file('file');
        $filesize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $courseId = Input::get('course_id');
        //generate random file name
        $filename = $file->getClientOriginalName();
        $directory = 'files/'.str_random(8);

        $uploadSuccess = $file->move($directory, $filename);
        
       

        if ($uploadSuccess) {
            //if file is uploaded sucessfully add new database entry and return success response
            $this->file->filename = $filename;
            $this->file->filepath = $directory;
            $this->file->filesize= $filesize;
            $this->file->user_id = Auth::user()->id;
            $this->file->mimetype =$fileMimeType;
            $this->file->course_id = $courseId;
            $this->file->save();
            return Response::json('success', 200);
        } else {
            //if file is not uploaded return error
            return Response::json('error', 400);
        }
    }
    
    
    
}