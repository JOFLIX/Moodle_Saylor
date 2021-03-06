<?php

// This file is part of the Accredible Certificate module for Moodle - http://moodle.org/
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
 * Certificate module core interaction API
 *
 * @package    mod
 * @subpackage accredible
 * @copyright  Accredible <dev@accredible.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/mod/accredible/locallib.php');

/**
 * Add certificate instance.
 *
 * @param array $certificate
 * @return array $certificate new certificate object
 */
function accredible_add_instance($post) {
    global $DB, $CFG;

    $course = $DB->get_record('course', array('id'=> $post->course), '*', MUST_EXIST);

    $group_id = sync_course_with_accredible($course, $post->instance, $post->groupid);

    // Issue certs
    if( isset($post->users) ) {
        // Checklist array from the form comes in the format:
        // int user_id => boolean issue_certificate
        foreach ($post->users as $user_id => $issue_certificate) {
            if($issue_certificate) {
                $user = $DB->get_record('user', array('id'=>$user_id), '*', MUST_EXIST);

                $credential = create_credential($user, $group_id);

                // evidence item posts
                $credential_id = $credential->id;
                if($post->finalquiz) {
                    $quiz = $DB->get_record('quiz', array('id'=>$post->finalquiz), '*', MUST_EXIST);
                    $users_grade = min( ( quiz_get_best_grade($quiz, $user->id) / $quiz->grade ) * 100, 100);
                    $grade_evidence =  array('string_object' => (string) $users_grade, 'description' => $quiz->name, 'custom'=> true, 'category' => 'grade');
                    if($users_grade < 50) {
                        $grade_evidence['hidden'] = true;
                    }
                    accredible_post_evidence($credential_id, $grade_evidence, true);
                }
                if($transcript = accredible_get_transcript($post->course, $user_id, $post->finalquiz)) {
                    accredible_post_evidence($credential_id, $transcript, true);
                }
                accredible_post_essay_answers($user_id, $post->course, $credential_id);
                accredible_course_duration_evidence($user_id, $post->course, $credential_id);
            }
        }
    }

    // Save record
    $db_record = new stdClass();
    $db_record->completionactivities = $post->completionactivities;
    $db_record->name = $post->name;
    $db_record->course = $post->course;
    $db_record->finalquiz = $post->finalquiz;
    $db_record->passinggrade = $post->passinggrade;
    $db_record->timecreated = time();
    $db_record->groupid = $group_id;

    return $DB->insert_record('accredible', $db_record);
}

/**
 * Update certificate instance.
 *
 * @param stdClass $post
 * @return stdClass $certificate updated 
 */
function accredible_update_instance($post) {
    // To update your certificate details, go to accredible.com.
    global $DB, $CFG;

    // don't know what this is
    $accredible_cm = get_coursemodule_from_id('accredible', $post->coursemodule, 0, false, MUST_EXIST);

    $accredible_certificate = $DB->get_record('accredible', array('id'=> $post->instance), '*', MUST_EXIST);

    $course = $DB->get_record('course', array('id'=> $post->course), '*', MUST_EXIST);

    // Update the group if we have one to sync with
    if($accredible_certificate->groupid){
        sync_course_with_accredible($course, $post->instance, $post->groupid);
    }

    // Issue certs for unissued users
    if(isset($post->unissuedusers)) {
        // Checklist array from the form comes in the format:
        // int user_id => boolean issue_certificate
        $groupid = $accredible_certificate->groupid;

        foreach ($post->unissuedusers as $user_id => $issue_certificate) {
            if($issue_certificate) {
                $user = $DB->get_record('user', array('id'=>$user_id), '*', MUST_EXIST);
                $completed_timestamp = accredible_manual_issue_completion_timestamp($accredible_certificate, $user);
                $completed_date = date('Y-m-d', (int) $completed_timestamp);

                    // Create the credential
                    $result = create_credential($user, $groupid, null, $completed_date);
                    $credential_id = $result->id;
                    // evidence item posts
                    if($post->finalquiz) {
                        $quiz = $DB->get_record('quiz', array('id'=>$post->finalquiz), '*', MUST_EXIST);
                        $users_grade = min( ( quiz_get_best_grade($quiz, $user->id) / $quiz->grade ) * 100, 100);
                        $grade_evidence =  array('string_object' => (string) $users_grade, 'description' => $quiz->name, 'custom'=> true, 'category' => 'grade');
                        if($users_grade < 50) {
                            $grade_evidence['hidden'] = true;
                        }
                        accredible_post_evidence($credential_id, $grade_evidence, true);
                    }
                    if($transcript = accredible_get_transcript($post->course, $user_id, $post->finalquiz)) {
                        accredible_post_evidence($credential_id, $transcript, true);
                    }
                    accredible_post_essay_answers($user_id, $post->course, $credential_id);
                    accredible_course_duration_evidence($user_id, $post->course, $credential_id, $completed_timestamp);

                // Log the creation
                $event = accredible_log_creation( 
                    $credential_id,
                    $user->id,
                    null,
                    $post->coursemodule
                );
                $event->trigger();
            }
        }       
    }

    // Issue certs
    if( isset($post->users) ) {
        // Checklist array from the form comes in the format:
        // int user_id => boolean issue_certificate
        foreach ($post->users as $user_id => $issue_certificate) {
            if($issue_certificate) {
                $user = $DB->get_record('user', array('id'=>$user_id), '*', MUST_EXIST);
                $completed_timestamp = accredible_manual_issue_completion_timestamp($accredible_certificate, $user);
                $completed_date = date('Y-m-d', (int) $completed_timestamp);
                
                $credential = create_credential($user, $accredible_certificate->groupid, null, $completed_date);

                // evidence item posts
                $credential_id = $credential->id;
                if($post->finalquiz) {
                    $quiz = $DB->get_record('quiz', array('id'=>$post->finalquiz), '*', MUST_EXIST);
                    $users_grade = min( ( quiz_get_best_grade($quiz, $user->id) / $quiz->grade ) * 100, 100);
                    $grade_evidence =  array('string_object' => (string) $users_grade, 'description' => $quiz->name, 'custom'=> true, 'category' => 'grade');
                    if($users_grade < 50) {
                        $grade_evidence['hidden'] = true;
                    }
                    accredible_post_evidence($credential_id, $grade_evidence, true);
                }
                if($transcript = accredible_get_transcript($post->course, $user_id, $post->finalquiz)) {
                    accredible_post_evidence($credential_id, $transcript, true);
                }
                accredible_post_essay_answers($user_id, $post->course, $credential_id);
                accredible_course_duration_evidence($user_id, $post->course, $credential_id, $completed_timestamp);

                // Log the creation
                $event = accredible_log_creation( 
                    $credential_id,
                    $user_id,
                    null,
                    $post->coursemodule
                );
                $event->trigger();
            }
        }
    }

    // If the group was changed we should save that
    $groupid = $accredible_certificate->groupid;

    // Set completion activitied to 0 if unchecked
    if(!property_exists($post, 'completionactivities')){
        $post->completionactivities = 0;
    }

    // Save record
    $db_record = new stdClass();
    $db_record->id = $post->instance;
    $db_record->completionactivities = $post->completionactivities;
    $db_record->name = $post->name;
    $db_record->course = $post->course;
    $db_record->finalquiz = $post->finalquiz;
    $db_record->passinggrade = $post->passinggrade;
    $db_record->timecreated = time();
    $db_record->groupid = $groupid;

    return $DB->update_record('accredible', $db_record);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance.
 *
 * @param int $id
 * @return bool true if successful
 */
function accredible_delete_instance($id) {
    global $DB;

    // Ensure the certificate exists
    if (!$certificate = $DB->get_record('accredible', array('id' => $id))) {
        return false;
    }

    return $DB->delete_records('accredible', array('id' => $id));
}

/**
 * Supported feature list
 *
 * @uses FEATURE_MOD_INTRO
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function accredible_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:               return false;
        default: return null;
    }
}