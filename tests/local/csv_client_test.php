<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * One Roster Enrolment Client Unit tests.
 *
 * @package    enrol_oneroster
 * @copyright  Gustavo Amorim De Almeida, Ruben Cooper, Josh Bateson, Brayden Porter
 */

namespace enrol_oneroster;

use advanced_testcase;
use enrol_oneroster\client_helper;
require_once(__DIR__ . '/../../classes/local/csv_client_helper.php');

/**
 * One Roster tests for the client_helper class.
 *
 * @package    enrol_oneroster
 * @copyright  Gustavo Amorim De Almeida, Ruben Cooper, Josh Bateson, Brayden Porter
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 * @covers  enrol_oneroster\client_helper
 * @covers  enrol_oneroster\local\v1p1\oneroster_client
 * @covers  enrol_oneroster\local\csv_client
 */

class client_csv_testcase extends advanced_testcase {
    /**
     * Test Synchronise method to check the data is inserted into the database.
     * This test uses the full data set.
     */
    public function test_execute_full_data(){
        global $DB;
        $this->resetAfterTest(true);

        $uniqueid = uniqid();
        $tempdir = make_temp_directory('oneroster_csv/' . $uniqueid);
        $zipfilepath = 'enrol/oneroster/tests/fixtures/csv_data/Test_full_data_set.zip';

        $zip = new \ZipArchive();
        $res = $zip->open($zipfilepath);
        $this->assertTrue($res === true, 'The ZIP file should open successfully.');
        $zip->extractTo($tempdir);
        $zip->close();

        $manifest_path = $tempdir . '/manifest.csv';

        $missing_files = OneRosterHelper::check_manifest_and_files($manifest_path, $tempdir);
        $this->assertEmpty($missing_files['missing_files'], 'There should be no missing files according to the manifest.');
        $this->assertEmpty($missing_files['invalid_headers'], 'There should be no invalid headers in the extracted CSV files.');

        $is_valid_data = OneRosterHelper::validate_csv_data_types($tempdir);
        $this->assertArrayHasKey('isValid', $is_valid_data);
        $this->assertTrue($is_valid_data['isValid']);

        $csv_data = OneRosterHelper::extract_csvs_to_arrays($tempdir);
        $this->assertNotEmpty($csv_data, 'The extracted CSV data should not be empty.');

        $csvclient = client_helper::get_csv_client();

        $selected_org_sourcedId = 'org-sch-222-456';

        if (OneRosterHelper::validate_and_save_users_to_database($csv_data) === true) {
            set_config('datasync_schools',  $selected_org_sourcedId, 'enrol_oneroster');
        }

        $csvclient->set_orgid($selected_org_sourcedId);
        
        $manifest = $csv_data['manifest'] ?? [];
        $users = $csv_data['users'] ?? [];
        $classes = $csv_data['classes'] ?? [];
        $orgs = $csv_data['orgs'] ?? [];
        $enrollments = $csv_data['enrollments'] ?? [];
        $academicSessions = $csv_data['academicSessions'] ?? [];

        $csvclient->set_data($manifest, $users, $classes, $orgs, $enrollments, $academicSessions);
    
        $csvclient->synchronise();

        $course_records = $DB->get_records('course');
        $user_records = $DB->get_records('user');
        $enrol_records = $DB->get_records('enrol');

        foreach ($course_records as $course) {
            $this->assertArrayHasKey('id', (array)$course);
            $this->assertArrayHasKey('fullname', (array)$course);
            $this->assertIsString($course->fullname, 'Course fullname should be a string.');
        }
    
        foreach ($user_records as $user) {
            $this->assertArrayHasKey('id', (array)$user);
            $this->assertArrayHasKey('username', (array)$user);
            $this->assertIsString($user->username, 'Username should be a string.');
        }
    
        foreach ($enrol_records as $enrol) {
            $this->assertArrayHasKey('courseid', (array)$enrol);
            $this->assertArrayHasKey('enrol', (array)$enrol);
            $courseid = (int) $enrol->courseid;
            $this->assertIsInt($courseid, 'Course ID should be an integer.');
        }
        
        $this->assertCount(3, $course_records, 'There should be exactly 3 course records.');
        $this->assertCount(7, $user_records, 'There should be exactly 7 user records.');
        $this->assertCount(8, $enrol_records, 'There should be exactly 8 enrolment records.');
    }

    /**
     * Test Synchronise method to check the data is inserted into the database.
     * This test uses the minimal data set.
     */
    public function test_execute_minimal_data() {
        global $DB;
        $this->resetAfterTest(true);
        $selected_org_sourcedId = 'org-sch-222-456';

        $uniqueid = uniqid();
        $tempdir = make_temp_directory('oneroster_csv/' . $uniqueid);
        $zipfilepath = 'enrol/oneroster/tests/fixtures/csv_data/Test_minimal_data_set.zip';

        $zip = new \ZipArchive();
        $res = $zip->open($zipfilepath);
        $this->assertTrue($res === true, 'The ZIP file should open successfully.');
        $zip->extractTo($tempdir);
        $zip->close();

        $manifest_path = $tempdir . '/manifest.csv';

        $missing_files = OneRosterHelper::check_manifest_and_files($manifest_path, $tempdir);
        $this->assertEmpty($missing_files['missing_files'], 'There should be no missing files according to the manifest.');
        $this->assertEmpty($missing_files['invalid_headers'], 'There should be no invalid headers in the extracted CSV files.');

        $is_valid_data = OneRosterHelper::validate_csv_data_types($tempdir);
        $this->assertArrayHasKey('isValid', $is_valid_data);
        $this->assertTrue($is_valid_data['isValid']);

        $csv_data = OneRosterHelper::extract_csvs_to_arrays($tempdir);
        $this->assertNotEmpty($csv_data, 'The extracted CSV data should not be empty.');

        if (OneRosterHelper::validate_and_save_users_to_database($csv_data) === true) {
            set_config('datasync_schools',  $selected_org_sourcedId, 'enrol_oneroster');
        }

        $csvclient = client_helper::get_csv_client();

        $csvclient->set_orgid($selected_org_sourcedId);
        
        $manifest = $csv_data['manifest'] ?? [];
        $users = $csv_data['users'] ?? [];
        $classes = $csv_data['classes'] ?? [];
        $orgs = $csv_data['orgs'] ?? [];
        $enrollments = $csv_data['enrollments'] ?? [];
        $academicSessions = $csv_data['academicSessions'] ?? [];

        $csvclient->set_data($manifest, $users, $classes, $orgs, $enrollments, $academicSessions);
    
        $csvclient->synchronise();

        $course_records = $DB->get_records('course');
        $user_records = $DB->get_records('user');
        $enrol_records = $DB->get_records('enrol');


        foreach ($course_records as $course) {
            $this->assertArrayHasKey('id', (array)$course);
            $this->assertArrayHasKey('fullname', (array)$course);
            $this->assertIsString($course->fullname, 'Course fullname should be a string.');
        }
    
        foreach ($user_records as $user) {
            $this->assertArrayHasKey('id', (array)$user);
            $this->assertArrayHasKey('username', (array)$user);
            $this->assertIsString($user->username, 'Username should be a string.');
        }
    
        foreach ($enrol_records as $enrol) {
            $this->assertArrayHasKey('id', (array)$enrol);
            $this->assertArrayHasKey('courseid', (array)$enrol);
            $courseid = (int) $enrol->courseid;
            $this->assertIsInt($courseid, 'Course ID should be an integer.');
        }
        
        $this->assertCount(3, $course_records, 'There should be exactly 3 course records.');
        $this->assertCount(2, $user_records, 'There should be exactly 2 user records.');
        $this->assertCount(8, $enrol_records, 'There should be exactly 8 enrolment records.');
    }
}
