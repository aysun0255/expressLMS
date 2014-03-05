<?php

class Assignment extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignments';

    public function sections() {
        return $this->belongsTo('Section');
    }

    public function files() {
        return $this->hasMany('AssignmentFiles');
    }

    public function answers() {
        return $this->hasMany('AssignmentAnswers');
    }

    public static $rules = [
        'name' => 'required',
        'intro' => 'required',
        'timedue' => 'required',
        'max_points' => 'required',
    ];

    public function isValid($data) {
        //Check for using custom rules

        $rules = static::$rules;
        $validation = Validator::make($data, $rules);
        if ($validation->passes()) {

            return true;
        }
        $this->errors = $validation->messages();
        return false;
    }

}