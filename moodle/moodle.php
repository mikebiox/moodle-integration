<?php

class Moodle {

    protected $wstoken = 'put token here';
    protected $domain = 'put domain here';
    public $moodle_course_id;
    public $moodle_user_id;

    public function __construct() {
        require_once('curl.php');
    }

    /**
     * Create Course in Moodle
     *
     * @param array $criteria supply: fullname, shortname, categoryid, summary, startdate, enddate, visible
     * 
     * <p>fullname: string </p>
     * <p>shortname: string (must be unique)</p>
     * <p>categoryid: int (see moodle_category table in OASIS)</p>
     * <p>summary: string (course description)</p>
     * <p>startdate: int (unix time stamp)</p>
     * <p>enddate: int (unix time stamp)</p>
     * <p>visibale: int (1 = public, 0 = hidden)</p>
     */
    public function createCourse($criteria) {
        /*
         * Example format: 
         * $criteria['courses'][0]['fullname']= 'Test Course'; //Required
         * $criteria['courses'][0]['shortname']= 'TC'; //Required
         * $criteria['courses'][0]['categoryid']= 26; //Required
         * $criteria['courses'][0]['summary']= 'This is a test course, please ignore.';
         * $criteria['courses'][0]['startdate']= mktime(0, 0, 0, 2, 15, 2017);
         * $criteria['courses'][0]['enddate']= mktime(0, 0, 0, 2, 20, 2017);
         * $criteria['courses'][0]['visible']= 0; // 1 = visible
         */
        $wsfunctionname = 'core_course_create_courses';
        header('Content-Type: text/plain');
        $serverurl = $this->domain . "/webservice/rest/server.php?wstoken=" . $this->wstoken . "&wsfunction=" . $wsfunctionname . '&moodlewsrestformat=json';
        $curl = new curl;
        $resp = $curl->post($serverurl, $criteria);
        $results = json_decode($resp);
        $this->moodle_course_id = $results[0]['id'];
    }

    /**
     * Lookup user in Moodle (returns user_id)
     *
     * @param array $criteria supply: key, value
     * 
     * <p>key: string</p>
     * <p>value: string (the actual username)</p>
     * 
     * @return int user_id
     */
    public function userLookup($criteria) {
        /*
         * Example format:
         * $criteria['criteria'][0]['key'] = 'username';
         * $criteria['criteria'][0]['value'] = 'admin';
         */
        $wsfunctionname = 'core_user_get_users';
        header('Content-Type: text/plain');
        $serverurl = $this->domain . "/webservice/rest/server.php?wstoken=" . $this->wstoken . "&wsfunction=" . $wsfunctionname . '&moodlewsrestformat=json';
        $curl = new curl;
        $resp = $curl->post($serverurl, $criteria);
        $results = json_decode($resp, true);
        $this->moodle_user_id = $results['users'][0]['id'];
    }

    /**
     * Enrol user in Moodle
     *
     * @param array $criteria supply: roleid, userid, courseid
     * 
     * <p>roleid: int</p>
     * <p>userid: int (</p>
     * <p>courseid: int</p>
     */
    public function enrollUser($criteria) {
        /*
         * Example format:
         * $criteria['enrolments'][0]['roleid']= int;
         * $criteria['enrolments'][0]['userid']= int;
         * $criteria['enrolments'][0]['courseid']= int;
         */
        $wsfunctionname = 'enrol_manual_enrol_users';
        header('Content-Type: text/plain');
        $serverurl = $this->domain . "/webservice/rest/server.php?wstoken=" . $this->wstoken . "&wsfunction=" . $wsfunctionname . '&moodlewsrestformat=json';
        $curl = new curl;
        $resp = $curl->post($serverurl, $criteria);
        $results = json_decode($resp, true);
        $this->moodle_user_id = $results['users'][0]['id'];
    }

    /**
     * Create user in Moodle
     *
     * @param array $criteria supply: username, firstname, lastname, email, auth, password
     * 
     * <p>username: string </p>
     * <p>firstname: string</p>
     * <p>lastname: string</p>
     * <p>email: string</p>
     * <p>auth: string (set to ldap)</p>
     * <p>password: string (with uppercase, lowercase, number, and symbol
     */
    public function createUser($criteria) {
        /*
         * Example format:
         * $criteria['users'][0]['username'] = string;
         * $criteria['users'][0]['firstname'] = string;
         * $criteria['users'][0]['lastname'] = string;
         * $criteria['users'][0]['email'] = string;
         * $criteria['users'][0]['auth'] = string;
         * $criteria['users'][0]['password'] = 'MoodleTest#1';
         */

        $wsfunctionname = 'core_user_create_users';
        header('Content-Type: text/plain');
        $serverurl = $this->domain . "/webservice/rest/server.php?wstoken=" . $this->wstoken . "&wsfunction=" . $wsfunctionname . '&moodlewsrestformat=json';
        $curl = new curl;
        $resp = $curl->post($serverurl, $criteria);
        $results = json_decode($resp, true);
        $this->moodle_user_id = $results['users'][0]['id'];
    }
}
