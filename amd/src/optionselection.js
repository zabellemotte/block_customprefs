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
 * Class block_customprefs
 *
 * @package    block_customprefs
 * @copyright  2024  zabelle_motte
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */ 
 define(['jquery','block_customprefs/optionselection'], function($,myscript) {
    return {
        init: function() {
            let mytogg0 = document.getElementById('customprefs_optionselectopener'); 
            let mytogg1 = document.getElementById('customprefs_courseselectopener'); 
            let myd0=document.getElementById('customprefs_optionselectblock');
            let myd1=document.getElementById('customprefs_courseselectblock');
            mytogg0.addEventListener('click', () => {
                if(getComputedStyle(myd0).display != 'none'){
                    myd0.style.display = 'none';
                } else {
                    myd1.style.display = 'none';
                    myd0.style.display = 'block';
                }
            });
            mytogg1.addEventListener('click', () => {
                if(getComputedStyle(myd1).display != 'none'){
                    myd1.style.display = 'none';
                } else {
                   myd0.style.display = 'none';
                   myd1.style.display = 'block';
                }
            });
        }
    }
});
