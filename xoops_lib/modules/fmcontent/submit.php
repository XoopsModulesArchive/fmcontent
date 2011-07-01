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
 * FmContent submit file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

if (! isset ( $forMods ))
	exit ( 'Module not found' );

include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";

$op = fmcontent_CleanVars ( $_REQUEST, 'op', '', 'string' );

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );

// Include language file
xoops_loadLanguage ( 'admin', $forMods->getVar ( 'dirname', 'e' ) );

// Check the access permission
global $xoopsUser;
$perm_handler = fmcontentPermission::getHandler ();
if (! $perm_handler->isAllowed ( $xoopsUser, 'fmcontent_ac', '8', $forMods )) {
	redirect_header ( "index.php", 3, _NOPERM );
	exit ();
}

switch ($op) {
	case 'add' :
		
		if (! isset ( $_POST ['post'] )) {
			redirect_header ( "index.php", 3, _NOPERM );
			exit ();
		}
		
		if ($_REQUEST ['content_modid'] != $forMods->getVar ( 'mid' )) {
			redirect_header ( 'index.php', 3, _NOPERM );
			exit ();
		}
		
		$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname' ) );
		$groups = (isset ( $groups )) ? $groups : '';
		$groups = (is_array ( $groups )) ? implode ( " ", $groups ) : '';
		
		$obj = $content_handler->create ();
		$obj->setVars ( $_REQUEST );
		
		$obj->setVar ( 'content_order', $content_handler->setorder($forMods) );
		$obj->setVar ( 'content_next', $content_handler->setNext($forMods, $_REQUEST ['content_topic']) );
		$obj->setVar ( 'content_prev', $content_handler->setPrevious($forMods, $_REQUEST ['content_topic']) );
		$obj->setVar ( 'content_menu', fmcontent_AjaxFilter ( $_REQUEST ['content_title'] ) );
		$obj->setVar ( 'content_alias', fmcontent_Filter ( $_REQUEST ['content_title'] ) );
		$obj->setVar ( 'content_words', fmcontent_MetaFilter ( $_REQUEST ['content_title'] ) );
		$obj->setVar ( 'content_desc', fmcontent_AjaxFilter ( $_REQUEST ['content_title'] ) );
		$obj->setVar ( 'content_create', time () );
		$obj->setVar ( 'content_update', time () );
		$obj->setVar ( 'content_groups', $groups );
		
		//Form topic_img
		fmcontentUtils::uploadimg ( $forMods, 'content_img', $obj, $_REQUEST ['content_img'] );
		
		if ($perm_handler->isAllowed ( $xoopsUser, 'fmcontent_ac', '16', $forMods )) {
			$obj->setVar ( 'content_status', '1' );
			$content_handler->updateposts ( $_REQUEST ['content_uid'], '1', $content_action = 'add' );
		}
		
		if (! $content_handler->insert ( $obj )) {
			fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
			include XOOPS_ROOT_PATH . '/footer.php';
			exit ();
		}
		
		// Reset next content for previous content
		$content_handler->resetNext($forMods, $_REQUEST ['content_topic'] , $obj->getVar ( 'content_id' ));
		$content_handler->resetPrevious($forMods, $_REQUEST ['content_topic'] , $obj->getVar ( 'content_id' ));
		
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$tag_handler = xoops_getmodulehandler ( 'tag', 'tag' );
			$tag_handler->updateByItem ( $_POST ["item_tag"], $obj->getVar ( 'content_id' ), $forMods->getVar ( "dirname" ), 0 );
		}
		
		// Redirect page
		fmcontent_Redirect ( 'index.php', 1, _FMCONTENT_MSG_WAIT );
		include XOOPS_ROOT_PATH . '/footer.php';
		exit ();
		break;
	
	default :
		
		$content_type = fmcontent_CleanVars ( $_REQUEST, 'content_type', 'content', 'string' );
		$obj = $content_handler->create ();
		$obj->getContentSimpleForm ( $forMods, $content_type );
		break;

}

// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';

?>