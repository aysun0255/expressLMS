<?php

class MessagesController extends BaseController {

    protected $message;

    public function __construct(Message $message) {
        $this->message = $message;
        $this->beforeFilter('auth');
    }

    public function index() {
        // get user messages
        $user = new User;
        $userMessages = $user->find(Auth::user()->id)->messages()->where('message_user.user_role', 'reciever')->get();
        return View::make('messages.index', ['messages' => $userMessages]);
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
        Session::flash('success', 'Your message was sent sucessfully!');
        return Redirect::route('messages.index');
    }

    public function show($id) {
        //show the selected message
        $message = $this->message->whereId($id)->first();
        //check if user is reciever or sender of the message
        if ($message->users->contains(Auth::user()->id)) {
            //if user is enroled show course page
            return View::make('messages.show', ['message' => $message]);
        } else {
            //if user dont have acces show error page
            return View::make('pages.message', ['error' => 'You dont have permission to read this message']);
        }
    }

    public function outgoing() {
        // get outgoing messages
        $user = new User;
        $userMessages = $user->find(Auth::user()->id)->messages()->where('message_user.user_role', 'sender')->get();
        return View::make('messages.outgoing', ['messages' => $userMessages]);
    }

    public function destroy() {
        $messageId = Input::get('message_id');
        $message = $this->message;
        $message = $message->find($messageId);
        $userRole = $message->find($messageId)->users()->where('message_user.user_id', Auth::user()->id)->get()->first()->pivot->user_role;
        $oppositeRole = $userRole == 'sender' ? 'reciever' : 'sender';
        //->users()->where('message_user.user_id', Auth::user()->id)->get()->first()
        $messageCount = count($message->users()->where('message_user.user_role', $oppositeRole)->get());
        if ($messageCount > 0) {
            $message->users()->detach(Auth::user()->id);
            Session::flash('success', 'Your message was deleted sucessfully!');
            return Redirect::back();
        } else {
            $message->users()->detach(Auth::user()->id);
            $message->delete();
             Session::flash('success', 'Your message was deleted sucessfully!');
            return Redirect::back();
        }
    }

}

