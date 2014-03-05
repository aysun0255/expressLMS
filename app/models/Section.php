<?php

class Section extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

    public function course() {
        return $this->belongsTo('Course');
    }

    public function files() {
        return $this->belongsToMany('Files')->withPivot('title', 'description');
        ;
    }

    public function contents() {
        return $this->hasMany('Content');
    }

     public function tests() {
        return $this->hasMany('Test');
    }
      public function assignments() {
        return $this->hasMany('Assignment');
    }
    public function websites() {
        return $this->hasMany('Website');
    }

}