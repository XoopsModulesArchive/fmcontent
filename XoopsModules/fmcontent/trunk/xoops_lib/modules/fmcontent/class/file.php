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
 * @version     $Id$
 */ 

class fmcontent_file extends XoopsObject {
	
	function fmcontent_file() {
		$this->initVar ( "file_id", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_modid", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_title", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_name", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_content", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_date", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_type", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_status", XOBJ_DTYPE_INT, 1 );

		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'fmcontent_file' );
	}
	
	function getForm($forMods) {
		$form = new XoopsThemeForm ( _FMCONTENT_FORM_FILE, 'file', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$form->addElement ( new XoopsFormHidden ( 'op', 'add_file' ) );
		} else {
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit_file' ) );
			$form->addElement ( new XoopsFormHidden ( 'file_previous', $this->getVar ( "file_content" ) ) );
		}
		$form->addElement ( new XoopsFormHidden ( 'file_id', $this->getVar ( 'file_id', 'e' ) ) );
		$form->addElement ( new XoopsFormHidden ( 'file_modid', $forMods->getVar ( 'mid' ) ) );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FILE_TITLE, "file_title", 50, 255, $this->getVar ( "file_title" ) ), true );
		
		$content_Handler = xoops_getModuleHandler ( "page", "fmcontent" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_status', '1' ) );
		$content = $content_Handler->getObjects ( $criteria );
		
		$select_content = new XoopsFormSelect(_FMCONTENT_FILE_CONTENT, 'file_content', $this->getVar("file_content"));
      foreach (array_keys($content) as $i) {
          $select_content->addOption($content[$i]->getVar("content_id"), $content[$i]->getVar("content_title"));
      }  
      $form->addElement ( $select_content ); 

		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_STATUS, 'file_status', $this->getVar ( 'file_status', 'e' ) ) );
		
		if ($this->isNew ()) {
		$uploadirectory_file = xoops_getModuleOption ( 'file_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_file = new XoopsFormElementTray ( _FMCONTENT_FILE, '<br />' );
		$fileseltray_file->addElement ( new XoopsFormFile ( _FMCONTENT_SELECT_FILE, 'file_name', xoops_getModuleOption ( 'file_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_file );
		}
		// Submit buttons
		$button_tray = new XoopsFormElementTray ( '', '' );
		$submit_btn = new XoopsFormButton ( '', 'post', _SUBMIT, 'submit' );
		$button_tray->addElement ( $submit_btn );
		$cancel_btn = new XoopsFormButton ( '', 'cancel', _CANCEL, 'cancel' );
		$cancel_btn->setExtra ( 'onclick="javascript:history.go(-1);"' );
		$button_tray->addElement ( $cancel_btn );
		$form->addElement ( $button_tray );
		$form->display ();
		
		return $form;
	}		
	
		/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 **/
	function toArray() {
		$ret = array ();
		$vars = $this->getVars ();
		foreach ( array_keys ( $vars ) as $i ) {
			$ret [$i] = $this->getVar ( $i );
		}
		return $ret;
	}
	
}

class fmcontentFileHandler extends XoopsPersistableObjectHandler {
	
	function fmcontentFileHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'fmcontent_file', 'fmcontent_file', 'file_id', 'file_title' );
	}

	function getFiles($forMods, $file , $content = null) {
		$ret = array ();
			$criteria = new CriteriaCompo ();
			$criteria->add ( new Criteria ( 'file_modid', $forMods->getVar ( 'mid' ) ) );
			if(isset($file['content'])) {
				$criteria->add ( new Criteria ( 'file_content', $file['content'] ) );
				$criteria->add ( new Criteria ( 'file_status', 1 ) );
			}	
			$criteria->setSort ( $file['sort'] );
			$criteria->setOrder ( $file['order'] );
			if(isset($file['limit'])) {
			$criteria->setLimit ( $file['limit'] );
			}
			$criteria->setStart ( $file['start'] );
		$files = $this->getObjects ( $criteria, false );
		if ($files) {
			
			foreach ( $files as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				if($content || is_array($content)) {
					foreach ( array_keys ( $content ) as $i ) {
						$list [$i] ['file_title'] = $content [$i]->getVar ( "content_title" );
						$list [$i] ['file_id'] = $content [$i]->getVar ( "content_id" );
					}
					if ($root->getVar ( 'file_content' )) {
						$tab ['content'] = $list [$root->getVar ( 'file_content' )] ['file_title'];
						$tab ['contentid'] = $list [$root->getVar ( 'file_content' )] ['file_id'];
					}
				}
				$tab ['fileurl'] = XOOPS_URL . xoops_getModuleOption ( 'file_dir', $forMods->getVar ( 'dirname' ) ) . $root->getVar ( 'file_name' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function getFileCount ($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'file_modid', $forMods->getVar ( 'mid' ) ) );
		return $this->getCount ( $criteria );
	}	
}
?>