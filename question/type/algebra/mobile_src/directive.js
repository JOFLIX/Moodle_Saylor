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
 * @package    qtype_algebra
 * @copyright  2017 Jean-Michel Vedrine
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

angular.module('mm.addons.qtype_algebra')

/**
 * Directive to render a short answer question.
 *
 * @module mm.addons.qtype_algebra
 * @ngdoc directive
 * @name mmaQtypeAlgebra
 */
.directive('mmaQtypeAlgebra', function($log, $mmQuestionHelper) {
	$log = $log.getInstance('mmaQtypeAlgebra');

    return {
        restrict: 'A',
        priority: 100,
        templateUrl: 'addons/qtype/algebra/template.html',
        link: function(scope) {
            $mmQuestionHelper.inputTextDirective(scope, $log);
        }
    };
});
