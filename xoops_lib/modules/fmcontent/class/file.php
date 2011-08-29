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

class fmcontent_file extends XoopsObject {
	
	function fmcontent_file() {
		$this->initVar ( "file_id", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_modid", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_title", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_name", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_content", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_date", XOBJ_DTYPE_INT, '' );
		$this->initVar ( "file_type", XOBJ_DTYPE_TXTBOX, '' );
		$this->initVar ( "file_status", XOBJ_DTYPE_INT, '' );

		$this->db = $GLOBALS ['xoopsDB'];
		$this->table = $this->db->prefix ( 'fmcontent_file' );
	}	
}

class fmcontentFileHandler extends XoopsPersistableObjectHandler {
	
	function fmcontentFileHandler($db) {
		parent::XoopsPersistableObjectHandler ( $db, 'fmcontent_file', 'fmcontent_file', 'file_id', 'file_title' );
	}

}
?>