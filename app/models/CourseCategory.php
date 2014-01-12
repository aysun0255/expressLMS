<?php

class CourseCategory extends Eloquent {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_categories';

     public function courses() {
        return $this->hasMany('Course');
    }
}
