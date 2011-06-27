<?php

$THEME->name = 'mymobile';

////////////////////////////////////////////////////
// Name of the theme. Most likely the name of
// the directory in which this file resides. 
////////////////////////////////////////////////////


$THEME->parents = array(
    'canvas',
    'base',
);

/////////////////////////////////////////////////////
// Which existing theme(s) in the /theme/ directory
// do you want this theme to extend. A theme can 
// extend any number of themes. Rather than 
// creating an entirely new theme and copying all 
// of the CSS, you can simply create a new theme, 
// extend the theme you like and just add the 
// changes you want to your theme.
////////////////////////////////////////////////////


$THEME->sheets = array(
    'jmobile1b1',
    'core'
);

////////////////////////////////////////////////////
// Name of the stylesheet(s) you've including in 
// this theme's /styles/ directory.
////////////////////////////////////////////////////

$THEME->parents_exclude_sheets = array(
        'base'=>array(
            'pagelayout',
            'dock', 
            'editor',
        ),
        'canvas'=>array(
            'pagelayout',
            'tabs',
            'editor',
            
        ),
        

);


$THEME->enable_dock = false;


////////////////////////////////////////////////////
// Do you want to use the new navigation dock?
////////////////////////////////////////////////////


//$THEME->editor_sheets = array('editor');

////////////////////////////////////////////////////
// An array of stylesheets to include within the 
// body of the editor.
////////////////////////////////////////////////////
$toblock = optional_param('blocks', false, PARAM_BOOL);
//get whether to show blocks and use appropriate pagelayout
//this is necessary for block JS errors and other block problems
if($toblock) {
$THEME->layouts = array(
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'standard' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'course' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post'
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    
    'frontpage' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        
        //'options' => array('nonavbar'=>true),
    ),
    'admin' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'mydashboard' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('nonavbar'=>true),
    ),
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nonavbar'=>true),
    ),
    'popup' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'noblocks'=>true, 'nonavbar'=>true),
    ),
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true),
    ),
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),
     // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true),
    ),
     // The pagelayout used for reports
    'report' => array(
        'file' => 'general.php',
        'regions' => array(),
         'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),


);
}
else {
//get rid of block region
$THEME->layouts = array(
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'standard' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'course' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    
    'frontpage' => array(
        'file' => 'general.php',
        'regions' => array(),
        
        //'options' => array('nonavbar'=>true),
    ),
    'admin' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'mydashboard' => array(
        'file' => 'general.php',
        'regions' => array(),
        
        'options' => array('nonavbar'=>true),
    ),
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nonavbar'=>true),
    ),
    'popup' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'noblocks'=>true, 'nonavbar'=>true),
    ),
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true),
    ),
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),
     // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true),
    ),
     // The pagelayout used for reports
    'report' => array(
        'file' => 'general.php',
        'regions' => array(),
         'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),


);
}

///////////////////////////////////////////////////////////////
// These are all of the possible layouts in Moodle. The
// simplest way to do this is to keep the theme and file
// variables the same for every layout. Including them
// all in this way allows some flexibility down the road
// if you want to add a different layout template to a
// specific page.
///////////////////////////////////////////////////////////////


    
////////////////////////////////////////////////////
// Allows the user to provide the name of a function 
// that all CSS should be passed to before being 
// delivered.
////////////////////////////////////////////////////

// $THEME->filter_mediaplugin_colors

////////////////////////////////////////////////////
// Used to control the colours used in the small 
// media player for the filters
////////////////////////////////////////////////////

 //$THEME->javascripts = 'jquery.mobile-1.0a1.min';
  //$THEME->javascripts = array('jquery.mobile-1.0a1.min');
  $THEME->javascripts = array('jquery-1.6.1.min', 'custom', 'jquery.mobile-1.0b1','scrollview','easing');

////////////////////////////////////////////////////
// An array containing the names of JavaScript files
// located in /javascript/ to include in the theme. 
// (gets included in the head)
////////////////////////////////////////////////////

// $THEME->javascripts_footer   

////////////////////////////////////////////////////
// As above but will be included in the page footer.
////////////////////////////////////////////////////

// $THEME->larrow   

////////////////////////////////////////////////////
// Overrides the left arrow image used throughout 
// Moodle
////////////////////////////////////////////////////

// $THEME->rarrow   

////////////////////////////////////////////////////
// Overrides the right arrow image used throughout Moodle
////////////////////////////////////////////////////

// $THEME->layouts  

////////////////////////////////////////////////////
// An array setting the layouts for the theme
////////////////////////////////////////////////////

// $THEME->parents_exclude_javascripts

////////////////////////////////////////////////////
// An array of JavaScript files NOT to inherit from
// the themes parents
////////////////////////////////////////////////////

// $THEME->parents_exclude_sheets   

////////////////////////////////////////////////////
// An array of stylesheets not to inherit from the
// themes parents
////////////////////////////////////////////////////

// $THEME->plugins_exclude_sheets

////////////////////////////////////////////////////
// An array of plugin sheets to ignore and not 
// include.
////////////////////////////////////////////////////

// $THEME->renderfactory

////////////////////////////////////////////////////
// Sets a custom render factory to use with the 
// theme, used when working with custom renderers.
////////////////////////////////////////////////////

// $THEME->resource_mp3player_colors

////////////////////////////////////////////////////
// Controls the colours for the MP3 player  
////////////////////////////////////////////////////

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
//$THEME->csspostprocess = 'mymobile_process_css';