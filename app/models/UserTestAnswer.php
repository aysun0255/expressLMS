<?php

class UserTestAnswer extends Eloquent {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_test_answers';
    

    public function test() {
        return $this->belongsTo('Test');
    }

    public function user() {
        return $this->belongsTo('User');
    }

}

?>