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
	function News_UploadImg($NewsModule, $type, $obj, $image) {
		include_once XOOPS_ROOT_PATH . "/class/uploader.php";
		$pach_original = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/original/';
		$pach_medium = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/medium/';
		$pach_thumb = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/thumb/';
		
		$uploader_img = new XoopsMediaUploader ( $pach_original , xoops_getModuleOption ( 'img_mime', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_size', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxwidth', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxheight', $NewsModule->getVar ( 'dirname' ) ) );
		if ($uploader_img->fetchMedia ( $type )) {
			$uploader_img->setPrefix ( $type . '_' );
			$uploader_img->fetchMedia ( $type );
			if (! $uploader_img->upload ()) {
				$errors = $uploader_img->getErrors ();
				self::News_Redirect ( "javascript:history.go(-1)", 3, $errors );
				xoops_cp_footer ();
			   exit ();
			} else {
				$obj->setVar ( $type, $uploader_img->getSavedFileName () );
				self::News_ResizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_medium . $uploader_img->getSavedFileName () , xoops_getModuleOption ( 'img_mediumwidth', $NewsModule->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_mediumheight', $NewsModule->getVar ( 'dirname' ) ));
				self::News_ResizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_thumb . $uploader_img->getSavedFileName (), xoops_getModuleOption ( 'img_thumbwidth', $NewsModule->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_thumbheight', $NewsModule->getVar ( 'dirname' ) ));
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
	function News_DeleteImg($NewsModule, $type, $obj) {
		if ($obj->getVar ( $type )) {
			
			// delete original image
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/original/'. $obj->getVar ( $type );
			if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
				if (! unlink ( $currentPicture )) {
					trigger_error ( "Error, impossible to delete the picture attached to this article" );
				}
			}
			
			// delete original medium
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/medium/'. $obj->getVar ( $type );
			if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
				if (! unlink ( $currentPicture )) {
					trigger_error ( "Error, impossible to delete the picture attached to this article" );
				}
			}
			
			// delete original thumb
			$currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/thumb/'. $obj->getVar ( $type );
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
	function News_UploadFile($NewsModule, $type, $obj, $file) {   
      include_once XOOPS_ROOT_PATH . "/class/uploader.php";
		$uploader = new XoopsMediaUploader(XOOPS_ROOT_PATH . xoops_getModuleOption ( 'file_dir', $NewsModule->getVar ( 'dirname' ) ), explode('|',xoops_getModuleOption ( 'file_mime', $NewsModule->getVar ( 'dirname' ) )), xoops_getModuleOption ( 'file_size', $NewsModule->getVar ( 'dirname' ) ));
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
			self::News_Redirect ( "javascript:history.go(-1)", 3, $errors );
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
	function News_Breadcrumb($NewsModule, $lasturl, $breadcrumbtitle, $topic_id, $prefix = ' &raquo; ', $title = 'topic_title') {
		$breadcrumb = '';
		include_once XOOPS_ROOT_PATH . '/modules/news/class/topic.php';
		require_once $GLOBALS ['xoops']->path ( '/class/tree.php' );
		$topic_Handler = xoops_getModuleHandler ( "topic", "news" );
		
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$topics_arr = $topic_Handler->getall ( $criteria );
		$mytree = new XoopsObjectTree ( $topics_arr, 'topic_id', 'topic_pid' );
		
		if (xoops_getModuleOption ( 'bc_tohome', $NewsModule->getVar ( 'dirname' ) )) {
			$breadcrumb = '<a title="' ._NEWS_MD_HOME . '" href="' . XOOPS_URL . '">' . _NEWS_MD_HOME . '</a>' . $prefix;
		}
		$breadcrumb = $breadcrumb . self::News_PathTreeUrl ( $mytree, $topic_id, $topics_arr, $title, $prefix, true, 'ASC', $lasturl, xoops_getModuleOption ( 'bc_modname', $NewsModule->getVar ( 'dirname' ) ) , $NewsModule);
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
	function News_PathTreeUrl($mytree, $key, $topic_array, $title, $prefix = ' &raquo; ', $link = false, $order = 'ASC', $lasturl = false, $modname , $NewsModule) {
		global $xoopsModule;
		$topic_parent = $mytree->getAllParent ( $key );
		if ($order == 'ASC') {
			$topic_parent = array_reverse ( $topic_parent );
			if ($link == true && $modname) {
				if($key) {
					$Path = '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$NewsModule->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>' . $prefix;
				} else {
					$Path = '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$NewsModule->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>';
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
				$Path .= '<a title="' . $topic_parent [$j]->getVar ( $title ) . '" href="'.self::News_TopicUrl($NewsModule->getVar ( 'dirname' ), $topic_info).'">' . $topic_parent [$j]->getVar ( $title ) . '</a>' . $prefix;
			} else {
				$Path .= $topic_parent [$j]->getVar ( $title ) . $prefix;
			}
		}
		if ($order == 'ASC') {
			if (array_key_exists ( $key, $topic_array )) {
				if ($lasturl == true) {
					$first_category = '<a title="' . $topic_array [$key]->getVar ( $title ) . '" href="'.self::News_TopicUrl($NewsModule->getVar ( 'dirname' ), array('topic_id'=>$topic_array [$key]->getVar ( 'topic_id' ),'topic_alias'=>$topic_array [$key]->getVar ( 'topic_alias' ))).'">' . $topic_array [$key]->getVar ( $title ) . '</a>';
				} else {
					$first_category = $topic_array [$key]->getVar ( $title );
				}
			} else {
				$first_category = '';
			}
			$Path .= $first_category;
		} else {
			if ($link == true) {
				$Path .= '<a title="' . $xoopsModule->name () . '" href="'.XOOPS_URL.'/modules/'.$NewsModule->getVar ( 'dirname' ).'/index.php">' . $xoopsModule->name () . '</a>';
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
	function News_Homepage($NewsModule, $story_infos, $type) {
		
		$story_handler = xoops_getmodulehandler ( 'story', 'news' );
		$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
		if (! $type) {
			$type = 'type1';
		}
		$contents = array ();
		
		switch ($type) {
			
			// list all contents from all topics whit out topic list
			case 'type1' :
				$contents ['content'] = $story_handler->News_GetContentList ( $NewsModule, $story_infos );
				$contents ['numrows'] = $story_handler->News_GetContentCount ( $NewsModule, $story_infos );
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
			     $topic_order = xoops_getModuleOption('admin_showorder_topic', $NewsModule->getVar('dirname'));
              $topic_sort = xoops_getModuleOption('admin_showsort_topic', $NewsModule->getVar('dirname'));
              $topic_parent = $story_infos ['story_topic'];
		        $contents ['content'] = $topic_handler->News_GetTopics($NewsModule, null, 0, $topic_order, $topic_sort, null, 1 , $topic_parent);
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
            
				$contents ['content'] = $story_handler->News_GetContentList ( $NewsModule, $story_infos );
				$contents ['numrows'] = $story_handler->News_GetContentCount ( $NewsModule, $story_infos );
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
				   	$title = xoops_getModuleOption ( 'static_name', $NewsModule->getVar ( 'dirname' ));
				   	$alias = self::News_AliasFilter(xoops_getModuleOption('static_name', $NewsModule->getVar ( 'dirname' )));
				   }		
					$default_info = array('id'=> $id , 'title' => $title , 'alias' => $alias);
					$contents ['content'] = $story_handler->News_ContentDefault($NewsModule, $default_info);
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
	function News_FieldExists($fieldname,$table)
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
	function News_AddField($field, $table)
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
	function News_TableExists($tablename)
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
	function News_AddTable($query) {
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
	function News_ResizePicture($src_path , $dst_path, $param_width , $param_height, $keep_original = true, $fit = 'inside')
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
   
   /**
    *  Rebuild
	 */
	function News_Rebuild ($handler , $item_id , $op , $set , $get , $start_id, $end_id) {
		// check last_id
		$criteria = new CriteriaCompo ();
		$criteria->setSort ( $item_id );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$last = $handler->getObjects ( $criteria );
	   foreach ( $last as $item ) {
			$last_id = $item->getVar ( $item_id );
		}

		// set end_id
		$end_id = $end_id + 100;
		
		// do rebuild
		while ($start_id <= $end_id) {
	      $obj = $handler->get ( $start_id );
	      if($obj) {
	      	$new = self::News_DoRebuild ($op , $obj->getVar ( $get, 'e' ));
		      $obj->setVar ( $set , $new); 
	        	$handler->insert ( $obj );
	      }
		   $start_id = $start_id + 1;
	   }
	   
	   
	   // Redirect
	   if($start_id <= $last_id) {
	      self::News_Redirect('tools.php?op='.$op.'&start_id='.$start_id.'&end_id='.$end_id, 20, _NEWS_AM_MSG_INPROC);
	      xoops_cp_footer ();
         exit ();
      }

	}	
	
	/**
    *  Make text for Rebuild
	 */
	function News_DoRebuild ($op , $get) {
		switch($op) {
			case 'alias':
				$item = self::News_AliasFilter($get);
				break;
				
			case 'topicalias':
				$item = self::News_AliasFilter($get);
				break;
				
			case 'keyword':
				$item = self::News_MetaFilter($get);
				break;
				
			case 'description':
				$item = self::News_AjaxFilter($get);
				break;			
		}	
		return $item;
	}
	
	/**
	 * Get variables passed by GET or POST method
	 *
	 */
	function News_CleanVars(&$global, $key, $default = '', $type = 'int') {
	
	    switch ($type) {
	        case 'array':
	            $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
	            break;
	        case 'date':
	            $ret = (isset($global[$key])) ? strtotime($global[$key]) : $default;
	            break;
	        case 'string':
	            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
	            break;
	        case 'int': default:
	            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
	            break;
	    }
	    if ($ret === false) {
	        return $default;
	    }
	    return $ret;
	}
	
	/**
	 * Check html editors
	 *
	 */
	function News_isEditorHTML($module) {
	   $editor = xoops_getModuleOption('form_editor', $module);
      if (isset($editor) && in_array($editor, array('tinymce', 'fckeditor', 'koivi', 'inbetween', 'spaw', 'ckeditor'))) {
        return true;
      }
      return false;
	}
	
	/**
	 * Replace all escape, character, ... for display a correct url
	 *
	 * @String  $url    string to transform
	 * @String  $type   string replacement for any blank case
	 * @return  $url
	 */
	function News_AliasFilter($url, $type = '', $module = 'news') {
	
	    // Get regular expression from module setting. default setting is : `[^a-z0-9]`i
	    $regular_expression = xoops_getModuleOption('regular_expression', $module);
	    
	    $url = strip_tags($url);
	    $url = preg_replace("`\[.*\]`U", "", $url);
	    $url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $url);
	    $url = htmlentities($url, ENT_COMPAT, 'utf-8');
	    $url = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $url);
	    $url = preg_replace(array($regular_expression, "`[-]+`"), "-", $url);
	    $url = ($url == "") ? $type : strtolower(trim($url, '-'));
	    return $url;
	}
	
	/**
	 * Replace all escape, character, ... for display a correct Meta
	 *
	 * @String  $meta    string to transform
	 * @String  $type   string replacement for any blank case
	 * @return  $meta
	 */
	function News_MetaFilter($meta, $type = '', $module = 'news') {
	
	    // Get regular expression from module setting. default setting is : `[^a-z0-9]`i
	    $regular_expression = xoops_getModuleOption('regular_expression', $module);
	    
	    $meta = strip_tags($meta);
	    $meta = preg_replace("`\[.*\]`U", "", $meta);
	    $meta = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', ',', $meta);
	    $meta = htmlentities($meta, ENT_COMPAT, 'utf-8');
	    $meta = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $meta);
	    $meta = preg_replace(array($regular_expression, "`[,]+`"), ",", $meta);
	    $meta = ($meta == "") ? $type : strtolower(trim($meta, ','));
	    return $meta;
	}
	
	/**
	 * Replace all escape, character, ... for display a correct text
	 *
	 * @String  $text    string to transform
	 * @String  $type   string replacement for any blank case
	 * @return  $text
	 */
	function News_AjaxFilter($text, $type = '') {
		 $text = strip_tags($text);
	    $text = preg_replace("`\[.*\]`U", "", $text);
	    $text = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $text);
	    $text = htmlentities($text, ENT_COMPAT, 'utf-8');
	    $text = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $text);
	    $text = stripslashes($text);
	    return $text;
	}
	
	/**
	 * Build Redirect page
	 */
	function News_Redirect($url, $time = 3, $message = '') {
	    global $xoopsModule;
	    if (preg_match("/[\\0-\\31]|about:|script:/i", $url)) {
	        if (!preg_match('/^\b(java)?script:([\s]*)history\.go\(-[0-9]*\)([\s]*[;]*[\s]*)$/si', $url)) {
	            $url = XOOPS_URL;
	        }
	    }
	    // Create Template instance
	    $tpl = new XoopsTpl();
	    // Assign Vars
	    $tpl->assign('url', $url);
	    $tpl->assign('time', $time);
	    $tpl->assign('message', $message);
	    $tpl->assign('ifnotreload', sprintf(_IFNOTRELOAD, $url));
	    // Call template file
	    echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/news_redirect.html');
	    // Force redirection
	    header("refresh: " . $time . "; url=" . $url);
	}
	
	/**
	 * Build Message
	 */
	function News_Message($page, $message = '', $id , $handler) {
	    global $xoopsModule;
	    $tpl = new XoopsTpl();
	    //ob_start();
	    $tpl->assign('message', $message);
	    $tpl->assign('id', $id);
	    $tpl->assign('url', $page);
	    $tpl->assign('handler', $handler);
	    $tpl->assign('ifnotreload', sprintf(_IFNOTRELOAD, $page));
	    echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/news_confirm.html');
	    //ob_flush();
	}

   /**
	 * Build topic URL
	 */
	function News_TopicUrl($module, $array) {
	    $lenght_id = xoops_getModuleOption('lenght_id', $module);
	    $friendly_url = xoops_getModuleOption('friendly_url', $module);
	    if ($lenght_id != 0) {
	        $id = $array['topic_id'];
	        while (strlen($id) < $lenght_id)
	            $id = "0" . $id;
	    } else {
	        $id = $array['topic_id'];
	    }
	
	    switch ($friendly_url) {
	
	        case 'none':
	            $rewrite_base = '/modules/';
	            $page = 'page=' . $array['topic_alias'];
	            return XOOPS_URL . $rewrite_base . $module . '/index.php?storytopic=' . $id . '&amp;' . $page;
	            break;
	
	        case 'rewrite':
	            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
	            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
	            $module_name = '';
	            if(xoops_getModuleOption('rewrite_name', $module)) {
		            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
	            }	
	            $page = $array['topic_alias'];
	            $type = xoops_getModuleOption('topic_name', $module) . '/';
	            $id = $id . '/';
	            return XOOPS_URL . $rewrite_base . $module_name . $type . $id . $page . $rewrite_ext;
	            break;
	            
	         case 'short':  
	            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
	            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
	            $module_name = '';
	            if(xoops_getModuleOption('rewrite_name', $module)) {
		            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
	            }	
	            $page = $array['topic_alias'];
	            $type = xoops_getModuleOption('topic_name', $module) . '/';
	            return XOOPS_URL . $rewrite_base . $module_name . $type . $page . $rewrite_ext;
	            break; 
	         
	         case 'id': 
	            return XOOPS_URL . '/modules/' . $module . '/index.php?storytopic=' . $id;
	            break;  
	    }
	    
	}

   /**
	 * Build Item URL
	 */
	function News_Url($module, $array , $type = 'article') {
	    $comment = '';
	    $lenght_id = xoops_getModuleOption('lenght_id', $module);
	    $friendly_url = xoops_getModuleOption('friendly_url', $module);
	
	    if ($lenght_id != 0) {
	        $id = $array['story_id'];
	        while (strlen($id) < $lenght_id)
	            $id = "0" . $id;
	    } else {
	        $id = $array['story_id'];
	    }
	
	    if (isset($array['topic_alias']) && $array['topic_alias']) {
	        $topic_name = $array['topic_alias'];
	    } else {
	        $topic_name = self::News_AliasFilter(xoops_getModuleOption('static_name', $module));
	    }
	
	    switch ($friendly_url) {
	
	        case 'none':
	            if($topic_name) {
		             $topic_name = 'topic=' . $topic_name . '&amp;';
	            }
	            $rewrite_base = '/modules/';
	            $page = 'page=' . $array['story_alias'];
	            return XOOPS_URL . $rewrite_base . $module . '/' . $type . '.php?' . $topic_name . 'storyid=' . $id . '&amp;' . $page . $comment;
	            break;
	
	        case 'rewrite':
	            if($topic_name) {
	                $topic_name = $topic_name . '/';
	            }   
	            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
	            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
	            $module_name = '';
	            if(xoops_getModuleOption('rewrite_name', $module)) {
		            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
	            }	
	            $page = $array['story_alias'];
	            $type = $type . '/';
	            $id = $id . '/';
	            if ($type == 'content/') $type = '';
	
	            if ($type == 'comment-edit/' || $type == 'comment-reply/' || $type == 'comment-delete/') {
	                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
	            }
	            
	            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name  . $id . $page . $rewrite_ext;
	            break;
	            
	         case 'short':  
	            if($topic_name) {
	                $topic_name = $topic_name . '/';
	            }   
	            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
	            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
	            $module_name = '';
	            if(xoops_getModuleOption('rewrite_name', $module)) {
		            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
	            }	
	            $page = $array['story_alias'];
	            $type = $type . '/';
	            if ($type == 'content/') $type = '';
	
	            if ($type == 'comment-edit/' || $type == 'comment-reply/' || $type == 'comment-delete/') {
	                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
	            }
	            
	            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name . $page . $rewrite_ext;
	            break;
	          
	         case 'id': 
	            return XOOPS_URL . '/modules/' . $module . '/' . $type . '.php?storyid=' . $id;
	            break;     
	    }
	}
}
?>