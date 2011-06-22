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
class fmcontent_topic extends XoopsObject {
	
	public $mod;
	public $db;
	public $table;
	
	/**
	 * Class constructor
	 */
	function fmcontent_topic() {
		
		$this->initVar ( "topic_id", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_title", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "topic_pid", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_desc", XOBJ_DTYPE_TXTAREA, '' );
		$this->initVar ( "topic_img", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "topic_weight", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_showtype", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_modid", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_submitter", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_date_created", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_date_update", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "topic_asmenu", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_online", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showtopic", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showauthor", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showdate", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showpdf", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showprint", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showmail", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_shownav", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showhits", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_showcoms", XOBJ_DTYPE_INT, 1 );
		$this->initVar ( "topic_perpage", XOBJ_DTYPE_INT, 0 );
		$this->initVar ( "topic_columns", XOBJ_DTYPE_INT, 0 );
		$this->initVar ( "topic_alias", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "topic_homepage", XOBJ_DTYPE_INT, 1 );
		
		// Pour autoriser le html
		$this->initVar ( "dohtml", XOBJ_DTYPE_INT, 1, false );
		
		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'fmcontent_topic' );
	}
	
	function getForm($forMods) {
		
		$form = new XoopsThemeForm ( _FMCONTENT_FORM_TOPIC, 'topic', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $forMods->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add_topic' ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'topic_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit_topic' ) );
		}
		
		$form->addElement ( new XoopsFormHidden ( 'topic_id', $this->getVar ( 'topic_id', 'e' ) ) );
		$form->addElement ( new XoopsFormHidden ( 'topic_submitter', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		$form->addElement ( new XoopsFormHidden ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_TOPIC_NAME, "topic_title", 50, 255, $this->getVar ( "topic_title" ) ), true );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_TOPIC_ALIAS, "topic_alias", 50, 255, $this->getVar ( "topic_alias" ) ), true );
		
		$topic_Handler = xoops_getModuleHandler ( "topic", "fmcontent" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		$topic = $topic_Handler->getObjects ( $criteria );
		$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
		ob_start ();
		echo $tree->makeSelBox ( 'topic_pid', 'topic_title', '--', $this->getVar ( 'topic_pid', 'e' ), true );
		$form->addElement ( new XoopsFormLabel ( _FMCONTENT_TOPIC_PARENT, ob_get_contents () ) );
		ob_end_clean ();
		
		$form->addElement ( new XoopsFormTextArea ( _FMCONTENT_TOPIC_DESC, "topic_desc", $this->getVar ( "topic_desc" ), 5, 47 ), false );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_TOPIC_WEIGHT, "topic_weight", 5, 11, $this->getVar ( "topic_weight" ) ), false );
		
		// Image
		$topic_img = $this->getVar ( 'topic_img' ) ? $this->getVar ( 'topic_img' ) : 'blank.gif';
		$uploadirectory_topic_img = xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) );
		$fileseltray_topic_img = new XoopsFormElementTray ( _FMCONTENT_TOPIC_IMG, '<br />' );
		$fileseltray_topic_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_topic_img . $topic_img . "' name='image_topic_img' id='image_topic_img' alt='' />" ) );
		if ($this->getVar ( 'topic_img' )) {
			$delete_img = new XoopsFormCheckBox ( '', 'deleteimage', 0 );
			$delete_img->addOption ( 1, _DELETE );
			$fileseltray_topic_img->addElement ( $delete_img );
		}
		$fileseltray_topic_img->addElement ( new XoopsFormFile ( _FMCONTENT_FORMUPLOAD, 'topic_img', xoops_getModuleOption ( 'img_size', $forMods->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_topic_img );
		
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_ONLINE, 'topic_online', $this->getVar ( 'topic_online', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_MENU, 'topic_asmenu', $this->getVar ( 'topic_asmenu', 'e' ) ) );
		$form->addElement ( new XoopsFormLabel ( _FMCONTENT_TOPIC_SETTING, _FMCONTENT_TOPIC_SETTING_DESC, '' ) );
		$homepage = new XoopsFormSelect ( _FMCONTENT_TOPIC_HOMEPAGE_, 'topic_homepage', $this->getVar ( "topic_homepage" ) );
		$homepage->addOption ( '1', _FMCONTENT_TOPIC_HOMEPAGE_1 );
		$homepage->addOption ( '2', _FMCONTENT_TOPIC_HOMEPAGE_2 );
		$homepage->addOption ( '3', _FMCONTENT_TOPIC_HOMEPAGE_3 );
		$homepage->addOption ( '4', _FMCONTENT_TOPIC_HOMEPAGE_4 );
		$homepage->setDescription ( _FMCONTENT_TOPIC_HOMEPAGE_DESC );
		$form->addElement ( $homepage );
		
		$showtype = new XoopsFormSelect ( _FMCONTENT_TOPIC_SHOWTYPE, 'topic_showtype', $this->getVar ( "topic_showtype" ) );
		$showtype->addOption ( '0', _FMCONTENT_SHOWTYPE_0 );
		$showtype->addOption ( '1', _FMCONTENT_SHOWTYPE_1 );
		$showtype->addOption ( '2', _FMCONTENT_SHOWTYPE_2 );
		$showtype->addOption ( '3', _FMCONTENT_SHOWTYPE_3 );
		$showtype->addOption ( '4', _FMCONTENT_SHOWTYPE_4 );
		$showtype->setDescription ( _FMCONTENT_TOPIC_SHOWTYPE_DESC );
		$form->addElement ( $showtype );
		
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWTOPIC, 'topic_showtopic', $this->getVar ( 'topic_showtopic', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWAUTHOR, 'topic_showauthor', $this->getVar ( 'topic_showauthor', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWDATE, 'topic_showdate', $this->getVar ( 'topic_showdate', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWDPF, 'topic_showpdf', $this->getVar ( 'topic_showpdf', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWPRINT, 'topic_showprint', $this->getVar ( 'topic_showprint', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWMAIL, 'topic_showmail', $this->getVar ( 'topic_showmail', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWNAV, 'topic_shownav', $this->getVar ( 'topic_shownav', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWHITS, 'topic_showhits', $this->getVar ( 'topic_showhits', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _FMCONTENT_TOPIC_SHOWCOMS, 'topic_showcoms', $this->getVar ( 'topic_showcoms', 'e' ) ) );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_TOPIC_PERPAGE, "topic_perpage", 50, 255, $this->getVar ( "topic_perpage" ) ), true );
		$form->addElement ( new XoopsFormText ( _FMCONTENT_TOPIC_COLUMNS, "topic_columns", 50, 255, $this->getVar ( "topic_columns" ) ) );
		
		//permissions
		$member_handler = & xoops_gethandler ( 'member' );
		$group_list = &$member_handler->getGroupList ();
		$gperm_handler = &xoops_gethandler ( 'groupperm' );
		$full_list = array_keys ( $group_list );
		global $xoopsModule;
		if (! $this->isNew ()) {
			$groups_ids_view = $gperm_handler->getGroupIds ( 'fmcontent_access', $this->getVar ( 'topic_id' ), $xoopsModule->getVar ( 'mid' ) );
			$groups_ids_submit = $gperm_handler->getGroupIds ( 'fmcontent_submit', $this->getVar ( 'topic_id' ), $xoopsModule->getVar ( 'mid' ) );
			$groups_ids_view = array_values ( $groups_ids_view );
			$groups_news_can_view_checkbox = new XoopsFormCheckBox ( _FMCONTENT_PERMISSIONS_ACCESS, 'groups_view[]', $groups_ids_view );
			$groups_ids_submit = array_values ( $groups_ids_submit );
			$groups_news_can_submit_checkbox = new XoopsFormCheckBox ( _FMCONTENT_PERMISSIONS_SUBMIT, 'groups_submit[]', $groups_ids_submit );
		
		} else {
			$groups_news_can_view_checkbox = new XoopsFormCheckBox ( _FMCONTENT_PERMISSIONS_ACCESS, 'groups_view[]', $full_list );
			$groups_news_can_submit_checkbox = new XoopsFormCheckBox ( _FMCONTENT_PERMISSIONS_SUBMIT, 'groups_submit[]', $full_list );
		
		}
		// pour voir
		$groups_news_can_view_checkbox->addOptionArray ( $group_list );
		$form->addElement ( $groups_news_can_view_checkbox );
		// pour editer
		$groups_news_can_submit_checkbox->addOptionArray ( $group_list );
		$form->addElement ( $groups_news_can_submit_checkbox );
		
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

}

class fmcontentTopicHandler extends XoopsPersistableObjectHandler {
	
	function fmcontentTopicHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'fmcontent_topic', 'fmcontent_topic', 'topic_id', 'topic_title' );
	}
	
	function getTopics($forMods, $topic_limit, $topic_start, $topic_order, $topic_sort, $topic_menu, $topic_online) {
		$ret = array ();
		if (! isset ( $criteria )) {
			$criteria = new CriteriaCompo ();
		}
		
		if (isset ( $criteria )) {
			$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
			$criteria->add ( new Criteria ( 'topic_asmenu', $topic_menu ) );
			$criteria->add ( new Criteria ( 'topic_online', $topic_online ) );
			$criteria->setSort ( $topic_sort );
			$criteria->setOrder ( $topic_order );
			$criteria->setLimit ( $topic_limit );
			$criteria->setStart ( $topic_start );
		}
		
		$topics = $this->getObjects ( $criteria, false );
		if ($topics) {
			
			foreach ( $topics as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				//$tab['contentcount'] = fmcontentPageHandler::getContentItemCount($forMods, $root->getVar('topic_id'));
				//$tab['menutcount'] = fmcontentPageHandler::getMenuItemCount($forMods, $root->getVar('topic_id'));
				$tab ['imgurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $forMods->getVar ( 'dirname' ) ) . $root->getVar ( 'topic_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	function getTopicCount($forMods) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $forMods->getVar ( 'mid' ) ) );
		return $this->getCount ( $criteria );
	}
	
	function getTopicFromId($topicid) {
		$myts = & MyTextSanitizer::getInstance ();
		$topicid = intval ( $topicid );
		$topic_title = '';
		if ($topicid > 0) {
			$topic_handler = xoops_getmodulehandler ( 'topic', 'fmcontent' );
			$topic = & $topic_handler->get ( $topicid );
			if (is_object ( $topic )) {
				$topic_title = $topic->getVar ( 'topic_title' );
			}
		}
		return $topic_title;
	}
	
	function getInsertId() {
		return $this->db->getInsertId ();
	}
}

?>