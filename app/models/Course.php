<?php

class Course extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';
    
    //Default validation rules
    public static $rules = [
        'name' => 'required|min:3',
        'description' => 'required|between:3,500',
    ];

    public function users() {
        return $this->belongsToMany('User');
    }

    public function lessons() {
        return $this->hasMany('Lesson');
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