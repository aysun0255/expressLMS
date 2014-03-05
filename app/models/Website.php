<?php

class Website extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'websites';

    public function sections() {
        return $this->belongsTo('Section');
    }
    public static $rules = [
        'title' => 'required',
        'link' => 'required',
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