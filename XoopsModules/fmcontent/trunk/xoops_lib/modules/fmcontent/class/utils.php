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
 * FmContent Utils class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

class fmcontentUtils {
	
	/**
	 * Uploadimg function
	 *
	 * For manage all upload parts for images
	 * Add topic , Edit topic , Add content , Edit content
	 */
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
	
	/**
	 * Deleteimg function
	 *
	 * For Deleteing uploaded images
	 * Edit topic ,Edit content
	 */
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
	
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Gregory Mage (Aka Mage)
	 * @package     TDMDownload
	 * @version     $Id$
	 */
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
	
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Gregory Mage (Aka Mage)
	 * @package     TDMDownload
	 * @version     $Id$
	 */
	function PathTreeUrl($mytree, $key, $topic_array, $title, $prefix = ' &raquo; ', $link = false, $order = 'ASC', $lasturl = false, $modname) {
		global $xoopsModule;
		$topic_parent = $mytree->getAllParent ( $key );
		if ($order == 'ASC') {
			$topic_parent = array_reverse ( $topic_parent );
			if ($link == true && $modname) {
				if($key) {
					$Path = '<a href="index.php">' . $xoopsModule->name () . '</a>' . $prefix;
				} else {
					$Path = '<a href="index.php">' . $xoopsModule->name () . '</a>';
				}
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
	
	/**
	 * Homepage function
	 *
	 * For management module index page
	 * 
	 */
	function homepage($forMods, $content_infos, $type) {
		
		$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
		$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );
		if (! $type) {
			$type = 'type1';
		}
		$contents = array ();
		
		switch ($type) {
			
			// list all contents from all topics whit out topic list
			case 'type1' :
				$contents ['content'] = $content_handler->getContentList ( $forMods, $content_infos );
				$contents ['numrows'] = $content_handler->getContentCount ( $forMods, $content_infos );
				if ($contents ['numrows'] > $content_infos ['content_limit']) {
					if ($content_topic) {
						$content_pagenav = new XoopsPageNav ( $contents ['numrows'], $content_infos ['content_limit'], $content_infos ['content_start'], 'start', 'limit=' . $content_infos ['content_limit'] . '&topic=' . $content_infos ['content_topic'] );
					} else {
						$content_pagenav = new XoopsPageNav ( $contents ['numrows'], $content_infos ['content_limit'], $content_infos ['content_start'], 'start', 'limit=' . $content_infos ['content_limit'] );
					}
					$contents ['pagenav'] = $content_pagenav->renderNav ( 4 );
				} else {
					$contents ['pagenav'] = '';
				}
				break;
			
			// List all topics
			case 'type2' :
			     $topic_order = xoops_getModuleOption('admin_showorder_topic', $forMods->getVar('dirname'));
              $topic_sort = xoops_getModuleOption('admin_showsort_topic', $forMods->getVar('dirname'));
		        $contents ['content'] = $topic_handler->getTopics($forMods, null, 0, $topic_order, $topic_sort, null, 1);
			     $contents ['pagenav'] = null;
				break;
			
			// List all static pages
			case 'type3' :
			   $content_infos ['content_topic'] = 0;
            $content_infos ['content_static'] = 0;
            $content_infos ['admin_side'] = 1;
            
				$contents ['content'] = $content_handler->getContentList ( $forMods, $content_infos );
				$contents ['numrows'] = $content_handler->getContentCount ( $forMods, $content_infos );
				if ($contents ['numrows'] > $content_infos ['content_limit']) {
					if ($content_topic) {
						$content_pagenav = new XoopsPageNav ( $contents ['numrows'], $content_infos ['content_limit'], $content_infos ['content_start'], 'start', 'limit=' . $content_infos ['content_limit'] . '&topic=' . $content_infos ['content_topic'] );
					} else {
						$content_pagenav = new XoopsPageNav ( $contents ['numrows'], $content_infos ['content_limit'], $content_infos ['content_start'], 'start', 'limit=' . $content_infos ['content_limit'] );
					}
					$contents ['pagenav'] = $content_pagenav->renderNav ( 4 );
				} else {
					$contents ['pagenav'] = '';
				}
				break;
			
			// Show selected static content
			case 'type4' :
					$default_info = array('id'=> 0 , 'title' => xoops_getModuleOption ( 'static_name', $forMods->getVar ( 'dirname' )));
					$contents ['content'] = $content_handler->contentDefault($forMods, $default_info);
				break;
		}
		return $contents;
	}
	
/**
    * Verify that a field exists inside a mysql table
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 * @package     News
	 * @version     $Id$
*/
function FieldExists($fieldname,$table)
{
	global $xoopsDB;
	$result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
	return($xoopsDB->getRowsNum($result) > 0);
}

/**
 * Add a field to a mysql table
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 * @package     News
	 * @version     $Id$
 */
function AddField($field, $table)
{
	global $xoopsDB;
	$result=$xoopsDB->queryF('ALTER TABLE ' . $table . ' ADD ' . $field);
	return $result;
}	
	
}
?>