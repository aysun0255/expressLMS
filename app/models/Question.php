<?php

class Question extends Eloquent {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';
    public static $rules = [
        'question' => 'required',
    ];

    public function test() {
        return $this->belongsTo('Test');
    }

    public function answers() {
        return $this->hasMany('QuestionAnswers');
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