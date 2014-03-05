<?php

/**
 * CalendarController is used for calendar of events.
 *
 * */
class CalendarController extends BaseController {

    public function __construct() {
        
    }

    public function index() {
        return View::make('calendar.calendar');
    }

    public function getEvents() {
        //get user courses
        $userCourses = User::whereId(Auth::user()->id)->first()->courses;
        //foreach course get sections and save sections ids to array
        foreach ($userCourses as $course) {
            $sections = $course->sections;
            foreach ($sections as $section) {
                $sect[] = $section->id;
                $cours[] = $course->id;
            }
        }
        //foreach secion get assignments and save assignment name and timedue to array
        foreach ($sect as $index => $s) {
            if (Assignment::whereSection_id($s)->first() != NULL) {
                $assignment = Assignment::whereSection_id($s)->get();
                foreach ($assignment as $a) {
                    $assignments['id_' . $a->id]['id'] = $a->id;
                    $assignments['id_' . $a->id]['name'] = $a->name;
                    $assignments['id_' . $a->id]['timedue'] = $a->timedue;
                    $assignments['id_' . $a->id]['section_id'] = $s;
                    $assignments['id_' . $a->id]['course_id'] = $cours[$index];
                }
            }
        }

        foreach ($sect as $index => $s) {
            if (Test::whereSection_id($s)->first() != NULL) {
                $test = Test::whereSection_id($s)->get();
                foreach ($test as $t) {
                    $tests['id_' . $t->id]['id'] = $t->id;
                    $tests['id_' . $t->id]['name'] = $t->name;
                    $tests['id_' . $t->id]['timedue'] = $t->timedue;
                    $tests['id_' . $t->id]['section_id'] = $s;
                    $tests['id_' . $t->id]['course_id'] = $cours[$index];
                }
            }
        }



        foreach ($assignments as $assignment) {
            $originalDate = $assignment['timedue'];
            $newDate = date("j/n/Y", strtotime($originalDate));
            $data[] = array(
                "$newDate",
                'Assignment:' . $assignment['name'],
                route('assignment.show', array($assignment['course_id'], $assignment['section_id'], $assignment['id'])),
                'red',
            );
        }

        foreach ($tests as $testt) {
            $originalDate = $testt['timedue'];
            $newDate = date("j/n/Y", strtotime($originalDate));
            $data[] = array(
                "$newDate",
                'Test:' . $testt['name'],
                route('test.show', array($testt['course_id'], $testt['section_id'], $testt['id'])),
                'red',
            );
        }
        return Response::json($data);
    }

}
