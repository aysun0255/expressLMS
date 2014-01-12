<?php

/**
 * SearchController is used for the "smart" search throughout the site.
 * it returns and array of items (with type and icon specified) so that the selectize.js plugin can render the search results properly
 * */
class SearchController extends BaseController {

    public function appendValue($data, $type, $element) {
        // operate on the item passed by reference, adding the element and type
        foreach ($data as $key => & $item) {
            $item[$element] = $type;
        }
        return $data;
    }
    
        public function appendClassId($data,$element) {
        // operate on the item passed by reference, adding the element and type
        foreach ($data as $key => & $item) {
            $item[$element] = $item['class'].'_'.$item['id'];
        }
        return $data;
    }

    public function appendURL($data, $prefix) {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix . '/' . $item['username']);
        }
        return $data;
    }

    public function appendCourseURL($data, $prefix) {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix . '/' . $item['id']);
        }
        return $data;
    }

    public function appendUsername($data) {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['name'] = $item['username'];
        }
        return $data;
    }

    public function appendAvatar($data) {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $userAvatar = Avatar::whereId($item['avatar_id'])->get()->all();
            $avatar = $userAvatar[0]['avatar'];
            $item['icon'] = url('images/avatars/' . $avatar);
        }
        return $data;
    }

    public function index() {
        $query = e(Input::get('q', ''));

        if (!$query && $query == '')
            return Response::json(array(), 400);

        $users = User::where('username', 'like', '%' . $query . '%')
                        ->orderBy('username', 'asc')
                        ->take(5)
                        ->get(array('id', 'username', 'avatar_id'))->toArray();

        $courses = Course::where('name', 'like', '%' . $query . '%')
                ->take(5)
                ->get(array('id', 'name'))
                ->toArray();

        // Data normalization'

        $users = $this->appendUsername($users);
        $users = $this->appendAvatar($users);
        $users = $this->appendURL($users, 'users');
        $users = $this->appendValue($users, 'user', 'class');
        $users = $this->appendClassId($users, 'class_id');
        $courses = $this->appendCourseURL($courses, 'courses');
        $courses = $this->appendValue($courses, 'course', 'class');
        $courses = $this->appendClassId($courses, 'class_id');
        $courses = $this->appendValue($courses, url('images/course.png'), 'icon');


        // Merge all data into one array
        $data = array_merge($users, $courses);

        return Response::json(array(
                    'data' => $data
        ));
    }

}