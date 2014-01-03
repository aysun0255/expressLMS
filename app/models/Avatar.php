<?php



class Avatar extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_avatars';
    
    public $timestamps = false;
}