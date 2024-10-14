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
 * One Roster Client.
 *
 * This plugin synchronises enrolment and roles with a One Roster endpoint.
 *
 * @package    enrol_oneroster
 * @copyright  Gustavo Amorim De Almeida, Ruben Cooper, Josh Bateson, Brayden Porter
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace enrol_oneroster\local;

use enrol_oneroster\local\interfaces\client as client_interface;
use enrol_oneroster\local\oneroster_client as root_oneroster_client;
use enrol_oneroster\local\command;
use enrol_oneroster\local\interfaces\filter;
use stdClass;
use DateTime;
use enrol_oneroster\local\v1p1\oneroster_client as versioned_client;

class csv_client implements client_interface  {
    use root_oneroster_client;
    use versioned_client;

    // Define constants for the base paths and types
    const BASEPATH_ORGS = 'orgs';
    const BASEPATH_SCHOOLS = 'schools';
    const TYPE_TERMS = 'terms';
    const TYPE_CLASSES = 'classes';
    const TYPE_ENROLLMENTS = 'enrollments';
    const BASEPATH_USERS = 'users';
    private $orgId; 

    /**
     * Authenticate the client. This is a no-op for the CSV client.
     * 
     * @return void
     */
    public function authenticate(): void {
        return;
    }

    /**
     * Set the data retrieved from the CSV file.
     *
     * @param array $manifest The manifest data
     * @param array $users The users data
     * @param array $classes The classes data
     * @param array $orgs The orgs data
     * @param array $enrollments The enrollments data
     * @param array $academicSessions The academic sessions data
     * @return void
     */
    public function set_data(
        array $manifest, 
        array $users, 
        array $classes, 
        array $orgs, 
        array $enrollments, 
        array $academicSessions
    ): void {
        $this->data = [
            'manifest' => $manifest,
            'users' => $users,
            'classes' => $classes,
            'orgs' => $orgs,
            'enrollments' => $enrollments,
            'academicSessions' => $academicSessions,
        ];
    }

    /**
     * Set the organisation ID.
     *
     * @param string $orgId The organisation ID
     */
    public function set_orgid($orgId) {
        $this->orgId = $orgId;
    }
   
    /**
     * Execute the supplied command.
     *
     * @param   command $command The command to execute
     * @param   filter $filter
     * @return  stdClass
     */
    public function execute(command $command, ?filter $filter = null): stdClass {
        $url = $command->get_url('');
        // Split the URL into tokens using '/' as the delimiter (eg. /schools/org-sch-222-456/terms)
        $tokens = explode('/', $url); 
        // The second token represents the base path ('users', 'orgs', 'schools')
        $basepath = $tokens[1];
        // The third token represents the Organisation ID
        $param = $tokens[2] ?? '';
        // The fourth token represents the type of data to fetch ('terms', 'classes', 'enrollments')
        $type = $tokens[3] ?? '';
        // Get the organisation ID
        $orgId = $this->orgId ?? null;

        if ($orgId === null) {
            throw new \Exception('Organization ID is not set.');
        }

        switch ($basepath):
            case self::BASEPATH_ORGS:
                // The endpoint getAllOrgs is called to fetch all organisations
                if ($param == $orgId || $param == '') {
                    $orgdata = $this->data['orgs'];
                    $keys = array_map(function($orgs) { return $orgs['sourcedId']; }, $orgdata);
                    $mapped_data = array_combine($keys, $orgdata);
                    if (isset($mapped_data[$orgId])) {
                        $org = (object) $mapped_data[$orgId];
                        if ($org->status == null && $org->dateLastModified == null) {
                            $org->status = 'active'; 
                            $org->dateLastModified = date('Y-m-d');
                        }
                        if ($org->status == 'inactive') {
                            $org->status = 'tobedeleted';
                        }
                        $org->children = [(object) ['sourcedId' => $org->parentSourcedId]];

                        unset($org->parentSourcedId);
                    }
                    return (object) [
                        'response' => (object) [
                            'org' => $org
                        ]
                    ];
                }

            case self::BASEPATH_SCHOOLS:
                // The endpoint getTermsForSchool is called to fetch a list of classes in a term 
                if ($type == self::TYPE_TERMS) {
                    $academicsessiondata = $this->data['academicSessions'];
                    $keys = array_map(function($schools) { return $schools['sourcedId']; }, $academicsessiondata);
                    $mapped_data = array_combine($keys, $academicsessiondata);
                    $academicSession = [];
                    foreach ($mapped_data as $academicId => $academicdata) {
                        $academic = (object) $academicdata;
                        if ($academic->status == 'inactive') {
                            $academic->status = 'tobedeleted';
                        }
                        
                        $academic->parent = (object)['sourcedId' => $academicdata['parentSourcedId']];
                        unset($academic->parentSourcedId);
                        $academicSession[$academicId] = $academic;
                    }
                    return (object) [
                        'response' => (object) [
                            'academicSessions' => $academicSession,
                            'terms' => $academicSession
                        ]
                    ];
                }

                if ($type == self::TYPE_CLASSES) {
                    // The endpoint getClassesForSchool is called to fetch all students for a class 
                    $classdata = $this->data['classes'];
                    $keys = array_map(function($schools) { return $schools['sourcedId']; }, $classdata);
                    $mapped_data = array_combine($keys, $classdata);
                    $classes = [];
                    foreach ($mapped_data as $classId => $classData) {
                        $class = (object) $classData;
                        if (isset($class->schoolSourcedId) && $class->schoolSourcedId == $orgId) {
                            if ($class->status == 'inactive') {
                                $class->status = 'tobedeleted';
                            }

                            if (!empty($class->termSourcedIds)) {
                                $termIds = explode(',', $class->termSourcedIds);
                                $class->terms = array_map(function ($termId) { return (object) ['sourcedId' => trim($termId), 'type' => 'academicSession']; }, $termIds);
                            } else {
                                $class->terms = [];
                            }
                
                            if (!empty($class->periods)) {
                                if (is_string($class->periods)) {
                                    $class->periods = array_map('trim', explode(',', $class->periods));
                                } elseif (!is_array($class->periods)) {
                                    $class->periods = [$class->periods];
                                }
                            } else {
                                $class->periods = [];
                            }

                            if (!empty($class->subjects)) {
                                if (is_string($class->subjects)) {
                                    $class->subjects = array_map('trim', explode(',', $class->subjects));
                                } elseif (!is_array($class->subjects)) {
                                    $class->subjects = [$class->subjects];
                                }
                            } else {
                                $class->subjects = [];
                            }

                            if (!empty($class->subjectCodes)) {
                                if (is_string($class->subjectCodes)) {
                                    $class->subjectCodes = array_map('trim', explode(',', $class->subjectCodes)); 
                                } elseif (!is_array($class->subjectCodes)) {
                                    $class->subjectCodes = [$class->subjectCodes];
                                }
                            } else {
                                $class->subjectCodes = [];
                            }

                            if (!empty($class->grades)) {
                                if (is_string($class->grades)) {
                                    $class->grades = array_map('trim', explode(',', $class->grades));
                                } elseif (!is_array($class->grades)) {
                                    $class->grades = [$class->grades];
                                }
                            } else {
                                $class->grades = [];
                            }

                            $class->school = (object) ['sourcedId' => $class->schoolSourcedId, 'type' => 'school'];
                            $class->course = (object) ['sourcedId' => $class->courseSourcedId, 'type' => 'course'];
                            unset($class->schoolSourcedId, $class->courseSourcedId, $class->termSourcedIds);
                        }
                        $classes[$classId] = $class;
                    }
                    return (object) [
                        'response' => (object) [
                            'classes' => $classes
                        ]
                    ];
                }

                if ($type == self::TYPE_ENROLLMENTS) {
                    // The endpoint getEnrollmentsForSchool is called to fetch all enrollments in a school 
                    $enrollmentdata = $this->data['enrollments'];
                    $keys = array_map(function($schools) { return $schools['sourcedId']; }, $enrollmentdata);
                    $mapped_data = array_combine($keys, $enrollmentdata);
                    $enrollments = [];
                    foreach ($mapped_data as $enrollmentId => $enrollmentData) {
                        $enrollment = (object) $enrollmentData;
                        if (isset($enrollment->schoolSourcedId) && $enrollment->schoolSourcedId == $orgId) {
                            if ($enrollment->status == 'inactive') {
                                $enrollment->status = 'tobedeleted';
                            }

                            $enrollment->user = (object) ['sourcedId' => $enrollmentData['userSourcedId'], 'type' => 'user'];
                            $enrollment->school = (object) ['sourcedId' => $enrollmentData['schoolSourcedId'], 'type' => 'school'];
                            $enrollment->class = (object) ['sourcedId' => $enrollmentData['classSourcedId'], 'type' => 'class'];
                            unset($enrollment->schoolSourcedId, $enrollment->classSourcedId, $enrollment->userSourcedId);
                        }
                        $enrollments[$enrollmentId] = $enrollment;
                    }
                    return (object) [
                        'response' => (object) [
                            'enrollments' => $enrollments
                        ]
                    ];
                }

            case self::BASEPATH_USERS:
                // The endpoint getAllUsers is called to fetch all users in a school
                $usersData = $this->data['users'];
                $keys = array_map(function($user) {return $user['sourcedId']; }, $usersData);
                $mapped_data = array_combine($keys, $usersData);
                $users = [];
                foreach ($mapped_data as $userId => $userData) {
                    $user = (object) $userData;
                    if ($user->status == 'inactive') {
                        $user->status = 'tobedeleted';
                    }

                    if (!empty($user->agentSourcedIds)) {
                        $agentIds = explode(',', $user->agentSourcedIds);
                        $user->agents = array_map(function ($agentId) { return (object) ['sourcedId' => trim($agentId), 'type' => 'user']; }, $agentIds);
                    } else {
                        $user->agents = [];
                    }
                    
                    if (!empty($user->orgSourcedIds)) {
                        $orgIds = explode(',', $user->orgSourcedIds);
                        $user->orgs = array_map(function ($orgId) { return (object) ['sourcedId' => trim($orgId), 'type' => 'org']; }, $orgIds);
                    } else {
                        $user->orgs = [];
                    }

                    if (!empty($user->userIds)) {
                        $userIds = explode(',', str_replace(['{', '}'], '', $user->userIds));
                        $user->userIds = array_map(function ($userId) { 
                            list($type, $identifier) = explode(':', $userId); 
                            return (object) [ 'type' => trim($type), 'identifier' => trim($identifier) ]; 
                        }, $userIds);
                    } else {
                        $user->userIds = [];
                    }

                    unset($user->orgSourcedIds, $user->agentSourcedIds);
                    foreach ($user->orgs as $org) {
                        if ($org->sourcedId === $orgId) {
                            $users[$userId] = $user;
                        }
                    }
                }
                return (object) [
                    'response' => (object) [
                        'users' => $users 
                    ]
                ];
            default:
                return new stdClass();
        endswitch;
    }
}