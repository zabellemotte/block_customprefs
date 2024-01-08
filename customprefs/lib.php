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
 * Library functions for overview.
 *
 * @package   block_customprefs
 * @copyright 2024 zabelle_motte
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();



/**
 * Get the current user preferences that are available
 *
 * @uses core_user::is_current_user
 *
 * @return array[] Array representing current options along with defaults
 */


    $preferences['customprefs_optionchoice'] = array(
        'null' => NULL_NOT_ALLOWED,
        'default' => 0,
        'type' => PARAM_ALPHA,
        'choices' => array(0,1,2),
        'permissioncallback' => [core_user::class, 'is_current_user'],
    );
    
    $preferences['customprefs_courseschoice'] = array(
        'null' => NULL_ALLOWED,
        'default' => null,
        'type' => PARAM_RAW,
        'permissioncallback' => [core_user::class, 'is_current_user'],
    );

    return $preferences;
   

