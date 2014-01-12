<?php

class AvatarsController extends BaseController {

    protected $avatar;

    public function __construct(Avatar $avatar) {
        $this->avatar = $avatar;
        $this->beforeFilter('auth');
    }

    public function avatar() {
        // get users avatars from DB and return avatars view
        $avatars = $this->avatar->whereUser_id(Auth::user()->id)->get()->all();
        return View::make('users.avatars', ['avatars' => $avatars]);
    }

    public function uploadAvatar() {
        $input = Input::all();
        $rules = array(
            'file' => 'image|max:3000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            $errors = $validation->messages();
            return Response::json($errors->first(), 400);
        }

        $file = Input::file('file');
        //generate random file name
        $filename = str_random(8) . '.' . $file->getClientOriginalExtension();
        $directory = 'images/avatars/';

        $uploadSuccess = $file->move($directory, $filename);

        if ($uploadSuccess) {
            //if avatar is uploaded sucessfully add new database entry and return success response
            $this->avatar->avatar = $filename;
            $this->avatar->user_id = Auth::user()->id;
            $this->avatar->save();
            return Response::json('success', 200);
        } else {
            //if avatar is not uploaded return error
            return Response::json('error', 400);
        }
    }

    public function deleteAvatar() {
        //get avatar info from input
        $avatarId = Input::get('avatar_id');
        $avatarFile = 'images/avatars/' . Input::get('avatar_file');

        $deleteFileSuccess = unlink($avatarFile);
        $deleteDBEntrySuccess = $this->avatar->whereId($avatarId)->delete();
        if ($deleteFileSuccess && $deleteDBEntrySuccess) {
            //set success message and return to avatars page
            Session::flash('success', 'Your avatar was deleted.');
            return Redirect::route('avatars');
        } else {
            //set error message and return to avatars page
            Session::flash('error', 'There was error when deleting your avatar.Please try again later.');
            return Redirect::route('avatars');
        }
    }
    
    public function useAvatar(){
        //get avatar info from input
        $avatarId = Input::get('avatar_id');
        //get user info from DB and update avatar_id
        $user = new User;
        $success = $user->whereId(Auth::user()->id)->update(array('avatar_id' => $avatarId));
        
        if ($success) {
            //set success message and return to avatars page
            Session::flash('success', 'You have changed your avatar successfuly.');
            return Redirect::route('avatars');
        } else {
            //set error message and return to avatars page
            Session::flash('error', 'There was error when changing your avatar.Please try again later.');
            return Redirect::route('avatars');
        }
    }

}