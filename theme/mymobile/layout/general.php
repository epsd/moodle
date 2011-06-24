<?php
$toshow = optional_param('loadedby', '', PARAM_TEXT);
//get loadedby determines whether this was an ajax load or http. loadby is set in the mymobile .js if it loads a page via ajax.
$toblock = optional_param('blocks', false, PARAM_BOOL);
//get blocks?
$toset = optional_param('settings', false, PARAM_BOOL);
//get settings?

$mypagetype = $this->page->pagetype;

$showswatch = $PAGE->theme->settings->mswatch;
if ($showswatch == "light") {
$dtheme = "d";
$dthemeb = "d";
$datatheme = "data-theme='b'";
$databodytheme = "data-theme='d'";
}
else {
$dtheme = "d";
$dthemeb = "c";
$datatheme = "data-theme='a'";
$databodytheme = "";
}

//custom settings
$hasmtext = (!empty($PAGE->theme->settings->mtext));
$hasithumb = $PAGE->theme->settings->mimgs;
$showsitetopic = $PAGE->theme->settings->mtopic;


if ($mypagetype == "course-view-topics" || $mypagetype == "course-view-weeks") {
    $jumptocurrent ="true";
    //jump to current topic only in course pages
}

else {
    $jumptocurrent ="false";
}

// below GETs determine whether to show blocks, or settings or nav and corrects for URL issues
$url = $this->page->url;
$last = substr($url, -1);
if ($last == "/") {
    $url = "$url?blocks=true";
}

else if (!strripos($url,'?')) {
    $url = "$url?blocks=true";
}

else {
    $url = "$url&blocks=true";
}

$urlS = $this->page->url;
$lastS = substr($urlS, -1);
if ($lastS == "/") {
    $urlS = "$urlS?settings=true";
}

else if (!strripos($urlS,'?')) {
    $urlS = "$urlS?settings=true";
}

else {
    $urlS = "$urlS&settings=true";
}

$urlN = $this->page->url;
$lastN = substr($urlN, -1);
if ($lastN == "/") {
    $urlN = "$urlN?navs=true";
}

else if (!strripos($urlS,'?')) {
    $urlN = "$urlN?navs=true";
}

else {
    $urlN = "$urlN&navs=true";
}
    


//if ajaxed only get these things then page.
if($toshow == "ajaxed" && !empty($SESSION->justloggedin)) {
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
}
//else it is a full reload
else {
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);


$bodyclasses = array();
$bodyclasses[] = "$hasithumb";
$bodyclasses[] = "$showsitetopic";
//add ithumb class to decide whether to show or hide images and site topic 

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $SITE->shortname ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
 
   
    
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $OUTPUT->pix_url('m2m2x', 'theme')?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $OUTPUT->pix_url('m2m', 'theme')?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('m2m', 'theme')?>">
    
    <meta name="description" content="<?php echo strip_tags(format_text($SITE->summary, FORMAT_HTML)) ?>" />
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">

    <?php echo $OUTPUT->standard_head_html() ?>
    
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php 
//end if ajaxed else

} ?>

<div id="<?php echo $PAGE->bodyid ?>PAGE" data-role="page" class="generalpage <?php if($toshow == "ajaxed") { echo "ajaxedclass "; echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses); } ?>" data-title="<?php echo $SITE->shortname ?>">
<!-- start header -->
    <div data-role="header" <?php echo $datatheme ?> class="mymobileheader">
        <h1><?php echo $PAGE->heading?></h1>
        <?php 
        if (isloggedin() && $mypagetype != "site-index") { ?>
        <a class="ui-btn-right" data-icon="home" href="<?php echo $CFG->wwwroot ?>" data-iconpos="notext">home</a>
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
        <li><a data-theme="c" class="blockload" href="<?php echo $url; ?>"><?php echo get_string('blocks'); ?></a></li>
        <?php } ?>
            
        <?php if(!$toset) { ?>
        <li><a data-theme="c" href="<?php echo $urlS; ?>"><?php echo get_string('settings'); ?></a></li>
        <?php } ?>
    
        <?php if ($jumptocurrent == "true" && !$toblock && !$toset) { ?>
        <li><a data-theme="c" class="jumptocurrent" href="#"><?php echo get_string('jump'); ?></a></li>
        <?php } ?>
        
        <?php 
        if (isloggedin() && $hasnavbar) { ?>
        <li><form id="navselectform"><select id="navselect" data-theme="c" data-inline="false" data-icon="false" >
        <option data-placeholder="true" value="-1"><?php echo get_string('navigation'); ?></option>
        <?php echo $OUTPUT->navbar(); ?>
    </select></form></li>
        <?php } ?>
    
        </ul>
    </div><!-- /navbar -->
         
    </div> 
<div id="page-header"><!-- empty page-header needed by moodle yui --></div> 
<!-- end header -->   



<!-- main content -->         
<div data-role="content" class="mymobilecontent" <?php echo $databodytheme ?>>      

<?php if($toblock) { 
//if we get the true, that means load/show blocks only
         if ($hassidepost) { ?>
                    <div id="region-post" class="block-region">
                        <div class="region-content"> 
                        <?php
                            echo "<h2 class='jsets'>";
                            echo get_string('blocks');
                            echo "</h2>";
                        ?>
             <div data-role="collapsible-set">          
             <?php echo $OUTPUT->blocks_for_region('side-post') ?>
             </div>
                <div class="mspacer"></div>
                           
                        </div>
                    </div>
           <?php } ?>
<?php } ?>
 
 <?php if($toset) { 
//if we get the true, that means load/show settings only
            echo "<h2 class='jsets'>";
            echo get_string('settings');
            echo "</h2>";
            //load lang menu if available
            echo $OUTPUT->lang_menu(); 
            $mobileblocks = new mymobile_mobileblocks_renderer($this->page, null);
            echo "<ul data-role=\"listview\" data-theme=\"$dthemeb\" data-dividertheme=\"$dtheme\" data-inset=\"true\" class=\"settingsul\">";
            echo $mobileblocks->settings_tree($this->page->settingsnav);
            echo "</ul>";
            echo $OUTPUT->login_info();
            }
        
?>    
                 
                            
<div class="region-content <?php if($toblock) { ?>mobile_blocksonly<?php } ?>" id="themains">
 <?php 
 //only show main content if we are not showing anything else
 if(!$toblock && !$toset) { ?>
 
 <?php if ($hasmtext && $mypagetype == "site-index") { ?>
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
                     
        <li><a id="mycal" class="callink" href="<?php echo $CFG->wwwroot ?>/calendar/view.php" data-icon="info" data-iconpos="top" ><?php echo get_string('calendar', 'calendar'); ?></a></li>
    
    <?php if (!empty($CFG->messaging)) { ?>                   
   <li><a id="mymess" href="<?php echo $CFG->wwwroot ?>/message/index.php" data-iconpos="top" data-icon="mymessage" ><?php echo get_string('messages', 'message'); ?></a></li> 
   <?php } ?>
   
  <?php if ($mypagetype != "site-index") { ?> 
  <li><a href="#" data-inline="true" data-role="button" data-iconpos="top" data-icon="arrow-u" id="uptotop"><?php echo get_string('up'); ?></a></li>
  <?php } ?> 
     </ul>
                     
    </div>
</div>
<!-- end footer -->                               
          
 <div id="underfooter">
 <?php
    echo $OUTPUT->login_infoB();
    echo"<div class='noajax'>";
    echo $OUTPUT->standard_footer_html();
    echo"</div>";
  ?>
 </div>         
          
          
 </div><!-- ends page -->                      
 
<!-- empty divs with info for the JS to use -->
 <div id="<?php echo sesskey(); ?>" class="mobilesession"></div>
 <div id="<?php echo $CFG->wwwroot; ?>" class="mobilesiteurl"></div>
 <div id="<?php echo $dtheme; ?>" class="datatheme"></div>
 <div id="<?php echo $dthemeb; ?>" class="datathemeb"></div>
 <div id="page-footer"><!-- empty page footer needed by moodle yui for embeds --></div>
<!-- end js divs --> 
    
<!-- running mymobile theme version: <?php echo get_string('mymobileversion','theme_mymobile');?> -->
<?php 
if($toshow == "ajaxed") {

}
else {
?>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
<?php } ?>