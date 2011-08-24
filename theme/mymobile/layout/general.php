<?php
$toblock = optional_param('mymobile_blocks', false, PARAM_BOOL);
//get blocks?
$toset = optional_param('mymobile_settings', false, PARAM_BOOL);
//get settings?

$mypagetype = $this->page->pagetype;


if (!empty($PAGE->theme->settings->mswatch)) {
    $showswatch = $PAGE->theme->settings->mswatch;
    } else {
    $showswatch = 'light';
}
    
if ($showswatch == 'light') {
    $dtheme = 'd';
    $dthemeb = 'd';
    $datatheme = 'data-theme=b';
    $databodytheme = 'data-theme=d';
} else {
    $dtheme = 'd';
    $dthemeb = 'c';
    $datatheme = 'data-theme=a';
    $databodytheme = '';
}

//custom settings
$hasmtext = (!empty($PAGE->theme->settings->mtext));

if (!empty($PAGE->theme->settings->mimgs)) {
    $hasithumb = $PAGE->theme->settings->mimgs;
    } else {
    $hasithumb = 'ithumb';
}

if (!empty($PAGE->theme->settings->mtopic)) {
    $showsitetopic = $PAGE->theme->settings->mtopic;
    } else {
    $showsitetopic = 'topicnoshow';
}

if ($mypagetype == 'course-view-topics' || $mypagetype == 'course-view-weeks') {
    $jumptocurrent = 'true';
    //jump to current topic only in course pages
}

else {
    $jumptocurrent = 'false';
}

// below sets a URL variable to use in some links
$url = new moodle_url($this->page->url, array('mymobile_blocks' => 'true'));
$urlS = new moodle_url($this->page->url, array('mymobile_settings' => 'true'));
    
    $hasheading = ($PAGE->heading);
    $hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
    $hasfooter = (empty($PAGE->layout_options['nofooter']));
    $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
    $bodyclasses = array();
    $bodyclasses[] = ''.$hasithumb.'';
    $bodyclasses[] = ''.$showsitetopic .'';
    //add ithumb class to decide whether to show or hide images and site topic 

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $SITE->shortname ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $OUTPUT->pix_url('m2m2x', 'theme')?>" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $OUTPUT->pix_url('m2m', 'theme')?>" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('m2m', 'theme')?>" />
    
    <meta name="description" content="<?php echo strip_tags(format_text($SITE->summary, FORMAT_HTML)) ?>" />
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />

    <?php echo $OUTPUT->standard_head_html() ?>
    
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>



<div id="<?php p($PAGE->bodyid) ?>PAGE" data-role="page" class="generalpage <?php echo 'ajaxedclass '; p($PAGE->bodyclasses.' '.join(' ', $bodyclasses));  ?>" data-title="<?php p($SITE->shortname) ?>">
<!-- start header -->
    <div data-role="header" <?php p($datatheme) ?> class="mymobileheader">
        <h1><?php p($PAGE->heading) ?></h1>
        <?php 
        if (isloggedin() && $mypagetype != 'site-index') { ?>
        <a class="ui-btn-right" data-icon="home" href="<?php p($CFG->wwwroot) ?>" data-iconpos="notext"><?php p(get_string('home')); ?></a>
    <?php } else if (!isloggedin()) {
        echo $OUTPUT->login_info();
        }
         ?>
         
        <!-- start navbar --> 
    <div data-role="navbar">
        <ul>
            
            <?php if (!$hassidepost && !$toblock) { 
        //if has sidepost means there are blocks so print block button
        ?>
        <li><a data-theme="c" class="blockload" href="<?php echo''.$url.''; ?>"><?php p(get_string('blocks')); ?></a></li>
        <?php } ?>
            
        <?php if(!$toset) { ?>
        <li><a data-theme="c" href="<?php echo''.$urlS.''; ?>"><?php p(get_string('settings')); ?></a></li>
        <?php } ?>
    
        <?php if ($jumptocurrent == 'true' && !$toblock && !$toset) { ?>
        <li><a data-theme="c" class="jumptocurrent" href="#"><?php  p(get_string('jump')); ?></a></li>
        <?php } ?>
        
        <?php 
        if (isloggedin() && $hasnavbar) { ?>
        <li><form id="navselectform"><select id="navselect" data-theme="c" data-inline="false" data-icon="false" >
        <option data-placeholder="true" value="-1"><?php p(get_string('navigation')); ?></option>
        <?php echo $OUTPUT->navbar(); ?>
    </select></form></li>
        <?php } ?>
    
        </ul>
    </div><!-- /navbar -->
         
    </div> 
<div id="page-header"><!-- empty page-header needed by moodle yui --></div> 
<!-- end header -->   

<!-- main content -->         
<div data-role="content" class="mymobilecontent" <?php p($databodytheme); ?>>      
<?php if($toblock) { 
//if we get the true, that means load/show blocks only
         if ($hassidepost) { ?>
                    <div id="region-post" class="block-region">
                        <div class="region-content"> 
                          <h2 class="jsets">
                            <?php p(get_string('blocks')); ?>
                          </h2>
                        
             <div data-role="collapsible-set">          
             <?php echo $OUTPUT->blocks_for_region('side-post') ?>
             </div>
                <div class="mspacer"></div>
                           
                        </div>
                    </div>
           <?php } ?>
<?php } ?>
 
 <?php if($toset) {  //if we get the true, that means load/show settings only ?>
         <h2 class="jsets">
         <?php p(get_string('settings')); ?>
         </h2>
            <?php
            //load lang menu if available
            echo $OUTPUT->lang_menu(); 
            $mobileblocks = new mymobile_mobileblocks_renderer($this->page, null);
            ?>
            <ul data-role="listview" data-theme="<?php p($dthemeb) ?>" data-dividertheme="<?php p($dtheme) ?>" data-inset="true" class="settingsul">
            <?php
            echo $mobileblocks->settings_tree($this->page->settingsnav);
            ?>
            </ul>
            <?php echo $OUTPUT->login_info(); ?>
            
 <?php } ?>    
                 
                            
<div class="region-content <?php if($toblock) { ?>mobile_blocksonly<?php } ?>" id="themains">
 <?php 
 //only show main content if we are not showing anything else
 if(!$toblock && !$toset) { ?>
 
 <?php if ($hasmtext && $mypagetype == 'site-index') { ?>
            <?php echo $PAGE->theme->settings->mtext; ?>
  <?php } ?>
 
 <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
 <?php } ?>
</div>
 
 </div>
<!-- end main content -->                          

<!-- start footer -->
<div data-role="footer" class="mobilefooter" <?php echo $datatheme ?>>
    <div data-role="navbar" class="jnav" >
    <ul> 
                     
    <li><a id="mycal" class="callink" href="<?php p($CFG->wwwroot) ?>/calendar/view.php" data-icon="info" data-iconpos="top" ><?php p(get_string('calendar', 'calendar')); ?></a></li>
    
    <?php if (!empty($CFG->messaging)) { ?>                   
   <li><a id="mymess" href="<?php p($CFG->wwwroot) ?>/message/index.php" data-iconpos="top" data-icon="mymessage" ><?php p(get_string('messages', 'message')); ?></a></li> 
   <?php } ?>
   
  <?php if ($mypagetype != 'site-index') { ?> 
  <li><a href="#" data-inline="true" data-role="button" data-iconpos="top" data-icon="arrow-u" id="uptotop"><?php p(get_string('up')); ?></a></li>
  <?php } ?> 
     </ul>
                     
    </div>
</div>
<!-- end footer -->                               
          
 <div id="underfooter">
 <?php
    echo $OUTPUT->login_infoB();
    echo '<div class="noajax">';
    echo $OUTPUT->standard_footer_html();
    echo '</div>';
  ?>
 </div>         
          
          
 </div><!-- ends page -->                      
 
<!-- empty divs with info for the JS to use -->
 <div id="<?php p(sesskey()); ?>" class="mobilesession"></div>
 <div id="<?php p($CFG->wwwroot); ?>" class="mobilesiteurl"></div>
 <div id="<?php p($dtheme); ?>" class="datatheme"></div>
 <div id="<?php p($dthemeb); ?>" class="datathemeb"></div>
 <div id="page-footer"><!-- empty page footer needed by moodle yui for embeds --></div>
<!-- end js divs --> 


<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>