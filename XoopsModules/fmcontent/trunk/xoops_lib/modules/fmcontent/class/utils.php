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
 * FmContent page class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

class fmcontentUtils {
	
	function uploadimg($forMods, $type, $obj, $image) {
		include_once XOOPS_ROOT_PATH . "/class/uploader.php";
		$uploader_img = new XoopsMediaUploader ( XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_mime', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxwidth', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxheight', $forMods->getVar ( 'dirname' ) ) );
		if ($uploader_img->fetchMedia ( $type )) {
			$uploader_img->setPrefix ( $type . '_' );
			$uploader_img->fetchMedia ( $type );
			if (! $uploader_img->upload ()) {
				$errors = $uploader_img->getErrors ();
				fmcontent_Redirect ( "javascript:history.go(-1)", 3, $errors );
			} else {
				$obj->setVar ( $type, $uploader_img->getSavedFileName () );
			}
		} else {
			if (isset ( $image )) {
				$obj->setVar ( $type, $image );
			}
		}
	}
	
	function deleteimg($forMods, $type, $obj) {
		if ($obj->getVar ( $type )) {
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . $obj->getVar ( $type );
			if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
				if (! unlink ( $currentPicture )) {
					trigger_error ( "Error, impossible to delete the picture attached to this article" );
				}
			}
		}
		$obj->setVar ( $type, '' );
	}
	
	function breadcrumb($forMods, $lasturl, $breadcrumbtitle, $topic_id, $prefix = ' &raquo; ', $title = 'topic_title') {
		$breadcrumb = '';
		include_once XOOPS_TRUST_PATH . '/modules/fmcontent/class/topic.php';
		require_once $GLOBALS ['xoops']->path ( '/class/tree.php' );
		$topic_Handler = xoops_getModuleHandler ( "topic", "fmcontent" );
		
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topics_arr = $topic_Handler->getall ( $criteria );
		$mytree = new XoopsObjectTree ( $topics_arr, 'topic_id', 'topic_pid' );
		
		if (xoops_getModuleOption ( 'bc_tohome', $forMods->getVar ( 'dirname' ) )) {
			$breadcrumb = '<a href=' . XOOPS_URL . '>Home</a>' . $prefix;
		}
		$breadcrumb = $breadcrumb . self::PathTreeUrl ( $mytree, $topic_id, $topics_arr, $title, $prefix, true, 'ASC', $lasturl, xoops_getModuleOption ( 'bc_modname', $forMods->getVar ( 'dirname' ) ) );
		if ($lasturl) {
			$breadcrumb = $breadcrumb . $prefix . $breadcrumbtitle;
		}
		return $breadcrumb;
	}
	
	function PathTreeUrl($mytree, $key, $topic_array, $title, $prefix = ' &raquo; ', $link = false, $order = 'ASC', $lasturl = false, $modname) {
		global $xoopsModule;
		$topic_parent = $mytree->getAllParent ( $key );
		if ($order == 'ASC') {
			$topic_parent = array_reverse ( $topic_parent );
			if ($link == true && $modname) {
				$Path = '<a href="index.php">' . $xoopsModule->name () . '</a>' . $prefix;
			} elseif ($modname) {
				$Path = $xoopsModule->name () . $prefix;
			}
		} else {
			if (array_key_exists ( $key, $topic_array )) {
				$first_category = $topic_array [$key]->getVar ( $title );
			} else {
				$first_category = '';
			}
			$Path = $first_category . $prefix;
		}
		foreach ( array_keys ( $topic_parent ) as $j ) {
			if ($link == true) {
				$Path .= '<a href="index.php?topic=' . $topic_parent [$j]->getVar ( 'topic_id' ) . '">' . $topic_parent [$j]->getVar ( $title ) . '</a>' . $prefix;
			} else {
				$Path .= $topic_parent [$j]->getVar ( $title ) . $prefix;
			}
		}
		if ($order == 'ASC') {
			if (array_key_exists ( $key, $topic_array )) {
				if ($lasturl == true) {
					$first_category = '<a href="index.php?topic=' . $topic_array [$key]->getVar ( 'topic_id' ) . '">' . $topic_array [$key]->getVar ( $title ) . '</a>';
				} else {
					$first_category = $topic_array [$key]->getVar ( $title );
				}
			} else {
				$first_category = '';
			}
			$Path .= $first_category;
		} else {
			if ($link == true) {
				$Path .= '<a href="index.php">' . $xoopsModule->name () . '</a>';
			} else {
				$Path .= $xoopsModule->name ();
			}
		}
		return $Path;
	}

}
?>