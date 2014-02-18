<?php

Breadcrumbs::register('home', function($breadcrumbs) {
            $breadcrumbs->push('Home', route('home'));
        });

Breadcrumbs::register('courses.index', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Courses', route('courses.index'));
        });
Breadcrumbs::register('courses.store', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Courses', route('courses.index'));
        });

Breadcrumbs::register('category', function($breadcrumbs, $courseCategories) {
            $breadcrumbs->parent('home');

            foreach ($courseCategories as $category) {
                $breadcrumbs->push($category->name, route('courses.index', $category->id));
            }

            $breadcrumbs->push($category->name, route('category', $category->id));
        });

Breadcrumbs::register('courses.create', function($breadcrumbs) {
            $breadcrumbs->parent('courses.index');
            $breadcrumbs->push('Create course', route('courses.create'));
        });

Breadcrumbs::register('courses.show', function($breadcrumbs, $course) {
            $breadcrumbs->parent('courses.index');
            $breadcrumbs->push(Course::whereId($course)->first()->name, route('courses.show', $course));
        });



Breadcrumbs::register('courses.edit', function($breadcrumbs, $course) {
            $breadcrumbs->parent('courses.show', $course);
            $breadcrumbs->push("Edit", route('courses.edit', $course));
        });

Breadcrumbs::register('courses.users', function($breadcrumbs, $course) {
            $breadcrumbs->parent('courses.show', $course);
            $breadcrumbs->push('Users', route('courses.users'));
        });

Breadcrumbs::register('courses.sections.create', function($breadcrumbs, $courseId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push('Add section', route('courses.sections.create', $courseId));
        });

Breadcrumbs::register('courses.sections.edit', function($breadcrumbs, $courseId, $sectionId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name . ' / Edit', route('courses.sections.edit', $courseId, $sectionId));
        });

Breadcrumbs::register('users.index', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Users', route('users.index'));
        });

Breadcrumbs::register('users.show', function($breadcrumbs, $username) {
            $breadcrumbs->parent('users.index');
            $breadcrumbs->push($username, route('users.show', $username));
        });

Breadcrumbs::register('users.edit', function($breadcrumbs, $username) {
            $breadcrumbs->parent('users.show', $username);
            $breadcrumbs->push('Edit', route('users.edit', $username));
        });

Breadcrumbs::register('users.create', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Register', route('users.create'));
        });

Breadcrumbs::register('login', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Login', route('login'));
        });

Breadcrumbs::register('avatars', function($breadcrumbs) {
            $breadcrumbs->parent('users.show', Auth::user()->username);
            $breadcrumbs->push('Avatars', route('avatars'));
        });

Breadcrumbs::register('messages.index', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Messages', route('messages.index'));
        });

Breadcrumbs::register('messages.show', function($breadcrumbs, $messageId) {
            $breadcrumbs->parent('messages.index');
            $breadcrumbs->push('Show Message', route('messages.show', $messageId));
        });

Breadcrumbs::register('messages.create', function($breadcrumbs) {
            $breadcrumbs->parent('messages.index');
            $breadcrumbs->push('Send message', route('messages.create'));
        });

Breadcrumbs::register('messages.outgoing', function($breadcrumbs) {
            $breadcrumbs->parent('messages.index');
            $breadcrumbs->push('Outgoing', route('messages.outgoing'));
        });

Breadcrumbs::register('sections.addfile', function($breadcrumbs, $courseId, $sectionId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push('Add file', route('sections.addfile', $courseId, $sectionId));
        });

Breadcrumbs::register('files', function($breadcrumbs, $courseId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push('Files', route('files', $courseId));
        });

Breadcrumbs::register('content.add', function($breadcrumbs, $courseId, $sectionId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push('Add content', route('content.add', $courseId, $sectionId));
        });

Breadcrumbs::register('content.show', function($breadcrumbs, $courseId, $sectionId, $contentId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push(Content::whereId($contentId)->first()->title, route('content.show', $courseId, $sectionId, $contentId));
        });

Breadcrumbs::register('content.edit', function($breadcrumbs, $courseId, $sectionId, $contentId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push(Content::whereId($contentId)->first()->title, route('content.show', $courseId, $sectionId, $contentId));
            $breadcrumbs->push('Edit', route('content.edit', $courseId, $sectionId, $contentId));
        });

Breadcrumbs::register('website.add', function($breadcrumbs, $courseId, $sectionId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push('Add web content', route('website.add', $courseId, $sectionId));
        });

Breadcrumbs::register('website.edit', function($breadcrumbs, $courseId, $sectionId, $websiteId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push('Edit web content', route('website.edit', $courseId, $sectionId, $websiteId));
        });

Breadcrumbs::register('assignment.add', function($breadcrumbs, $courseId, $sectionId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push('Add assignment', route('assignment.add', $courseId, $sectionId));
        });

Breadcrumbs::register('assignment.show', function($breadcrumbs, $courseId, $sectionId, $assignmentId) {
            $breadcrumbs->parent('courses.show', $courseId);
            $breadcrumbs->push(Section::whereId($sectionId)->first()->name, route('courses.show', $courseId));
            $breadcrumbs->push(Assignment::whereId($assignmentId)->first()->name, route('assignment.show', $courseId, $sectionId, $assignmentId));
        });

Breadcrumbs::register('assignment.edit', function($breadcrumbs, $courseId, $sectionId, $assignmentId) {
            $breadcrumbs->parent('assignment.show', $courseId, $sectionId, $assignmentId);
            $breadcrumbs->push('Edit', route('assignment.edit', $courseId, $sectionId, $assignmentId));
        });
Breadcrumbs::register('remind', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Remind password', route('remind'));
        });

Breadcrumbs::register('reset', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Reset password', route('reset'));
        });

Breadcrumbs::register('courses.sections.store', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Reset password', route('reset'));
        });

Breadcrumbs::register('calendar', function($breadcrumbs) {
            $breadcrumbs->parent('home');
            $breadcrumbs->push('Calendar', route('calendar'));
        });