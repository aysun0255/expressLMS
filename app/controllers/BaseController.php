<?php

use Illuminate\Routing\Controller;

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    //Check for user permissions
    public function hasPermission($userId, $permission) {
        $user = new User;
        return $user->whereId($userId)->first()->usergroup->$permission;
    }

    //check user role in given course
    public function userRole($courseId, $userId) {
        $course = Course::whereId($courseId)->first();
        if ($course->users->contains($userId)) {
            $userRole = $course->users()->whereId($userId)->first()->pivot->role;
        } else {
            $userRole = 'student';
        }

        return $userRole;
    }

}