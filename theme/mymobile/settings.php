<?php


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

$name = 'theme_mymobile/mswatch';
    $title = get_string('mswatch','theme_mymobile');
    $description = get_string('mswatchdesc', 'theme_mymobile');
    $default = 'light';
    $choices = array('light'=>'light', 'grey'=>'grey');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
    $name = 'theme_mymobile/mtext';
    $title = get_string('mtext','theme_mymobile');
    $description = get_string('mtextdesc', 'theme_mymobile');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

$name = 'theme_mymobile/mtopic';
    $title = get_string('mtopic','theme_mymobile');
    $description = get_string('mtopicdesc', 'theme_mymobile');
    $default = 'topicshow';
    $choices = array('topicshow'=>'Yes', 'topicnoshow'=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
$name = 'theme_mymobile/mimgs';
    $title = get_string('mimgs','theme_mymobile');
    $description = get_string('mimgsdesc', 'theme_mymobile');
    $default = 'ithumb';
    $choices = array('ithumb'=>'No', 'ithumbno'=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
  
   
}
