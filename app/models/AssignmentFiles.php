<?php

class AssignmentFiles extends Eloquent {

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignment_file_submissions';

    public function sections() {
        return $this->belongsTo('Assignment');
    }

}