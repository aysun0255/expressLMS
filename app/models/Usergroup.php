<?php

class Usergroup extends Eloquent {

    public $timestamps = false;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usergroups';

        public function users() {
        return $this->hasMany('User');
    }

}