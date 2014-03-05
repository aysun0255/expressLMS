<?php

class Files extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';
    
    
     public function sections() {
        return $this->belongsToMany('Section')->withPivot('title','description');;
    }
    
    
}