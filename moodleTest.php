<?php

require_once ('/moodle/moodle.php');

$moodle = new Moodle ();

//Create a course
$course['courses'][0]['fullname'] = 'Test Course'; //Required
$course['courses'][0]['shortname'] = 'TC'; //Required
$course['courses'][0]['categoryid'] = 26; //Required
$course['courses'][0]['summary'] = 'This is a test course, please ignore.';
$course['courses'][0]['startdate'] = mktime(0, 0, 0, 2, 15, 2017);
$course['courses'][0]['enddate'] = mktime(0, 0, 0, 2, 20, 2017);
$course['courses'][0]['visible'] = 0; // 1 = visible

//Check a user
$user['criteria'][0]['key'] = 'username';
$user['criteria'][0]['value'] = 'admin';

//create a user
$criteria['users'][0]['username'] = 'astudent';
$criteria['users'][0]['firstname'] = 'Student';
$criteria['users'][0]['lastname'] = 'Test';
$criteria['users'][0]['email'] = 'uniqueEmail@email.com';
$criteria['users'][0]['auth'] = 'ldap'; //or manual
$criteria['users'][0]['password'] = 'MoodleTest#1';

//$moodle->createUser($criteria);
//$moodle->createCourse($course);
$moodle->userLookup($user);
echo $moodle->moodle_user_id; //will return ID of admin in Moodle
