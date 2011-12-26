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
 * News page class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */
class news_topic extends XoopsObject {
	
	public $mod;
	public $db;
	public $table;
	
	/**
	 * Class constructor
	 */
	function news_topic() {
		
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
		$this->initVar ( "topic_show", XOBJ_DTYPE_INT, 1 );
		
		// Pour autoriser le html
		$this->initVar ( "dohtml", XOBJ_DTYPE_INT, 1, false );
		
		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'news_topic' );
	}
	
	/**
	 * Topic form
	 */
	function getForm($NewsModule) {
		
		$form = new XoopsThemeForm ( _NEWS_AM_TOPIC_FORM, 'topic', 'backend.php', 'post' );
		$form->setExtra ( 'enctype="multipart/form-data"' );
		
		if ($this->isNew ()) {
			$groups = xoops_getModuleOption ( 'groups', $NewsModule->getVar ( 'dirname', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'add_topic' ) );
		} else {
			$groups = explode ( " ", $this->getVar ( 'topic_groups', 'e' ) );
			$form->addElement ( new XoopsFormHidden ( 'op', 'edit_topic' ) );
		}
		
		$form->addElement ( new XoopsFormHidden ( 'topic_id', $this->getVar ( 'topic_id', 'e' ) ) );
		$form->addElement ( new XoopsFormHidden ( 'topic_submitter', $GLOBALS ['xoopsUser']->getVar ( 'uid' ) ) );
		$form->addElement ( new XoopsFormHidden ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$form->addElement ( new XoopsFormText ( _NEWS_AM_TOPIC_NAME, "topic_title", 50, 255, $this->getVar ( "topic_title" ) ), true );
		$form->addElement ( new XoopsFormText ( _NEWS_AM_TOPIC_ALIAS, "topic_alias", 50, 255, $this->getVar ( "topic_alias" ) ), true );
		
		$topic_Handler = xoops_getModuleHandler ( "topic", "news" );
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$topic = $topic_Handler->getObjects ( $criteria );
		$tree = new XoopsObjectTree ( $topic, 'topic_id', 'topic_pid' );
		ob_start ();
		echo $tree->makeSelBox ( 'topic_pid', 'topic_title', '--', $this->getVar ( 'topic_pid', 'e' ), true );
		$form->addElement ( new XoopsFormLabel ( _NEWS_AM_TOPIC_PARENT, ob_get_contents () ) );
		ob_end_clean ();
		
		$form->addElement ( new XoopsFormTextArea ( _NEWS_AM_TOPIC_DESC, "topic_desc", $this->getVar ( "topic_desc" ), 5, 47 ), false );
		//$form->addElement ( new XoopsFormText ( _NEWS_AM_TOPIC_WEIGHT, "topic_weight", 5, 11, $this->getVar ( "topic_weight" ) ), false );
		
		// Image
		$topic_img = $this->getVar ( 'topic_img' ) ? $this->getVar ( 'topic_img' ) : 'blank.gif';
		$uploadirectory_topic_img = xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) );
		$fileseltray_topic_img = new XoopsFormElementTray ( _NEWS_AM_TOPIC_IMG, '<br />' );
		$fileseltray_topic_img->addElement ( new XoopsFormLabel ( '', "<img class='fromimage' src='" . XOOPS_URL . $uploadirectory_topic_img . $topic_img . "' name='image_topic_img' id='image_topic_img' alt='' />" ) );
		if ($this->getVar ( 'topic_img' )) {
			$delete_img = new XoopsFormCheckBox ( '', 'deleteimage', 0 );
			$delete_img->addOption ( 1, _DELETE );
			$fileseltray_topic_img->addElement ( $delete_img );
		}
		$fileseltray_topic_img->addElement ( new XoopsFormFile ( _NEWS_AM_GLOBAL_FORMUPLOAD, 'topic_img', xoops_getModuleOption ( 'img_size', $NewsModule->getVar ( 'dirname' ) ) ), false );
		$form->addElement ( $fileseltray_topic_img );
		
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_ONLINE, 'topic_online', $this->getVar ( 'topic_online', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_MENU, 'topic_asmenu', $this->getVar ( 'topic_asmenu', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOW, 'topic_show', $this->getVar ( 'topic_show', 'e' ) ) );
		$form->addElement ( new XoopsFormLabel ( _NEWS_AM_TOPIC_OPTIONS, _NEWS_AM_TOPIC_OPTIONS_DESC, '' ) );
		$homepage = new XoopsFormSelect ( _NEWS_AM_TOPIC_HOMEPAGE, 'topic_homepage', $this->getVar ( "topic_homepage" ) );
		$homepage->addOption ( '1', _NEWS_AM_TOPIC_HOMEPAGE_1 );
		$homepage->addOption ( '2', _NEWS_AM_TOPIC_HOMEPAGE_2 );
		$homepage->addOption ( '3', _NEWS_AM_TOPIC_HOMEPAGE_3 );
		$homepage->addOption ( '4', _NEWS_AM_TOPIC_HOMEPAGE_4 );
		$homepage->setDescription ( _NEWS_AM_TOPIC_HOMEPAGE_DESC );
		$form->addElement ( $homepage );
		
		$showtype = new XoopsFormSelect ( _NEWS_AM_TOPIC_SHOWTYPE, 'topic_showtype', $this->getVar ( "topic_showtype" ) );
		$showtype->addOption ( '0', _NEWS_AM_TOPIC_SHOWTYPE_0 );
		$showtype->addOption ( '1', _NEWS_AM_TOPIC_SHOWTYPE_1 );
		$showtype->addOption ( '2', _NEWS_AM_TOPIC_SHOWTYPE_2 );
		$showtype->addOption ( '3', _NEWS_AM_TOPIC_SHOWTYPE_3 );
		$showtype->addOption ( '4', _NEWS_AM_TOPIC_SHOWTYPE_4 );
		$showtype->setDescription ( _NEWS_AM_TOPIC_SHOWTYPE_DESC );
		$form->addElement ( $showtype );
		
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWTOPIC, 'topic_showtopic', $this->getVar ( 'topic_showtopic', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWAUTHOR, 'topic_showauthor', $this->getVar ( 'topic_showauthor', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWDATE, 'topic_showdate', $this->getVar ( 'topic_showdate', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWDPF, 'topic_showpdf', $this->getVar ( 'topic_showpdf', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWPRINT, 'topic_showprint', $this->getVar ( 'topic_showprint', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWMAIL, 'topic_showmail', $this->getVar ( 'topic_showmail', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWNAV, 'topic_shownav', $this->getVar ( 'topic_shownav', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWHITS, 'topic_showhits', $this->getVar ( 'topic_showhits', 'e' ) ) );
		$form->addElement ( new XoopsFormRadioYN ( _NEWS_AM_TOPIC_SHOWCOMS, 'topic_showcoms', $this->getVar ( 'topic_showcoms', 'e' ) ) );
		$form->addElement ( new XoopsFormText ( _NEWS_AM_TOPIC_PERPAGE, "topic_perpage", 50, 255, $this->getVar ( "topic_perpage" ) ), true );
		$form->addElement ( new XoopsFormText ( _NEWS_AM_TOPIC_COLUMNS, "topic_columns", 50, 255, $this->getVar ( "topic_columns" ) ) );
		
		//permissions
		$member_handler = & xoops_gethandler ( 'member' );
		$group_list = &$member_handler->getGroupList ();
		$gperm_handler = &xoops_gethandler ( 'groupperm' );
		$full_list = array_keys ( $group_list );
		global $xoopsModule;
		if (! $this->isNew ()) {
			$groups_ids_view = $gperm_handler->getGroupIds ( 'news_access', $this->getVar ( 'topic_id' ), $xoopsModule->getVar ( 'mid' ) );
			$groups_ids_submit = $gperm_handler->getGroupIds ( 'news_submit', $this->getVar ( 'topic_id' ), $xoopsModule->getVar ( 'mid' ) );
			$groups_ids_view = array_values ( $groups_ids_view );
			$groups_NEWS_AM_can_view_checkbox = new XoopsFormCheckBox ( _NEWS_AM_PERMISSIONS_ACCESS, 'groups_view[]', $groups_ids_view );
			$groups_ids_submit = array_values ( $groups_ids_submit );
			$groups_NEWS_AM_can_submit_checkbox = new XoopsFormCheckBox ( _NEWS_AM_PERMISSIONS_SUBMIT, 'groups_submit[]', $groups_ids_submit );
		
		} else {
			$groups_NEWS_AM_can_view_checkbox = new XoopsFormCheckBox ( _NEWS_AM_PERMISSIONS_ACCESS, 'groups_view[]', $full_list );
			$groups_NEWS_AM_can_submit_checkbox = new XoopsFormCheckBox ( _NEWS_AM_PERMISSIONS_SUBMIT, 'groups_submit[]', $full_list );
		
		}
		// pour voir
		$groups_NEWS_AM_can_view_checkbox->addOptionArray ( $group_list );
		$form->addElement ( $groups_NEWS_AM_can_view_checkbox );
		// pour editer
		$groups_NEWS_AM_can_submit_checkbox->addOptionArray ( $group_list );
		$form->addElement ( $groups_NEWS_AM_can_submit_checkbox );
		
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

class NewsTopicHandler extends XoopsPersistableObjectHandler {
	
	function NewsTopicHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'news_topic', 'news_topic', 'topic_id', 'topic_alias' );
	}
	
	
	/**
	 * Check if content alias already exist
	 *
	 * @param   String  $alias
	 * @return  boolean
	 **/
	function News_ExistTopicAlias($NewsModule , $infos) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'topic_alias', $infos['topic_alias'] ) );
		if($infos['topic_id']) {
			$criteria->add ( new Criteria ( 'topic_id', $infos['topic_id'] , '!=') );
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
	function News_GetTopicId($alias) {
		$criteria = new CriteriaCompo ();
		$criteria = new Criteria ( 'topic_alias', $alias );
		$criteria->setLimit ( 1 );
		$obj_array = $this->getObjects ( $criteria, false, false );
		if (count ( $obj_array ) != 1) {
			return 0;
		}
		return $obj_array [0] [$this->keyName];
	}
	
	/**
	 * Get topic information
	 */
	function News_GetTopics($NewsModule, $topic_limit, $topic_start, $topic_order, $topic_sort, $topic_menu, $topic_online , $topic_parent) {
		$ret = array ();
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$criteria->add ( new Criteria ( 'topic_asmenu', $topic_menu ) );
		$criteria->add ( new Criteria ( 'topic_online', $topic_online ) );
		if(isset($topic_parent)) {
			$criteria->add ( new Criteria ( 'topic_pid', $topic_parent ) );
		}	
		$criteria->setSort ( $topic_sort );
		$criteria->setOrder ( $topic_order );
		$criteria->setLimit ( $topic_limit );
		$criteria->setStart ( $topic_start );
		$topics = $this->getObjects ( $criteria, false );
		if ($topics) {
			
			foreach ( $topics as $root ) {
				$tab = array ();
				$tab = $root->toArray ();
				$tab ['topicurl'] = NewsUtils::News_TopicUrl ( $NewsModule->getVar ( 'dirname' ), $tab );
				$tab ['thumburl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) . '/thumb/' .$root->getVar ( 'topic_img' );
				$tab ['imageurl'] = XOOPS_URL . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) . '/medium/' .$root->getVar ( 'topic_img' );
				$ret [] = $tab;
			}
		}
		return $ret;
	}
	
	/**
	 * Get topic Count
	 */
	function News_GetTopicCount($NewsModule) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		return $this->getCount ( $criteria );
	}
	
	/**
	 * Get topic from ID
	 */
	function News_GetTopicFromId($topicid) {
		$myts = & MyTextSanitizer::getInstance ();
		$topicid = intval ( $topicid );
		$topic_title = '';
		if ($topicid > 0) {
			$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
			$topic = & $topic_handler->get ( $topicid );
			if (is_object ( $topic )) {
				$topic_title = $topic->getVar ( 'topic_title' );
			}
		}
		return $topic_title;
	}
	
	/**
	 * Get Insert ID
	 */
	function getInsertId() {
		return $this->db->getInsertId ();
	}
	
	/**
	 * Get All of sub topics
	 */
	function News_GetSubTopics($NewsModule , $id ,$topics) {
		$ret = array();
		   $ret [] = $id;
			foreach ( $topics as $root ) {
				if($root->getVar ( 'topic_pid' ) == $id) {
            $ret [] =   $root->getVar ( 'topic_id' );
            }
			}
		return $ret;
	}	
	
	/**
	 * Set order
	 */
	function setorder($NewsModule) {
		$criteria = new CriteriaCompo ();
		$criteria->add ( new Criteria ( 'topic_modid', $NewsModule->getVar ( 'mid' ) ) );
		$criteria->setSort ( 'topic_weight' );
		$criteria->setOrder ( 'DESC' );
		$criteria->setLimit ( 1 );
		$last = $this->getObjects ( $criteria );
		$order = 1;
		foreach ( $last as $item ) {
			$order = $item->getVar ( 'topic_weight' ) + 1;
		}
		return $order;
	}
	
	/**
	 * Get all visible topics
	 */
	function allVisible($NewsModule, $topics, $topic) {
		$topic_show = array();
		if($topic) {
			$topic_show[] = $topic;
		}
		foreach ( array_keys ( $topics ) as $i ) {
			if($topics [$i]->getVar ( "topic_show" )) {
			$topic_show[] = $topics [$i]->getVar ( "topic_id" );
			}	
		}	
		return $topic_show;
	}	
}

?>