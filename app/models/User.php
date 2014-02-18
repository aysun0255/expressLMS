<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    public $timestamps = true;
    public static $rules = [
        'username' => 'required|between:3,15|alphanum|unique:users',
        'password' => 'required|between:6,20|confirmed',
        'password_confirmation' => 'required|between:6,20',
        'email' => 'required|email|between:3,64|unique:users|confirmed',
        'email_confirmation' => 'required|email|between:3,64',
        'first_name' => 'required|between:3,15|alpha',
        'last_name' => 'required|between:3,15|alpha',
        'secret_question' => 'required|between:3,35',
        'secret_answer' => 'required|between:3,35|alphanum',
        'gender' => 'required',
        'birthday' => 'required|date_format:Y-m-d',
    ];
    protected $fillable = ['username', 'password', 'first_name', 'last_name', 'email', 'gender', 'secret_question', 'secret_answer', 'birthday'];
    public $errors;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    public function courses() {
        return $this->belongsToMany('Course')->withPivot('role');
    }

    public function messages() {
        return $this->belongsToMany('Message')->withPivot('user_role', 'read');
    }

    public function usergroup() {
        return $this->belongsTo('Usergroup');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the user full name.
     *
     * @access public
     * @return string
     */
    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function isValid($data, $rules = 0) {
        //Check for using custom rules
        if ($rules == 0) {
            $rules = static::$rules;
        }
        $validation = Validator::make($data, $rules);
        if ($validation->passes()) {

            return true;
        }
        $this->errors = $validation->messages();
        return false;
    }

}