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
 * News topic file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version   $Id$
 */
 
require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

$story_handler = xoops_getmodulehandler ( 'story', 'news' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );

// Include content template
$xoopsOption ['template_main'] = 'news_topic.html';

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/style.css' );

// get module configs
$topic_perpage = xoops_getModuleOption('admin_perpage_topic', $NewsModule->getVar('dirname'));
$topic_order = xoops_getModuleOption('admin_showorder_topic', $NewsModule->getVar('dirname'));
$topic_sort = xoops_getModuleOption('admin_showsort_topic', $NewsModule->getVar('dirname'));

// get limited information
if (isset($_REQUEST['limit'])) {
   $topic_limit = NewsUtils::News_CleanVars($_REQUEST, 'limit', 0, 'int');
} else {
   $topic_limit = $topic_perpage;
}

// get start information
if (isset($_REQUEST['start'])) {
   $topic_start = NewsUtils::News_CleanVars($_REQUEST, 'start', 0, 'int');
} else {
   $topic_start = 0;
}

$newscountbytopic = $story_handler->News_GetNewsCountByTopic();
$topics = $topic_handler->News_GetTopics($NewsModule, $topic_limit, $topic_start, $topic_order, $topic_sort, $topic_menu = null, $topic_online = null , $topic_parent = null , $newscountbytopic);
$topic_numrows = $topic_handler->News_GetTopicCount($NewsModule);

if ($topic_numrows > $topic_limit) {
   $topic_pagenav = new XoopsPageNav($topic_numrows, $topic_limit, $topic_start, 'start', 'limit=' . $topic_limit);
   $topic_pagenav = $topic_pagenav->renderNav(4);
} else {
   $topic_pagenav = '';
}
        
if (xoops_getModuleOption ( 'img_lightbox', $NewsModule->getVar ( 'dirname' ) )) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/plugins/jquery.lightbox.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( XOOPS_URL . '/modules/system/css/lightbox.css' );
	$xoopsTpl->assign ( 'img_lightbox', true );
}
        
$xoopsTpl->assign('topics', $topics);
$xoopsTpl->assign('topic_pagenav', $topic_pagenav);
$xoopsTpl->assign('xoops_dirname', $NewsModule->getVar('dirname'));
$xoopsTpl->assign ( 'advertisement', xoops_getModuleOption ( 'advertisement', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgwidth', xoops_getModuleOption ( 'imgwidth', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgfloat', xoops_getModuleOption ( 'imgfloat', $NewsModule->getVar ( 'dirname' ) ) );  
    
// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';
?>