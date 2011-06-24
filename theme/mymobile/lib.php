<?php

class mymobile_mobileblocks_renderer extends plugin_renderer_base {

    public function settings_tree(settings_navigation $navigation) {
        global $CFG;
        $content = $this->navigation_node($navigation, array('class' => 'settings'));
        if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) {
           
        }
      
        return $content;
    }

    public function navigation_tree(global_navigation $navigation) {
        global $CFG;
               $content .= $this->navigation_node($navigation, array());
        
        return $content;
    }

    protected function navigation_node(navigation_node $node, $attrs=array()) {
        $items = $node->children;

        // exit if empty, we don't want an empty ul element
        if ($items->count() == 0) {
            return '';
        }

        // array of nested li elements
        $lis = array();
        foreach ($items as $item) {
            if (!$item->display) {
                continue;
            }

            $isbranch = ($item->children->count() > 0 || $item->nodetype == navigation_node::NODETYPE_BRANCH);
            $hasicon = (!$isbranch && $item->icon instanceof renderable);

            if ($isbranch) {
                $item->hideicon = true;
            }
                $item->hideicon = true;
            $content = $this->output->render($item);
            if(substr($item->id, 0, 17)=='expandable_branch' && $item->children->count()==0) {
                // Navigation block does this via AJAX - we'll merge it in directly instead
                $dummypage = new mymobile_dummy_page();
                $dummypage->set_context(get_context_instance(CONTEXT_SYSTEM));
                $subnav = new mymobile_expand_navigation($dummypage, $item->type, $item->key);
                if (!isloggedin() || isguestuser()) {
                    $subnav->set_expansion_limit(navigation_node::TYPE_COURSE);
                }
                    //below by john for too manu items...
                    $subnav->set_expansion_limit(navigation_node::TYPE_COURSE);
                $branch = $subnav->find($item->key, $item->type);
                $content .= $this->navigation_node($branch);
            } else {
                $content .= $this->navigation_node($item);
            }


            if($isbranch && !(is_string($item->action) || empty($item->action))) {
                //$content = html_writer::tag('li', $content, array('class' => 'clickable-with-children'));
                //$content = $content;
                $itest = $item->key;
                $content = html_writer::tag("li data-role=\"list-divider\" class=\"$itest\" ", $content);
             
             
            } 
            
           else if($isbranch) {
           $itest = $item->key;
            $content = html_writer::tag('li data-role="list-divider"', $content);

            }
            
            else {
                $itest = $item->text;
                
                $content = html_writer::tag("li class=\"$itest\"", $content);
               
              
               //$content = $content;
               
            }
            $lis[] = $content;
        }

        if (count($lis)) {
       
           return implode("\n", $lis);
           
        } else {
            return '';
        }
    }

    public function search_form(moodle_url $formtarget, $searchvalue) {
        global $CFG;

        if (empty($searchvalue)) {
            $searchvalue = 'Search Settings..';
        }

        $content = html_writer::start_tag('form', array('class' => 'topadminsearchform', 'method' => 'get', 'action' => $formtarget));
        $content .= html_writer::start_tag('div', array('class' => 'search-box'));
        $content .= html_writer::tag('label', s(get_string('searchinsettings', 'admin')), array('for' => 'adminsearchquery', 'class' => 'accesshide'));
        $content .= html_writer::empty_tag('input', array('id' => 'topadminsearchquery', 'type' => 'text', 'name' => 'query', 'value' => s($searchvalue),
                    'onfocus' => "if(this.value == 'Search Settings..') {this.value = '';}",
                    'onblur' => "if (this.value == '') {this.value = 'Search Settings..';}"));
        //$content .= html_writer::empty_tag('input', array('class'=>'search-go','type'=>'submit', 'value'=>''));
        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('form');

        return $content;
    }

}




class mymobile_expand_navigation extends global_navigation {

    /** @var array */
    protected $expandable = array();

    /**
     * Constructs the navigation for use in AJAX request
     */
    public function __construct($page, $branchtype, $id) {
        $this->page = $page;
        $this->cache = new navigation_cache(NAVIGATION_CACHE_NAME);
        $this->children = new navigation_node_collection();
        $this->initialise($branchtype, $id);
    }
    /**
     * Initialise the navigation given the type and id for the branch to expand.
     *
     * @param int $branchtype One of navigation_node::TYPE_*
     * @param int $id
     * @return array The expandable nodes
     */
    public function initialise($branchtype, $id) {
        global $CFG, $DB, $SITE;

        if ($this->initialised || during_initial_install()) {
            return $this->expandable;
        }
        $this->initialised = true;

        $this->rootnodes = array();
        $this->rootnodes['site']      = $this->add_course($SITE);
        $this->rootnodes['courses'] = $this->add(get_string('courses'), null, self::TYPE_ROOTNODE, null, 'courses');

        // Branchtype will be one of navigation_node::TYPE_*
        switch ($branchtype) {
            case self::TYPE_CATEGORY :
                $this->load_all_categories($id);
                $limit = 20;
                if (!empty($CFG->navcourselimit)) {
                    $limit = (int)$CFG->navcourselimit;
                }
                $courses = $DB->get_records('course', array('category' => $id), 'sortorder','*', 0, $limit);
                foreach ($courses as $course) {
                    $this->add_course($course);
                }
                break;
            case self::TYPE_COURSE :
                $course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
                //require_course_login($course);
                //$this->page = $PAGE;
                $this->page->set_context(get_context_instance(CONTEXT_COURSE, $course->id));
                $coursenode = $this->add_course($course);
                // john $this->add_course_essentials($coursenode, $course);
                if ($this->format_display_course_content($course->format)) {
                    $this->load_course_sections($course, $coursenode);
                }
                break;
            case self::TYPE_SECTION :
                $sql = 'SELECT c.*, cs.section AS sectionnumber
                        FROM {course} c
                        LEFT JOIN {course_sections} cs ON cs.course = c.id
                        WHERE cs.id = ?';
                $course = $DB->get_record_sql($sql, array($id), MUST_EXIST);
                //require_course_login($course);
                //$this->page = $PAGE;
                $this->page->set_context(get_context_instance(CONTEXT_COURSE, $course->id));
                $coursenode = $this->add_course($course);
                $this->add_course_essentials($coursenode, $course);
                $sections = $this->load_course_sections($course, $coursenode);
                $this->load_section_activities($sections[$course->sectionnumber]->sectionnode, $course->sectionnumber, get_fast_modinfo($course));
                //$this->load_course_sections($course, $coursenode);
                break;
            case self::TYPE_ACTIVITY :
                $cm = get_coursemodule_from_id(false, $id, 0, false, MUST_EXIST);
                $course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);
                //require_course_login($course, true, $cm);
                //$this->page = $PAGE;
                $this->page->set_context(get_context_instance(CONTEXT_MODULE, $cm->id));
                $coursenode = $this->load_course($course);
                $sections = $this->load_course_sections($course, $coursenode);
                foreach ($sections as $section) {
                    if ($section->id == $cm->section) {
                        $cm->sectionnumber = $section->section;
                        break;
                    }
                }
                if ($course->id == SITEID) {
                    $modulenode = $this->load_activity($cm, $course, $coursenode->find($cm->id, self::TYPE_ACTIVITY));
                } else {
                    $activities = $this->load_section_activities($sections[$cm->sectionnumber]->sectionnode, $cm->sectionnumber, get_fast_modinfo($course));
                    $modulenode = $this->load_activity($cm, $course, $activities[$cm->id]);
                }
                break;
            default:
                throw new Exception('Unknown type');
                return $this->expandable;
        }
        $this->find_expandable($this->expandable);
        return $this->expandable;
    }

    public function get_expandable() {
        return $this->expandable;
    }
}

class mymobile_dummy_page extends moodle_page {
    /**
     * REALLY Set the main context to which this page belongs.
     * @param object $context a context object, normally obtained with get_context_instance.
     */
    public function set_context($context) {
        if ($context === null) {
            // extremely ugly hack which sets context to some value in order to prevent warnings,
            // use only for core error handling!!!!
            if (!$this->_context) {
                $this->_context = get_context_instance(CONTEXT_SYSTEM);
            }
            return;
        }
        $this->_context = $context;
    }
}









