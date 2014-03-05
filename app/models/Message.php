<?php

class Message extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';
    
    
    public function users(){
        
        return $this->belongsToMany('User')->withPivot('user_role', 'read');
    }
    
    
}