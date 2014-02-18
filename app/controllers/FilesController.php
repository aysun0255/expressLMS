<?php

class FilesController extends BaseController {

    protected $file;

    public function __construct(Files $file) {
        $this->file = $file;
        $this->beforeFilter('auth');
    }

    public function index($courseId) {
        // get files for course
        $files = $this->file->where('course_id', $courseId)->get()->all();
        return View::make('files.files', ['files' => $files, 'courseId' => $courseId]);
    }

    public function uploadFile() {
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
        $fileMimeType = $file->getClientOriginalExtension();
        $courseId = Input::get('course_id');
        //generate random file name
        $filename = $file->getClientOriginalName();
        $directory = 'files/' . str_random(8);

        $uploadSuccess = $file->move($directory, $filename);



        if ($uploadSuccess) {
            //if file is uploaded sucessfully add new database entry and return success response
            $this->file->filename = $filename;
            $this->file->filepath = $directory;
            $this->file->filesize = $filesize;
            $this->file->user_id = Auth::user()->id;
            $this->file->mimetype = $fileMimeType;
            $this->file->course_id = $courseId;
            $this->file->save();
            return Response::json('success', 200);
        } else {
            //if file is not uploaded return error
            return Response::json('error', 400);
        }
    }

    public function destroy() {
        //get file info from input
        $fileId = Input::get('file_id');
        $filePath = Input::get('filepath');
        $fileName = Input::get('filename');
        $file = $filePath . '/' . $fileName;
        $courseId = Input::get('course_id');


        $deleteFileSuccess = unlink($file) && rmdir($filePath);
        $deleteDBEntrySuccess = $this->file->whereId($fileId)->delete();
        if ($deleteFileSuccess && $deleteDBEntrySuccess) {
            //set success message and return to avatars page
            Session::flash('success', 'Your file was deleted.');
            return Redirect::route('files', $courseId);
        } else {
            //set error message and return to avatars page
            Session::flash('error', 'There was error when deleting your file.Please try again later.');
            return Redirect::route('files', $courseId);
        }
    }

    public function downloadFile($courseId, $fileId) {
        $file = $this->file->whereId($fileId)->first();
        return Response::download($file->filepath . '/' . $file->filename);
    }

    public function submitAssignmentFile($courseId, $sectionId, $assignmentId) {
        $assignFile = new AssignmentFiles;
        $assigned = $assignFile;
        $assigned = $assigned->whereUser_id(Auth::user()->id)->whereAssignment_id($assignmentId)->first();
        //check if there is uploaded file
        //if there is a uploaded file delete it and upload the new file
        if (count($assigned) != 0) {
            $filePath = $assigned->filepath;
            $fileName = $assigned->filename;
            $file = $filePath . '/' . $fileName;
            unlink($file);
            rmdir($filePath);
            $assigned->delete();
            $courseId = Input::get('course_id');
            $file = Input::file('file');
            $filesize = $file->getSize();
            $fileMimeType = $file->getClientOriginalExtension();
            
            //generate random file name
            $filename = $file->getClientOriginalName();
            $directory = 'files/assignment_submissions/' . str_random(8);

            $uploadSuccess = $file->move($directory, $filename);



            if ($uploadSuccess) {
                //if file is uploaded sucessfully add new database entry and return success response
                $assignFile->filename = $filename;
                $assignFile->filepath = $directory;
                $assignFile->filesize = $filesize;
                $assignFile->user_id = Auth::user()->id;
                $assignFile->mimetype = $fileMimeType;
                $assignFile->assignment_id = $assignmentId;
                $assignFile->save();
                return Response::json('success', 200);
            } else {
                //if file is not uploaded return error
                return Response::json('error', 400);
            }
        } else {
            $file = Input::file('file');
            $filesize = $file->getSize();
            $fileMimeType = $file->getClientOriginalExtension();           
            //generate random file name
            $filename = $file->getClientOriginalName();
            $directory = 'files/assignment_submissions/' . str_random(8);

            $uploadSuccess = $file->move($directory, $filename);



            if ($uploadSuccess) {
                //if file is uploaded sucessfully add new database entry and return success response
                $assignFile->filename = $filename;
                $assignFile->filepath = $directory;
                $assignFile->filesize = $filesize;
                $assignFile->user_id = Auth::user()->id;
                $assignFile->mimetype = $fileMimeType;
                $assignFile->assignment_id = $assignmentId;
                $assignFile->save();
                return Response::json('success', 200);
            } else {
                //if file is not uploaded return error
                return Response::json('error', 400);
            }
        }
    }

     public function downloadAssignmentFile($courseId,$sectionId, $assignmentId) {
        $assignFile = new AssignmentFiles;
        $file = $assignFile->whereAssignment_id($assignmentId)->whereUser_id(Auth::user()->id)->first();
        return Response::download($file->filepath . '/' . $file->filename);
    }
}