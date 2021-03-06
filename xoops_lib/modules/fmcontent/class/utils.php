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
 * @version     $Id$
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
				xoops_cp_footer ();
			   exit ();
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
	 * Uploadfile function
	 *
	 * For manage all upload parts for files
	 */
	function uploadfile($forMods, $type, $obj, $file) {   
      include_once XOOPS_ROOT_PATH . "/class/uploader.php";
		$uploader = new XoopsMediaUploader(XOOPS_ROOT_PATH . xoops_getModuleOption ( 'file_dir', $forMods->getVar ( 'dirname' ) ), explode('|',xoops_getModuleOption ( 'file_mime', $forMods->getVar ( 'dirname' ) )), xoops_getModuleOption ( 'file_size', $forMods->getVar ( 'dirname' ) ));
      if ($uploader->fetchMedia($type)) {
      	$uploader->setPrefix ( $type . '_' );
			$uploader->fetchMedia ( $type );
			if ($uploader->upload()) {
				$obj->setVar ( $type, $uploader->getSavedFileName () );
				$obj->setVar ( 'file_type', preg_replace('/^.*\./', '', $uploader->getSavedFileName ()));
			} else {
				echo _AM_UPLOAD_ERROR. ' ' . $uploader->getErrors();
			}
		} else {
			$errors = $uploader->getErrors ();
			fmcontent_Redirect ( "javascript:history.go(-1)", 3, $errors );
			xoops_cp_footer ();
		   exit ();
		}
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
			$breadcrumb = '<a title="' ._FMCONTENT_XHOME . '" href="' . XOOPS_URL . '">' . _FMCONTENT_XHOME . '</a>' . $prefix;
		}
		$breadcrumb = $breadcrumb . self::PathTreeUrl ( $mytree, $topic_id, $topics_arr, $title, $prefix, true, 'ASC', $lasturl, xoops_getModuleOption ( 'bc_modname', $forMods->getVar ( 'dirname' ) ) , $forMods);
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
	function PathTreeUrl($mytree, $key, $topic_array, $title, $prefix = ' &raquo; ', $link = false, $order = 'ASC', $lasturl = false, $modname , $forMods) {
		global $xoopsModule;
		$topic_parent = $mytree->getAllParent ( $key );
		if ($order == 'ASC') {
			$topic_parent = array_reverse ( $topic_parent );
			if ($link == true && $modname) {
				if($key) {
					$Path = '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$forMods->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>' . $prefix;
				} else {
					$Path = '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$forMods->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>';
				}
			} elseif ($modname) {
				$Path = $xoopsModule->name () . $prefix;
			} else {
				$Path = '';
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
				$topic_info = array(
				'topic_id'=>$topic_parent [$j]->getVar ( 'topic_id' ),
				'topic_title'=>$topic_parent [$j]->getVar ( 'topic_title' ),
            'topic_alias'=>$topic_parent [$j]->getVar ( 'topic_alias' ),
				);
				$Path .= '<a title="' . $topic_parent [$j]->getVar ( $title ) . '" href="'.fmcontent_TopicUrl($forMods->getVar ( 'dirname' ), $topic_info).'">' . $topic_parent [$j]->getVar ( $title ) . '</a>' . $prefix;
			} else {
				$Path .= $topic_parent [$j]->getVar ( $title ) . $prefix;
			}
		}
		if ($order == 'ASC') {
			if (array_key_exists ( $key, $topic_array )) {
				if ($lasturl == true) {
					$first_category = '<a title="' . $topic_array [$key]->getVar ( $title ) . '" href="'.fmcontent_TopicUrl($forMods->getVar ( 'dirname' ), array('topic_id'=>$topic_array [$key]->getVar ( 'topic_id' ),'topic_alias'=>$topic_array [$key]->getVar ( 'topic_alias' ))).'">' . $topic_array [$key]->getVar ( $title ) . '</a>';
				} else {
					$first_category = $topic_array [$key]->getVar ( $title );
				}
			} else {
				$first_category = '';
			}
			$Path .= $first_category;
		} else {
			if ($link == true) {
				$Path .= '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$forMods->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>';
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
					if ($content_infos ['content_topic']) {
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
              $topic_parent = $content_infos ['content_topic'];
		        $contents ['content'] = $topic_handler->getTopics($forMods, null, 0, $topic_order, $topic_sort, null, 1 , $topic_parent);
			     $contents ['pagenav'] = null;
				break;
			
			// List all static pages
			case 'type3' :
				if(!$content_infos ['content_topic']) {
				   $content_infos ['content_topic'] = 0;
				}
				$content_infos ['content_subtopic'] = null;
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
				   if($content_infos['id'] && $content_infos['title'] && $content_infos['alias']) {
				   	$id = $content_infos['id'];
				   	$title = $content_infos['title'];
				   	$alias = $content_infos['alias'];
				   } else {
				   	$id = 0;
				   	$title = xoops_getModuleOption ( 'static_name', $forMods->getVar ( 'dirname' ));
				   	$alias = fmcontent_Filter(xoops_getModuleOption('static_name', $forMods->getVar ( 'dirname' )));
				   }		
					$default_info = array('id'=> $id , 'title' => $title , 'alias' => $alias);
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
	
/**
    * Verify that a mysql table exists
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 * @package     Oledrion
	 * @version     $Id$
*/
function TableExists($tablename)
{
	global $xoopsDB;
	$result = $xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");
	return($xoopsDB->getRowsNum($result) > 0);
}

/**
    * Add a table
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 * @package     Oledrion
	 * @version     $Id$
*/
function AddTable($query) {
	global $xoopsDB;
	$result = $xoopsDB->queryF($query);
	return $result;
}

}
?>