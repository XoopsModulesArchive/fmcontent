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

class news_rate extends XoopsObject {
	
	/**
	 * Class constructor
	 */
	function news_rate() {
		$this->initVar ( "rate_id", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "rate_modid", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "rate_story", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "rate_user", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "rate_rating", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "rate_hostname", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "rate_created", XOBJ_DTYPE_INT, '' );


		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'news_rate' );
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

class NewsRateHandler extends XoopsPersistableObjectHandler {
	
	function NewsRateHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'news_rate', 'news_rate', 'rate_id', 'rate_story' );
	}

}
?>