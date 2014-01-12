<?php

class MessagesController extends BaseController {

    protected $message;

    public function __construct(Message $message) {
        $this->message = $message;
        $this->beforeFilter('auth');
    }

    public function index() {
        // get files for course
        return 'Messages index page!!!';
    }

    public function create() {
        return View::make('messages.create');
    }

    public function store() {
        //get list of recievers and message subject and body
        $recievers = Input::get('recievers');
        $subject = Input::get('subject');
        $messageContent = Input::get('message');
        $message = $this->message;
        $message->subject = $subject;
        $message->message = $messageContent;
        //save message to DB
        $message->save();
        //get saved message id
        $messageId = $message->id;
        //attach message sender
        $message->users()->attach(Auth::user()->id, array('user_role' => 'sender', 'read' => 'yes'));

        foreach ($recievers as $reciever) {
            
            $coursePos = strpos($reciever, 'course_');
            if ($coursePos !== false) {
                $courseId = ltrim($reciever, "course_");
                $course = new Course;
                $course = $course->find($courseId);
                $courseUsers = $course->users;
                foreach ($courseUsers as $user) {
                    $userId = $user->id;
                    $message->users()->attach($userId, array('user_role' => 'reciever', 'read' => 'no'));
                }
            }
            
            $userPos = strpos($reciever, 'user_');
            if ($userPos !== false) {
                $userId = ltrim($reciever, "user_");
                $message->users()->attach($userId, array('user_role' => 'reciever', 'read' => 'no'));
            }
        }
        return 'Succcess!!!!!!!!!!!!';
    }

}

