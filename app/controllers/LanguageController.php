<?php

class LanguageController extends BaseController {

    protected $lang;

    public function __construct(Language $lang) {
        $this->lang = $lang;
        $this->beforeFilter('auth');
    }

    public function setLanguage($langCode) {
        $lang = $this->lang->whereCode($langCode)->first();
        if (count($lang) > 0) {
            $user = User::whereId(Auth::user()->id)->first();
            $user->language = $lang->code;
            $user->save();
            Session::flash('success', 'You have suceesfully changed your language settings!');
            if (Request::header('referer') != NULL) {
                return Redirect::back();
            } else {
                return Redirect::route('home');
            }
        } else {
            Session::flash('error', 'You have selected invalid language!');
            if (Request::header('referer') != NULL) {
                return Redirect::back();
            } else {
                return Redirect::route('home');
            }
        }
    }

}
