<?php

class Content extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'section_content';
    
    public static $rules = [
        'title' => 'required',
        'content' => 'required',
    ];
    
       public function section() {
        return $this->belongsTo('Section');
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