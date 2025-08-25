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
 * This file contains the news item block class, based upon block_base.
 *
 * @package    block_news_items
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class block_customprefs
 *
 * @package    block_customprefs
 * @copyright  2024  zabelle_motte
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();

 
class block_customprefs extends block_base {

    public function init() {
        $this->title = get_string('blocktitle','block_customprefs');
    }
    

 function applicable_formats() {
        return array('my' => true);
    }
    
 public function has_config() {
        return false;
    }

 function get_required_javascript() {
       //script to display block with form course selection 
        $this->page->requires->js_call_amd('block_customprefs/optionselection','init');
 }


function get_content() {
       global $USER;
       // get list of possible options
       $options=[];
       $options[0]=get_string('option1', 'block_customprefs');
       $options[1]=get_string('option2', 'block_customprefs');
       $options[2]=get_string('option3', 'block_customprefs');
       // get list of choosen options
       if( isset( $_POST['customprefs_optionchoice'] ) ){
           $currentchoice = $_POST['customprefs_optionchoice'];
           set_user_preference('customprefs_optionchoice', $currentchoice);
       }
       else {           
           $currentchoice=get_user_preferences('customprefs_optionchoice');
       }
       // build user courses list 
       $courselistarray=[];
       $allcourses=[];
       if ($courses = enrol_get_my_courses()) {
                foreach ($courses as $course) {
                    $courseid= $course->id;
                    $courseshortname=$course->shortname;
                    $courselistarray[$courseid] =$courseshortname;
                    array_push($allcourses,$courseid);
                }
        }
       // get list of choosen courses or select all
       if (isset( $_POST['customprefs_courseschoice'] ) )
       {
       $currentcourses = $_POST['customprefs_courseschoice'];
       $currentcoursesstring= implode(',', $currentcourses);
       set_user_preference('customprefs_courseschoice', $currentcoursesstring);
       }
       elseif ( !is_null( get_user_preferences('customprefs_courseschoice') ) ) 
       {
       $currentcoursesstring = get_user_preferences('customprefs_courseschoice');
       $currentcourses=explode(',', $currentcoursesstring);
       }
       else
       $currentcourses=$allcourses;

       $this->content = new stdClass;
       $this->content->text="";
       // button to open option selection form
       $this->content->text .=html_writer::start_tag('div', array('class'=>'customprefs_optionselectopener','id'=>'customprefs_optionselectopener'));
       $this->content->text .=get_string('osotext','block_customprefs');
       $this->content->text .="<span class='expanded-icon'><i class='icon fa fa-chevron-down fa-fw'></i></span>";
       $this->content->text .= html_writer::end_tag('div');
         // button to open course selection form  
       $this->content->text .=html_writer::start_tag('div', array('class'=>'customprefs_courseselectopener','id'=>'customprefs_courseselectopener'));
       $this->content->text .=get_string('csotext','block_customprefs');
       $this->content->text .="<span class='expanded-icon'><i class='icon fa fa-chevron-down fa-fw'></i></span>";
       $this->content->text .= html_writer::end_tag('div');
       
       // block with option selection form
       $this->content->text .=html_writer::start_tag('div', array('class'=>'customprefs_optionselectblock','id'=>'customprefs_optionselectblock'));
       $this->content->text .= html_writer::start_tag('form', array('action' => '','method' => 'post','class' => 'customprefs_optionselectform'));
       // radio boxes with list of options
       for ($i=0; $i<sizeof($options);$i++) {
           if ($i==$currentchoice)
               $checked='checked';
           else $checked='';
           $this->content->text .= "<input type='radio' name='customprefs_optionchoice' value='".$i."' ".$checked."/>";
           $this->content->text .="<label>".$options[$i]."</label>";
       }
       // submit button for option selection form
        $this->content->text .=html_writer::start_tag('button',array('class'=>'customprefs_optionselectbutton','onclick'=>'document.getElementById("customprefs_optionselectblock").submit()'));
        $this->content->text .=get_string("save","block_customprefs");
        $this->content->text .=html_writer::end_tag('button');
       //$this->content->text .= html_writer::select($options, 'customprefs_choice',$currentchoice,false, array('onchange'=>'this.form.submit()'));       
       $this->content->text .= html_writer::end_tag('form');
       $this->content->text .= html_writer::end_tag('div');

  
            // block with course selection form
       $this->content->text .=html_writer::start_tag('div', array('class'=>'customprefs_courseselectblock', 'id'=>'customprefs_courseselectblock'));
       $this->content->text .= html_writer::start_tag('form', array('action' => '','method' => 'post','class' => 'customprefs_courseselectform'));
       // checkboxes with list of courses
       foreach ($courses as $course) {
                    $courseid= $course->id;
                    if (in_array($courseid,$currentcourses))
                        $checked=true; 
                    else $checked=false;
                    $courseshortname=$course->shortname;
                    $this->content->text .= html_writer::checkbox('customprefs_courseschoice[]',$courseid,$checked,$courseshortname);
       }
        // submit button for course selection form
        $this->content->text .=html_writer::start_tag('button',array('class'=>'customprefs_courseselectbutton','onclick'=>'document.getElementById("customprefs_courseselectblock").submit()'));
        $this->content->text .=get_string("save","block_customprefs");
        $this->content->text .=html_writer::end_tag('button');

       $this->content->text .= html_writer::end_tag('form');
        $this->content->text .= html_writer::end_tag('div');


       // result of the different selections
       $this->content->text.="<hr><div class='customprefs_option'> ".get_string('ocitext','block_customprefs').$options[$currentchoice]."</div>";
       $this->content->text.="<div class='customprefs_course'>".get_string('ccitext','block_customprefs');
       foreach ($currentcourses as $one){
             $this->content->text.=$courselistarray[$one].", ";
       }
       $this->content->text=rtrim($this->content->text,', ');
       $this->content->text.="</div>";
 
        return $this->content;
    }
}


