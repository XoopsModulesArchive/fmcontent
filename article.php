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
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

// Initialize content handler
$story_handler = xoops_getmodulehandler ( 'story', 'news' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
$file_handler = xoops_getmodulehandler('file', 'news');

if(isset($_REQUEST['storyid'])) {
	$story_id = NewsUtils::News_CleanVars ( $_REQUEST, 'storyid', 0, 'int' );
} else {
	$story_alias = NewsUtils::News_CleanVars ( $_REQUEST, 'story', 0, 'string' );
	if($story_alias) {
		$_GET['storyid'] = $story_id = $story_handler->News_GetId($story_alias);
	}
}

// Include content template
$template = xoops_getModuleOption ( 'template', $NewsModule->getVar ( 'dirname' ) );
$xoopsOption ['template_main'] = 'news_article.html';

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/style.css' );
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/legacy.css' );

if (! $story_id) {
	$criteria = new CriteriaCompo ();
	$criteria->add ( new Criteria ( 'story_modid', $NewsModule->getVar ( 'mid' ) ) );
	$criteria->add ( new Criteria ( 'story_default', 1 ) );
	$criteria->add ( new Criteria ( 'story_topic', 0 ) );
	$story_id = $story_handler->News_GetDefault ( $criteria );
	if (! $story_id) {
		$xoopsTpl->assign ( 'story_error', _NEWS_MD_ERROR_DEFAULT );
	}
}

$content = array ();
$obj = $story_handler->get ( $story_id );

if(!$obj) {
  redirect_header ( 'index.php', 3, _NEWS_MD_ERROR_EXIST);
  exit ();
}

$story_topic = $obj->getVar ( 'story_topic' );

if(!$obj->getVar ( 'story_status' )) {
	redirect_header ( 'index.php', 3, _NEWS_MD_ERROR_STATUS );
	exit ();
}	
	
// Get user right
$group = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
$groups = explode ( " ", $obj->getVar ( 'story_groups' ) );
if (count ( array_intersect ( $group, $groups ) ) <= 0) {
	$xoopsTpl->assign ( 'story_error', _NOPERM );
}

$content = $obj->toArray ();

// Update content hits
$story_handler->News_UpdateHits ( $story_id );

// set arrey
$view_topic = $topic_handler->get ( $story_topic );
$content ['topic'] = $view_topic->getVar ( 'topic_title' );
$content ['topic_alias'] = $view_topic->getVar ( 'topic_alias' );
$content ['topic_id'] = $view_topic->getVar ( 'topic_id' );
$content ['story_publish'] = formatTimestamp ( $content ['story_publish'], _MEDIUMDATESTRING );
$content ['story_update'] = formatTimestamp ( $content ['story_update'], _MEDIUMDATESTRING );
$content ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) . '/medium/' . $content ['story_img'];
$content ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) . '/thumb/' . $content ['story_img'];

if (isset ( $story_topic ) && $story_topic > 0) {
	
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
}

$link = array ();

if (isset ( $story_topic ) && $story_topic > 0 && $view_topic->getVar ( 'topic_showtype' ) != '0') { // The option for select setting from topic or module options must be added
	

	// get topic confing from topic
	if ($view_topic->getVar ( 'topic_showtopic' )) {
		$link ['topic'] = $view_topic->getVar ( 'topic_title' );
		$link ['topicid'] = $story_topic;
		$link ['topicshow'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showauthor' )) {
		$content ['author'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'story_uid' ) );
	}
	if ($view_topic->getVar ( 'topic_showdate' )) {
		$link ['date'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showpdf' )) {
		$link ['pdf'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content, 'pdf' );
	}
	if ($view_topic->getVar ( 'topic_showprint' )) {
		$link ['print'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content, 'print' );
	}
	if ($view_topic->getVar ( 'topic_showhits' )) {
		$link ['hits'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showcoms' ) == '1') {
		$link ['coms'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showmail' )) {
		// Mail link & label
		$link ['mail_subject'] = $content ['story_title'] . ' - ' . $xoopsConfig ['sitename'];
		$link ['mail_linkto'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content );
		if (xoops_getModuleOption ( 'tellafriend', $NewsModule->getVar ( 'dirname' ) )) {
			$link ['mail'] = "mailto:|xoops_tellafriend:" . $link ['mail_subject'];
		} else {
			$link ['mail'] = "mailto:?subject=" . $link ['mail_subject'] . "&amp;body=" . $link ['mail_linkto'];
		}
	}
	if ($view_topic->getVar ( 'topic_shownav' )) {
		if ($obj->getVar ( 'story_next' ) != 0) {
			$next_obj = $story_handler->get ( $obj->getVar ( 'story_next' ) );
			$next_link = $next_obj->toArray ();
			$next_link ['topic'] = $content ['topic'];
			$link ['next'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $next_link );
			$link ['next_title'] = $next_link ['story_title'];
		}
		if ($obj->getVar ( 'story_prev' ) != 0) {
			$prev_obj = $story_handler->get ( $obj->getVar ( 'story_prev' ) );
			$prev_link = $prev_obj->toArray ();
			$prev_link ['topic'] = $content ['topic'];
			$link ['prev'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $prev_link );
			$link ['prev_title'] = $prev_link ['story_title'];
		}
	}

} else {
	
	// get topic config from module option
	if (xoops_getModuleOption ( 'disp_topic', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['topic'] = $view_topic->getVar ( 'topic_title' );
		$link ['topicid'] = $story_topic;
		if ($story_topic) {
			$link ['topicshow'] = '1';
		} else {
			$link ['topicshow'] = '0';
		}
	}
	if (xoops_getModuleOption ( 'disp_date', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['date'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'story_publish' ) );
	}
	if (xoops_getModuleOption ( 'disp_author', $NewsModule->getVar ( 'dirname' ) )) {
		$content ['author'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'story_uid' ) );
	}
	if (xoops_getModuleOption ( 'disp_pdflink', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['pdf'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content, 'pdf' );
	}
	if (xoops_getModuleOption ( 'disp_printlink', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['print'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content, 'print' );
	}
	if (xoops_getModuleOption ( 'disp_hits', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['hits'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_coms', $NewsModule->getVar ( 'dirname' ) )) {
		$link ['coms'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_maillink', $NewsModule->getVar ( 'dirname' ) )) {
		// Mail link & label
		$link ['mail_subject'] = $content ['story_title'] . ' - ' . $xoopsConfig ['sitename'];
		$link ['mail_linkto'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content );
		if (xoops_getModuleOption ( 'tellafriend', $NewsModule->getVar ( 'dirname' ) )) {
			$link ['mail'] = "mailto:|xoops_tellafriend:" . $link ['mail_subject'];
		} else {
			$link ['mail'] = "mailto:?subject=" . $link ['mail_subject'] . "&amp;body=" . $link ['mail_linkto'];
		}
	}
	if (xoops_getModuleOption ( 'disp_navlink', $NewsModule->getVar ( 'dirname' ) )) {
		if ($obj->getVar ( 'story_next' ) != 0) {
			$next_obj = $story_handler->get ( $obj->getVar ( 'story_next' ) );
			$next_link = $next_obj->toArray ();
			$next_link ['topic'] = $content ['topic'];
			$link ['next'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $next_link );
			$link ['next_title'] = $next_link ['story_title'];
		}
		if ($obj->getVar ( 'story_prev' ) != 0) {
			$prev_obj = $story_handler->get ( $obj->getVar ( 'story_prev' ) );
			$prev_link = $prev_obj->toArray ();
			$prev_link ['topic'] = $content ['topic'];
			$link ['prev'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $prev_link );
			$link ['prev_title'] = $prev_link ['story_title'];
		}
	}
}

if (xoops_getModuleOption ( 'editinplace', $NewsModule->getVar ( 'dirname' ) ) && is_object ( $xoopsUser ) && ($xoopsUser->id () == $obj->getVar ( 'story_uid' ) || $xoopsUser->isAdmin ()) && $content ['dohtml']) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/js/jeditable/jquery.wysiwyg.js' );
	$xoTheme->addScript ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/js/jeditable/jquery.jeditable.mini.js' );
	$xoTheme->addScript ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/js/jeditable/jquery.jeditable.wysiwyg.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/jquery.wysiwyg.css' );
	$xoopsTpl->assign ( 'editinplace', true );
}

if (xoops_getModuleOption ( 'img_lightbox', $NewsModule->getVar ( 'dirname' ) )) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/plugins/jquery.lightbox.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( XOOPS_URL . '/modules/system/css/lightbox.css' );
	$xoopsTpl->assign ( 'img_lightbox', true );
}

if (file_exists ( XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/language/' . $GLOBALS ['xoopsConfig'] ['language'] . '/main.php' )) {
	$xoopsTpl->assign ( 'xoops_language', $GLOBALS ['xoopsConfig'] ['language'] );
} else {
	$xoopsTpl->assign ( 'xoops_language', 'english' );
}

if (isset ( $xoTheme ) && is_object ( $xoTheme )) {
	if ($content ['story_words'] != '') {
		$xoTheme->addMeta ( 'meta', 'keywords', $content ['story_words'] );
	}
	if ($content ['story_desc'] != '') {
		$xoTheme->addMeta ( 'meta', 'description', $content ['story_desc'] );
	}
} elseif (isset ( $xoopsTpl ) && is_object ( $xoopsTpl )) { // Compatibility for old Xoops versions
	if ($content ['story_words'] != '') {
		$xoopsTpl->assign ( 'xoops_meta_keywords', $content ['story_words'] );
	}
	if ($content ['story_desc'] != '') {
		$xoopsTpl->assign ( 'xoops_meta_description', $content ['story_desc'] );
	}
}

// For social networks scripts
if (xoops_getModuleOption ( 'show_social_book', $NewsModule->getVar ( 'dirname' ) ) == '1' || xoops_getModuleOption ( 'show_social_book', $NewsModule->getVar ( 'dirname' ) ) == '3') {
	$xoTheme->addScript ( 'http://platform.twitter.com/widgets.js' );
	$xoTheme->addScript ( 'http://connect.facebook.net/en_US/all.js#xfbml=1' );
	$xoTheme->addScript ( 'https://apis.google.com/js/plusone.js' );
}

// For xoops tag
if ((xoops_getModuleOption ( 'usetag', $NewsModule->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
	include_once XOOPS_ROOT_PATH . "/modules/tag/include/tagbar.php";
	$xoopsTpl->assign ( 'tagbar', tagBar ( $content ['story_id'], $catid = 0 ) );
	$xoopsTpl->assign ( 'tags', true );
} else {
	$xoopsTpl->assign ( 'tags', false );
}

// Get URLs 
$link ['url'] = NewsUtils::News_Url ( $NewsModule->getVar ( 'dirname' ), $content );
$link ['topicurl'] = NewsUtils::News_TopicUrl ( $NewsModule->getVar ( 'dirname' ), $content );

// breadcrumb
if (xoops_getModuleOption ( 'bc_show', $NewsModule->getVar ( 'dirname' ) )) {
	$breadcrumb = NewsUtils::News_Breadcrumb ( $NewsModule, true, $content ['story_title'], $content ['story_topic'], ' &raquo; ', 'topic_title' );
}


// Get Attached files information
if($content ['story_file'] > 0) {
	$file = array();
	$file['order'] = 'DESC';
   $file['sort'] = 'file_id';
	$file['start'] = 0;
	$file['content'] = $story_id;
	$view_file = $file_handler->News_GetFiles($NewsModule, $file);
	$xoopsTpl->assign ( 'files', $view_file );
	$xoopsTpl->assign ( 'jwwidth', '470' );
	$xoopsTpl->assign ( 'jwheight', '320' );
}	

// Get related contents
if(xoops_getModuleOption ( 'related', $NewsModule->getVar ( 'dirname' ) )) {
	$related_infos ['story_id'] = $obj->getVar ( 'story_id' );
	$related_infos ['story_topic'] = $obj->getVar ( 'story_topic' );
	$related_infos ['story_limit'] = xoops_getModuleOption ( 'related_limit', $NewsModule->getVar ( 'dirname' ) );
	$related_infos ['topic_alias'] = $view_topic->getVar ( 'topic_alias' );
	$related = $story_handler->News_RelatedContent($NewsModule, $related_infos);
	$xoopsTpl->assign ( 'related', $related );	
}	
 
$xoopsTpl->assign ( 'content', $content );
$xoopsTpl->assign ( 'link', $link );
$xoopsTpl->assign ( 'modname', $NewsModule->getVar ( 'name' ) );
$xoopsTpl->assign ( 'xoops_pagetitle', $content ['story_title'] );
$xoopsTpl->assign ( 'rss', xoops_getModuleOption ( 'rss_show', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'multiple_columns', xoops_getModuleOption ( 'multiple_columns', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'show_social_book', xoops_getModuleOption ( 'show_social_book', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'advertisement', xoops_getModuleOption ( 'advertisement', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgwidth', xoops_getModuleOption ( 'imgwidth', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgfloat', xoops_getModuleOption ( 'imgfloat', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'alluserpost', xoops_getModuleOption ( 'alluserpost', $NewsModule->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'breadcrumb', $breadcrumb );

// include Xoops footer
include XOOPS_ROOT_PATH . '/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';

?>