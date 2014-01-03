<?php

class Course extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    public function users() {
        return $this->hasMany('User');
    }

    public function lessons() {
        return $this->hasMany('Lesson');
    }

}