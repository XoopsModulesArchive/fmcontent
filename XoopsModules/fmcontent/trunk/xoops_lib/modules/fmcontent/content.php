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
 * FmContent index file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id:$
 */

if (! isset ( $forMods ))
	exit ( 'Module not found' );

// Initialize content handler
$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );

if(isset($_REQUEST['id'])) {
	$content_id = fmcontent_CleanVars ( $_REQUEST, 'id', 0, 'int' );
} else {
	$content_alias = fmcontent_CleanVars ( $_REQUEST, 'page', 0, 'string' );
	if($content_alias) {
		$content_id = $content_handler->getId($content_alias);
	}
}

// Include content template
$template = xoops_getModuleOption ( 'template', $forMods->getVar ( 'dirname' ) );
$xoopsOption ['template_main'] = 'fmcontent_' . $template . '_content.html';

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/style.css' );
switch ($template) {
	case 'legacy' :
		$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/legacy.css' );
		break;
	
	case 'ui' :
		$xoTheme->addStylesheet ( XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption ( 'jquery_theme', 'system' ) . '/ui.all.css' );
		break;
	
	case 'html5' :
		$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/legacy.css' );
		$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/css3.css' );
		break;
}



if (! $content_id) {
	$criteria = new CriteriaCompo ();
	$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
	$criteria->add ( new Criteria ( 'content_default', 1 ) );
	$criteria->add ( new Criteria ( 'content_topic', 0 ) );
	$content_id = $content_handler->getDefault ( $criteria );
	if (! $content_id) {
		$xoopsTpl->assign ( 'content_error', _FMCONTENT_ERROR_DEFAULT );
	}
}

$content = array ();
$obj = $content_handler->get ( $content_id );

$content_topic = $obj->getVar ( 'content_topic' );

// Get user right
$group = is_object ( $xoopsUser ) ? $xoopsUser->getGroups () : array (XOOPS_GROUP_ANONYMOUS );
$groups = explode ( " ", $obj->getVar ( 'content_groups' ) );
if (count ( array_intersect ( $group, $groups ) ) <= 0) {
	$xoopsTpl->assign ( 'content_error', _NOPERM );
}

$content = $obj->toArray ();

// Update content hits
$content_handler->updateHits ( $content_id );

// set arrey
$view_topic = $topic_handler->get ( $content_topic );
$content ['topic'] = $view_topic->getVar ( 'topic_title' );
$content ['topic_alias'] = $view_topic->getVar ( 'topic_alias' );
$content ['topic_id'] = $view_topic->getVar ( 'topic_id' );
$content ['content_create'] = formatTimestamp ( $content ['content_create'], _MEDIUMDATESTRING );
$content ['content_update'] = formatTimestamp ( $content ['content_update'], _MEDIUMDATESTRING );
$content ['imgurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . $content ['content_img'];

if (isset ( $content_topic ) && $content_topic > 0) {
	
	if (! isset ( $view_topic )) {
		redirect_header ( 'index.php', 3, _FMCONTENT_TOPIC_ERROR );
		exit ();
	}
	
	if ($view_topic->getVar ( 'topic_modid' ) != $forMods->getVar ( 'mid' )) {
		redirect_header ( 'index.php', 3, _FMCONTENT_TOPIC_ERROR );
		exit ();
	}
	
	if ($view_topic->getVar ( 'topic_online' ) == '0') {
		redirect_header ( 'index.php', 3, _FMCONTENT_TOPIC_ERROR );
		exit ();
	}
	
	// Check the access permission
	$perm_handler = fmcontentPermission::getHandler ();
	if (! $perm_handler->isAllowed ( $xoopsUser, 'fmcontent_access', $view_topic->getVar ( 'topic_id' ), $forMods )) {
		redirect_header ( "index.php", 3, _NOPERM );
		exit ();
	}
}

$link = array ();

if (isset ( $content_topic ) && $content_topic > 0 && $view_topic->getVar ( 'topic_showtype' ) != '0') { // The option for select setting from topic or module options must be added
	

	// get topic confing from topic
	if ($view_topic->getVar ( 'topic_showtopic' )) {
		$link ['topic'] = $view_topic->getVar ( 'topic_title' );
		$link ['topicid'] = $content_topic;
		$link ['topicshow'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showauthor' )) {
		$content ['author'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'content_uid' ) );
	}
	if ($view_topic->getVar ( 'topic_showdate' )) {
		$link ['date'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showpdf' )) {
		$link ['pdf'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content, 'pdf' );
	}
	if ($view_topic->getVar ( 'topic_showprint' )) {
		$link ['print'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content, 'print' );
	}
	if ($view_topic->getVar ( 'topic_showhits' )) {
		$link ['hits'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showcoms' ) == '1') {
		$link ['coms'] = '1';
	}
	if ($view_topic->getVar ( 'topic_showmail' )) {
		// Mail link & label
		$link ['mail_subject'] = $content ['content_title'] . ' - ' . $xoopsConfig ['sitename'];
		$link ['mail_linkto'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content );
		if (xoops_getModuleOption ( 'tellafriend', $forMods->getVar ( 'dirname' ) )) {
			$link ['mail'] = "mailto:|xoops_tellafriend:" . $link ['mail_subject'];
		} else {
			$link ['mail'] = "mailto:?subject=" . $link ['mail_subject'] . "&amp;body=" . $link ['mail_linkto'];
		}
	}
	if ($view_topic->getVar ( 'topic_shownav' )) {
		if ($obj->getVar ( 'content_next' ) != 0) {
			$next_obj = $content_handler->get ( $obj->getVar ( 'content_next' ) );
			$next_link = $next_obj->toArray ();
			$link ['next'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $next_link );
			$link ['next_title'] = $next_link ['content_title'];
		}
		if ($obj->getVar ( 'content_prev' ) != 0) {
			$prev_obj = $content_handler->get ( $obj->getVar ( 'content_prev' ) );
			$prev_link = $prev_obj->toArray ();
			$link ['prev'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $prev_link );
			$link ['prev_title'] = $prev_link ['content_title'];
		}
	}

} else {
	
	// get topic config from module option
	if (xoops_getModuleOption ( 'disp_topic', $forMods->getVar ( 'dirname' ) )) {
		$link ['topic'] = $view_topic->getVar ( 'topic_title' );
		$link ['topicid'] = $content_topic;
		if ($content_topic) {
			$link ['topicshow'] = '1';
		} else {
			$link ['topicshow'] = '0';
		}
	}
	if (xoops_getModuleOption ( 'disp_date', $forMods->getVar ( 'dirname' ) )) {
		$link ['date'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'content_create' ) );
	}
	if (xoops_getModuleOption ( 'disp_author', $forMods->getVar ( 'dirname' ) )) {
		$content ['author'] = XoopsUser::getUnameFromId ( $obj->getVar ( 'content_uid' ) );
	}
	if (xoops_getModuleOption ( 'disp_pdflink', $forMods->getVar ( 'dirname' ) )) {
		$link ['pdf'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content, 'pdf' );
	}
	if (xoops_getModuleOption ( 'disp_printlink', $forMods->getVar ( 'dirname' ) )) {
		$link ['print'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content, 'print' );
	}
	if (xoops_getModuleOption ( 'disp_hits', $forMods->getVar ( 'dirname' ) )) {
		$link ['hits'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_coms', $forMods->getVar ( 'dirname' ) )) {
		$link ['coms'] = '1';
	}
	if (xoops_getModuleOption ( 'disp_maillink', $forMods->getVar ( 'dirname' ) )) {
		// Mail link & label
		$link ['mail_subject'] = $content ['content_title'] . ' - ' . $xoopsConfig ['sitename'];
		$link ['mail_linkto'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content );
		if (xoops_getModuleOption ( 'tellafriend', $forMods->getVar ( 'dirname' ) )) {
			$link ['mail'] = "mailto:|xoops_tellafriend:" . $link ['mail_subject'];
		} else {
			$link ['mail'] = "mailto:?subject=" . $link ['mail_subject'] . "&amp;body=" . $link ['mail_linkto'];
		}
	}
	if (xoops_getModuleOption ( 'disp_navlink', $forMods->getVar ( 'dirname' ) )) {
		if ($obj->getVar ( 'content_next' ) != 0) {
			$next_obj = $content_handler->get ( $obj->getVar ( 'content_next' ) );
			$next_link = $next_obj->toArray ();
			$link ['next'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $next_link );
			$link ['next_title'] = $next_link ['content_title'];
		}
		if ($obj->getVar ( 'content_prev' ) != 0) {
			$prev_obj = $content_handler->get ( $obj->getVar ( 'content_prev' ) );
			$prev_link = $prev_obj->toArray ();
			$link ['prev'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $prev_link );
			$link ['prev_title'] = $prev_link ['content_title'];
		}
	}
}

if (xoops_getModuleOption ( 'editinplace', $forMods->getVar ( 'dirname' ) ) && is_object ( $xoopsUser ) && ($xoopsUser->id () == $obj->getVar ( 'content_uid' ) || $xoopsUser->isAdmin ()) && $content ['dohtml']) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( 'browse.php?modules/' . $forMods->getVar ( 'dirname' ) . '/js/jquery.wysiwyg.js' );
	$xoTheme->addScript ( 'browse.php?modules/' . $forMods->getVar ( 'dirname' ) . '/js/jquery.jeditable.mini.js' );
	$xoTheme->addScript ( 'browse.php?modules/' . $forMods->getVar ( 'dirname' ) . '/js/jquery.jeditable.wysiwyg.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $forMods->getVar ( 'dirname' ) . '/css/jquery.wysiwyg.css' );
	$xoopsTpl->assign ( 'editinplace', true );
}

if (xoops_getModuleOption ( 'img_lightbox', $forMods->getVar ( 'dirname' ) )) {
	// Add scripts
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/jquery.js' );
	$xoTheme->addScript ( 'browse.php?Frameworks/jquery/plugins/jquery.lightbox.js' );
	// Add Stylesheet
	$xoTheme->addStylesheet ( 'browse.php?modules/system/css/lightbox.css' );
	$xoopsTpl->assign ( 'img_lightbox', true );
}

if (file_exists ( XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar ( 'dirname' ) . '/language/' . $GLOBALS ['xoopsConfig'] ['language'] . '/main.php' )) {
	$xoopsTpl->assign ( 'xoops_language', $GLOBALS ['xoopsConfig'] ['language'] );
} else {
	$xoopsTpl->assign ( 'xoops_language', 'english' );
}

if (isset ( $xoTheme ) && is_object ( $xoTheme )) {
	if ($content ['content_words'] != '') {
		$xoTheme->addMeta ( 'meta', 'keywords', $content ['content_words'] );
	}
	if ($content ['content_desc'] != '') {
		$xoTheme->addMeta ( 'meta', 'description', $content ['content_desc'] );
	}
} elseif (isset ( $xoopsTpl ) && is_object ( $xoopsTpl )) { // Compatibility for old Xoops versions
	if ($content ['content_words'] != '') {
		$xoopsTpl->assign ( 'xoops_meta_keywords', $content ['content_words'] );
	}
	if ($content ['content_desc'] != '') {
		$xoopsTpl->assign ( 'xoops_meta_description', $content ['content_desc'] );
	}
}

// For social networks scripts
if (xoops_getModuleOption ( 'show_social_book', $forMods->getVar ( 'dirname' ) ) == '1' || xoops_getModuleOption ( 'show_social_book', $forMods->getVar ( 'dirname' ) ) == '3') {
	$xoTheme->addScript ( 'http://platform.twitter.com/widgets.js' );
	$xoTheme->addScript ( 'http://www.google.com/buzz/api/button.js' );
	$xoTheme->addScript ( 'http://connect.facebook.net/en_US/all.js#xfbml=1' );
	$xoTheme->addScript ( 'https://apis.google.com/js/plusone.js' );
}

// For xoops tag
if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
	include_once XOOPS_ROOT_PATH . "/modules/tag/include/tagbar.php";
	$xoopsTpl->assign ( 'tagbar', tagBar ( $content ['content_id'], $catid = 0 ) );
	$xoopsTpl->assign ( 'tags', true );
} else {
	$xoopsTpl->assign ( 'tags', false );
}

// Get URLs 
$link ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $content );
$link ['topicurl'] = fmcontent_TopicUrl ( $forMods->getVar ( 'dirname' ), $content );

// breadcrumb
if (xoops_getModuleOption ( 'bc_show', $forMods->getVar ( 'dirname' ) )) {
	$breadcrumb = fmcontentUtils::breadcrumb ( $forMods, true, $content ['content_title'], $content ['content_topic'], ' &raquo; ', 'topic_title' );
}

$xoopsTpl->assign ( 'content', $content );
$xoopsTpl->assign ( 'link', $link );
$xoopsTpl->assign ( 'modname', $forMods->getVar ( 'name' ) );
$xoopsTpl->assign ( 'xoops_pagetitle', $content ['content_title'] );
$xoopsTpl->assign ( 'rss', xoops_getModuleOption ( 'rss_show', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'multiple_columns', xoops_getModuleOption ( 'multiple_columns', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'show_social_book', xoops_getModuleOption ( 'show_social_book', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'advertisement', xoops_getModuleOption ( 'advertisement', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgwidth', xoops_getModuleOption ( 'imgwidth', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'imgfloat', xoops_getModuleOption ( 'imgfloat', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'alluserpost', xoops_getModuleOption ( 'alluserpost', $forMods->getVar ( 'dirname' ) ) );
$xoopsTpl->assign ( 'breadcrumb', $breadcrumb );

// include Xoops footer
include XOOPS_ROOT_PATH . '/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';

?>