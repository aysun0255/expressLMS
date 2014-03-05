<?php

class Test extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tests';
    public static $rules = [
        'name' => 'required',
        'timedue' => 'required',
    ];

    public function section() {
        return $this->belongsTo('Section');
    }

    public function questions() {
        return $this->hasMany('Question');
    }

    public function results() {
        return $this->hasMany('TestResult');
    }

    public function userAnswers() {
        return $this->hasMany('UserTestAnswer');
    }

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

?>