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
 * News Utils class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

class NewsUtils {
	
	/**
	 * Uploadimg function
	 *
	 * For manage all upload parts for images
	 * Add topic , Edit topic , Add content , Edit content
	 */
	function uploadimg($forMods, $type, $obj, $image) {
		include_once XOOPS_ROOT_PATH . "/class/uploader.php";
		$pach_original = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/original/';
		$pach_medium = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/medium/';
		$pach_thumb = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/thumb/';
		
		$uploader_img = new XoopsMediaUploader ( $pach_original , xoops_getModuleOption ( 'img_mime', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxwidth', $forMods->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxheight', $forMods->getVar ( 'dirname' ) ) );
		if ($uploader_img->fetchMedia ( $type )) {
			$uploader_img->setPrefix ( $type . '_' );
			$uploader_img->fetchMedia ( $type );
			if (! $uploader_img->upload ()) {
				$errors = $uploader_img->getErrors ();
				News_Redirect ( "javascript:history.go(-1)", 3, $errors );
				xoops_cp_footer ();
			   exit ();
			} else {
				$obj->setVar ( $type, $uploader_img->getSavedFileName () );
				self::news_resizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_medium . $uploader_img->getSavedFileName () , xoops_getModuleOption ( 'img_mediumwidth', $forMods->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_mediumheight', $forMods->getVar ( 'dirname' ) ));
				self::news_resizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_thumb . $uploader_img->getSavedFileName (), xoops_getModuleOption ( 'img_thumbwidth', $forMods->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_thumbheight', $forMods->getVar ( 'dirname' ) ));
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
			
			// delete original image
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/original/'. $obj->getVar ( $type );
			if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
				if (! unlink ( $currentPicture )) {
					trigger_error ( "Error, impossible to delete the picture attached to this article" );
				}
			}
			
			// delete original medium
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/medium/'. $obj->getVar ( $type );
			if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
				if (! unlink ( $currentPicture )) {
					trigger_error ( "Error, impossible to delete the picture attached to this article" );
				}
			}
			
			// delete original thumb
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) .'/thumb/'. $obj->getVar ( $type );
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
			News_Redirect ( "javascript:history.go(-1)", 3, $errors );
			xoops_cp_footer ();
		   exit ();
		}
 	}
	
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Gregory Mage (Aka Mage)
	 */
	function breadcrumb($forMods, $lasturl, $breadcrumbtitle, $topic_id, $prefix = ' &raquo; ', $title = 'topic_title') {
		$breadcrumb = '';
		include_once XOOPS_ROOT_PATH . '/modules/news/class/topic.php';
		require_once $GLOBALS ['xoops']->path ( '/class/tree.php' );
		$topic_Handler = xoops_getModuleHandler ( "topic", "news" );
		
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topics_arr = $topic_Handler->getall ( $criteria );
		$mytree = new XoopsObjectTree ( $topics_arr, 'topic_id', 'topic_pid' );
		
		if (xoops_getModuleOption ( 'bc_tohome', $forMods->getVar ( 'dirname' ) )) {
			$breadcrumb = '<a title="' ._NEWS_MD_HOME . '" href="' . XOOPS_URL . '">' . _NEWS_MD_HOME . '</a>' . $prefix;
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
				$Path .= '<a title="' . $topic_parent [$j]->getVar ( $title ) . '" href="'.News_TopicUrl($forMods->getVar ( 'dirname' ), $topic_info).'">' . $topic_parent [$j]->getVar ( $title ) . '</a>' . $prefix;
			} else {
				$Path .= $topic_parent [$j]->getVar ( $title ) . $prefix;
			}
		}
		if ($order == 'ASC') {
			if (array_key_exists ( $key, $topic_array )) {
				if ($lasturl == true) {
					$first_category = '<a title="' . $topic_array [$key]->getVar ( $title ) . '" href="'.News_TopicUrl($forMods->getVar ( 'dirname' ), array('topic_id'=>$topic_array [$key]->getVar ( 'topic_id' ),'topic_alias'=>$topic_array [$key]->getVar ( 'topic_alias' ))).'">' . $topic_array [$key]->getVar ( $title ) . '</a>';
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
	 * For management module index page
	 * Types:
	 * list all contents from all topics whit out topic list
	 * List all topics
	 * List all static pages
	 * Show selected content
	 */
	function homepage($forMods, $story_infos, $type) {
		
		$story_handler = xoops_getmodulehandler ( 'story', 'news' );
		$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
		if (! $type) {
			$type = 'type1';
		}
		$contents = array ();
		
		switch ($type) {
			
			// list all contents from all topics whit out topic list
			case 'type1' :
				$contents ['content'] = $story_handler->getContentList ( $forMods, $story_infos );
				$contents ['numrows'] = $story_handler->getContentCount ( $forMods, $story_infos );
				if ($contents ['numrows'] > $story_infos ['story_limit']) {
					if ($story_infos ['story_topic']) {
						$story_pagenav = new XoopsPageNav ( $contents ['numrows'], $story_infos ['story_limit'], $story_infos ['story_start'], 'start', 'limit=' . $story_infos ['story_limit'] . '&topic=' . $story_infos ['story_topic'] );
					} else {
						$story_pagenav = new XoopsPageNav ( $contents ['numrows'], $story_infos ['story_limit'], $story_infos ['story_start'], 'start', 'limit=' . $story_infos ['story_limit'] );
					}
					$contents ['pagenav'] = $story_pagenav->renderNav ( 4 );
				} else {
					$contents ['pagenav'] = '';
				}
				break;
			
			// List all topics
			case 'type2' :
			     $topic_order = xoops_getModuleOption('admin_showorder_topic', $forMods->getVar('dirname'));
              $topic_sort = xoops_getModuleOption('admin_showsort_topic', $forMods->getVar('dirname'));
              $topic_parent = $story_infos ['story_topic'];
		        $contents ['content'] = $topic_handler->getTopics($forMods, null, 0, $topic_order, $topic_sort, null, 1 , $topic_parent);
			     $contents ['pagenav'] = null;
				break;
			
			// List all static pages
			case 'type3' :
				if(!$story_infos ['story_topic']) {
				   $story_infos ['story_topic'] = 0;
				}
				$story_infos ['story_subtopic'] = null;
            $story_infos ['story_static'] = 0;
            $story_infos ['admin_side'] = 1;
            
				$contents ['content'] = $story_handler->getContentList ( $forMods, $story_infos );
				$contents ['numrows'] = $story_handler->getContentCount ( $forMods, $story_infos );
				if ($contents ['numrows'] > $story_infos ['story_limit']) {
					if ($story_topic) {
						$story_pagenav = new XoopsPageNav ( $contents ['numrows'], $story_infos ['story_limit'], $story_infos ['story_start'], 'start', 'limit=' . $story_infos ['story_limit'] . '&topic=' . $story_infos ['story_topic'] );
					} else {
						$story_pagenav = new XoopsPageNav ( $contents ['numrows'], $story_infos ['story_limit'], $story_infos ['story_start'], 'start', 'limit=' . $story_infos ['story_limit'] );
					}
					$contents ['pagenav'] = $story_pagenav->renderNav ( 4 );
				} else {
					$contents ['pagenav'] = '';
				}
				break;
			
			// Show selected static content
			case 'type4' :
				   if($story_infos['id'] && $story_infos['title'] && $story_infos['alias']) {
				   	$id = $story_infos['id'];
				   	$title = $story_infos['title'];
				   	$alias = $story_infos['alias'];
				   } else {
				   	$id = 0;
				   	$title = xoops_getModuleOption ( 'static_name', $forMods->getVar ( 'dirname' ));
				   	$alias = News_Filter(xoops_getModuleOption('static_name', $forMods->getVar ( 'dirname' )));
				   }		
					$default_info = array('id'=> $id , 'title' => $title , 'alias' => $alias);
					$contents ['content'] = $story_handler->contentDefault($forMods, $default_info);
				break;
		}
		return $contents;
	}
	
	/**
    * Verify that a field exists inside a mysql table
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
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
	*/
	function AddTable($query) {
		global $xoopsDB;
		$result = $xoopsDB->queryF($query);
		return $result;
	}
	
	/**
	 * Resize a Picture to some given dimensions (using the wideImage library)
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 *
	 * @param string $src_path	Picture's source
	 * @param string $dst_path	Picture's destination
	 * @param integer $param_width Maximum picture's width
	 * @param integer $param_height	Maximum picture's height
	 * @param boolean $keep_original	Do we have to keep the original picture ?
	 * @param string $fit	Resize mode (see the wideImage library for more information)
	 */
	function news_resizePicture($src_path , $dst_path, $param_width , $param_height, $keep_original = true, $fit = 'inside')
	{
	  require XOOPS_ROOT_PATH.'/modules/news/class/wideimage/WideImage.inc.php';
	  $resize = true;
	    $pictureDimensions = getimagesize($src_path);
	    if (is_array($pictureDimensions)) {
	        $pictureWidth = $pictureDimensions[0];
	        $pictureHeight = $pictureDimensions[1];
	        if ($pictureWidth < $param_width && $pictureHeight < $param_height) {
	            $resize = false;
	        }
	    }
	
	  $img = wiImage::load($src_path);
	  if ($resize) {
	    $result = $img->resize($param_width, $param_height, $fit);
	    $result->saveToFile($dst_path);
	   } else {
	        @copy($src_path, $dst_path);
	   }
	  if(!$keep_original) {
	    @unlink( $src_path ) ;
	  }
	  return true;
	}

}
?>