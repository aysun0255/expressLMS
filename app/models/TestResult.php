<?php

class TestResult extends Eloquent {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'test_results';
    

    public function test() {
        return $this->belongsTo('Test');
    }

    public function user() {
        return $this->belongsTo('User');
    }

}

?>