<?php

class AssignmentAnswers extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignment_answer_submissions';

    public function sections() {
        return $this->belongsTo('Assignment');
    }

    
    public static $rules = [
        'answer' => 'required',
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