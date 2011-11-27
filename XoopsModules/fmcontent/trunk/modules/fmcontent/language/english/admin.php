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
 * FmContent language file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

if (!defined('_FMCONTENT_PREFERENCES')) {
    // Index page
    define('_FMCONTENT_ADD_CONTENT', 'Add Content');
    define('_FMCONTENT_ADD_TOPIC', 'Add Topic');
    define('_FMCONTENT_ADD_MENU', 'Add Link');
    define('_FMCONTENT_ADD_FILE', 'Add File');
    define('_FMCONTENT_LAST_TOPIC', 'Last Topics');
    define('_FMCONTENT_LAST_CONTENTS', 'Last Contents');
    define("_FMCONTENT_ADMENU1", "Topics");
    define("_FMCONTENT_ADMENU2", "Contents");
    define("_FMCONTENT_INDEX_TOPICS", "There are %s Topics in our database");
	 define("_FMCONTENT_INDEX_CONTENTS", "There are %s Contents in our database");
// Topic page
    define('_FMCONTENT_FORM_TOPIC', 'Manage Topic');
    define('_FMCONTENT_TOPIC_ID', 'ID');
    define('_FMCONTENT_TOPIC_NUM', 'Weight');
    define('_FMCONTENT_TOPIC_NAME', 'Title');
    define('_FMCONTENT_TOPIC_PARENT', 'Parent topic');
    define('_FMCONTENT_TOPIC_DESC', 'Description');
    define('_FMCONTENT_TOPIC_IMG', 'Image');
    define('_FMCONTENT_TOPIC_WEIGHT', 'Weight');
    define('_FMCONTENT_TOPIC_SHOWTYPE', 'Display mode');
    define('_FMCONTENT_TOPIC_SHOWTYPE_DESC', 'Contents display template for this topic<br />"Module based" will use display options defined in module preferences.');
    define('_FMCONTENT_TOPIC_PERPAGE', 'Per page');
    define('_FMCONTENT_TOPIC_COLUMNS', 'Columns');
    define('_FMCONTENT_TOPIC_ONLINE', 'Active');
    define('_FMCONTENT_TOPIC_MENU', 'Menu');
	 define('_FMCONTENT_TOPIC_SHOW', 'Show');
    define('_FMCONTENT_TOPIC_ACTION', 'Actions');
    define('_FMCONTENT_TOPIC_PID', 'Parent');
    define('_FMCONTENT_TOPIC_COLOR', 'Topic color');
    define('_FMCONTENT_TOPIC_DATE_CREATED', 'Time created');
    define('_FMCONTENT_TOPIC_DATE_UPDATE', 'Time updated');
    define('_FMCONTENT_TOPIC_SHOWTOPIC', 'Display Topic title');
    define('_FMCONTENT_TOPIC_SHOWAUTHOR', 'Display Author');
    define('_FMCONTENT_TOPIC_SHOWDATE', 'Display Date');
    define('_FMCONTENT_TOPIC_SHOWDPF', 'Display PDF Icon');
    define('_FMCONTENT_TOPIC_SHOWPRINT', 'Display Print Icon');
    define('_FMCONTENT_TOPIC_SHOWMAIL', 'Display Mail Icon');
    define('_FMCONTENT_TOPIC_SHOWNAV', 'Display Prev/Next navigation');
    define('_FMCONTENT_TOPIC_SHOWHITS', 'Display Hits');
    define('_FMCONTENT_TOPIC_SHOWCOMS', 'Display Comments count');
    define('_FMCONTENT_TOPIC_HOMEPAGE', 'Topic homepage seting');
    define('_FMCONTENT_TOPIC_HOMEPAGE_DESC', 'Seting content show type in topic pages');
    define('_FMCONTENT_TOPIC_HOMEPAGE_1', 'List all contents from this topic and subtopics');
    define('_FMCONTENT_TOPIC_HOMEPAGE_2', 'List all subtopics');
    define('_FMCONTENT_TOPIC_HOMEPAGE_3', 'List all contents from just this topic');
    define('_FMCONTENT_TOPIC_HOMEPAGE_4', 'Show selected content from this topic');
    define('_FMCONTENT_TOPIC_OPTIONS', 'Sellect topic show options');
    define('_FMCONTENT_TOPIC_OPTIONS_DESC', 'Sellect topic show options');
    define('_FMCONTENT_TOPIC_ALIAS', 'Alias (for url)');
// Content page
    define('_FMCONTENT_FORM', 'Manage Content');
    define('_FMCONTENT_FORMTYPE', 'Type');
    define('_FMCONTENT_FORMTYPE_CONTENT', 'Content');
    define('_FMCONTENT_FORMTYPE_LINK', 'Link');
    define('_FMCONTENT_FORMTYPE_HEADER', 'Section Header');
    define('_FMCONTENT_FORMTYPE_SEPARATOR', 'Separator');
    define('_FMCONTENT_FORMTITLE', 'Title');
    define('_FMCONTENT_FORMTITLE_DISP', 'Display page title?');
    define('_FMCONTENT_FORMAUTHOR', 'Source (Name)');
    define('_FMCONTENT_FORMSOURCE', 'Source (URL)');
    define('_FMCONTENT_FORMPARENT', 'Parent');
    define('_FMCONTENT_FORMTEXT', 'Text');
    define('_FMCONTENT_FORMTEXT_DESC', 'Main content of the page');
    define('_FMCONTENT_FORMGROUP', 'Groups');
    define('_FMCONTENT_FORMALIAS', 'Alias (for url)');
    define('_FMCONTENT_FORMACTIF', 'Online');
    define('_FMCONTENT_FORMDISPLAY', 'Menu');
    define('_FMCONTENT_FORMLINK', 'Link');
    define('_FMCONTENT_FORMDEFAULT', 'Default');
    define('_FMCONTENT_THEME', 'Theme');
    define('_FMCONTENT_FORMOPTION', 'Options');
    define('_FMCONTENT_FORMHTML', 'HTML');
    define('_FMCONTENT_FORMPREV', 'Previous link');
    define('_FMCONTENT_FORMNEXT', 'Next link');
    define('_FMCONTENT_DOHTML', 'Allow HTML code');
    define('_FMCONTENT_BREAKS', 'Convert line breaks');
    define('_FMCONTENT_DOIMAGE', 'Allow XOOPS Images');
    define('_FMCONTENT_DOXCODE', 'Allow XOOPS BBcode');
    define('_FMCONTENT_DOSMILEY', 'Allow XOOPS Smilies');
    define('_FMCONTENT_SHORT', 'Short text');
    define('_FMCONTENT_IMG', 'Image');
    define('_FMCONTENT_FORMUPLOAD', 'Select Image');
    define('_FMCONTENT_CONTENT_TITLE', 'Title');
    define('_FMCONTENT_CONTENT_MANAGER', 'Content manager');
    define('_FMCONTENT_CONTENT_FILE', 'File');
    define('_FMCONTENT_CONTENT_ID', 'ID');
    define('_FMCONTENT_CONTENT_NUM', 'Weight');
    define('_FMCONTENT_CONTENT_PAGE', 'Page');
    define('_FMCONTENT_CONTENT_TYPE', 'Type');
    define('_FMCONTENT_CONTENT_OWNER', 'Owner');
    define('_FMCONTENT_CONTENT_ACTIF', 'Active');
    define('_FMCONTENT_CONTENT_DEFAULT', 'Default');
    define('_FMCONTENT_CONTENT_ORDER', 'Order');
    define('_FMCONTENT_CONTENT_ACTION', 'Actions');
    define('_FMCONTENT_CONTENT_VIEW', 'View');
    define('_FMCONTENT_CONTENT_EDIT', 'Edit');
    define('_FMCONTENT_CONTENT_DELETE', 'Delete');
    define('_FMCONTENT_CONTENT_DOWN', 'Down');
    define('_FMCONTENT_CONTENT_UP', 'Up');
    define('_FMCONTENT_CONTENT_SHORT', 'Short Desc');
    define('_FMCONTENT_CONTENT_TOPIC', 'Topic');
    define('_FMCONTENT_CONTENT_TOPIC_DESC', 'Empty selection will set the content as a Static Page');
    define('_FMCONTENT_MENU_TOPIC', 'Menu Name');
    define('_FMCONTENT_CONTENT_MENU', 'Menu Title');
    define('_FMCONTENT_STATIC', 'Static page');
    define('_FMCONTENT_STATICS', 'Static pages');
    define('_FMCONTENT_ALL_ITEMS', 'All content/item list');
    define('_FMCONTENT_ALL_ITEMS_FROM', 'Item list filtered by: ');
// Menu page
    define('_FMCONTENT_MENU_DEFAULT', 'Default');
    define('_FMCONTENT_CONTENT_CHILD', 'Child');
// Tools page
    define('_FMCONTENT_FORMFOLDER_TITLE', 'Clone module');
    define('_FMCONTENT_FORMFOLDER_NAME', 'Folder name');
    define('_FMCONTENT_LOG_TITLE', 'Clone module log');
    define('_FMCONTENT_FORMPURGE_TITLE', 'Purge page of deleted clone');
    define('_FMCONTENT_ALIAS_TITLE', 'Rebuild Alias');
    define('_FMCONTENT_ALIAS_CONTENT', 'Rebuild content alias');
    define('_FMCONTENT_ALIAS_TOPIC', 'Rebuild topic alias');
    define('_FMCONTENT_META_TITLE', 'Rebuild Metas');
    define('_FMCONTENT_META_KEYWORD', 'Rebuild Meta keywords');
    define('_FMCONTENT_META_DESCRIPTION', 'Rebuild Meta Description');
// Permissions
    define('_FMCONTENT_PERMISSIONS_ACCESS', 'Access permissions');
    define('_FMCONTENT_PERMISSIONS_SUBMIT', 'Submit permissions');
    define('_FMCONTENT_PERMISSIONS_GLOBAL', 'Global permissions');
    define('_FMCONTENT_PERMISSIONS_GLOBAL_4', 'Rate');
    define('_FMCONTENT_PERMISSIONS_GLOBAL_8', 'Submit from user side');
    define('_FMCONTENT_PERMISSIONS_GLOBAL_16', 'Auto approve');
// Attach files
	 define('_FMCONTENT_FILE_ID', 'ID');
	 define('_FMCONTENT_FILE_ONLINE', 'Online');
	 define('_FMCONTENT_FILE_ACTION', 'Action');
    define('_FMCONTENT_FORM_FILE', 'Attach file');
	 define('_FMCONTENT_FILE_TITLE', 'Title');
	 define('_FMCONTENT_FILE_CONTENT', 'File Content');
	 define('_FMCONTENT_STATUS', 'Active');
	 define('_FMCONTENT_SELECT_FILE', 'Select your file');
	 define('_FMCONTENT_FILE_TYPE', 'Type');
// Admin message
    define('_FMCONTENT_MSG_DBUPDATE', 'Database updated successfully!');
    define('_FMCONTENT_MSG_ERRORDELETE', 'You cannot delete this content! <br />Please move or delete all child of this content');
    define('_FMCONTENT_MSG_WAIT', 'Please wait...');
    define('_FMCONTENT_MSG_DELETE', 'Are you sure you would like to delete: %s ?');
    define('_FMCONTENT_MSG_EDIT_ERROR', 'Could not find page or invalid page id!');
    define('_FMCONTENT_MSG_UPDATE_ERROR', 'Could not update database! Update content error');
    define('_FMCONTENT_MSG_INSERT_ERROR', 'Could not update database! Insert content error ');
    define('_FMCONTENT_MSG_CLONE_ERROR', 'This folder already exists !');
    define('_FMCONTENT_MSG_NOPERMSSET', 'Permission cannot be set: No Topics created yet! Please create a Topic first.');
	 define('_FMCONTENT_MSG_ALIASERROR', 'Your selected Alias is already taken. Please change it and try again');
// Tips
    define('_FMCONTENT_HOME_TIPS',
    '<ul>
	<li>Not yet</li>
	</ul>');
    define('_FMCONTENT_TOPIC_TIPS',
    '<ul>
	<li>Reorder, view, edit or delete any topic</li>
	<li>Display topic contents as a menu in block</li>
	<li>Show/hide topics in index and parent pages</li>
	<li>Click on a topic title to see all contents for that topic</li>
	</ul>');
    define('_FMCONTENT_CONTENT_TIPS',
    '<ul>
	<li>Reorder, view, edit or delete any content page</li>
	<li>Create content, link, section header or separator</li>
	<li>To change order of contents (which will be reflected in the Menu), simply drag and drop the contents into the desired position.</li>
	</ul>');
    define('_FMCONTENT_TOOLS_TIPS',
    '<ul>
	<li>Not yet</li>
	</ul>');
    define('_FMCONTENT_PERMISSIONS_TIPS',
    '<ul>
	<li>Access, submit and global permissions for the module</li>
	</ul>');
	define('_FMCONTENT_FILE_TIPS',
    '<ul>
	<li>Not yet</li>
	</ul>');

}
?>