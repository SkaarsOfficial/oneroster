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

namespace enrol_oneroster;

/**
 * Class OneRosterHelper
 *
 * Helper class for OneRoster plugin
 *
 * @package    enrol_oneroster
 * @copyright  Gustavo Amorim De Almeida, Ruben Cooper, Josh Bateson, Brayden Porter
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class OneRosterHelper {
    // Individual header constants
    const HEADER_SOURCEDID = 'sourcedId';
    const HEADER_STATUS = 'status';
    const HEADER_DATE_LAST_MODIFIED = 'dateLastModified';
    const HEADER_TITLE = 'title';
    const HEADER_TYPE = 'type';
    const HEADER_START_DATE = 'startDate';
    const HEADER_END_DATE = 'endDate';
    const HEADER_PARENT_SOURCEDID = 'parentSourcedId';
    const HEADER_SCHOOL_YEAR = 'schoolYear';
    const HEADER_GRADES = 'grades';
    const HEADER_COURSE_SOURCEDID = 'courseSourcedId';
    const HEADER_CLASS_CODE = 'classCode';
    const HEADER_CLASS_TYPE = 'classType';
    const HEADER_LOCATION = 'location';
    const HEADER_SCHOOL_SOURCEDID = 'schoolSourcedId';
    const HEADER_TERM_SOURCEDIDS = 'termSourcedIds';
    const HEADER_SUBJECTS = 'subjects';
    const HEADER_SUBJECT_CODES = 'subjectCodes';
    const HEADER_PERIODS = 'periods';
    const HEADER_CLASS_SOURCEDID = 'classSourcedId';
    const HEADER_USER_SOURCEDID = 'userSourcedId';
    const HEADER_ROLE = 'role';
    const HEADER_PRIMARY = 'primary';
    const HEADER_BEGIN_DATE = 'beginDate';
    const HEADER_IDENTIFIER = 'identifier';
    const HEADER_NAME = 'name';
    const HEADER_ENABLED_USER = 'enabledUser';
    const HEADER_ORG_SOURCEDIDS = 'orgSourcedIds';
    const HEADER_USERNAME = 'username';
    const HEADER_USERIDS = 'userIds';
    const HEADER_GIVEN_NAME = 'givenName';
    const HEADER_FAMILY_NAME = 'familyName';
    const HEADER_MIDDLE_NAME = 'middleName';
    const HEADER_EMAIL = 'email';
    const HEADER_SMS = 'sms';
    const HEADER_PHONE = 'phone';
    const HEADER_AGENT_SOURCEDIDS = 'agentSourcedIds';
    const HEADER_PASSWORD = 'password';

    // CSV file names
    const FILE_MANIFEST = 'manifest.csv';
    const FILE_ACADEMIC_SESSIONS = 'academicSessions.csv';
    const FILE_CLASSES = 'classes.csv';
    const FILE_ENROLLMENTS = 'enrollments.csv';
    const FILE_ORGS = 'orgs.csv';
    const FILE_USERS = 'users.csv';

    // Define constants for the types    
    const DATATYPE_NULL = 'null';
    const DATATYPE_GUID = 'guid';
    const DATATYPE_INT = 'int';
    const DATATYPE_DATETIME = 'datetime';
    const DATATYPE_DATE = 'date';
    const DATATYPE_YEAR = 'year';
    const DATATYPE_ENUM_STATUS = 'enum_status';
    const DATATYPE_ENUM_TYPE = 'enum_type';
    const DATATYPE_ARRAY_GUID = 'array_guid';
    const DATATYPE_ARRAY_GRADE = 'array_grade';
    const DATATYPE_GRADE = 'grade';
    const DATATYPE_STRING_EMAIL = 'string_email';
    const DATATYPE_ARRAY_USERIDS = 'array_userIds';
    const DATATYPE_ENUM_ROLE_USER = 'enum_role_user';
    const DATATYPE_ENUM_TYPE_ENROL = 'enum_type_enrol';
    const DATATYPE_ENUM_PRIMARY = 'enum_primary';
    const DATATYPE_ENUM_CLASS_TYPE = 'enum_class_type';
    const DATATYPE_ENUM_ORG_TYPE = 'enum_org_type';
    const DATATYPE_ARRAY_SUBJECTS = 'array_subjects';
    const DATATYPE_ARRAY_SUBJECT_CODES = 'array_subjectCodes';
    const DATATYPE_ARRAY_PERIODS = 'array_periods';
    const DATATYPE_PASSWORD = 'password';
    const DATATYPE_STRING = 'string';

    // Header constants for each file
    const HEADER_ACADEMIC_SESSIONS = [
        self::HEADER_SOURCEDID, self::HEADER_STATUS, self::HEADER_DATE_LAST_MODIFIED, self::HEADER_TITLE,
        self::HEADER_TYPE, self::HEADER_START_DATE, self::HEADER_END_DATE, self::HEADER_PARENT_SOURCEDID, self::HEADER_SCHOOL_YEAR
    ];
    const HEADER_CLASSES = [
        self::HEADER_SOURCEDID, self::HEADER_STATUS, self::HEADER_DATE_LAST_MODIFIED, self::HEADER_TITLE, self::HEADER_GRADES,
        self::HEADER_COURSE_SOURCEDID, self::HEADER_CLASS_CODE, self::HEADER_CLASS_TYPE, self::HEADER_LOCATION,
        self::HEADER_SCHOOL_SOURCEDID, self::HEADER_TERM_SOURCEDIDS, self::HEADER_SUBJECTS, self::HEADER_SUBJECT_CODES, self::HEADER_PERIODS
    ];
    const HEADER_ENROLLMENTS = [
        self::HEADER_SOURCEDID, self::HEADER_STATUS, self::HEADER_DATE_LAST_MODIFIED, self::HEADER_CLASS_SOURCEDID,
        self::HEADER_SCHOOL_SOURCEDID, self::HEADER_USER_SOURCEDID, self::HEADER_ROLE, self::HEADER_PRIMARY,
        self::HEADER_BEGIN_DATE, self::HEADER_END_DATE
    ];
    const HEADER_ORGS = [
        self::HEADER_SOURCEDID, self::HEADER_STATUS, self::HEADER_DATE_LAST_MODIFIED, self::HEADER_NAME, self::HEADER_TYPE,
        self::HEADER_IDENTIFIER, self::HEADER_PARENT_SOURCEDID
    ];
    const HEADER_USERS = [
        self::HEADER_SOURCEDID, self::HEADER_STATUS, self::HEADER_DATE_LAST_MODIFIED, self::HEADER_ENABLED_USER,
        self::HEADER_ORG_SOURCEDIDS, self::HEADER_ROLE, self::HEADER_USERNAME, self::HEADER_USERIDS,
        self::HEADER_GIVEN_NAME, self::HEADER_FAMILY_NAME, self::HEADER_MIDDLE_NAME, self::HEADER_IDENTIFIER,
        self::HEADER_EMAIL, self::HEADER_SMS, self::HEADER_PHONE, self::HEADER_AGENT_SOURCEDIDS, self::HEADER_GRADES, self::HEADER_PASSWORD
    ];

    // Data type definitions for each file
    public static $datatype_files = [
        self::FILE_ACADEMIC_SESSIONS => [
            self::HEADER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_STATUS => [self::DATATYPE_ENUM_STATUS, self::DATATYPE_NULL],
            self::HEADER_DATE_LAST_MODIFIED => [self::DATATYPE_DATETIME, self::DATATYPE_NULL],
            self::HEADER_TITLE => self::DATATYPE_STRING,
            self::HEADER_TYPE => self::DATATYPE_ENUM_TYPE,
            self::HEADER_START_DATE => self::DATATYPE_DATE,
            self::HEADER_END_DATE => self::DATATYPE_DATE,
            self::HEADER_PARENT_SOURCEDID => [self::DATATYPE_GUID, self::DATATYPE_NULL],
            self::HEADER_SCHOOL_YEAR => self::DATATYPE_YEAR,
        ],
        self::FILE_CLASSES => [
            self::HEADER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_STATUS => [self::DATATYPE_ENUM_STATUS, self::DATATYPE_NULL],
            self::HEADER_DATE_LAST_MODIFIED => [self::DATATYPE_DATETIME, self::DATATYPE_NULL],
            self::HEADER_TITLE => self::DATATYPE_STRING,
            self::HEADER_GRADES => [self::DATATYPE_ARRAY_GRADE, self::DATATYPE_NULL],
            self::HEADER_COURSE_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_CLASS_CODE => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_CLASS_TYPE => self::DATATYPE_ENUM_CLASS_TYPE,
            self::HEADER_LOCATION => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_SCHOOL_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_TERM_SOURCEDIDS => [self::DATATYPE_ARRAY_GUID],
            self::HEADER_SUBJECTS => [self::DATATYPE_ARRAY_SUBJECTS, self::DATATYPE_NULL],
            self::HEADER_SUBJECT_CODES => [self::DATATYPE_ARRAY_SUBJECT_CODES, self::DATATYPE_NULL],
            self::HEADER_PERIODS => [self::DATATYPE_ARRAY_PERIODS, self::DATATYPE_NULL],
        ],
        self::FILE_ENROLLMENTS => [
            self::HEADER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_STATUS => [self::DATATYPE_ENUM_STATUS, self::DATATYPE_NULL],
            self::HEADER_DATE_LAST_MODIFIED => [self::DATATYPE_DATETIME, self::DATATYPE_NULL],
            self::HEADER_CLASS_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_SCHOOL_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_USER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_ROLE => self::DATATYPE_ENUM_TYPE_ENROL,
            self::HEADER_PRIMARY => [self::DATATYPE_ENUM_PRIMARY, self::DATATYPE_NULL],
            self::HEADER_BEGIN_DATE => [self::DATATYPE_DATE, self::DATATYPE_NULL],
            self::HEADER_END_DATE => [self::DATATYPE_DATE, self::DATATYPE_NULL],
        ],
        self::FILE_ORGS => [
            self::HEADER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_STATUS => [self::DATATYPE_ENUM_STATUS, self::DATATYPE_NULL],
            self::HEADER_DATE_LAST_MODIFIED => [self::DATATYPE_DATETIME, self::DATATYPE_NULL],
            self::HEADER_NAME => self::DATATYPE_STRING,
            self::HEADER_TYPE => self::DATATYPE_ENUM_ORG_TYPE,
            self::HEADER_IDENTIFIER => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_PARENT_SOURCEDID => [self::DATATYPE_GUID, self::DATATYPE_NULL],
        ],
        self::FILE_USERS => [
            self::HEADER_SOURCEDID => self::DATATYPE_GUID,
            self::HEADER_STATUS => [self::DATATYPE_ENUM_STATUS, self::DATATYPE_NULL],
            self::HEADER_DATE_LAST_MODIFIED => [self::DATATYPE_DATETIME, self::DATATYPE_NULL],
            self::HEADER_ENABLED_USER => self::DATATYPE_ENUM_PRIMARY,
            self::HEADER_ORG_SOURCEDIDS => self::DATATYPE_ARRAY_GUID,
            self::HEADER_ROLE => self::DATATYPE_ENUM_ROLE_USER,
            self::HEADER_USERNAME => self::DATATYPE_STRING,
            self::HEADER_USERIDS => [self::DATATYPE_ARRAY_USERIDS, self::DATATYPE_NULL],
            self::HEADER_GIVEN_NAME => self::DATATYPE_STRING,
            self::HEADER_FAMILY_NAME => self::DATATYPE_STRING,
            self::HEADER_MIDDLE_NAME => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_IDENTIFIER => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_EMAIL => [self::DATATYPE_STRING_EMAIL, self::DATATYPE_NULL],
            self::HEADER_SMS => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_PHONE => [self::DATATYPE_STRING, self::DATATYPE_NULL],
            self::HEADER_AGENT_SOURCEDIDS => [self::DATATYPE_ARRAY_GUID, self::DATATYPE_NULL],
            self::HEADER_GRADES => [self::DATATYPE_GRADE, self::DATATYPE_NULL],
            self::HEADER_PASSWORD => [self::DATATYPE_PASSWORD, self::DATATYPE_NULL],
        ],
    ];

    // Required files and their headers
    const REQUIRED_FILES = [
        self::FILE_ACADEMIC_SESSIONS => self::HEADER_ACADEMIC_SESSIONS,
        self::FILE_CLASSES => self::HEADER_CLASSES,
        self::FILE_ENROLLMENTS => self::HEADER_ENROLLMENTS,
        self::FILE_ORGS => self::HEADER_ORGS,
        self::FILE_USERS => self::HEADER_USERS,
    ];

    // Validators for each data type
    public static $validators = [
        self::DATATYPE_GUID => 'is_guid_type',
        self::DATATYPE_INT => 'is_int_type',
        self::DATATYPE_DATETIME => 'is_datetime_type',
        self::DATATYPE_DATE => 'is_date_type',
        self::DATATYPE_YEAR => 'is_year_type',
        self::DATATYPE_ENUM_STATUS => 'is_status_enum_type',
        self::DATATYPE_ENUM_TYPE => 'is_type_enum',
        self::DATATYPE_ARRAY_GUID => 'is_valid_guid_list',
        self::DATATYPE_ARRAY_GRADE => 'is_valid_grades',
        self::DATATYPE_GRADE => 'is_valid_grade',
        self::DATATYPE_STRING_EMAIL => 'is_email_type',
        self::DATATYPE_ARRAY_USERIDS => 'is_valid_user_id',
        self::DATATYPE_ENUM_ROLE_USER => 'is_role_user_enum',
        self::DATATYPE_ENUM_TYPE_ENROL => 'is_role_enum',
        self::DATATYPE_ENUM_PRIMARY => 'is_primary_enum',
        self::DATATYPE_ENUM_CLASS_TYPE => 'is_class_type_enum',
        self::DATATYPE_ENUM_ORG_TYPE => 'is_org_type_enum',
        self::DATATYPE_ARRAY_SUBJECTS => 'is_list_of_strings',
        self::DATATYPE_ARRAY_SUBJECT_CODES => 'is_valid_subject_codes',
        self::DATATYPE_PASSWORD => 'is_valid_password',
        self::DATATYPE_ARRAY_PERIODS => 'is_valid_periods',
        self::DATATYPE_STRING => 'is_valid_human_readable_string',
    ];

    /**
     * Function to validate CSV headers
     *
     * @param string $file_path Path to the CSV file
     * @return bool True if the headers are valid, false otherwise
     */
    public static function validate_csv_headers(string $file_path): bool {
        $clean_file_path = clean_param($file_path, PARAM_PATH);
        $file_name = basename($clean_file_path);
        $expected_headers = self::getHeader($file_name);

        if (($handle = fopen($clean_file_path, "r")) !== false) {
            $headers = fgetcsv($handle, 1000, ",");
            fclose($handle);
            return $headers === $expected_headers;
        } 
        return false;
    }

    /**
     * Function to check if the manifest and required files are present
     *
     * @param string $manifest_path Path to the manifest file
     * @param string $tempdir Path to the temporary directory
     * @return array An array containing the missing files and invalid headers
     */
    public static function check_manifest_and_files($manifest_path, $tempdir) {
        $invalid_headers = [];
        $required_files = [];

        if (($handle = fopen($manifest_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (in_array($data[1], ['bulk', 'delta'])) {
                    $required_files[] = str_replace('file.', '', $data[0]) . '.csv';
                }
            }
            fclose($handle);
        }

        $extracted_files = array_diff(scandir($tempdir), array('.', '..', 'uploadedzip.zip'));
        $missing_files = array_diff($required_files, $extracted_files);

        foreach ($required_files as $file) {
            if (in_array($file, $extracted_files)) {
                $file_path = $tempdir . '/' . $file;
                if (!self::validate_csv_headers($file_path)) {
                    $invalid_headers[] = $file;
                }
            }
        }

        return [
            'missing_files' => $missing_files,
            'invalid_headers' => $invalid_headers
        ];
    }

    /**
     * Function to extract CSV files to arrays
     *
     * @param string $directory Path to the directory containing the CSV files
     * @return array An associative array containing the CSV data
     */
    public static function extract_csvs_to_arrays($directory) {
        $csv_data = [];
        $files = scandir($directory);
    
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'csv') {
                $file_name = pathinfo($file, PATHINFO_FILENAME);
                $csv_data[$file_name] = [];

                if (($handle = fopen($directory . '/' . $file, 'r')) !== false) {
                    $headers = fgetcsv($handle, 1000, ',');
                    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                        $csv_data[$file_name][] = array_combine($headers, $row);
                    }
                    fclose($handle);
                }
            }
        }
        return $csv_data;
    }

    /**
     * Function to display missing and invalid files
     *
     * @param array $missing_files An array containing the missing files and invalid headers
     */
    public static function display_missing_and_invalid_files($missing_files) {
        $critical_files = [self::FILE_ACADEMIC_SESSIONS, self::FILE_CLASSES, self::FILE_ENROLLMENTS, self::FILE_ORGS, self::FILE_USERS];
    
        if (!empty($missing_files['missing_files'])) {
            foreach ($missing_files['missing_files'] as $missing_file) {
                if (in_array($missing_file, $critical_files, true)) {
                    echo get_string('missingfiles', 'enrol_oneroster') . implode(', ', $missing_files['missing_files']) . '<br>';
                } else {
                    echo $missing_file . get_string('invalid_manifest_selection', 'enrol_oneroster') .'<br>';
                }
            }
        }
    
        if (!empty($missing_files['invalid_headers'])) {
            echo get_string('invalidheaders', 'enrol_oneroster') . implode(', ', $missing_files['invalid_headers']) . '<br>';
        }
    }
    
    /**
     * Function to get the header for a given file
     *
     * @param string $file_name The name of the file
     * @return array The header for the given file
     */
    public static function getHeader($file_name) {
        switch ($file_name) {
            case self::FILE_MANIFEST:
                return self::HEADER_MANIFEST;
            case self::FILE_ACADEMIC_SESSIONS:
                return self::HEADER_ACADEMIC_SESSIONS;
            case self::FILE_CLASSES:
                return self::HEADER_CLASSES;
            case self::FILE_ENROLLMENTS:
                return self::HEADER_ENROLLMENTS;
            case self::FILE_ORGS:
                return self::HEADER_ORGS;
            case self::FILE_USERS:
                return self::HEADER_USERS;
            default:
                return [];
        }
    }

    /**
     * Get the expected data types for a given file
     *
     * @param string $file_name The name of the file
     * @return array The expected data types for the given file
     */
    public static function get_data_types($file_name) {
        return self::$datatype_files[$file_name] ?? [];
    }

    /**
     * Validate the data types of the CSV files
     *
     * @param string $directory The directory containing the CSV files
     * @return array An array containing the validity of the files, the invalid files, and error messages
     */
    public static function validate_csv_data_types($directory) {
        $isValid = true;
        $invalid_files = [];
        $error_messages = [];

        $files = scandir($directory);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || pathinfo($file, PATHINFO_EXTENSION) !== 'csv' || $file === self::FILE_MANIFEST) {
                continue;
            }

            $clean_file_path = clean_param($directory . '/' . $file, PARAM_PATH);
            $expected_data_types = self::get_data_types($file);
            $detected_data_types = [];

            if (($handle = fopen($clean_file_path, "r")) !== false) {
                $headers = fgetcsv($handle, 1000, ",");
                if ($headers === false) {
                    $isValid = false;
                    $invalid_files[] = $file;
                    $error_messages[] = "Failed to read headers from CSV file: $file";
                    continue;
                }

                $detected_data_types = array_fill(0, count($headers), 'unknown');
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    foreach ($row as $index => $value) {
                        $detected_type = self::determine_data_type($value, $expected_data_types[$headers[$index]] ?? []);
                        if ($detected_data_types[$index] === 'unknown' || $detected_data_types[$index] === self::DATATYPE_NULL || $detected_data_types[$index] !== false) {
                            $detected_data_types[$index] = $detected_type;
                        }
                    }
                }

                fclose($handle);

                $file_is_valid = true;
                foreach ($headers as $index => $header) {
                    $expected_types = $expected_data_types[$header] ?? ['N/A'];
                    $detected_type = $detected_data_types[$index];
                    if (!in_array($detected_type, (array)$expected_types, true)) {
                        $error_messages[] = "Validation failed for header '$header' in file '$file'.";
                        $isValid = false;
                        $file_is_valid = false;
                    }
                }

                if (!$file_is_valid) {
                    $invalid_files[] = $file;
                }
            }
        }

        return [
            'isValid' => $isValid,
            'invalid_files' => $invalid_files,
            'error_messages' => $error_messages
        ];
    }

    /**
     * Function to display errors for CSV data type validation
     *
     * @param array $validation_result An array containing the validity of the files, the invalid files, and error messages
     */
    public static function display_validation_errors($validation_result) {
        if (!empty($validation_result['error_messages'])) {
            echo '<h3>' . "Data Type Errors Messages" . '</h3>';
            echo '<ul>';
            foreach ($validation_result['error_messages'] as $message) {
                echo '<li>' . $message . '</li>';
            }
            echo '</ul>';
            echo '<p>'. get_string('reference_message', 'enrol_oneroster');
            echo '<a href="https://www.imsglobal.org/oneroster-v11-final-csv-tables#_Toc480293266" target="_blank">' . get_string('csv_spec', 'enrol_oneroster') . '</a>.</p>';
        }
    }

    /**
     * Function to validate users and configure settings for database entry
     * If all users have an identifier, the users will be saved to the database
     * Otherwise, no users will be saved
     *
     * @param array $csv_data An array containing user data, including identifiers and other relevant details.
     */
    public static function validate_and_save_users_to_database($csv_data): bool {
        foreach ($csv_data['users'] as $user) {
            // If any user has an empty identifier, return false
            if (empty($user['identifier']) && empty($user['password'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Determine the data type of a value
     *
     * @param string $value The value to determine the data type of
     * @param array $expected_types The expected data types for the value
     * @return string The detected data type
     */
    public static function determine_data_type($value, $expected_types) {
        if (trim($value) === '') {
            return self::DATATYPE_NULL;
        }

        foreach ((array)$expected_types as $expected_type) {
            if (isset(self::$validators[$expected_type]) && call_user_func([self::class, self::$validators[$expected_type]], $value)) {
                return $expected_type;
            }
        }
        return 'unknown';
    }

    /**
     * Check if a value is a valid password
     *
     * @param mixed $value The value to check
     * @return bool True if the value is a valid password, false otherwise
     */
    public static function is_valid_password($value) {
        if (!preg_match('/\d/', $value)) {
            return false;
        }
    
        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }
    
        if (!preg_match('/[\W_]/', $value)) {
            return false;
        }
    
        return true;
    }

    /**
     * Check if a value is a valid human-readable string
     *
     * @param mixed $value The value to check
     * @return bool True if the value is human-readable string, false otherwise
     */
    public static function is_valid_human_readable_string($value) : bool {
        $trimmed_value = trim($value);
        $result = is_string($trimmed_value) && preg_match('/^[\p{L}\p{N}\s.,-]+$/u', $trimmed_value);
        
        return $result;
    }

    /**
     * Check if a value is of type int
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type int, false otherwise
     */
    public static function is_int_type($value) : bool {
        return is_numeric($value) && filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

   /**
    * Check if a value is of type list (array of strings)
    *
    * @param mixed $value The value to check
    * @return bool True if the value is of type list of strings, false otherwise
    */
    public static function is_list_of_strings($value) : bool {
        if (is_string($value)) {
            $value = array_map('trim', explode(',', $value)); 
        }
    
        foreach ($value as &$item) {
            $item = str_replace(',', '', $item);
            if (trim($item) === '') {
                continue;
            }
            if (!is_string($item)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate and parse subject codes
     * Subject codes can be a single string or a list of strings separated by commas
     *
     * @param mixed $value The value to check
     * @return bool True if the value is a valid list of subject codes, false otherwise
     */
    public static function is_valid_subject_codes($value) : bool {
        if (is_string($value)) {
            $value = array_map('trim', explode(',', $value)); 
        }

        foreach ($value as $item) {
            if (preg_match('/^".*?"$/', trim($item))) {
                $item = trim($item, '"');
                $codes = explode(',', $item);
                foreach ($codes as $code) {
                    if (!is_string(trim($code)) || trim($code) === '') {
                        return false; 
                    }
                }
            } else {
                if (!is_string(trim($item)) || trim($item) === '') {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Validate and parse periods string.
     *
     * @param string $value The value to check and parse
     * @return bool True if the value is a valid periods string, false otherwise
     */
    public static function is_valid_periods($value) : bool {
        $value = trim($value);

        if (preg_match('/^".*?"$/', $value)) {
            $value = trim($value, '"');
        }

        $periods = array_map('trim', explode(',', $value));

        foreach ($periods as $period) {
            if (!self::is_int_type($period)) {
                return false;
            }
        }
        return true;
    }
 
    /**
     * Check if a value is of type datetime
     * Regular expression for ISO 8601 datetime format (YYYY-MM-DDTHH:MM:SS.SSSZ)
     *
     * If the value is in the old format (YYYY-MM-DD), it transforms to the new format (YYYY-MM-DDT23:59:59.999Z).
     *
     * @param mixed $value The value to check
     * @return bool|string True if the value is of type datetime, transformed datetime string if in v1.0 format, false otherwise
     */
    public static function is_datetime_type($value) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{3}Z$/', $value)) {
            return true;
        }

        // Check if the value matches the v1.0 format (YYYY-MM-DD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Check if a value is of type date
     * Regular expression for ISO 8601 date format (YYYY-MM-DD)
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type date, false otherwise
     */
    public static function is_date_type($value) {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1;
    }

    /**
     * Check if a value is of type 
     * Regular expression for GUID (characters: 0-9, a-z, A-Z, ., -, _, /, @)
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type GUID, false otherwise
     */
    public static function is_guid_type($value) : bool {
        return strlen($value) < 256 && preg_match('/^[0-9a-zA-Z.\-_\/@]+$/', $value) === 1;
    }

    /**
     * Check if a value is of type status enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type status enum, false otherwise
     */
    public static function is_status_enum_type($value) : bool {
        $valid_status_values = ['active', 'tobedeleted', 'inactive'];
        return in_array(strtolower($value), $valid_status_values, true);
    }

    /**
     * Check if a value is of type type enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type type enum, false otherwise
     */
    public static function is_type_enum($value) : bool {
        $valid_type_values = ['gradingPeriod', 'semester', 'schoolYear', 'term'];
        return in_array($value, $valid_type_values, true);
    }

    /**
     * Check if a value is of type year
     * Regular expression for year format (YYYY)
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type year, false otherwise
     */
    public static function is_year_type($value) : bool {
        $currentYear = (int)date('Y');
        return preg_match('/^\d{4}$/', $value) === 1 && (int)$value >= 1800 && (int)$value <= $currentYear;
    }

    /**
     * Check if a value is of type grade
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type grade, false otherwise
     */
    public static function is_valid_grades($value) : bool{
        $valid_grade_codes = [
            'IT', 'PR', 'PK', 'TK', 'KG', '01', '02', '03', '04', '05', '06',
            '07', '08', '09', '10', '11', '12', '13', 'PS', 'UG', 'Other'
        ];
        $grades = array_map('trim', explode(',', $value));

        foreach ($grades as $grade) {
            if (!in_array($grade, $valid_grade_codes, true)) {
                return false;
            }
        }    
        return true;
    }

    /**
     * Check if a value is of type grade
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type grade, false otherwise
     */
    public static function is_valid_grade($value) : bool {
        $valid_grade_codes = [
            'IT', 'PR', 'PK', 'TK', 'KG', '01', '02', '03', '04', '05', '06',
            '07', '08', '09', '10', '11', '12', '13', 'PS', 'UG', 'Other'
        ];
        $value = trim($value);
        return in_array($value, $valid_grade_codes, true);
    }

    /**
     * Check if a value is of type class type enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type class type enum, false otherwise
     */
    public static function is_class_type_enum($value) : bool {
        $valid_class_types = ['homeroom', 'scheduled'];
        return in_array(strtolower($value), $valid_class_types, true);
    }

    /**
     * Check if a value is of type GUID list
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type GUID list, false otherwise
     */
    public static function is_valid_guid_list($value) : bool {
        $guids = array_map('trim', explode(',', $value));
    
        foreach ($guids as $guid) {
            if (!self::is_guid_type($guid)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if a value is of type role enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type role enum, false otherwise
     */
    public static function is_role_enum($value) : bool {
        $valid_roles = ['administrator', 'proctor', 'student', 'teacher'];
        return in_array(strtolower($value), $valid_roles, true);
    }

    /**
     * Check if a value is of type primary enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type primary enum, false otherwise
     */
    public static function is_primary_enum($value) : bool {
        $valid_primary_values = ['true', 'false'];
        return in_array(strtolower($value), $valid_primary_values, true);
    }

    /**
     * Check if a value is of type org type enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type org type enum, false otherwise
     */
    public static function is_org_type_enum($value) : bool {
        $valid_org_types = ['department', 'school', 'district', 'local', 'state', 'national'];
        return in_array(strtolower($value), $valid_org_types, true);
    }

    /**
     * Check if a value is of type email
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type email, false otherwise
     */
    public static function is_email_type($value) : bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check if a value is of type user ID or a valid user ID list.
     * Regular expression for user ID format ({[a-zA-Z0-9]+:[a-zA-Z0-9]+}).
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type user ID or user ID list, false otherwise
     */
    public static function is_valid_user_id($value) : bool {
        $value = trim($value, '"');
        $userIds = array_map('trim', explode(',', $value));
        
        foreach ($userIds as $userId) {
            if (!preg_match('/^\{[a-zA-Z0-9]+:[a-zA-Z0-9]+\}$/', $userId)) {
                return false;
            }
        }
        return true;
    }


    /**
     * Check if a value is of type role user enum
     *
     * @param mixed $value The value to check
     * @return bool True if the value is of type role user enum, false otherwise
     */
    public static function is_role_user_enum($value) : bool {
        $valid_roles = [
            'administrator', 'aide', 'guardian', 'parent', 'proctor', 
            'relative', 'student', 'teacher'
        ];
        return in_array(strtolower($value), $valid_roles, true);
    }
}
