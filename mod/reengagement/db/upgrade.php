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
 * Upgrade tasks.
 *
 * @package    mod_reengagement
 * @author     Peter Bulmer
 * @copyright  2016 Catalyst IT {@link http://www.catalyst.net.nz}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Code run to upgrade the reengagment database tables.
 *
 * @param int $oldversion
 * @return bool always true
 */
function xmldb_reengagement_upgrade($oldversion=0) {
    global $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2014071701) {
        // Define new fields to support emailing managers.
        // Define field emailrecipient to be added to reengagement to record who should receive emails.
        $table = new xmldb_table('reengagement');
        $field = new xmldb_field('emailrecipient', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('reengagement');
        // Define field to hold the email subject which should be used in emails to user's managers.
        $field = new xmldb_field('emailsubjectmanager', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('reengagement');
        // Define field to hold the email content which should be used in emails to user's managers.
        $field = new xmldb_field('emailcontentmanager', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('reengagement');
        $field = new xmldb_field('emailcontentmanagerformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_mod_savepoint(true, 2014071701, 'reengagement');
    }

    // Add remindercount fields.
    if ($oldversion < 2016080301) {

        $table = new xmldb_table('reengagement');
        $field = new xmldb_field('remindercount', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, '1');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_mod_savepoint(true, 2016080301, 'reengagement');
    }

    // Add third-party email fields.
    if ($oldversion < 2016112400) {
        // Define new fields to support emailing thirdparties.
        $table = new xmldb_table('reengagement');

        // Define field thirdpartyemails to be added to reengagement to record who should receive emails.
        $field = new xmldb_field('thirdpartyemails', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field to hold the email subject which should be used in emails to user's thirdparties.
        $field = new xmldb_field('emailsubjectthirdparty', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field to hold the email content which should be used in emails to user's thirdparties.
        $field = new xmldb_field('emailcontentthirdparty', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('emailcontentthirdpartyformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_mod_savepoint(true, 2016112400, 'reengagement');
    }
    // Set default value
    if ($oldversion < 2017040400) {

        $table = new xmldb_table('reengagement');
        $field = new xmldb_field('thirdpartyemails', XMLDB_TYPE_TEXT, null, null, false, null, null);
        $dbman->change_field_notnull($table, $field);

        $field = new xmldb_field('emailsubjectthirdparty', XMLDB_TYPE_CHAR, '255', null, false, null, null);
        $dbman->change_field_notnull($table, $field);

        $field = new xmldb_field('emailcontentthirdparty', XMLDB_TYPE_TEXT, null, null, false, null, null);
        $dbman->change_field_notnull($table, $field);

        $field = new xmldb_field('emailcontentthirdpartyformat', XMLDB_TYPE_INTEGER, '4', null, false, null, '0');
        $dbman->change_field_notnull($table, $field);

        upgrade_mod_savepoint(true, 2017040400, 'reengagement');
    }

    return true;
}