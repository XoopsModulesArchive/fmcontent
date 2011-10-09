<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * FmContent topic file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version   $Id:$
 */
if (! isset ( $forMods ))
	exit ( 'Module not found' ); 

include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );

// Include content template
$xoopsOption ['template_main'] = 'fmcontent_topic.html';

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/style.css' );

// get module configs
$topic_perpage = xoops_getModuleOption('admin_perpage_topic', $forMods->getVar('dirname'));
$topic_order = xoops_getModuleOption('admin_showorder_topic', $forMods->getVar('dirname'));
$topic_sort = xoops_getModuleOption('admin_showsort_topic', $forMods->getVar('dirname'));

// get limited information
if (isset($_REQUEST['limit'])) {
   $topic_limit = fmcontent_CleanVars($_REQUEST, 'limit', 0, 'int');
} else {
   $topic_limit = $topic_perpage;
}

// get start information
if (isset($_REQUEST['start'])) {
   $topic_start = fmcontent_CleanVars($_REQUEST, 'start', 0, 'int');
} else {
   $topic_start = 0;
}

$topics = $topic_handler->getTopics($forMods, $topic_limit, $topic_start, $topic_order, $topic_sort, $topic_menu = null, $topic_online = null , $topic_parent = null);
$topic_numrows = $topic_handler->getTopicCount($forMods);

if ($topic_numrows > $topic_limit) {
   $topic_pagenav = new XoopsPageNav($topic_numrows, $topic_limit, $topic_start, 'start', 'limit=' . $topic_limit);
   $topic_pagenav = $topic_pagenav->renderNav(4);
} else {
   $topic_pagenav = '';
}
        
$xoopsTpl->assign('topics', $topics);
$xoopsTpl->assign('topic_pagenav', $topic_pagenav);
$xoopsTpl->assign('xoops_dirname', $forMods->getVar('dirname'));
$xoopsTpl->assign ( 'advertisement', xoops_getModuleOption ( 'advertisement', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgwidth', xoops_getModuleOption ( 'imgwidth', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgfloat', xoops_getModuleOption ( 'imgfloat', $forMods->getVar ( 'dirname' ) ) );  
    
// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';
?>