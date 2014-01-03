<?php

class Lesson extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lessons';

    public function course() {
        return $this->belongsTo('Course');
    }

}