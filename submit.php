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
 * News submit file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($forMods)) exit('Module not found');

include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";

$op = news_CleanVars ( $_REQUEST, 'op', '', 'string' );

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

$story_handler = xoops_getmodulehandler ( 'story', 'news' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
$file_handler = xoops_getmodulehandler ( 'file', 'news' );

// Include language file
xoops_loadLanguage ( 'admin', $forMods->getVar ( 'dirname', 'e' ) );

// Check the access permission
global $xoopsUser;
$perm_handler = NewsPermission::getHandler ();
if (! $perm_handler->isAllowed ( $xoopsUser, 'news_ac', '8', $forMods )) {
	redirect_header ( "index.php", 3, _NOPERM );
	exit ();
}

switch ($op) {
	case 'add' :
		
		if (! isset ( $_POST ['post'] )) {
			redirect_header ( "index.php", 3, _NOPERM );
			exit ();
		}
		
		if ($_REQUEST ['story_modid'] != $forMods->getVar ( 'mid' )) {
			redirect_header ( 'index.php', 3, _NOPERM );
			exit ();
		}
		
		$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname' ) );
		$groups = (isset ( $groups )) ? $groups : '';
		$groups = (is_array ( $groups )) ? implode ( " ", $groups ) : '';
		
		$obj = $story_handler->create ();
		$obj->setVars ( $_REQUEST );
		
		$obj->setVar ( 'story_order', $story_handler->setorder($forMods) );
		$obj->setVar ( 'story_next', $story_handler->setNext($forMods, $_REQUEST ['story_topic']) );
		$obj->setVar ( 'story_prev', $story_handler->setPrevious($forMods, $_REQUEST ['story_topic']) );
		$obj->setVar ( 'story_menu', News_AjaxFilter ( $_REQUEST ['story_title'] ) );
		$obj->setVar ( 'story_alias', News_Filter ( $_REQUEST ['story_title'] ) );
		$obj->setVar ( 'story_words', News_MetaFilter ( $_REQUEST ['story_title'] ) );
		$obj->setVar ( 'story_desc', News_AjaxFilter ( $_REQUEST ['story_title'] ) );
		$obj->setVar ( 'story_create', time () );
		$obj->setVar ( 'story_update', time () );
		$obj->setVar ( 'story_groups', $groups );
		
		//Form topic_img
		NewsUtils::uploadimg ( $forMods, 'story_img', $obj, $_REQUEST ['story_img'] );
		
		if ($perm_handler->isAllowed ( $xoopsUser, 'news_ac', '16', $forMods )) {
			$obj->setVar ( 'story_status', '1' );
			$story_handler->updateposts ( $_REQUEST ['story_uid'], '1', $story_action = 'add' );
		}
		
		if (! $story_handler->insert ( $obj )) {
			News_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _NEWS_MD_MSG_ERROR );
			include XOOPS_ROOT_PATH . '/footer.php';
			exit ();
		}
		
		// Reset next content for previous content
		$story_handler->resetNext($forMods, $_REQUEST ['story_topic'] , $obj->getVar ( 'story_id' ));
		$story_handler->resetPrevious($forMods, $_REQUEST ['story_topic'] , $obj->getVar ( 'story_id' ));
		
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$tag_handler = xoops_getmodulehandler ( 'tag', 'tag' );
			$tag_handler->updateByItem ( $_POST ["item_tag"], $obj->getVar ( 'story_id' ), $forMods->getVar ( "dirname" ), 0 );
		}
		
		// file
		if($_REQUEST ['file_name']) {
			$fileobj = $file_handler->create ();
		   $fileobj->setVar ( 'file_date', time () );
		   $fileobj->setVar ( 'file_modid', $forMods->getVar ( 'mid' ) );
			$fileobj->setVar ( 'file_title', $_REQUEST ['story_title'] );
			$fileobj->setVar ( 'file_content', $obj->getVar ( 'story_id' ) );
		   $fileobj->setVar ( 'file_status', 1 );
		   
		   NewsUtils::uploadfile ( $forMods, 'file_name', $fileobj, $_REQUEST ['file_name'] );
		   $story_handler->contentfile('add',$obj->getVar ( 'story_id' ));
		   if (! $file_handler->insert ( $fileobj )) {
					News_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _NEWS_MD_MSG_ERROR );
					xoops_cp_footer ();
					exit ();
			}
		}
			
		// Redirect page
		News_Redirect ( 'index.php', 1, _NEWS_MD_MSG_WAIT );
		include XOOPS_ROOT_PATH . '/footer.php';
		exit ();
		break;
	
	default :
		
		$story_type = news_CleanVars ( $_REQUEST, 'story_type', 'news', 'string' );
		$obj = $story_handler->create ();
		$obj->getContentSimpleForm ( $forMods, $story_type );
		break;

}

// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';

?>