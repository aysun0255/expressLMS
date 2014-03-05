<?php

class SectionContentController extends BaseController {

    protected $section;

    public function __construct(Section $section) {
        $this->section = $section;
        $this->beforeFilter('auth');
    }

    public function addFile($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('sections.addFile', ['courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\t have permission to add file!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addFileDBEntry($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $title = Input::get('title');
            $description = Input::get('description');
            $fileId = Input::get('file');
            $section = $this->section;
            $section = $section->whereId($sectionId)->first();
            $section->files()->attach($fileId, array('title' => $title, 'description' => $description));
            Session::flash('success', 'You added selected file successfuly!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to add file!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function removeFileDBEntry($courseId, $sectionId, $fileId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $title = Input::get('title');
            $description = Input::get('description');
            //$fileId = Input::get('file');
            $section = $this->section;
            $section = $section->whereId($sectionId)->first();
            $section->files()->detach($fileId);
            Session::flash('success', 'You have deleted selected file successfuly!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to delete this file!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addContent($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('sections.addContent', ['courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\t have permission to add content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addContentToDB($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $content = new Content;
            $input = Input::all();
            //validation
            if (!$content->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($content->errors);
            }
            $title = Input::get('title');
            $contentInput = Input::get('content');
            $content->title = $title;
            $content->content = $contentInput;
            $content->section_id = $sectionId;
            $content->save();
            Session::flash('success', 'You have sucessfully added new content!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to add content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function showContent($courseId, $sectionId, $contentId) {
        $course = Course::whereId($courseId)->first();
        //check if user is enroled
        if (!($course->users->contains(Auth::user()->id) || ($course->allow_guest_access == 'yes' && $course->use_key == 'no'))) {

            return View::make('courses.enrol', ['course' => $course]);
        }

        $content = new Content;
        $content = $content->whereId($contentId)->first();
        return View::make('sections.showContent', ['content' => $content]);
    }

    public function removeContent($courseId, $sectionId, $contentId) {
        //check for user permission
        $userRole = $this->userRole($courseId, Auth::user()->id);

        if ($userRole == 'teacher') {
            $content = new Content;
            $content = $content->whereId($contentId)->first();
            $content->delete();
            Session::flash('success', 'Content was deleted sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to delete this content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function editContent($courseId, $sectionId, $contentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);

        if ($userRole == 'teacher') {
            $content = Content::whereId($contentId)->first();
            return View::make('sections.editContent', ['courseId' => $courseId, 'sectionId' => $sectionId, 'contentId' => $contentId])->with(compact('content'));
        } else {
            Session::flash('error', 'You don\t have permission to edit this content!');
            return Redirect::route('content.show', array($courseId, $sectionId, $contentId));
        }
    }

    public function editContentDBEntry($courseId, $sectionId, $contentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $content = Content::whereId($contentId)->first();
            $input = Input::all();
            //validation
            if (!$content->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($content->errors);
            }
            $content->title = Input::get('title');
            $content->content = Input::get('content');
            $content->save();
            Session::flash('success', 'Content was edited sucessfully!');
            return Redirect::route('content.show', array($courseId, $sectionId, $contentId));
        } else {
            Session::flash('error', 'You don\t have permission to edit this content!');
            return Redirect::route('content.show', array($courseId, $sectionId, $contentId));
        }
    }

    public function addWebsite($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('sections.addWebsite', ['courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\t have permission to add web content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addWebsiteDBEntry($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $website = new Website;
            $input = Input::all();
            //validation
            if (!$website->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($website->errors);
            }
            $website->title = Input::get('title');
            $website->link = Input::get('link');
            $website->section_id = Input::get('section_id');
            $website->save();
            Session::flash('success', 'Web content was added sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to add web content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function removeWebsite($courseId, $sectionId, $websiteId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $website = Website::whereId($websiteId)->first();
            $website->delete();
            Session::flash('success', 'Web content was deleted sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to delete  selected web content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function editWebsite($courseId, $sectionId, $websiteId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $website = Website::whereId($websiteId)->first();
            return View::make('sections.editWebsite', ['courseId' => $courseId, 'sectionId' => $sectionId, 'websiteId' => $websiteId])->with(compact('website'));
        } else {
            Session::flash('error', 'You don\t have permission to edit  selected web content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function editWebsiteDBEntry($courseId, $sectionId, $websiteId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $website = new Website;
            $website = $website->whereId($websiteId)->first();
            $input = Input::all();
            //validation
            if (!$website->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($website->errors);
            }
            $website->title = Input::get('title');
            $website->link = Input::get('link');
            $website->section_id = Input::get('section_id');
            $website->save();
            Session::flash('success', 'Web content was edited sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to edit  selected web content!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addAssignment($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            return View::make('sections.addAssignment', ['courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\t have permission to add assignment!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function addAssignmentDBEntry($courseId, $sectionId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $assignment = new Assignment;
            $input = Input::all();
            //validation
            if (!$assignment->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($assignment->errors);
            }
            $assignment->name = Input::get('name');
            $assignment->intro = Input::get('intro');
            $assignment->timedue = Input::get('timedue');
            $assignment->submit_type = Input::get('submission_type');
            $assignment->section_id = Input::get('section_id');
            $assignment->max_points = Input::get('max_points');
            $assignment->save();
            Session::flash('success', 'Assignment was added sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to add assignment!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function editAssignment($courseId, $sectionId, $assignmentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $assignment = Assignment::whereId($assignmentId)->first();
            return View::make('sections.editAssignment', ['courseId' => $courseId, 'sectionId' => $sectionId, 'assignmentId' => $assignmentId])->with(compact('assignment'));
        } else {
            Session::flash('error', 'You don\t have permission to edit selected assignment!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function editAssignmentDBEntry($courseId, $sectionId, $assignmentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $assignment = new Assignment;
            $input = Input::all();
            //validation
            if (!$assignment->isValid($input)) {
                return Redirect::back()->withInput()->withErrors($assignment->errors);
            }
            $assignment = $assignment->whereId($assignmentId)->first();
            $assignment->name = Input::get('name');
            $assignment->intro = Input::get('intro');
            $assignment->timedue = Input::get('timedue');
            $assignment->submit_type = Input::get('submission_type');
            $assignment->section_id = Input::get('section_id');
            $assignment->max_points = Input::get('max_points');
            $assignment->save();
            Session::flash('success', 'Assignment was edited sucessfully!');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\t have permission to edit selected assignment!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function showAssignment($courseId, $sectionId, $assignmentId) {
        $course = Course::whereId($courseId)->first();
        //check if user is enroled
        if (!($course->users->contains(Auth::user()->id) || ($course->allow_guest_access == 'yes' && $course->use_key == 'no'))) {

            return View::make('courses.enrol', ['course' => $course]);
        }
        $userRole = $this->userRole($courseId, Auth::user()->id);
        $assignment = new Assignment;
        $assignment = $assignment->whereId($assignmentId)->first();
        return View::make('sections.showAssignment', ['assignment' => $assignment, 'sectionId' => $sectionId, 'courseId' => $courseId, 'userRole' => $userRole]);
    }

    public function submitAssignmentAnswer($courseId, $sectionId, $assignmentId) {
        $assignedAnswer = AssignmentAnswers::whereAssignment_id($assignmentId)->whereUser_id(Auth::user()->id)->first();
        if (count($assignedAnswer) > 0) {
            $assignedAnswer->delete();
        }
        $assignmentAnswer = new AssignmentAnswers;
        $input = Input::all();
        //validation
        if (!$assignmentAnswer->isValid($input)) {
            return Redirect::back()->withInput()->withErrors($assignmentAnswer->errors);
        }
        $assignmentAnswer->answer = Input::get('answer');
        $assignmentAnswer->user_id = Auth::user()->id;
        $assignmentAnswer->assignment_id = $assignmentId;
        $assignmentAnswer->save();
        Session::flash('success', 'Answer was submitted sucessfully!');
        return Redirect::route('assignment.show', array($courseId, $sectionId, $assignmentId));
    }

    public function assignmentSubmissions($courseId, $sectionId, $assignmentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $assignment = new Assignment;
            $assignment = $assignment->whereId($assignmentId)->first();
            return View::make('sections.assignmentSubmissions', ['assignment' => $assignment, 'courseId' => $courseId, 'sectionId' => $sectionId]);
        } else {
            Session::flash('error', 'You don\'t have permission to view this page!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function acceptAssignmentSubmission($courseId, $sectionId, $assignmentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $submitType = Input::get('submit_type');
            if ($submitType == 'file') {
                $submission = AssignmentFiles::whereId(Input::get('submission_id'))->first();
                $submission->points = Input::get('points');
                $submission->accepted = 'yes';
                $submission->save();
                Session::flash('success', 'You have succesfully accepted user submission!');
                return Redirect::route('assignment.submissions', array($courseId, $sectionId, $assignmentId));
            } else {
                $submission = AssignmentAnswers::whereId(Input::get('submission_id'))->first();
                $submission->points = Input::get('points');
                $submission->accepted = 'yes';
                $submission->save();
                Session::flash('success', 'You have succesfully accepted user submission!');
                return Redirect::route('assignment.submissions', array($courseId, $sectionId, $assignmentId));
            }
        } else {
            Session::flash('error', 'You don\'t have permission to perform this action!');
            return Redirect::route('courses.show', $courseId);
        }
    }

    public function removeAssignment($courseId, $sectionId, $assignmentId) {
        $userRole = $this->userRole($courseId, Auth::user()->id);
        if ($userRole == 'teacher') {
            $assignment = Assignment::whereId($assignmentId)->first();
            $assignment->delete();
            Session::flash('success', 'You have successfully deleted selected assignment');
            return Redirect::route('courses.show', $courseId);
        } else {
            Session::flash('error', 'You don\'t have permission to delete selected assignment!');
            return Redirect::route('courses.show', $courseId);
        }
    }

}
