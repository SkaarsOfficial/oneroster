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
use moodleform;

require_once($CFG->libdir . '/formslib.php');

/**
 * One Roster Enrollment Client.
 *
 * @package    enrol_oneroster
 * @copyright  Gustavo Amorim De Almeida, Ruben Cooper, Josh Bateson, Brayden Porter
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class oneroster_csv_form extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        // file picker for CSV file upload
        $mform->addElement('filepicker', 'uploadedzip', 'Upload Zip File', null, array('accepted_types' => '.zip'));
        $mform->addRule('uploadedzip', null, 'required', null, 'client');

        // buttons
        $this->add_action_buttons(true, 'Upload');
    }
}
