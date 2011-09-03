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
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

class fmcontent_content extends XoopsObject {
	
	public $mod;
	public $db;
	public $table;
	
	/**
	 * Class constructor
	 */
	function fmcontent_content() {
		$this->initVar ( 'content_id', XOBJ_DTYPE_INT );
		$this->initVar ( 'content_title', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_titleview', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'content_menu', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_topic', XOBJ_DTYPE_INT );
		$this->initVar ( 'content_type', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_short', XOBJ_DTYPE_TXTAREA, '' );
		$this->initVar ( 'content_text', XOBJ_DTYPE_TXTAREA, '' );
		$this->initVar ( 'content_link', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_words', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_desc', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_alias', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_status', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'content_display', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_default', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_create', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'content_update', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'content_uid', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_author', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_source', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_groups', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_order', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_next', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_prev', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'content_modid', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'content_hits', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'content_img', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'content_comments', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'content_file', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'dohtml', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'doxcode', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'dosmiley', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'doimage', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'dobr', XOBJ_DTYPE_INT, 0 );
		
		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'fmcontent_content' );
	}
	
	function getContentForm($forMods, $content_type = 'content') {
		$form = new XoopsThemeForm ( _FMCONTENT_FORM, 'content', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add' ) );
			$form->addElement ( new XoopsFormHidden ( 'content_uid', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'content_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit' ) );
			$content_type = $this->getVar ( 'content_type', 'e' );
		}
		// Content Id
		$form->addElement ( new XoopsFormHidden ( 'content_id', $this->getVar ( 'content_id', 'e' ) ) );
		// Module Id
		$form->addElement ( new XoopsFormHidden ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		// Content type
		$form->addElement ( new XoopsFormHidden ( 'content_type', $content_type ) );
		// Content title
		$title = new XoopsFormElementTray ( _FMCONTENT_FORMTITLE );
		$title->addElement ( new XoopsFormText ( '', 'content_title', 50, 255, $this->getVar ( 'content_title', 'e' ) ), true );
		$display_title = new XoopsFormCheckBox ( '', 'content_titleview', $this->getVar ( 'content_titleview', 'e' ) );
		$display_title->addOption ( 1, _FMCONTENT_FORMTITLE_DISP );
		$title->addElement ( $display_title );
		$form->addElement ( $title );
		// Content menu
		$form->addElement ( new XoopsFormText ( _FMCONTENT_CONTENT_MENU, 'content_menu', 50, 255, $this->getVar ( 'content_menu', 'e' ) ), true );
		// Content menu text
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FORMALIAS, 'content_alias', 50, 255, $this->getVar ( 'content_alias', 'e' ) ), true );
		// Topic
		$topic_Handler = xoops_getModuleHandler ( "topic", "fmcontent" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topic = $topic_Handler->getObjects ( $criteria );
		if ($topic) {
			$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
			ob_start ();
			echo $tree->makeSelBox ( 'content_topic', 'topic_title', '--', $this->getVar ( 'content_topic', 'e' ), true );
			$topic_sel = new XoopsFormLabel ( _FMCONTENT_CONTENT_TOPIC, ob_get_contents () );
			$topic_sel->setDescription ( _FMCONTENT_CONTENT_TOPIC_DESC );
			$form->addElement ( $topic_sel );
			ob_end_clean ();
		}
		// Short
		$form->addElement ( new XoopsFormTextArea ( _FMCONTENT_SHORT, 'content_short', $this->getVar ( 'content_short', 'e' ), 5, 90 ) );
		// Editor
		$editor_tray = new XoopsFormElementTray ( _FMCONTENT_FORMTEXT, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$configs = array ('name' => 'content_desc', 'value' => $this->getVar ( 'content_text', 'e' ), 'rows' => 25, 'cols' => 90, 'width' => '100%', 'height' => '400px', 'editor' => xoops_getModuleOption ( 'form_editor', $forMods->getVar ( 'dirname', 'e' ) ) );
			$editor_tray->addElement ( new XoopsFormEditor ( '', 'content_text', $configs, false, $onfailure = 'textarea' ) );
		} else {
			$editor_tray->addElement ( new XoopsFormDhtmlTextArea ( '', 'content_text', $this->getVar ( 'content_text', 'e' ), '100%', '100%' ) );
		}
		$editor_tray->setDescription ( _FMCONTENT_FORMTEXT_DESC );
		if (! fmcontent_isEditorHTML ( $forMods->getVar ( 'dirname', 'e' ) )) {
			if ($this->isNew ()) {
				$this->setVar ( 'dohtml', 0 );
				$this->setVar ( 'dobr', 1 );
			}
			// HTML
			$html_checkbox = new XoopsFormCheckBox ( '', 'dohtml', $this->getVar ( 'dohtml', 'e' ) );
			$html_checkbox->addOption ( 1, _FMCONTENT_DOHTML );
			$editor_tray->addElement ( $html_checkbox );
			// Break line
			$breaks_checkbox = new XoopsFormCheckBox ( '', 'dobr', $this->getVar ( 'dobr', 'e' ) );
			$breaks_checkbox->addOption ( 1, _FMCONTENT_BREAKS );
			$editor_tray->addElement ( $breaks_checkbox );
		} else {
			$form->addElement ( new xoopsFormHidden ( 'dohtml', 1 ) );
			$form->addElement ( new xoopsFormHidden ( 'dobr', 0 ) );
		}
		// Xoops Image
		$doimage_checkbox = new XoopsFormCheckBox ( '', 'doimage', $this->getVar ( 'doimage', 'e' ) );
		$doimage_checkbox->addOption ( 1, _FMCONTENT_DOIMAGE );
		$editor_tray->addElement ( $doimage_checkbox );
		// Xoops Code
		$xcodes_checkbox = new XoopsFormCheckBox ( '', 'doxcode', $this->getVar ( 'doxcode', 'e' ) );
		$xcodes_checkbox->addOption ( 1, _FMCONTENT_DOXCODE );
		$editor_tray->addElement ( $xcodes_checkbox );
		// Xoops Smiley
		$smiley_checkbox = new XoopsFormCheckBox ( '', 'dosmiley', $this->getVar ( 'dosmiley', 'e' ) );
		$smiley_checkbox->addOption ( 1, _FMCONTENT_DOSMILEY );
		$editor_tray->addElement ( $smiley_checkbox );
		// Editor and options
		$form->addElement ( $editor_tray );
		//tag
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$items_id = $this->isNew () ? 0 : $this->getVar ( "content_id" );
			include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php";
			$form->addElement ( new XoopsFormTag ( "item_tag", 60, 255, $items_id, $catid = 0 ) );
		}
		// Image
		$content_img = $this->getVar ( 'content_img' ) ? $this->getVar ( 'content_img' ) : 'blank.gif';
		$uploadirectory_content_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_content_img = new XoopsFormElementTray ( _FMCONTENT_IMG, '<br />' );
		$fileseltray_content_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_content_img . $content_img . "' name='image_content_img' id='image_content_img' alt='' />" ) );
		if ($this->getVar ( 'content_img' )) {
			$delete_img = new XoopsFormCheckBox ( '', 'deleteimage', 0 );
			$delete_img->addOption ( 1, _DELETE );
			$fileseltray_content_img->addElement ( $delete_img );
		}
		$fileseltray_content_img->addElement ( new XoopsFormFile ( _FMCONTENT_FORMUPLOAD, 'content_img', xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_content_img );
		// Metas
		$form->addElement ( new XoopsFormTextArea ( 'Metas Keyword', 'content_words', $this->getVar ( 'content_words', 'e' ), 5, 90 ) );
		$form->addElement ( new XoopsFormTextArea ( 'Metas Description', 'content_desc', $this->getVar ( 'content_desc', 'e' ), 5, 90 ) );
		// Content author
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FORMAUTHOR, 'content_author', 50, 255, $this->getVar ( 'content_author', 'e' ) ), false );
		// Content Source
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FORMSOURCE, 'content_source', 50, 255, $this->getVar ( 'content_source', 'e' ) ), false );
		// Groups access
		$form->addElement ( new XoopsFormSelectGroup ( _FMCONTENT_FORMGROUP, 'content_groups', true, $groups, 5, true ) );
		// Next & prev
		if (!$this->isNew ()) {
			$content_Handler = xoops_getModuleHandler ( "page", "fmcontent" );
			$criteria = new CriteriaCompo ();
			$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
			$criteria->add ( new Criteria ( 'content_status', '1' ) );
			$criteria->add ( new Criteria ( 'content_topic', $this->getVar ( 'content_topic', 'e' ) ) );
			$content = $content_Handler->getObjects ( $criteria );
			$tree = new XoopsObjectTree ( $content, 'content_id', 'content_topic' );
			ob_start ();
			echo $tree->makeSelBox ( 'content_prev', 'content_title', '', $this->getVar ( 'content_prev', 'e' ), true );
			$form->addElement ( new XoopsFormLabel ( _FMCONTENT_FORMPREV, ob_get_contents () ) );
			ob_end_clean ();
			ob_start ();
			echo $tree->makeSelBox ( 'content_next', 'content_title', '', $this->getVar ( 'content_next', 'e' ), true );
			$form->addElement ( new XoopsFormLabel ( _FMCONTENT_FORMNEXT, ob_get_contents () ) );
			ob_end_clean ();
		}
		// Active
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_FORMACTIF, 'content_status', $this->getVar ( 'content_status', 'e' ) ) );
		// Menu
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_FORMDISPLAY, 'content_display', $this->getVar ( 'content_display', 'e' ) ) );
		// Default
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_FORMDEFAULT, 'content_default', $this->getVar ( 'content_default', 'e' ) ) );
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
	
	function getContentSimpleForm($forMods, $content_type = 'content') {
		$form = new XoopsThemeForm ( _FMCONTENT_FORM, 'content', 'submit.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add' ) );
			$form->addElement ( new XoopsFormHidden ( 'content_uid', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'content_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit' ) );
			$content_type = $this->getVar ( 'content_type', 'e' );
		}
		// Content Id
		$form->addElement ( new XoopsFormHidden ( 'content_id', $this->getVar ( 'content_id', 'e' ) ) );
		// Module Id
		$form->addElement ( new XoopsFormHidden ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		// Content type
		$form->addElement ( new XoopsFormHidden ( 'content_type', $content_type ) );
		// Content title
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FORMTITLE, 'content_title', 50, 255, $this->getVar ( 'content_title', 'e' ) ), true );
		// Topic
		$topic_Handler = xoops_getModuleHandler ( "topic", "fmcontent" );
		$perm_handler = fmcontentPermission::getHandler ();
		$topics = fmcontentPermission::getItemIds ( 'fmcontent_submit', $forMods );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		global $xoopsUser;
		if ($xoopsUser) {
			if (! $xoopsUser->isAdmin ( $forMods->getVar ( 'mid' ) )) {
				$criteria->add ( new Criteria ( 'topic_id', '(' . implode ( ',', $topics ) . ')', 'IN' ) );
			}
		} else {
			$criteria->add ( new Criteria ( 'topic_id', '(' . implode ( ',', $topics ) . ')', 'IN' ) );
		}
		$topic = $topic_Handler->getObjects ( $criteria );
		if ($topic) {
			$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
			ob_start ();
			echo $tree->makeSelBox ( 'content_topic', 'topic_title', '--', $this->getVar ( 'content_topic', 'e' ), true );
			$topic_sel = new XoopsFormLabel ( _FMCONTENT_CONTENT_TOPIC, ob_get_contents () );
			$topic_sel->setDescription ( _FMCONTENT_CONTENT_TOPIC_DESC );
			$form->addElement ( $topic_sel );
			ob_end_clean ();
		}
		// Short
		$form->addElement ( new XoopsFormTextArea ( _FMCONTENT_SHORT, 'content_short', $this->getVar ( 'content_short', 'e' ), 5, 80 ) );
		// Editor
		$editor_tray = new XoopsFormElementTray ( _FMCONTENT_FORMTEXT, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$configs = array ('name' => 'content_desc', 'value' => $this->getVar ( 'content_text', 'e' ), 'rows' => 15, 'cols' => 80, 'width' => '95%', 'height' => '250px', 'editor' => xoops_getModuleOption ( 'form_editor', $forMods->getVar ( 'dirname', 'e' ) ) );
			$editor_tray->addElement ( new XoopsFormEditor ( '', 'content_text', $configs, false, $onfailure = 'textarea' ) );
		} else {
			$editor_tray->addElement ( new XoopsFormDhtmlTextArea ( '', 'content_text', $this->getVar ( 'content_text', 'e' ), '100%', '100%' ) );
		}
		$editor_tray->setDescription ( _FMCONTENT_FORMTEXT_DESC );
		// Editor and options
		$form->addElement ( $editor_tray );
		if (! fmcontent_isEditorHTML ( $forMods->getVar ( 'dirname', 'e' ) )) {
			$form->addElement ( new xoopsFormHidden ( 'dohtml', 0 ) );
			$form->addElement ( new xoopsFormHidden ( 'dobr', 1 ) );
		} else {
			$form->addElement ( new xoopsFormHidden ( 'dohtml', 1 ) );
			$form->addElement ( new xoopsFormHidden ( 'dobr', 0 ) );
		}
		$form->addElement ( new xoopsFormHidden ( 'doimage', 1 ) );
		$form->addElement ( new xoopsFormHidden ( 'doxcode', 1 ) );
		$form->addElement ( new xoopsFormHidden ( 'dosmiley', 1 ) );
		//tag
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$items_id = $this->isNew () ? 0 : $this->getVar ( "content_id" );
			include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php";
			$form->addElement ( new XoopsFormTag ( "item_tag", 60, 255, $items_id, $catid = 0 ) );
		}
		// Image
		$content_img = $this->getVar ( 'content_img' ) ? $this->getVar ( 'content_img' ) : 'blank.gif';
		$uploadirectory_content_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_content_img = new XoopsFormElementTray ( _FMCONTENT_IMG, '<br />' );
		$fileseltray_content_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_content_img . $content_img . "' name='image_content_img' id='image_content_img' alt='' />" ) );
		$fileseltray_content_img->addElement ( new XoopsFormFile ( _FMCONTENT_FORMUPLOAD, 'content_img', xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_content_img );
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
	
	function getMenuForm($forMods, $content_type = 'link') {
		$form = new XoopsThemeForm ( _FMCONTENT_FORM, 'link', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add' ) );
			$form->addElement ( new XoopsFormHidden ( 'content_uid', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'content_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit' ) );
			$content_type = $this->getVar ( 'content_type', 'e' );
		}
		// Content Id
		$form->addElement ( new XoopsFormHidden ( 'content_id', $this->getVar ( 'content_id', 'e' ) ) );
		// Module Id
		$form->addElement ( new XoopsFormHidden ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		// Display menu
		$form->addElement ( new XoopsFormHidden ( 'content_display', '1' ) );
		// Content type
		$form->addElement ( new XoopsFormHidden ( 'content_type', $content_type ) );
		// Content menumenu
		$form->addElement ( new XoopsFormText ( _FMCONTENT_CONTENT_MENU, 'content_menu', 50, 255, $this->getVar ( 'content_menu', 'e' ) ), true );
		// Link
		$form->addElement ( new XoopsFormText ( _FMCONTENT_FORMLINK, 'content_link', 50, 255, $this->getVar ( 'content_link', 'e' ) ), true );
		// Topic
		$topic_Handler = xoops_getModuleHandler ( "topic", "fmcontent" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topic = $topic_Handler->getObjects ( $criteria );
		$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
		ob_start ();
		echo $tree->makeSelBox ( 'content_topic', 'topic_title', '--', $this->getVar ( 'content_topic', 'e' ), true );
		$form->addElement ( new XoopsFormLabel ( _FMCONTENT_CONTENT_TOPIC, ob_get_contents () ) );
		ob_end_clean ();
		// Groups access
		$form->addElement ( new XoopsFormSelectGroup ( _FMCONTENT_FORMGROUP, 'content_groups', true, $groups, 5, true ) );
		// Options
		$options = new XoopsFormElementTray ( _FMCONTENT_FORMOPTION );
		// Active
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_FORMACTIF, 'content_status', $this->getVar ( 'content_status', 'e' ) ) );
		
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

/**
 * Content handler class
 *
 **/
class fmcontentPageHandler extends XoopsPersistableObjectHandler {
	
	function fmcontentPageHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'fmcontent_content', 'fmcontent_content', 'content_id', 'content_alias' );
	}
	
	/**
	 * Check if content alias already exist
	 *
	 * @param   String  $alias
	 * @return  boolean
	 **/
	function existAlias($forMods , $infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_alias', $infos['content_alias'] ) );
		if($infos['content_id']) {
			$criteria->add ( new Criteria ( 'content_id', $infos['content_id'] , '!='));
		}
		if ($this->getCount ( $criteria ) == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	function getId($alias) {
		$criteria = new CriteriaCompo ();
		$criteria = new Criteria ( 'content_alias', $alias );
		$criteria->setLimit ( 1 );
		$obj_array = $this->getObjects ( $criteria, false, false );
		if (count ( $obj_array ) != 1) {
			return 0;
		}
		return $obj_array [0] [$this->keyName];
	}
	
	function getDefault($criteria = null) {
		$obj_array = $this->getObjects ( $criteria, false, false );
		if (count ( $obj_array ) != 1) {
			return 0;
		}
		return $obj_array [0] [$this->keyName];
	}
	
	function contentDefault($forMods, $default_info) {
		$contentdefault = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_default', 1 ) );
		$criteria->add ( new Criteria ( 'content_topic', $default_info ['id'] ) );
		$default = self::getDefault ( $criteria );
		$obj = self::get ( $default );
		$contentdefault = $obj->toArray ();
		$contentdefault ['content_create'] = formatTimestamp ( $contentdefault ['content_create'], _MEDIUMDATESTRING );
		$contentdefault ['imgurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . $contentdefault ['content_img'];
		$contentdefault ['topic'] = $default_info ['title'];
		$contentdefault ['topic_alias'] = $default_info ['alias'];
		$contentdefault ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $contentdefault );
		if (isset ( $contentdefault ['content_id'] )) {
			return $contentdefault;
		}
	}
	
	function getContentList($forMods, $content_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_status', $content_infos ['content_status'] ) );
		if ($content_infos ['content_static']) {
			$criteria->add ( new Criteria ( 'content_topic', '0', '>' ) );
		}
		if (! $content_infos ['admin_side']) {
			$access_topic = fmcontentPermission::getItemIds ( 'fmcontent_access', $forMods);
			$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );
			$topic_show = $topic_handler->allVisible($forMods,$content_infos ['topics']);
			$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $access_topic ) . ')', 'IN' ) );
			$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $topic_show ) . ')', 'IN' ) );
			$criteria->add ( new Criteria ( 'content_type', 'content' ) );
		}
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $content_infos ['content_topic'] ) );
      if(isset($content_infos ['content_subtopic'])) {
      	foreach ($content_infos ['content_subtopic'] as $subtopic){
				$criteria->add ( new Criteria ( 'content_topic', $subtopic ) ,'OR');
			}
		}
		$criteria->add ( new Criteria ( 'content_uid', $content_infos ['content_user'] ) );
		$criteria->setSort ( $content_infos ['content_sort'] );
		$criteria->setOrder ( $content_infos ['content_order'] );
		$criteria->setLimit ( $content_infos ['content_limit'] );
		$criteria->setStart ( $content_infos ['content_start'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'content_uid' ) );
               if(is_array($content_infos ['topics'])) {
						foreach ( array_keys ( $content_infos ['topics'] ) as $i ) {
							$list [$i] ['topic_title'] = $content_infos ['topics'] [$i]->getVar ( "topic_title" );
							$list [$i] ['topic_id'] = $content_infos ['topics'] [$i]->getVar ( "topic_id" );
							$list [$i] ['topic_alias'] = $content_infos ['topics'] [$i]->getVar ( "topic_alias" );
						}
					}
					if ($root->getVar ( 'content_topic' )) {
						$tab ['topic'] = $list [$root->getVar ( 'content_topic' )] ['topic_title'];
						$tab ['topic_alias'] = $list [$root->getVar ( 'content_topic' )] ['topic_alias'];
						$tab ['topicurl'] = fmcontent_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'content_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'content_topic' )] ['topic_alias'] ));
					}

				$tab ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['content_create'] = formatTimestamp ( $root->getVar ( 'content_create' ), _MEDIUMDATESTRING );
				$tab ['content_update'] = formatTimestamp ( $root->getVar ( 'content_update' ), _MEDIUMDATESTRING );
				$tab ['imgurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . $root->getVar ( 'content_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function getMenuList($forMods, $content_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_display', '1' ) );
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		if ($content_infos ['menu_id'] != '-1') {
			$criteria->add ( new Criteria ( 'content_topic', $content_infos ['menu_id'] ) );
		}
		$criteria->setSort ( $content_infos ['menu_sort'] );
		$criteria->setOrder ( $content_infos ['menu_order'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				
					foreach ( array_keys ( $content_infos ['topics'] ) as $i ) {
						$list [$i] ['topic_title'] = $content_infos ['topics'] [$i]->getVar ( "topic_title" );
						$list [$i] ['topic_id'] = $content_infos ['topics'] [$i]->getVar ( "topic_id" );
						$list [$i] ['topic_alias'] = $content_infos ['topics'] [$i]->getVar ( "topic_alias" );
					}
					if ($root->getVar ( 'content_topic' )) {
						$tab ['topic'] = $list [$root->getVar ( 'content_topic' )] ['topic_title'];
						$tab ['topic_alias'] = $list [$root->getVar ( 'content_topic' )] ['topic_alias'];
						$tab ['topicurl'] = fmcontent_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'content_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'content_topic' )] ['topic_alias'] ));
					}
				
				$tab ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function getContentBlockList($forMods, $content_infos ,$options) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_type', 'content' ) );
		$criteria->add ( new Criteria ( 'content_status', '1' ) );
		$access_topic = fmcontentPermission::getItemIds ( 'fmcontent_access', $forMods);
		$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $access_topic ) . ')', 'IN' ) );
		if (! (count ( $options ) == 1 && $options [0] == 0)) {
			$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $options ) . ')', 'IN' ) );
		}
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->setSort ( $content_infos ['content_sort'] );
		$criteria->setOrder ( $content_infos ['content_order'] );
		$criteria->setLimit ( $content_infos ['content_limit'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'content_uid' ) );
				
					foreach ( array_keys ( $content_infos ['topics'] ) as $i ) {
						$list [$i] ['topic_title'] = $content_infos ['topics'] [$i]->getVar ( "topic_title" );
						$list [$i] ['topic_id'] = $content_infos ['topics'] [$i]->getVar ( "topic_id" );
						$list [$i] ['topic_alias'] = $content_infos ['topics'] [$i]->getVar ( "topic_alias" );
					}
					if ($root->getVar ( 'content_topic' )) {
						$tab ['topic'] = $list [$root->getVar ( 'content_topic' )] ['topic_title'];
						$tab ['topic_alias'] = $list [$root->getVar ( 'content_topic' )] ['topic_alias'];
						$tab ['topicurl'] = fmcontent_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'content_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'content_topic' )] ['topic_alias'] ));
					}
				
				$tab ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['title'] = mb_strlen ( $root->getVar ( 'content_title' ), 'utf-8' ) > $content_infos ['lenght_title'] ? mb_substr ( $root->getVar ( 'content_title' ), 0, ($content_infos ['lenght_title']), 'utf-8' ) . "..." : $root->getVar ( 'content_title' );
				$tab ['date'] = formatTimestamp ( $root->getVar ( 'content_create' ), _MEDIUMDATESTRING );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function getContentCount($forMods, $content_infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $content_infos ['content_topic'] ) );
		if (! $content_infos ['admin_side']) {
			$access_topic = fmcontentPermission::getItemIds ( 'fmcontent_access', $forMods);
			$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );
			$topic_show = $topic_handler->allVisible($forMods,$content_infos ['topics']);
			$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $access_topic ) . ')', 'IN' ) );
			$criteria->add ( new Criteria ( 'content_topic', '(' . implode ( ',', $topic_show ) . ')', 'IN' ) );
			$criteria->add ( new Criteria ( 'content_type', 'content' ) );
		}
		if(isset($content_infos ['content_subtopic'])) {
         foreach ($content_infos ['content_subtopic'] as $subtopic){
				$criteria->add ( new Criteria ( 'content_topic', $subtopic ) ,'OR');
			}
		}
		if ($content_infos ['content_static']) {
			$criteria->add ( new Criteria ( 'content_topic', '0', '>' ) );
		}
		return $this->getCount ( $criteria );
	}
	
	function getMenuItemCount($forMods, $topic_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_display', '1' ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
		$getcount = $content_handler->getCount ( $criteria );
		return $getcount;
	}
	
	function getContentItemCount($forMods, $topic_id = '') {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$content_handler = xoops_getmodulehandler ( 'page', 'fmcontent' );
		$getcount = $content_handler->getCount ( $criteria );
		return $getcount;
	}
	
	function getLastContent($forMods, $content_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['topic'] = fmcontentTopicHandler::getTopicFromId ( $root->getVar ( 'content_topic' ) );
            $tab ['topic_alias'] = $tab ['topic'];
				$tab ['url'] = fmcontent_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function setNext($forMods, $topic_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$criteria->setSort ( 'content_id' );
		$criteria->setOrder ( 'ASC' );
		$criteria->setLimit ( 1 );
		$previous = $this->getObjects ( $criteria );
		foreach ( $previous as $item ) {
			return $item->getVar ( 'content_id' );
		}
	}
	
	function setPrevious($forMods, $topic_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$criteria->setSort ( 'content_id' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$previous = $this->getObjects ( $criteria );
		foreach ( $previous as $item ) {
			return $item->getVar ( 'content_id' );
		}
	}
	
	function resetNext($forMods, $topic_id , $next_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$criteria->setSort ( 'content_id' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$criteria->setStart ( 1 );
		$next = $this->getObjects ( $criteria );
		foreach ( $next as $item ) {
			$item->setVar ( 'content_next', $next_id );
			return $this->insert ( $item );
		}
	}
	
	function resetPrevious($forMods, $topic_id , $prev_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_topic', $topic_id ) );
		$criteria->setSort ( 'content_id' );
		$criteria->setOrder ( 'ASC' );
		$criteria->setLimit ( 1 );
		$criteria->setStart ( 0 );
		$prev = $this->getObjects ( $criteria );
		foreach ( $prev as $item ) {
			$item->setVar ( 'content_prev', $prev_id );
			return $this->insert ( $item );
		}
	}
	
	function setorder($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->setSort ( 'content_order' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$last = $this->getObjects ( $criteria );
		$order = 1;
		foreach ( $last as $item ) {
			$order = $item->getVar ( 'content_order' ) + 1;
		}
		return $order;
	}
		
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 * @package     Oledrion
	 * @version     $Id$
	 */
	
	function updateHits($content_id) {
		$sql = 'UPDATE ' . $this->table . ' SET content_hits = content_hits + 1 WHERE content_id= ' . intval ( $content_id );
		return $this->db->queryF ( $sql );
	}
	
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Zoullou (http://www.zoullou.net)
	 * @package     ExtGallery
	 * @version     $Id$
	 */
	function getSearchedContent($queryArray, $condition, $limit, $start, $userId) {
		$ret = array ();
		include_once 'topic.php';
		$criteria = new CriteriaCompo ();
		if ($userId > 0)
			$criteria->add ( new Criteria ( 'content_uid', $userId ) );
		$criteria->add ( new Criteria ( 'content_status', 1 ) );
		if (is_array ( $queryArray ) && count ( $queryArray ) > 0) {
			$subCriteria = new CriteriaCompo ();
			foreach ( $queryArray as $keyWord ) {
				$keyWordCriteria = new CriteriaCompo ();
				$keyWordCriteria->add ( new Criteria ( 'content_title', '%' . $keyWord . '%', 'LIKE' ) );
				$keyWordCriteria->add ( new Criteria ( 'content_text', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'content_short', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'content_words', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'content_desc', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$subCriteria->add ( $keyWordCriteria, $condition );
				unset ( $keyWordCriteria );
			}
			$criteria->add ( $subCriteria );
		}
		$criteria->setStart ( $start );
		$criteria->setLimit ( $limit );
		$criteria->setSort ( 'content_create' );
		
		$contents = $this->getObjects ( $criteria );
		
		$ret = array ();
		foreach ( $contents as $content ) {
			$data = array ();
			$data = $content->toArray ();
			$data ['image'] = 'images/forum.gif';
			$data ['topic'] = fmcontentTopicHandler::getTopicFromId ( $content->getVar ( 'content_topic' ) );
			$data ['topic_alias'] = $data ['topic'];
			$data ['link'] = fmcontent_Url ( 'fmcontent', $data );
			$data ['title'] = $content->getVar ( 'content_title' );
			$data ['time'] = $content->getVar ( 'content_create' );
			$data ['uid'] = $content->getVar ( 'content_uid' );
			$ret [] = $data;
		}
		
		return $ret;
	}
	
	/**
	 * Generate function for update user post
	 *
	 * @ Update user post count after send approve content
	 * @ Update user post count after change status content
	 * @ Update user post count after delete content
	 */
	function updateposts($content_uid, $content_status, $content_action) {
		switch ($content_action) {
			case 'add' :
				if ($content_uid && $content_status) {
					$user = new xoopsUser ( $content_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) + 1 );
				}
				break;
			
			case 'delete' :
				if ($content_uid && $content_status) {
					$user = new xoopsUser ( $content_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) - 1 );
				}
				break;
			
			case 'status' :
				if ($content_uid) {
					$user = new xoopsUser ( $content_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					if ($content_status) {
						$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) - 1 );
					} else {
						$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) + 1 );
					}
				}
				break;
		}
	}
	
	function contentfile($action , $id , $previous = null) {
		switch($action) {
			case 'add':
				$sql = 'UPDATE ' . $this->table . ' SET content_file = content_file + 1 WHERE content_id= ' . intval ( $id );
			   break;
			
			case 'delete':
				$sql = 'UPDATE ' . $this->table . ' SET content_file = content_file - 1 WHERE content_id= ' . intval ( $id );
			   break;
		}
		return $this->db->queryF ( $sql );	
	}	
	
	function getfile($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'content_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'content_file', '0', '>' ) );
		return $this->getAll ( $criteria );
	}	
}

?> 