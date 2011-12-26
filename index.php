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
 * News index file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version   $Id$
 */
 
require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

global $xoopsUser;

$story_handler = xoops_getmodulehandler ( 'story', 'news' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );

// Include content template
$template = xoops_getModuleOption ( 'template', $NewsModule->getVar ( 'dirname' ) );
$xoopsOption ['template_main'] = 'news_index.html';

if (isset ( $_REQUEST ["user"] )) {
	$story_user = NewsUtils::News_CleanVars ( $_REQUEST, 'user', 0, 'int' );
} else {
	$story_user = null;
}

if (isset ( $_REQUEST ["storytopic"] )) {
	$story_topic = NewsUtils::News_CleanVars ( $_REQUEST, 'storytopic', 0, 'int' );
} elseif(isset ($_REQUEST ["page"])) {
	$topic_alias = NewsUtils::News_CleanVars ( $_REQUEST, 'story', 0, 'string' );
	$story_topic = $topic_handler->News_GetTopicId($topic_alias);
} else {
	$story_topic = null;
}

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/style.css' );
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/legacy.css' );

if (isset ( $story_topic )) {
	$topics = $topic_handler->getall ( $story_topic );
	$view_topic = $topics[$story_topic];
	if (! isset ( $view_topic )) {
		redirect_header ( 'index.php', 3, _NEWS_MD_TOPIC_ERROR );
		exit ();
	}
	
	if ($view_topic->getVar ( 'topic_modid' ) != $NewsModule->getVar ( 'mid' )) {
		redirect_header ( 'index.php', 3, _NEWS_MD_TOPIC_ERROR );
		exit ();
	}
	
	if ($view_topic->getVar ( 'topic_online' ) == '0') {
		redirect_header ( 'index.php', 3, _NEWS_MD_TOPIC_ERROR );
		exit ();
	}
	
	// Check the access permission
	$perm_handler = NewsPermission::getHandler ();
	if (! $perm_handler->News_IsAllowed ( $xoopsUser, 'news_access', $view_topic->getVar ( 'topic_id' ), $NewsModule )) {
		redirect_header ( "index.php", 3, _NOPERM );
		exit ();
	}
	
	// get topic information
	$topic_title = $default_title = $view_topic->getVar ( 'topic_title' );
	$topic_alias = $default_alias = $view_topic->getVar ( 'topic_alias' );
	$topic_id = $default_id = $view_topic->getVar ( 'topic_id' );
	$topic_img = $view_topic->getVar ( 'topic_img' );
	$topic_imgurl = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) . $view_topic->getVar ( 'topic_img' );
	$topic_desc = $view_topic->getVar ( 'topic_desc' );
	
	$xoopsTpl->assign ( 'topic_desc', $topic_desc );
   $xoopsTpl->assign ( 'topic_img', $topic_img );
   $xoopsTpl->assign ( 'topic_imgurl', $topic_imgurl );
	$xoopsTpl->assign ( 'topic_title', $topic_title );
	$xoopsTpl->assign ( 'xoops_pagetitle', $topic_title );
	
	if ($view_topic->getVar ( 'topic_showtype' ) > '0') {
		$showtype = $view_topic->getVar ( 'topic_showtype' );
	} else {
		$showtype = xoops_getModuleOption ( 'showtype', $NewsModule->getVar ( 'dirname' ) );
	}
	
	if ($view_topic->getVar ( 'topic_columns' ) > '0') {
		$columns = $view_topic->getVar ( 'topic_columns' );
	} else {
		$columns = xoops_getModuleOption ( 'columns', $NewsModule->getVar ( 'dirname' ) );
	}
	
	if ($view_topic->getVar ( 'topic_perpage' ) > '0') {
		$story_perpage = $view_topic->getVar ( 'topic_perpage' );
	} else {
		$story_perpage = xoops_getModuleOption ( 'perpage', $NewsModule->getVar ( 'dirname' ) );
	}
	$type = 'type'.$view_topic->getVar ( 'topic_homepage' );
	
	$story_subtopic = $topic_handler->News_GetSubTopics($NewsModule , $story_topic , $topics);

} else {
	
	// get all topic informations
	$topics = $topic_handler->getall ( $story_topic );
	$default_title = xoops_getModuleOption ( 'static_name', $NewsModule->getVar ( 'dirname' ) );
	$default_alias = NewsUtils::News_AliasFilter($default_title);
	$topic_id = $default_id = '0';
	// get module configs
	$showtype = xoops_getModuleOption ( 'showtype', $NewsModule->getVar ( 'dirname' ) );
	$columns = xoops_getModuleOption ( 'columns', $NewsModule->getVar ( 'dirname' ) );
	$story_perpage = xoops_getModuleOption ( 'perpage', $NewsModule->getVar ( 'dirname' ) );
	$type = xoops_getModuleOption ( 'homepage', $NewsModule->getVar ( 'dirname' ) );
	$story_subtopic = null;
}

// get module configs
$story_order = xoops_getModuleOption ( 'showorder', $NewsModule->getVar ( 'dirname' ) );
$story_sort = xoops_getModuleOption ( 'showsort', $NewsModule->getVar ( 'dirname' ) );

// get limited information
if (isset ( $_REQUEST ['limit'] )) {
	$story_limit = NewsUtils::News_CleanVars ( $_REQUEST, 'limit', 0, 'int' );
} else {
	$story_limit = $story_perpage;
}

// get start information
if (isset ( $_REQUEST ['start'] )) {
	$story_start = NewsUtils::News_CleanVars ( $_REQUEST, 'start', 0, 'int' );
} else {
	$story_start = 0;
}

$story_infos = array ('topics' => $topics, 'story_limit' => $story_limit, 'story_topic' => $story_topic, 'story_user' => $story_user, 'story_start' => $story_start, 'story_order' => $story_order, 'story_sort' => $story_sort, 'story_status' => '1', 'story_subtopic' => $story_subtopic , 'id' => $default_id, 'title' => $default_title , 'alias' => $default_alias);

// Get Information for Show in indexpage or topic pages
$contents = NewsUtils::News_Homepage ( $NewsModule, $story_infos, $type );

if(isset($contents ['pagenav'])) {
	$pagenav = $contents ['pagenav'];
} else {
	$pagenav = null;
}
		
$info = array();
if (isset ( $story_topic ) && $story_topic > 0 && $view_topic->getVar ( 'topic_showtype' ) != '0') { // The option for select setting from topic or module options must be added
	if ($view_topic->getVar ( 'topic_showauthor' )) {
		$info ['author'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showdate' )) {
		$info ['date'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showhits' )) {
		$info ['hits'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showcoms' )) {
		$info ['coms'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showtopic' )) {
		$info ['showtopic'] = '1';
	}
} else {
	if (xoops_getModuleOption ( 'disp_date', $NewsModule->getVar ( 'dirname' ) )) {
		$info ['date'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_author', $NewsModule->getVar ( 'dirname' ) )) {
		$info ['author'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_hits', $NewsModule->getVar ( 'dirname' ) )) {
		$info ['hits'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_coms', $NewsModule->getVar ( 'dirname' ) )) {
		$info ['coms'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_topic', $NewsModule->getVar ( 'dirname' ) )) {
		$info ['showtopic'] = '1';
	}
}

if (xoops_getModuleOption ( 'img_lightbox', $NewsModule->getVar ( 'dirname' ) )) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/plugins/jquery.lightbox.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( 'browse.php?modules/system/css/lightbox.css' );
	$xoopsTpl->assign ( 'img_lightbox', true );
}

if (file_exists ( XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/language/' . $GLOBALS ['xoopsConfig'] ['language'] . '/main.php' )) {
	$xoopsTpl->assign ( 'xoops_language', $GLOBALS ['xoopsConfig'] ['language'] );
} else {
	$xoopsTpl->assign ( 'xoops_language', 'english' );
}

// breadcrumb
if (xoops_getModuleOption ( 'bc_show', $NewsModule->getVar ( 'dirname' ) )) {
	$breadcrumb = NewsUtils::News_Breadcrumb ( $NewsModule, false, '', $topic_id, ' &raquo; ', 'topic_title' );
}

// Get default content
$default_info = array ('id' => $default_id, 'title' => $default_title , 'alias' => $default_alias);
$contents ['default'] = $story_handler->News_ContentDefault ( $NewsModule, $default_info );

$xoopsTpl->assign ( 'story_topic', $story_topic );
$xoopsTpl->assign ( 'story_limit', $story_limit );
$xoopsTpl->assign ( 'showtype', $showtype );
$xoopsTpl->assign ( 'columns', $columns );
$xoopsTpl->assign ( 'story_pagenav', $pagenav );
$xoopsTpl->assign ( 'info', $info );
$xoopsTpl->assign ( 'contents', $contents ['content'] );
$xoopsTpl->assign ( 'modname', $NewsModule->getVar ( 'name' ) );
$xoopsTpl->assign ( 'rss', xoops_getModuleOption ( 'rss_show', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgwidth', xoops_getModuleOption ( 'imgwidth', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgfloat', xoops_getModuleOption ( 'imgfloat', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'alluserpost', xoops_getModuleOption ( 'alluserpost', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'breadcrumb', $breadcrumb );
$xoopsTpl->assign ( 'type', $type );
$xoopsTpl->assign ( 'default', $contents ['default'] );
$xoopsTpl->assign ( 'advertisement', xoops_getModuleOption ( 'advertisement', $NewsModule->getVar ( 'dirname' ) ) );

// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';

?>