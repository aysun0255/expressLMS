<?php

class QuestionAnswers extends Eloquent {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'question_answers';
    
    public static $rules = [
        'answer' => 'required',
        'points' => 'required',
    ];
    
       public function question() {
        return $this->belongsTo('Question');
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