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
 * Local plugin "Boost navigation fumbling" - Language pack
 *
 * @package    local_boostnavigation
 * @copyright  2017 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Boost navigation fumbling';
$string['setting_removenodesheading'] = 'Remove root nodes from Boost\'s nav drawer';
$string['setting_removenodestechnicalhint'] = 'Technically, this is done by setting the node\'s showinflatnavigation attribute to false. Thus, the node will only be hidden from the nav drawer, but it will remain in the navigation tree and can still be accessed by other parts of Moodle.';
$string['setting_removecalendarnode'] = 'Remove "Calendar" node';
$string['setting_removecalendarnode_desc'] = 'Enabling this setting will remove the "Calendar" node from Boost\'s nav drawer.';
$string['setting_removefirsthomenode'] = 'Remove first "Home" or "Dashboard" node';
$string['setting_removefirsthomenode_desc'] = 'Enabling this setting will remove the "Home" or "Dashboard" node, depending on what the user chose to be his home page, from Boost\'s nav drawer.';
$string['setting_removehomenode'] = 'Remove "Home" node';
$string['setting_removehomenode_desc'] = 'Enabling this setting will remove the "Home" node from Boost\'s nav drawer.';
$string['setting_removesecondhomenode'] = 'Remove second "Home" or "Dashboard" node';
$string['setting_removesecondhomenode_desc'] = 'Enabling this setting will remove the "Home" or "Dashboard" node, depending on what the user chose not to be his home page, from Boost\'s nav drawer.';
$string['setting_removedashboardnode'] = 'Remove "Dashboard" node';
$string['setting_removedashboardnode_desc'] = 'Enabling this setting will remove the "Dashboard" node from Boost\'s nav drawer.';
$string['setting_removemycoursesnode'] = 'Remove "My courses" node';
$string['setting_removemycoursesnode_desc'] = 'Enabling this setting will remove the "My courses" node from Boost\'s nav drawer.';
$string['setting_removemycoursesnodeperformancehint'] = 'Please note: If you enable this setting and have also enabled the setting <a href="/admin/search.php?query=navshowmycoursecategories">navshowmycoursecategories</a>, removing the "My courses" node takes more time and you should consider disabling the navshowmycoursecategories setting.';
$string['setting_removeprivatefilesnode'] = 'Remove "Private files" node';
$string['setting_removeprivatefilesnode_desc'] = 'Enabling this setting will remove the "Private files" node from Boost\'s nav drawer.';
$string['setting_collapseactivitiescoursenode'] = 'Collapse node "Activities"';
$string['setting_collapseactivitiescoursenode_desc'] = 'Enabling this setting will let users collapse the "Activities" node.<br /><em>This setting is only processed when the "Inserting node \'Activities\'" setting is also activated.</em>';
$string['setting_collapseactivitiescoursenodedefault'] = 'Collapse node "Activities" by default';
$string['setting_collapseactivitiescoursenodedefault_desc'] = 'Enabling this setting will collapse the "Activities" node by default. Otherwise, it will be expanded by default. This setting just controls the default for each user when the node is rendered for him for the first time.<br /><em>This setting is only processed when collapsing the node is activated at all.</em>';
$string['setting_collapsecoursenodesheading'] = 'Collapse course nodes in Boost\'s nav drawer';
$string['setting_collapsecoursesectionscoursenode'] = 'Collapse node "Sections"';
$string['setting_collapsecoursesectionscoursenode_desc'] = 'Enabling this setting will let users collapse the "Sections" node.<br /><em>This setting is only processed when the "Inserting node \'Sections\'" setting is also activated.</em>';
$string['setting_collapsecoursesectionscoursenodedefault'] = 'Collapse node "Sections" by default';
$string['setting_collapsecoursesectionscoursenodedefault_desc'] = 'Enabling this setting will collapse the "Sections" node by default. Otherwise, it will be expanded by default. This setting just controls the default for each user when the node is rendered for him for the first time.<br /><em>This setting is only processed when collapsing the node is activated at all.</em>';
$string['setting_collapsenodesheading'] = 'Collapse root nodes in Boost\'s nav drawer';
$string['setting_collapsemycoursesnode'] = 'Collapse node "My Courses"';
$string['setting_collapsemycoursesnode_desc'] = 'Enabling this setting will let users collapse the "My courses" node.';
$string['setting_collapsemycoursesnodedefault'] = 'Collapse node "My Courses" by default';
$string['setting_collapsemycoursesnodedefault_desc'] = 'Enabling this setting will collapse the "My courses" node by default. Otherwise, it will be expanded by default. This setting just controls the default for each user when the node is rendered for him for the first time.<br /><em>This setting is only processed when collapsing the node is activated at all.</em>';
$string['setting_collapsemycoursesnodeperformancehint'] = 'Please note: This feature will only work if the setting <a href="/admin/search.php?query=navshowmycoursecategories">navshowmycoursecategories</a> is not active. If you enabled navshowmycoursecategories, this setting will be ignored and won\'t do anything.';
$string['setting_collapsenodestechnicalhint'] = 'Technically, this is done by adding some JavaScript and CSS code to the page which will show or hide the second-level nodes as soon as the user clicks on the node. The collapse status of the node will be stored in each user\'s session. Thus, the nodes will only be hidden from the nav drawer at runtime, but they will remain in the navigation tree and can still be accessed by other parts of Moodle.';
$string['setting_collapsenodestemplatehint'] = 'Please note that this feature is only working with Boost installations which have the patch from MDL-59425 integrated. See README file for details';
$string['setting_insertactivitiescoursenode'] = 'Insert node "Activities"';
$string['setting_insertactivitiescoursenode_desc'] = 'Enabling this setting will insert an "Activities" node to Boost\'s nav drawer which will hold nodes linking to the activity overview pages. It basically brings the existing functionality of the "Activities" block to Boost\'s nav drawer.';
$string['setting_insertcoursenodesheading'] = 'Insert course nodes to Boost\'s nav drawer';
$string['setting_insertcoursesectionscoursenode'] = 'Insert node "Sections"';
$string['setting_insertcoursesectionscoursenode_desc'] = 'Enabling this setting will insert a "Sections" node to Boost\'s nav drawer which will be placed above the first section of the current course.';
$string['setting_insertcoursesectionscoursenodecorehint'] = 'Please note: This feature will only work if the setting <a href="/admin/search.php?query=linkcoursesections">linkcoursesections</a> is active. If you disabled linkcoursesections, this setting will be ignored and won\'t do anything.';
$string['setting_insertnodescollapsehint'] = 'Please note that the inserted node has an action link which leads to the course home page because Boost does not support adding nodes without an action link. The action link will be overridden as soon as you also enable the setting to collapse the node at the same time.';
$string['setting_insertresourcescoursenode'] = 'Insert node "Resources"';
$string['setting_insertresourcescoursenode_desc'] = 'Enabling this setting will insert a "Resources" node to Boost\'s nav drawer which will link to the resources overview page.<br /><em>This setting is associated to the "Inserting node \'Activities\'" setting. If you enable both settings, you wil get an "Activities" and a "Resources" node as requested. If you only enable the "Activities" setting, the "Activities" node will also hold a node linking to the resources overview page.</em>';
