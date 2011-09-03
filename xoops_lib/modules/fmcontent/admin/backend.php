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
 * FmContent Admin page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id:$
 */

if (! isset ( $forMods ))
	exit ( 'Module not found' );

	// Define default value
$op = fmcontent_CleanVars ( $_REQUEST, 'op', 'new', 'string' );
// Admin header
xoops_cp_header ();
// Redirect to content page
if (! isset ( $_POST ['post'] ) && isset ( $_POST ['content_type'] )) {
	
	$content_type = $_POST ['content_type'];
	fmcontent_Redirect ( 'navigation.php?content_type=' . $content_type, 0, _FMCONTENT_MSG_WAIT );
	// Include footer
	xoops_cp_footer ();
	exit ();
}

// Initialize content handler
$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );
$file_handler = xoops_getmodulehandler ( 'file', 'fmcontent' );

switch ($op) {
	
	case 'add_topic' :
		$obj = $topic_handler->create ();
		$obj->setVars ( $_REQUEST );

		if($topic_handler->existAlias($forMods,$_REQUEST)) {
	      fmcontent_Redirect ( "javascript:history.go(-1)", 3, _FMCONTENT_MSG_ALIASERROR );
			xoops_cp_footer ();
			exit ();
		}	
			
		$obj->setVar ( 'topic_date_created', time () );
		$obj->setVar ( 'topic_date_update', time () );
		$obj->setVar ( 'topic_weight', $topic_handler->setorder($forMods) );
		
		//image
		fmcontentUtils::uploadimg ( $forMods, 'topic_img', $obj, $_REQUEST ['topic_img'] );
		
		if (! $topic_handler->insert ( $obj )) {
			fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
			xoops_cp_footer ();
			exit ();
		}
		
		$topic_id = $obj->db->getInsertId ();
		
		//permission
		fmcontentPermission::setpermission ( $forMods, 'fmcontent_access', $_POST ['groups_view'], $topic_id, true );
		fmcontentPermission::setpermission ( $forMods, 'fmcontent_submit', $_POST ['groups_submit'], $topic_id, true );
		
		// Redirect page
		fmcontent_Redirect ( 'topic.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
	
	case 'edit_topic' :
		$topic_id = fmcontent_CleanVars ( $_REQUEST, 'topic_id', 0, 'int' );
		if ($topic_id > 0) {
			
			$obj = $topic_handler->get ( $topic_id );
			$obj->setVars ( $_POST );
			$obj->setVar ( 'topic_date_update', time () );

			if($topic_handler->existAlias($forMods,$_REQUEST)) {
		      fmcontent_Redirect ( "javascript:history.go(-1)", 3, _FMCONTENT_MSG_ALIASERROR );
				xoops_cp_footer ();
				exit ();
			}	
		
			//image
			fmcontentUtils::uploadimg ( $forMods, 'topic_img', $obj, $_REQUEST ['topic_img'] );
			if (isset ( $_POST ['deleteimage'] ) && intval ( $_POST ['deleteimage'] ) == 1) {
				fmcontentUtils::deleteimg ( $forMods, 'topic_img', $obj );
			}
			//permission
			fmcontentPermission::setpermission ( $forMods, 'fmcontent_access', $_POST ['groups_view'], $topic_id, false );
			fmcontentPermission::setpermission ( $forMods, 'fmcontent_submit', $_POST ['groups_submit'], $topic_id, false );
			
			if (! $topic_handler->insert ( $obj )) {
				fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
				xoops_cp_footer ();
				exit ();
			}
		}
		
		// Redirect page
		fmcontent_Redirect ( 'topic.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
	
	case 'add' :
		$groups = (isset ( $_POST ['content_groups'] )) ? $_POST ['content_groups'] : '';
		$groups = (is_array ( $groups )) ? implode ( " ", $groups ) : '';
		
		$obj = $content_handler->create ();
		$obj->setVars ( $_REQUEST );
		
		if($content_handler->existAlias($forMods,$_REQUEST)) {
	      fmcontent_Redirect ( "javascript:history.go(-1)", 3, _FMCONTENT_MSG_ALIASERROR );
			xoops_cp_footer ();
			exit ();
		}	
		
		if ($_REQUEST ['content_type'] == 'link') {
			$obj->setVar ( 'content_title', $_REQUEST ['content_menu'] );
		}
		
		if(!$_REQUEST ['content_default'] && $_REQUEST ['content_topic'] == 0) {
			$criteria = new CriteriaCompo ();
		   $criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		   $criteria->add ( new Criteria ( 'content_topic', 0) );
		   $criteria->add ( new Criteria ( 'content_default', 1 ) );
		   if(!$content_handler->getCount ( $criteria )) {
		   	$obj->setVar ( 'content_default', '1' );
		   }	
		}	
		
		$obj->setVar ( 'content_order', $content_handler->setorder($forMods) );
		$obj->setVar ( 'content_next', $content_handler->setNext($forMods, $_REQUEST ['content_topic']) );
		$obj->setVar ( 'content_prev', $content_handler->setPrevious($forMods, $_REQUEST ['content_topic']) );
		$obj->setVar ( 'content_groups', $groups );
		$obj->setVar ( 'content_create', time () );
		$obj->setVar ( 'content_update', time () );
		
		//image
		fmcontentUtils::uploadimg ( $forMods, 'content_img', $obj, $_REQUEST ['content_img'] );
		
		$content_handler->updateposts ( $_REQUEST ['content_uid'], $_REQUEST ['content_status'], $content_action = 'add' );
		
		
		if (! $content_handler->insert ( $obj )) {
			fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
			xoops_cp_footer ();
			exit ();
		}
		
		// Reset next and previous content
		$content_handler->resetNext($forMods, $_REQUEST ['content_topic'] , $obj->getVar ( 'content_id' ));
		$content_handler->resetPrevious($forMods, $_REQUEST ['content_topic'] , $obj->getVar ( 'content_id' ));
		
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$tag_handler = xoops_getmodulehandler ( 'tag', 'tag' );
			$tag_handler->updateByItem ( $_POST ["item_tag"], $obj->getVar ( 'content_id' ), $forMods->getVar ( "dirname" ), 0 );
		}
		
		// Redirect page
		fmcontent_Redirect ( 'content.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
	   exit ();
		break;
	
	case 'edit' :
		$content_id = fmcontent_CleanVars ( $_REQUEST, 'content_id', 0, 'int' );
		if ($content_id > 0) {
			$groups = (isset ( $_POST ['content_groups'] )) ? $_POST ['content_groups'] : '';
			$groups = (is_array ( $groups )) ? implode ( " ", $groups ) : '';
			
			$obj = $content_handler->get ( $content_id );
			$obj->setVars ( $_REQUEST );
         $obj->setVar ( 'content_groups', $groups );
			$obj->setVar ( 'content_update', time () );
			
			if($content_handler->existAlias($forMods,$_REQUEST)) {
		      fmcontent_Redirect ( "javascript:history.go(-1)", 3, _FMCONTENT_MSG_ALIASERROR );
				xoops_cp_footer ();
				exit ();
			}	
		
			if ($_REQUEST ['content_type'] == 'link') {
				$obj->setVar ( 'content_title', $_REQUEST ['content_menu'] );
			}
			
			if (! isset ( $_REQUEST ['content_titleview'] )) {
				$obj->setVar ( 'content_titleview', 0 );
			}
			
			if (! isset ( $_REQUEST ['dohtml'] )) {
				$obj->setVar ( 'dohtml', 0 );
			}
			
			if (! isset ( $_REQUEST ['dobr'] )) {
				$obj->setVar ( 'dobr', 0 );
			}
			
			if (! isset ( $_REQUEST ['doimage'] )) {
				$obj->setVar ( 'doimage', 0 );
			}
			
			if (! isset ( $_REQUEST ['dosmiley'] )) {
				$obj->setVar ( 'dosmiley', 0 );
			}
			
			if (! isset ( $_REQUEST ['doxcode'] )) {
				$obj->setVar ( 'doxcode', 0 );
			}
			
			//image
			fmcontentUtils::uploadimg ( $forMods, 'content_img', $obj, $_REQUEST ['content_img'] );
			if (isset ( $_POST ['deleteimage'] ) && intval ( $_POST ['deleteimage'] ) == 1) {
				fmcontentUtils::deleteimg ( $forMods, 'content_img', $obj );
			}
			
			if (! $content_handler->insert ( $obj )) {
				fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
				xoops_cp_footer ();
				exit ();
			}
			
			//tag
			if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
				$tag_handler = xoops_getmodulehandler ( 'tag', 'tag' );
				$tag_handler->updateByItem ( $_POST ["item_tag"], $content_id, $forMods->getVar ( "dirname" ), $catid = 0 );
			}

		}
		
		// Redirect page
		fmcontent_Redirect ( 'content.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
	
	case 'add_file' :
	   
	   $obj = $file_handler->create ();
		$obj->setVars ( $_REQUEST );
	   $obj->setVar ( 'file_date', time () );
	   
	   fmcontentUtils::uploadfile ( $forMods, 'file_name', $obj, $_REQUEST ['file_name'] );
	   $content_handler->contentfile('add',$_REQUEST['file_content']);
	   if (! $file_handler->insert ( $obj )) {
				fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
				xoops_cp_footer ();
				exit ();
		}
			
		// Redirect page
		fmcontent_Redirect ( 'file.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
		
	case 'edit_file' :

	   $file_id = fmcontent_CleanVars ( $_REQUEST, 'file_id', 0, 'int' );
		if ($file_id > 0) {

		   $obj = $file_handler->get ( $file_id );
			$obj->setVars ( $_REQUEST );
			
		   if (! $file_handler->insert ( $obj )) {
					fmcontent_Redirect ( 'onclick="javascript:history.go(-1);"', 1, _FMCONTENT_MSG_ERROR );
					xoops_cp_footer ();
					exit ();
			}
		}	
		// Redirect page
		fmcontent_Redirect ( 'file.php', 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
		
	case 'status' :
		$content_id = fmcontent_CleanVars ( $_REQUEST, 'content_id', 0, 'int' );
		if ($content_id > 0) {
			$obj = & $content_handler->get ( $content_id );
			$old = $obj->getVar ( 'content_status' );
			$content_handler->updateposts ( $obj->getVar ( 'content_uid' ), $obj->getVar ( 'content_status' ), $content_action = 'status' );
			$obj->setVar ( 'content_status', ! $old );
			if ($content_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
	
	case 'default' :
		$content_id = fmcontent_CleanVars ( $_REQUEST, 'content_id', 0, 'int' );
		$topic_id = fmcontent_CleanVars ( $_REQUEST, 'topic_id', 0, 'int' );
		if ($content_id > 0) {
			$criteria = new CriteriaCompo ();
			$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
			$content_handler->updateAll ( 'content_default', 0, $criteria );
			$obj = & $content_handler->get ( $content_id );
			$obj->setVar ( 'content_default', 1 );
			if ($content_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
	
	case 'display' :
		$content_id = fmcontent_CleanVars ( $_REQUEST, 'content_id', 0, 'int' );
		if ($content_id > 0) {
			$obj = & $content_handler->get ( $content_id );
			$old = $obj->getVar ( 'content_display' );
			$obj->setVar ( 'content_display', ! $old );
			if ($content_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
	
	case 'topic_asmenu' :
		$topic_id = fmcontent_CleanVars ( $_REQUEST, 'topic_id', 0, 'int' );
		if ($topic_id > 0) {
			$obj = & $topic_handler->get ( $topic_id );
			$old = $obj->getVar ( 'topic_asmenu' );
			$obj->setVar ( 'topic_asmenu', ! $old );
			if ($topic_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
	
	case 'topic_online' :
		$topic_id = fmcontent_CleanVars ( $_REQUEST, 'topic_id', 0, 'int' );
		if ($topic_id > 0) {
			$obj = & $topic_handler->get ( $topic_id );
			$old = $obj->getVar ( 'topic_online' );
			$obj->setVar ( 'topic_online', ! $old );
			if ($topic_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;

	case 'topic_show' :
		$topic_id = fmcontent_CleanVars ( $_REQUEST, 'topic_id', 0, 'int' );
		if ($topic_id > 0) {
			$obj = & $topic_handler->get ( $topic_id );
			$old = $obj->getVar ( 'topic_show' );
			$obj->setVar ( 'topic_show', ! $old );
			if ($topic_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
	
	case 'file_status' :
		$file_id = fmcontent_CleanVars ( $_REQUEST, 'file_id', 0, 'int' );
		if ($file_id > 0) {
			$obj = & $file_handler->get ( $file_id );
			$old = $obj->getVar ( 'file_status' );
			$obj->setVar ( 'file_status', ! $old );
			if ($file_handler->insert ( $obj )) {
				exit ();
			}
			echo $obj->getHtmlErrors ();
		}
		break;
			
	case 'delete' :
	   //print_r($_POST);
		$id = fmcontent_CleanVars ( $_REQUEST, 'id', 0, 'int' );
		$handler = fmcontent_CleanVars ( $_REQUEST, 'handler', 0, 'string' );
		if ($id > 0 && $handler) {
			switch($handler) {
				case 'content':
					$obj = $content_handler->get ( $id );
					$url = 'content.php';
					$content_handler->updateposts ( $obj->getVar ( 'content_uid' ), $obj->getVar ( 'content_status' ), $content_action = 'delete' );
					if (! $content_handler->delete ( $obj )) {
						echo $obj->getHtmlErrors ();
					}
				break;
				case 'topic':
					$obj = $topic_handler->get ( $id );
					$url = 'topic.php';
					if (! $topic_handler->delete ( $obj )) {
						echo $obj->getHtmlErrors ();
					}
				break;
				case 'file':
					$obj = $file_handler->get ( $id );
					$url = 'file.php';
					$content_handler->contentfile('delete',$obj->getVar ( 'file_content' ));
					if (! $file_handler->delete ( $obj )) {
						echo $obj->getHtmlErrors ();
					}
				break;
			}	
		}
		
		// Redirect page
		fmcontent_Redirect ( $url , 1, _FMCONTENT_MSG_WAIT );
		xoops_cp_footer ();
		exit ();
		break;
}

// Redirect page
fmcontent_Redirect ( 'index.php', 1, _FMCONTENT_MSG_WAIT );
// Include footer
xoops_cp_footer ();

?>