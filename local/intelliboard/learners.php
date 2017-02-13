<?php
// IntelliBoard.net
//
// IntelliBoard.net is built to work with any LMS designed in Moodle
// with the goal to deliver educational data analytics to single dashboard instantly.
// With power to turn this analytical data into simple and easy to read reports,
// IntelliBoard.net will become your primary reporting tool.
//
// Moodle
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// IntelliBoard.net is built as a local plugin for Moodle.

/**
 * IntelliBoard.net
 *
 *
 * @package    	intelliboard
 * @copyright  	2015 IntelliBoard, Inc
 * @license    	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @created by	IntelliBoard, Inc
 * @website		www.intelliboard.net
 */
require('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot .'/local/intelliboard/externallib.php');
require_once($CFG->dirroot .'/local/intelliboard/locallib.php');

require_login();
require_capability('local/intelliboard:view', context_system::instance());
admin_externalpage_setup('intelliboardlearners');

$params = (object) array(
	'filter_user_deleted'=>get_config('local_intelliboard', 'filter1'),
	'filter_user_suspended'=>get_config('local_intelliboard', 'filter2'),
	'filter_user_guest'=>get_config('local_intelliboard', 'filter3'),
	'filter_course_visible'=>get_config('local_intelliboard', 'filter4'),
	'filter_enrolmethod_status'=>get_config('local_intelliboard', 'filter5'),
	'filter_enrol_status'=>get_config('local_intelliboard', 'filter6'),
	'filter_enrolled_users'=>get_config('local_intelliboard', 'filter8'),
	'filter_module_visible'=>get_config('local_intelliboard', 'filter7'),
	'teacher_roles'=>get_config('local_intelliboard', 'filter10'),
	'learner_roles'=>get_config('local_intelliboard', 'filter11'),
	'sizemode'=> get_config('local_intelliboard', 'sizemode'),
	'userid'=>0,
	'courseid'=>0,
	'timestart'=> strtotime('-6 month'),
	'timefinish'=>time()
);
$plugin = new local_intelliboard_external();
$data  = array(
	15 => json_encode($plugin->get_system_users($params)),
	19 => json_encode($plugin->get_unique_sessions($params)),
	4 => json_encode($plugin->get_active_users($params)),
	2 => json_encode($plugin->get_active_users_per_day($params)),
	3 => json_encode($plugin->get_users_per_day($params)),
	1 => json_encode($plugin->get_users_count($params))
);
$params = array(
	'url'=>$CFG->wwwroot,
	'email'=>s($USER->email),
	'firstname'=>s($USER->firstname),
	'lastname'=>s($USER->lastname),
	'reports'=>get_config('local_intelliboard', 'reports'),
	'data'=>json_encode($data),
	'type'=>'learners',
	'do'=>'widgets'
);
$intelliboard = intelliboard($params);
$PAGE->set_pagelayout('report');
$PAGE->set_pagetype('learners');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('intelliboardroot', 'local_intelliboard'));
$PAGE->set_heading(get_string('intelliboardroot', 'local_intelliboard'));
$PAGE->requires->css('/local/intelliboard/assets/css/style.css');
echo $OUTPUT->header();
?>
<script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
			  'language':'en',
              'packages':['corechart']
            }]
          }"></script>
<div class="intelliboard-page">
	<?php include("views/menu.php"); ?>
	<div class="intelliboard-content"><?php echo intelliboard_clean($intelliboard->content); ?></div>
	<?php include("views/footer.php"); ?>
</div>
<?php
echo $OUTPUT->footer();
