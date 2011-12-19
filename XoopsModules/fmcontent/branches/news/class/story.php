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
 * News story class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

class news_story extends XoopsObject {
	
	public $mod;
	public $db;
	public $table;
	
	/**
	 * Class constructor
	 */
	function news_story() {
		$this->initVar ( 'story_id', XOBJ_DTYPE_INT );
		$this->initVar ( 'story_title', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_subtitle', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_titleview', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'story_topic', XOBJ_DTYPE_INT );
		$this->initVar ( 'story_type', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_short', XOBJ_DTYPE_TXTAREA, '' );
		$this->initVar ( 'story_text', XOBJ_DTYPE_TXTAREA, '' );
		$this->initVar ( 'story_link', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_words', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_desc', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_alias', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_status', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'story_important', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_default', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_create', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_update', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_publish', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_expire', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_uid', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_author', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_source', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_groups', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_order', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_next', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_prev', XOBJ_DTYPE_INT, 0 );
		$this->initVar ( 'story_modid', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_hits', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_img', XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( 'story_comments', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'story_file', XOBJ_DTYPE_INT, '' );
		$this->initVar ( 'dohtml', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'doxcode', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'dosmiley', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'doimage', XOBJ_DTYPE_INT, 1 );
		$this->initVar ( 'dobr', XOBJ_DTYPE_INT, 0 );
		
		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'news_story' );
	}
	
	/**
	 * Submit form in admin side
	 */
	function getContentForm($forMods, $story_type = 'news') {
		$form = new XoopsThemeForm ( _NEWS_AM_CONTENT_FORM, 'news', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add' ) );
			$form->addElement ( new XoopsFormHidden ( 'story_uid', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'story_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit' ) );
			$story_type = $this->getVar ( 'story_type', 'e' );
		}
		// Content Id
		$form->addElement ( new XoopsFormHidden ( 'story_id', $this->getVar ( 'story_id', 'e' ) ) );
		// Module Id
		$form->addElement ( new XoopsFormHidden ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		// Content type
		$form->addElement ( new XoopsFormHidden ( 'story_type', $story_type ) );
		// Content title
		$title = new XoopsFormElementTray ( _NEWS_AM_CONTENT_FORMTITLE );
		$title->addElement ( new XoopsFormText ( '', 'story_title', 50, 255, $this->getVar ( 'story_title', 'e' ) ), true );
		$display_title = new XoopsFormCheckBox ( '', 'story_titleview', $this->getVar ( 'story_titleview', 'e' ) );
		$display_title->addOption ( 1, _NEWS_AM_CONTENT_FORMTITLE_DISP );
		$title->addElement ( $display_title );
		$form->addElement ( $title );
		// Content alias text
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_FORMALIAS, 'story_alias', 50, 255, $this->getVar ( 'story_alias', 'e' ) ), true );
		// subtitle
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_SUBTITLE, 'story_subtitle', 50, 255, $this->getVar ( 'story_subtitle', 'e' ) ), false );
		// Topic
		$topic_Handler = xoops_getModuleHandler ( "topic", "news" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topic = $topic_Handler->getObjects ( $criteria );
		if ($topic) {
			$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
			ob_start ();
			echo $tree->makeSelBox ( 'story_topic', 'topic_title', '--', $this->getVar ( 'story_topic', 'e' ), true );
			$topic_sel = new XoopsFormLabel ( _NEWS_AM_CONTENT_TOPIC, ob_get_contents () );
			$topic_sel->setDescription ( _NEWS_AM_CONTENT_TOPIC_DESC );
			$form->addElement ( $topic_sel );
			ob_end_clean ();
		} else {
			$form->addElement ( new XoopsFormHidden ( 'story_topic', 0 ) );
		}	
		// Short
		$form->addElement ( new XoopsFormTextArea ( _NEWS_AM_CONTENT_SHORT, 'story_short', $this->getVar ( 'story_short', 'e' ), 5, 90 ) );
		// Editor
		$editor_tray = new XoopsFormElementTray ( _NEWS_AM_CONTENT_FORMTEXT, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$configs = array ('name' => 'story_desc', 'value' => $this->getVar ( 'story_text', 'e' ), 'rows' => 25, 'cols' => 90, 'width' => '100%', 'height' => '400px', 'editor' => xoops_getModuleOption ( 'form_editor', $forMods->getVar ( 'dirname', 'e' ) ) );
			$editor_tray->addElement ( new XoopsFormEditor ( '', 'story_text', $configs, false, $onfailure = 'textarea' ) );
		} else {
			$editor_tray->addElement ( new XoopsFormDhtmlTextArea ( '', 'story_text', $this->getVar ( 'story_text', 'e' ), '100%', '100%' ) );
		}
		$editor_tray->setDescription ( _NEWS_AM_CONTENT_FORMTEXT_DESC );
		if (! News_isEditorHTML ( $forMods->getVar ( 'dirname', 'e' ) )) {
			if ($this->isNew ()) {
				$this->setVar ( 'dohtml', 0 );
				$this->setVar ( 'dobr', 1 );
			}
			// HTML
			$html_checkbox = new XoopsFormCheckBox ( '', 'dohtml', $this->getVar ( 'dohtml', 'e' ) );
			$html_checkbox->addOption ( 1, _NEWS_AM_CONTENT_DOHTML );
			$editor_tray->addElement ( $html_checkbox );
			// Break line
			$breaks_checkbox = new XoopsFormCheckBox ( '', 'dobr', $this->getVar ( 'dobr', 'e' ) );
			$breaks_checkbox->addOption ( 1, _NEWS_AM_CONTENT_BREAKS );
			$editor_tray->addElement ( $breaks_checkbox );
		} else {
			$form->addElement ( new xoopsFormHidden ( 'dohtml', 1 ) );
			$form->addElement ( new xoopsFormHidden ( 'dobr', 0 ) );
		}
		// Xoops Image
		$doimage_checkbox = new XoopsFormCheckBox ( '', 'doimage', $this->getVar ( 'doimage', 'e' ) );
		$doimage_checkbox->addOption ( 1, _NEWS_AM_CONTENT_DOIMAGE );
		$editor_tray->addElement ( $doimage_checkbox );
		// Xoops Code
		$xcodes_checkbox = new XoopsFormCheckBox ( '', 'doxcode', $this->getVar ( 'doxcode', 'e' ) );
		$xcodes_checkbox->addOption ( 1, _NEWS_AM_CONTENT_DOXCODE );
		$editor_tray->addElement ( $xcodes_checkbox );
		// Xoops Smiley
		$smiley_checkbox = new XoopsFormCheckBox ( '', 'dosmiley', $this->getVar ( 'dosmiley', 'e' ) );
		$smiley_checkbox->addOption ( 1, _NEWS_AM_CONTENT_DOSMILEY );
		$editor_tray->addElement ( $smiley_checkbox );
		// Editor and options
		$form->addElement ( $editor_tray );
		//tag
		if ((xoops_getModuleOption ( 'usetag', $forMods->getVar ( 'dirname' ) )) and (is_dir ( XOOPS_ROOT_PATH . '/modules/tag' ))) {
			$items_id = $this->isNew () ? 0 : $this->getVar ( "story_id" );
			include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php";
			$form->addElement ( new XoopsFormTag ( "item_tag", 60, 255, $items_id, $catid = 0 ) );
		}
		// Image
		$story_img = $this->getVar ( 'story_img' ) ? $this->getVar ( 'story_img' ) : 'blank.gif';
		$uploadirectory_story_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/original';
		$uploadirectory_thumb_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/thumb/';
		$fileseltray_story_img = new XoopsFormElementTray ( _NEWS_AM_GLOBAL_IMG, '<br />' );
		$fileseltray_story_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_thumb_img . $story_img . "' name='image_story_img' id='image_story_img' alt='' />" ) );
		if ($this->getVar ( 'story_img' )) {
			$delete_img = new XoopsFormCheckBox ( '', 'deleteimage', 0 );
			$delete_img->addOption ( 1, _DELETE );
			$fileseltray_story_img->addElement ( $delete_img );
		}
		$fileseltray_story_img->addElement ( new XoopsFormFile ( _NEWS_AM_GLOBAL_FORMUPLOAD, 'story_img', xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_story_img );
		// Files
		$uploadirectory_file = xoops_getModuleOption ( 'file_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_file = new XoopsFormFile ( _NEWS_AM_FILE_SELECT, 'file_name', xoops_getModuleOption ( 'file_size', $forMods->getVar ( 'dirname' ) ) );
		$file = new XoopsFormElementTray ( _NEWS_AM_FILE );
		$file->addElement ( $fileseltray_file );
		$file->setDescription ( _NEWS_AM_CONTENT_FILE_DESC );
		$form->addElement ($file);
		// Metas
		$form->addElement ( new XoopsFormTextArea ( 'Metas Keyword', 'story_words', $this->getVar ( 'story_words', 'e' ), 5, 90 ) );
		$form->addElement ( new XoopsFormTextArea ( 'Metas Description', 'story_desc', $this->getVar ( 'story_desc', 'e' ), 5, 90 ) );
		// Content author
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_FORMAUTHOR, 'story_author', 50, 255, $this->getVar ( 'story_author', 'e' ) ), false );
		// Content Source
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_FORMSOURCE, 'story_source', 50, 255, $this->getVar ( 'story_source', 'e' ) ), false );
		// Groups access
		$form->addElement ( new XoopsFormSelectGroup ( _NEWS_AM_CONTENT_FORMGROUP, 'story_groups', true, $groups, 5, true ) );
      // publish and expire date
		$date_option = new XoopsFormElementTray(_NEWS_AM_CONTENT_PEDATE,'<br />');
	   $check = $this->getVar ( 'story_create' ) != $this->getVar ( 'story_publish' ) ? 1 :0;
	   $publish_checkbox = new XoopsFormCheckBox('', 'autopublish', $check);
	   $publish_checkbox->addOption(1, _NEWS_AM_CONTENT_SETDATETIME);
	   $date_option->addElement($publish_checkbox);
	   $date_option->addElement(new XoopsFormDateTime(_NEWS_AM_CONTENT_SETDATETIME, 'story_publish', 15,  $this->getVar ( 'story_publish' )));
	   $check = $this->getVar ( 'story_expire' ) > 0 ? 1 :0;
	   $expir_checkbox = new XoopsFormCheckBox('', 'autoexpire', $check);
	   $expir_checkbox ->addOption(1, _NEWS_AM_CONTENT_SETEXPDATETIME);
	   $date_option->addElement($expir_checkbox );
	   $date_option->addElement(new XoopsFormDateTime(_NEWS_AM_CONTENT_SETEXPDATETIME, 'story_expire', 15,  $this->getVar ( 'story_expire' )));
      $form->addElement($date_option);
      // Next & prev
		if (!$this->isNew ()) {
			$story_handler = xoops_getmodulehandler ( 'story', 'news' );
			$criteria = new CriteriaCompo ();
			$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
			$criteria->add ( new Criteria ( 'story_status', '1' ) );
			$criteria->add ( new Criteria ( 'story_topic', $this->getVar ( 'story_topic', 'e' ) ) );
			$content = $story_handler->getObjects ( $criteria );
			$tree = new XoopsObjectTree ( $content, 'story_id', 'story_topic' );
			ob_start ();
			echo $tree->makeSelBox ( 'story_prev', 'story_title', '', $this->getVar ( 'story_prev', 'e' ), true );
			$form->addElement ( new XoopsFormLabel ( _NEWS_AM_CONTENT_FORMPREV, ob_get_contents () ) );
			ob_end_clean ();
			ob_start ();
			echo $tree->makeSelBox ( 'story_next', 'story_title', '', $this->getVar ( 'story_next', 'e' ), true );
			$form->addElement ( new XoopsFormLabel ( _NEWS_AM_CONTENT_FORMNEXT, ob_get_contents () ) );
			ob_end_clean ();
		}
		// Active
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_CONTENT_FORMACTIF, 'story_status', $this->getVar ( 'story_status', 'e' ) ) );
		// Default
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_CONTENT_FORMDEFAULT, 'story_default', $this->getVar ( 'story_default', 'e' ) ) );
		// Important
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_CONTENT_IMPORTANT, 'story_important', $this->getVar ( 'story_important', 'e' ) ) );
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
	 * Submit form in admin side
	 */
	function getContentSimpleForm($forMods, $story_type = 'news') {
		$form = new XoopsThemeForm ( _NEWS_AM_CONTENT_FORM, 'news', 'submit.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add' ) );
			$form->addElement ( new XoopsFormHidden ( 'story_uid', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'story_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit' ) );
			$story_type = $this->getVar ( 'story_type', 'e' );
		}
		// Content Id
		$form->addElement ( new XoopsFormHidden ( 'story_id', $this->getVar ( 'story_id', 'e' ) ) );
		// Module Id
		$form->addElement ( new XoopsFormHidden ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		// Content type
		$form->addElement ( new XoopsFormHidden ( 'story_type', $story_type ) );
		// Content title
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_FORMTITLE, 'story_title', 50, 255, $this->getVar ( 'story_title', 'e' ) ), true );
		// subtitle
		$form->addElement ( new XoopsFormText ( _NEWS_AM_CONTENT_SUBTITLE, 'story_subtitle', 50, 255, $this->getVar ( 'story_subtitle', 'e' ) ), false );
		// Topic
		$topic_Handler = xoops_getModuleHandler ( "topic", "news" );
		$perm_handler = NewsPermission::getHandler ();
		$topics = NewsPermission::getItemIds ( 'news_submit', $forMods );
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
			echo $tree->makeSelBox ( 'story_topic', 'topic_title', '--', $this->getVar ( 'story_topic', 'e' ), true );
			$topic_sel = new XoopsFormLabel ( _NEWS_AM_CONTENT_TOPIC, ob_get_contents () );
			$topic_sel->setDescription ( _NEWS_AM_CONTENT_TOPIC_DESC );
			$form->addElement ( $topic_sel );
			ob_end_clean ();
		} else {
			$form->addElement ( new XoopsFormHidden ( 'story_topic', 0 ) );
		}	
		// Short
		$form->addElement ( new XoopsFormTextArea ( _NEWS_AM_CONTENT_SHORT, 'story_short', $this->getVar ( 'story_short', 'e' ), 5, 80 ) );
		// Editor
		$editor_tray = new XoopsFormElementTray ( _NEWS_AM_CONTENT_FORMTEXT, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$configs = array ('name' => 'story_desc', 'value' => $this->getVar ( 'story_text', 'e' ), 'rows' => 15, 'cols' => 80, 'width' => '95%', 'height' => '250px', 'editor' => xoops_getModuleOption ( 'form_editor', $forMods->getVar ( 'dirname', 'e' ) ) );
			$editor_tray->addElement ( new XoopsFormEditor ( '', 'story_text', $configs, false, $onfailure = 'textarea' ) );
		} else {
			$editor_tray->addElement ( new XoopsFormDhtmlTextArea ( '', 'story_text', $this->getVar ( 'story_text', 'e' ), '100%', '100%' ) );
		}
		$editor_tray->setDescription ( _NEWS_AM_CONTENT_FORMTEXT_DESC );
		// Editor and options
		$form->addElement ( $editor_tray );
		if (! News_isEditorHTML ( $forMods->getVar ( 'dirname', 'e' ) )) {
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
			$items_id = $this->isNew () ? 0 : $this->getVar ( "story_id" );
			include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php";
			$form->addElement ( new XoopsFormTag ( "item_tag", 60, 255, $items_id, $catid = 0 ) );
		}
		// Image
		$story_img = $this->getVar ( 'story_img' ) ? $this->getVar ( 'story_img' ) : 'blank.gif';
		$uploadirectory_story_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/original';
		$fileseltray_story_img = new XoopsFormElementTray ( _NEWS_AM_GLOBAL_IMG, '<br />' );
		$fileseltray_story_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_story_img . $story_img . "' name='image_story_img' id='image_story_img' alt='' />" ) );
		$fileseltray_story_img->addElement ( new XoopsFormFile ( _NEWS_AM_GLOBAL_FORMUPLOAD, 'story_img', xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_story_img );
		// Files
		$uploadirectory_file = xoops_getModuleOption ( 'file_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_file = new XoopsFormFile ( _NEWS_AM_FILE_SELECT, 'file_name', xoops_getModuleOption ( 'file_size', $forMods->getVar ( 'dirname' ) ) );
		$file = new XoopsFormElementTray ( _NEWS_AM_FILE );
		$file->addElement ( $fileseltray_file );
		$file->setDescription ( _NEWS_AM_CONTENT_FILE_DESC );
		$form->addElement ($file);
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

/**
 * Content handler class
 *
 **/
class NewsStoryHandler extends XoopsPersistableObjectHandler {
	
	function NewsStoryHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'news_story', 'news_story', 'story_id', 'story_alias' );
	}
	
	/**
	 * Check if content alias already exist
	 *
	 * @param   String  $alias
	 * @return  boolean
	 **/
	function existAlias($forMods , $infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_alias', $infos['story_alias'] ) );
		if($infos['story_id']) {
			$criteria->add ( new Criteria ( 'story_id', $infos['story_id'] , '!='));
		}
		if ($this->getCount ( $criteria ) == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Get id from alias
	 */
	function getId($alias) {
		$criteria = new CriteriaCompo ();
		$criteria = new Criteria ( 'story_alias', $alias );
		$criteria->setLimit ( 1 );
		$obj_array = $this->getObjects ( $criteria, false, false );
		if (count ( $obj_array ) != 1) {
			return 0;
		}
		return $obj_array [0] [$this->keyName];
	}
	
	/**
	 * Get Default content
	 */
	function getDefault($criteria = null) {
		$obj_array = $this->getObjects ( $criteria, false, false );
		if (count ( $obj_array ) != 1) {
			return 0;
		}
		return $obj_array [0] [$this->keyName];
	}
	
	/**
	 * Get Default content
	 */
	function contentDefault($forMods, $default_info) {
		$contentdefault = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_default', 1 ) );
		$criteria->add ( new Criteria ( 'story_topic', $default_info ['id'] ) );
		$default = self::getDefault ( $criteria );
		$obj = self::get ( $default );
		$contentdefault = $obj->toArray ();
		$contentdefault ['story_create'] = formatTimestamp ( $contentdefault ['story_create'], _MEDIUMDATESTRING );
		$contentdefault ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/medium/' . $contentdefault ['story_img'];
		$contentdefault ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/thumb/' . $contentdefault ['story_img'];
		$contentdefault ['topic'] = $default_info ['title'];
		$contentdefault ['topic_alias'] = $default_info ['alias'];
		$contentdefault ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $contentdefault );
		if (isset ( $contentdefault ['story_id'] )) {
			return $contentdefault;
		}
	}
	
	/**
	 * Get content list for admin side
	 */
	function getAdminContentList($forMods, $story_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_status', $story_infos ['story_status'] ) );
		if ($story_infos ['story_static']) {
			$criteria->add ( new Criteria ( 'story_topic', '0', '>' ) );
		}
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
		$criteria->add ( new Criteria ( 'story_uid', $story_infos ['story_user'] ) );
		$criteria->setSort ( $story_infos ['story_sort'] );
		$criteria->setOrder ( $story_infos ['story_order'] );
		$criteria->setLimit ( $story_infos ['story_limit'] );
		$criteria->setStart ( $story_infos ['story_start'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'story_uid' ) );
				
            if(is_array($story_infos ['topics'])) {
					foreach ( array_keys ( $story_infos ['topics'] ) as $i ) {
						$list [$i] ['topic_title'] = $story_infos ['topics'] [$i]->getVar ( "topic_title" );
						$list [$i] ['topic_id'] = $story_infos ['topics'] [$i]->getVar ( "topic_id" );
						$list [$i] ['topic_alias'] = $story_infos ['topics'] [$i]->getVar ( "topic_alias" );
					}
				}
				if ($root->getVar ( 'story_topic' )) {
					$tab ['topic'] = $list [$root->getVar ( 'story_topic' )] ['topic_title'];
					$tab ['topic_alias'] = $list [$root->getVar ( 'story_topic' )] ['topic_alias'];
					$tab ['topicurl'] = News_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'story_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'story_topic' )] ['topic_alias'] ));
				}

				$tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['story_create'] = formatTimestamp ( $root->getVar ( 'story_create' ), _MEDIUMDATESTRING );
				$tab ['story_update'] = formatTimestamp ( $root->getVar ( 'story_update' ), _MEDIUMDATESTRING );
				$tab ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/medium/' . $root->getVar ( 'story_img' );
				$tab ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/thumb/' . $root->getVar ( 'story_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
		
	/**
	 * Get content list for user side
	 */	
	function getContentList($forMods, $story_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_status', $story_infos ['story_status'] ) );
		$access_topic = NewsPermission::getItemIds ( 'news_access', $forMods);
		$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
		$topic_show = $topic_handler->allVisible($forMods,$story_infos ['topics'],$story_infos ['story_topic']);
      $topiclist = array_intersect($access_topic , $topic_show);
		$criteria->add ( new Criteria ( 'story_topic', '(' . implode ( ',', $topiclist ) . ')', 'IN' ) );
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_publish', time() , '<=' ));
		$criteria->add ( new Criteria ( 'story_publish', 0 , '>' ));
		$criteria->add ( new Criteria ( 'story_expire', time() , '>=' ));
		$criteria->add ( new Criteria ( 'story_expire', 0 ) ,'OR');
		$criteria->add ( new Criteria ( 'story_uid', $story_infos ['story_user'] ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
      if(isset($story_infos ['story_subtopic'])) {
      	foreach ($story_infos ['story_subtopic'] as $subtopic){
				$criteria->add ( new Criteria ( 'story_topic', $subtopic ) ,'OR');
			}
		}
		$criteria->setSort ( $story_infos ['story_sort'] );
		$criteria->setOrder ( $story_infos ['story_order'] );
		$criteria->setLimit ( $story_infos ['story_limit'] );
		$criteria->setStart ( $story_infos ['story_start'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'story_uid' ) );
				
            if(is_array($story_infos ['topics'])) {
					foreach ( array_keys ( $story_infos ['topics'] ) as $i ) {
						$list [$i] ['topic_title'] = $story_infos ['topics'] [$i]->getVar ( "topic_title" );
						$list [$i] ['topic_id'] = $story_infos ['topics'] [$i]->getVar ( "topic_id" );
						$list [$i] ['topic_alias'] = $story_infos ['topics'] [$i]->getVar ( "topic_alias" );
					}
				}
				if ($root->getVar ( 'story_topic' )) {
					$tab ['topic'] = $list [$root->getVar ( 'story_topic' )] ['topic_title'];
					$tab ['topic_alias'] = $list [$root->getVar ( 'story_topic' )] ['topic_alias'];
					$tab ['topicurl'] = News_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'story_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'story_topic' )] ['topic_alias'] ));
				}

				$tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['story_create'] = formatTimestamp ( $root->getVar ( 'story_create' ), _MEDIUMDATESTRING );
				$tab ['story_update'] = formatTimestamp ( $root->getVar ( 'story_update' ), _MEDIUMDATESTRING );
				$tab ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/medium/' . $root->getVar ( 'story_img' );
				$tab ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/thumb/' . $root->getVar ( 'story_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	/**
	 * Get content list for list block
	 */
	function getContentBlockList($forMods, $story_infos ,$options) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_status', '1' ) );
		$criteria->add ( new Criteria ( 'story_publish', time() , '<=' ));
		$criteria->add ( new Criteria ( 'story_publish', 0 , '>' ));
		$criteria->add ( new Criteria ( 'story_expire', time() , '>=' ));
		$criteria->add ( new Criteria ( 'story_expire', 0 ) ,'OR');
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$access_topic = NewsPermission::getItemIds ( 'news_access', $forMods);
		$criteria->add ( new Criteria ( 'story_topic', '(' . implode ( ',', $access_topic ) . ')', 'IN' ) );
		if (! (count ( $options ) == 1 && $options [0] == 0)) {
			$criteria->add ( new Criteria ( 'story_topic', '(' . implode ( ',', $options ) . ')', 'IN' ) );
		}
		$criteria->setSort ( $story_infos ['story_sort'] );
		$criteria->setOrder ( $story_infos ['story_order'] );
		$criteria->setLimit ( $story_infos ['story_limit'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'story_uid' ) );
				
				foreach ( array_keys ( $story_infos ['topics'] ) as $i ) {
					$list [$i] ['topic_title'] = $story_infos ['topics'] [$i]->getVar ( "topic_title" );
					$list [$i] ['topic_id'] = $story_infos ['topics'] [$i]->getVar ( "topic_id" );
					$list [$i] ['topic_alias'] = $story_infos ['topics'] [$i]->getVar ( "topic_alias" );
				}
				if ($root->getVar ( 'story_topic' )) {
					$tab ['topic'] = $list [$root->getVar ( 'story_topic' )] ['topic_title'];
					$tab ['topic_alias'] = $list [$root->getVar ( 'story_topic' )] ['topic_alias'];
					$tab ['topicurl'] = News_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'story_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'story_topic' )] ['topic_alias'] ));
				}
				
				$tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['title'] = mb_strlen ( $root->getVar ( 'story_title' ), 'utf-8' ) > $story_infos ['lenght_title'] ? mb_substr ( $root->getVar ( 'story_title' ), 0, ($story_infos ['lenght_title']), 'utf-8' ) . "..." : $root->getVar ( 'story_title' );
				$tab ['date'] = formatTimestamp ( $root->getVar ( 'story_create' ), _MEDIUMDATESTRING );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	/**
	 * Get Expire list for admin side
	 */
	function getExpireContentList($forMods, $story_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_expire', 0 , '!='));
      $criteria->add ( new Criteria ( 'story_expire', time() , '<=' ));
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->setSort ( $story_infos ['story_sort'] );
		$criteria->setOrder ( $story_infos ['story_order'] );
		$criteria->setLimit ( $story_infos ['story_limit'] );
		$criteria->setStart ( $story_infos ['story_start'] );
		
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['owner'] = XoopsUser::getUnameFromId ( $root->getVar ( 'story_uid' ) );
				
            if(is_array($story_infos ['topics'])) {
					foreach ( array_keys ( $story_infos ['topics'] ) as $i ) {
						$list [$i] ['topic_title'] = $story_infos ['topics'] [$i]->getVar ( "topic_title" );
						$list [$i] ['topic_id'] = $story_infos ['topics'] [$i]->getVar ( "topic_id" );
						$list [$i] ['topic_alias'] = $story_infos ['topics'] [$i]->getVar ( "topic_alias" );
					}
				}
				if ($root->getVar ( 'story_topic' )) {
					$tab ['topic'] = $list [$root->getVar ( 'story_topic' )] ['topic_title'];
					$tab ['topic_alias'] = $list [$root->getVar ( 'story_topic' )] ['topic_alias'];
					$tab ['topicurl'] = News_TopicUrl ( $forMods->getVar ( 'dirname' ), array('topic_id'=>$list [$root->getVar ( 'story_topic' )] ['topic_id'], 'topic_alias'=>$list [$root->getVar ( 'story_topic' )] ['topic_alias'] ));
				}

				$tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$tab ['story_create'] = formatTimestamp ( $root->getVar ( 'story_create' ), _MEDIUMDATESTRING );
				$tab ['story_update'] = formatTimestamp ( $root->getVar ( 'story_update' ), _MEDIUMDATESTRING );
				$tab ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/medium/' . $root->getVar ( 'story_img' );
				$tab ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . '/thumb/' . $root->getVar ( 'story_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	/**
	 * Get Content Count for user side
	 * use in homepage function in NewsUtils class
	 */
	function getContentCount($forMods, $story_infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
		$access_topic = NewsPermission::getItemIds ( 'news_access', $forMods);
		$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
		$topic_show = $topic_handler->allVisible($forMods,$story_infos ['topics'],$story_infos ['story_topic']);
		$topiclist = array_intersect($access_topic , $topic_show);
		$criteria->add ( new Criteria ( 'story_topic', '(' . implode ( ',', $topiclist ) . ')', 'IN' ) );
		if(isset($story_infos ['story_subtopic'])) {
         foreach ($story_infos ['story_subtopic'] as $subtopic){
				$criteria->add ( new Criteria ( 'story_topic', $subtopic ) ,'OR');
			}
		}
		if ($story_infos ['story_static']) {
			$criteria->add ( new Criteria ( 'story_topic', '0', '>' ) );
		}
		return $this->getCount ( $criteria );
	}
	
	/**
	 * Get Content Count for admin side
	 */
	function getAdminContentCount($forMods, $story_infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
		if ($story_infos ['story_static']) {
			$criteria->add ( new Criteria ( 'story_topic', '0', '>' ) );
		}
		return $this->getCount ( $criteria );
	}
		
	/**
	 * Get Offline Content Count for admin side
	 */	
	function getOfflineContentCount($forMods, $story_infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
		$criteria->add ( new Criteria ( 'story_status', 0 ) );
		return $this->getCount ( $criteria );
	}
	
	/**
	 * Get Expire Content Count for admin side
	 */
	function getExpireContentCount ($forMods, $story_infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
      $criteria->add ( new Criteria ( 'story_expire', 0 , '!='));
      $criteria->add ( new Criteria ( 'story_expire', time() , '<=' ));
		return $this->getCount ( $criteria );
	}
	/**
	 * Get All Content Count for admin side
	 */
	function getAllContentCount($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
      return $this->getCount ( $criteria );
	}
	
	/**
	 * Get Last Content
	 */
	function getLastContent($forMods, $story_infos) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$obj = $this->getObjects ( $criteria, false );
		if ($obj) {
			foreach ( $obj as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['topic'] = NewsTopicHandler::getTopicFromId ( $root->getVar ( 'story_topic' ) );
            $tab ['topic_alias'] = $tab ['topic'];
				$tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	/**
	 * some function for set Next and Previous content
	 *
	 * setNext function
	 * setPrevious function
	 * resetNext function
	 * resetPrevious function
	 */
	function setNext($forMods, $topic_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $topic_id ) );
		$criteria->setSort ( 'story_id' );
		$criteria->setOrder ( 'ASC' );
		$criteria->setLimit ( 1 );
		$previous = $this->getObjects ( $criteria );
		foreach ( $previous as $item ) {
			return $item->getVar ( 'story_id' );
		}
	}
	
	function setPrevious($forMods, $topic_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $topic_id ) );
		$criteria->setSort ( 'story_id' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$previous = $this->getObjects ( $criteria );
		foreach ( $previous as $item ) {
			return $item->getVar ( 'story_id' );
		}
	}
	
	function resetNext($forMods, $topic_id , $next_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $topic_id ) );
		$criteria->setSort ( 'story_id' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$criteria->setStart ( 1 );
		$next = $this->getObjects ( $criteria );
		foreach ( $next as $item ) {
			$item->setVar ( 'story_next', $next_id );
			return $this->insert ( $item );
		}
	}
	
	function resetPrevious($forMods, $topic_id , $prev_id) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_topic', $topic_id ) );
		$criteria->setSort ( 'story_id' );
		$criteria->setOrder ( 'ASC' );
		$criteria->setLimit ( 1 );
		$criteria->setStart ( 0 );
		$prev = $this->getObjects ( $criteria );
		foreach ( $prev as $item ) {
			$item->setVar ( 'story_prev', $prev_id );
			return $this->insert ( $item );
		}
	}
	
	/**
	 * Set order
	 */
	function setorder($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->setSort ( 'story_order' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$last = $this->getObjects ( $criteria );
		$order = 1;
		foreach ( $last as $item ) {
			$order = $item->getVar ( 'story_order' ) + 1;
		}
		return $order;
	}
		
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Hervé Thouzard (ttp://www.instant-zero.com)
	 */
	
	function updateHits($story_id) {
		$sql = 'UPDATE ' . $this->table . ' SET story_hits = story_hits + 1 WHERE story_id= ' . intval ( $story_id );
		return $this->db->queryF ( $sql );
	}
	
	/**
	 *
	 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
	 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
	 * @author      Zoullou (http://www.zoullou.net)
	 */
	function getSearchedContent($queryArray, $condition, $limit, $start, $userId) {
		$ret = array ();
		include_once 'topic.php';
		$criteria = new CriteriaCompo ();
		if ($userId > 0)
			$criteria->add ( new Criteria ( 'story_uid', $userId ) );
		$criteria->add ( new Criteria ( 'story_status', 1 ) );
		if (is_array ( $queryArray ) && count ( $queryArray ) > 0) {
			$subCriteria = new CriteriaCompo ();
			foreach ( $queryArray as $keyWord ) {
				$keyWordCriteria = new CriteriaCompo ();
				$keyWordCriteria->add ( new Criteria ( 'story_title', '%' . $keyWord . '%', 'LIKE' ) );
				$keyWordCriteria->add ( new Criteria ( 'story_text', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'story_subtitle', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'story_short', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'story_words', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$keyWordCriteria->add ( new Criteria ( 'story_desc', '%' . $keyWord . '%', 'LIKE' ), 'OR' );
				$subCriteria->add ( $keyWordCriteria, $condition );
				unset ( $keyWordCriteria );
			}
			$criteria->add ( $subCriteria );
		}
		$criteria->setStart ( $start );
		$criteria->setLimit ( $limit );
		$criteria->setSort ( 'story_create' );
		
		$contents = $this->getObjects ( $criteria );
		
		$ret = array ();
		foreach ( $contents as $content ) {
			$data = array ();
			$data = $content->toArray ();
			$data ['image'] = 'images/forum.gif';
			$data ['topic'] = NewsTopicHandler::getTopicFromId ( $content->getVar ( 'story_topic' ) );
			$data ['topic_alias'] = $data ['topic'];
			$data ['link'] = News_Url ( 'news', $data );
			$data ['title'] = $content->getVar ( 'story_title' );
			$data ['time'] = $content->getVar ( 'story_create' );
			$data ['uid'] = $content->getVar ( 'story_uid' );
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
	function updateposts($story_uid, $story_status, $story_action) {
		switch ($story_action) {
			case 'add' :
				if ($story_uid && $story_status) {
					$user = new xoopsUser ( $story_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) + 1 );
				}
				break;
			
			case 'delete' :
				if ($story_uid && $story_status) {
					$user = new xoopsUser ( $story_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) - 1 );
				}
				break;
			
			case 'status' :
				if ($story_uid) {
					$user = new xoopsUser ( $story_uid );
					$member_handler = & xoops_gethandler ( 'member' );
					if ($story_status) {
						$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) - 1 );
					} else {
						$member_handler->updateUserByField ( $user, 'posts', $user->getVar ( 'posts' ) + 1 );
					}
				}
				break;
		}
	}
	
	/**
	 * Set number of files for each content
	 */
	function contentfile($action , $id , $previous = null) {
		switch($action) {
			case 'add':
				$sql = 'UPDATE ' . $this->table . ' SET story_file = story_file + 1 WHERE story_id= ' . intval ( $id );
			   break;
			
			case 'delete':
				$sql = 'UPDATE ' . $this->table . ' SET story_file = story_file - 1 WHERE story_id= ' . intval ( $id );
			   break;
		}
		return $this->db->queryF ( $sql );	
	}	
	
	/**
	 * Get all files fro each content
	 */
	function getfile($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'story_file', '0', '>' ) );
		return $this->getAll ( $criteria );
	}	
	
	/**
	 * Get related contents
	 */
	 function relatedContent($forMods, $story_infos) {
	 	 $ret = array();
		 $criteria = new CriteriaCompo ();
		 $criteria->add ( new Criteria ( 'story_modid', $forMods->getVar ( 'mid' ) ) );	
		 $criteria->add ( new Criteria ( 'story_topic', $story_infos ['story_topic'] ) );
		 $criteria->add ( new Criteria ( 'story_status', 1 ) );
		 $criteria->add ( new Criteria ( 'story_publish', time() , '<=' ));
		 $criteria->add ( new Criteria ( 'story_publish', 0 , '>' ));
		 $criteria->add ( new Criteria ( 'story_expire', time() , '>=' ));
		 $criteria->add ( new Criteria ( 'story_expire', 0 ) ,'OR');
		 $criteria->add ( new Criteria ( 'story_id', $story_infos ['story_id'], '!=' ) );
		 $criteria->setSort ( 'story_publish' );
		 $criteria->setOrder ( 'DESC' );
		 $criteria->setLimit ( $story_infos ['story_limit'] );
		 $obj = $this->getObjects ( $criteria, false );
		 if ($obj) {
			 foreach ( $obj as $root ) {
				 $tab = array ();
				 $tab = $root->toArray ();
				 $tab ['topic_alias'] = $story_infos ['topic_alias'];
				 $tab ['url'] = News_Url ( $forMods->getVar ( 'dirname' ), $tab );
				 $ret [] = $tab;
			 }
		 }
		 return $ret;
	 }	
}

?> 