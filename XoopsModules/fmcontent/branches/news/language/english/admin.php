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
 * News language file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

if (!defined('_NEWS_AM_PREFERENCES')) {
// Global page
    define('_NEWS_AM_GLOBAL_ADD_CONTENT', 'Add Article');
    define('_NEWS_AM_GLOBAL_ADD_TOPIC', 'Add Topic');
    define('_NEWS_AM_GLOBAL_ADD_FILE', 'Add File');
    define('_NEWS_AM_GLOBAL_IMG', 'Image');
    define('_NEWS_AM_GLOBAL_FORMUPLOAD', 'Select Image');
// Index page
    define("_NEWS_AM_INDEX_ADMENU1", "Topics");
    define("_NEWS_AM_INDEX_ADMENU2", "Articles");
    define("_NEWS_AM_INDEX_TOPICS", "There are <span class='green'>%s</span> Topics in our database");
	 define("_NEWS_AM_INDEX_CONTENTS", "There are <span class='green'>%s</span> Articles in our database");
	 define("_NEWS_AM_INDEX_CONTENTS_OFFLINE", "There are <span class='red'>%s</span> Offline news in our database");
	 define("_NEWS_AM_INDEX_CONTENTS_EXPIRE", "There are <span class='red'>%s</span> Expire news in our database");
// Topic page
    define('_NEWS_AM_TOPIC_FORM', 'Manage Topic');
    define('_NEWS_AM_TOPIC_ID', 'ID');
    define('_NEWS_AM_TOPIC_NUM', 'Weight');
    define('_NEWS_AM_TOPIC_NAME', 'Title');
    define('_NEWS_AM_TOPIC_PARENT', 'Parent topic');
    define('_NEWS_AM_TOPIC_DESC', 'Description');
    define('_NEWS_AM_TOPIC_IMG', 'Image');
    define('_NEWS_AM_TOPIC_WEIGHT', 'Weight');
    define('_NEWS_AM_TOPIC_SHOWTYPE', 'Display mode');
    define('_NEWS_AM_TOPIC_SHOWTYPE_DESC', 'Articles display template for this topic<br />"Module based" will use display options defined in module preferences.');
    define('_NEWS_AM_TOPIC_PERPAGE', 'Per page');
    define('_NEWS_AM_TOPIC_COLUMNS', 'Columns');
    define('_NEWS_AM_TOPIC_ONLINE', 'Active');
    define('_NEWS_AM_TOPIC_MENU', 'Menu');
	 define('_NEWS_AM_TOPIC_SHOW', 'Show');
    define('_NEWS_AM_TOPIC_ACTION', 'Actions');
    define('_NEWS_AM_TOPIC_PID', 'Parent');
    define('_NEWS_AM_TOPIC_DATE_CREATED', 'Time created');
    define('_NEWS_AM_TOPIC_DATE_UPDATE', 'Time updated');
    define('_NEWS_AM_TOPIC_SHOWTOPIC', 'Display Topic title');
    define('_NEWS_AM_TOPIC_SHOWAUTHOR', 'Display Author');
    define('_NEWS_AM_TOPIC_SHOWDATE', 'Display Date');
    define('_NEWS_AM_TOPIC_SHOWDPF', 'Display PDF Icon');
    define('_NEWS_AM_TOPIC_SHOWPRINT', 'Display Print Icon');
    define('_NEWS_AM_TOPIC_SHOWMAIL', 'Display Mail Icon');
    define('_NEWS_AM_TOPIC_SHOWNAV', 'Display Prev/Next navigation');
    define('_NEWS_AM_TOPIC_SHOWHITS', 'Display Hits');
    define('_NEWS_AM_TOPIC_SHOWCOMS', 'Display Comments count');
    define('_NEWS_AM_TOPIC_HOMEPAGE', 'Topic homepage seting');
    define('_NEWS_AM_TOPIC_HOMEPAGE_DESC', 'Seting article show type in topic pages');
    define('_NEWS_AM_TOPIC_HOMEPAGE_1', 'List all articles from this topic and subtopics');
    define('_NEWS_AM_TOPIC_HOMEPAGE_2', 'List all subtopics');
    define('_NEWS_AM_TOPIC_HOMEPAGE_3', 'List all articles from just this topic');
    define('_NEWS_AM_TOPIC_HOMEPAGE_4', 'Show selected article from this topic');
    define('_NEWS_AM_TOPIC_OPTIONS', 'Sellect topic show options');
    define('_NEWS_AM_TOPIC_OPTIONS_DESC', 'Sellect topic show options');
    define('_NEWS_AM_TOPIC_ALIAS', 'Alias (for url)');
    define('_NEWS_AM_TOPIC_SHOWTYPE_0', 'Module based');
    define('_NEWS_AM_TOPIC_SHOWTYPE_1', 'News type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_2', 'Table type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_3', 'Photo type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_4', 'List type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_5', 'Spotlight');
// Content page
    define('_NEWS_AM_CONTENT_FORM', 'Manage Article');
    define('_NEWS_AM_CONTENT_FORMTITLE', 'Title');
    define('_NEWS_AM_CONTENT_FORMTITLE_DISP', 'Display page title?');
    define('_NEWS_AM_CONTENT_FORMAUTHOR', 'Source (Name)');
    define('_NEWS_AM_CONTENT_FORMSOURCE', 'Source (URL)');
    define('_NEWS_AM_CONTENT_FORMTEXT', 'Text');
    define('_NEWS_AM_CONTENT_FORMTEXT_DESC', 'Main content of the page');
    define('_NEWS_AM_CONTENT_FORMGROUP', 'Groups');
    define('_NEWS_AM_CONTENT_FORMALIAS', 'Alias (for url)');
    define('_NEWS_AM_CONTENT_FORMACTIF', 'Online');
    define('_NEWS_AM_CONTENT_IMPORTANT', 'Important');
    define('_NEWS_AM_CONTENT_FORMDEFAULT', 'Default');
    define('_NEWS_AM_CONTENT_FORMPREV', 'Previous link');
    define('_NEWS_AM_CONTENT_FORMNEXT', 'Next link');
    define('_NEWS_AM_CONTENT_DOHTML', 'Allow HTML code');
    define('_NEWS_AM_CONTENT_BREAKS', 'Convert line breaks');
    define('_NEWS_AM_CONTENT_DOIMAGE', 'Allow Images');
    define('_NEWS_AM_CONTENT_DOXCODE', 'Allow BBcode');
    define('_NEWS_AM_CONTENT_DOSMILEY', 'Allow Smilies');
    define('_NEWS_AM_CONTENT_SHORT', 'Short text');
    define('_NEWS_AM_CONTENT_TITLE', 'Title');
    define('_NEWS_AM_CONTENT_MANAGER', 'Article manager');
    define('_NEWS_AM_CONTENT_FILE', 'File');
    define('_NEWS_AM_CONTENT_ID', 'ID');
    define('_NEWS_AM_CONTENT_NUM', 'Weight');
    define('_NEWS_AM_CONTENT_PAGE', 'Page');
    define('_NEWS_AM_CONTENT_TYPE', 'Type');
    define('_NEWS_AM_CONTENT_OWNER', 'Owner');
    define('_NEWS_AM_CONTENT_ACTIF', 'Active');
    define('_NEWS_AM_CONTENT_DEFAULT', 'Default');
    define('_NEWS_AM_CONTENT_ORDER', 'Order');
    define('_NEWS_AM_CONTENT_ACTION', 'Actions');
    define('_NEWS_AM_CONTENT_VIEW', 'View');
    define('_NEWS_AM_CONTENT_EDIT', 'Edit');
    define('_NEWS_AM_CONTENT_DELETE', 'Delete');
    define('_NEWS_AM_CONTENT_SHORTDESC', 'Short Desc');
    define('_NEWS_AM_CONTENT_TOPIC', 'Topic');
    define('_NEWS_AM_CONTENT_TOPIC_DESC', 'Empty selection will set the article as a Static Page');
    define('_NEWS_AM_CONTENT_STATIC', 'Static page');
    define('_NEWS_AM_CONTENT_STATICS', 'Static pages');
    define('_NEWS_AM_CONTENT_ALL_ITEMS', 'All article/item list');
    define('_NEWS_AM_CONTENT_ALL_ITEMS_FROM', 'Item list filtered by: ');
    define('_NEWS_AM_CONTENT_FILE_DESC', 'For add more files you must use admin file system in admin side');
    define('_NEWS_AM_CONTENT_SUBTITLE', 'Subtitle');
    define('_NEWS_AM_CONTENT_ALL', 'All News');
    define('_NEWS_AM_CONTENT_OFFLINE', 'Offline news');
    define('_NEWS_AM_CONTENT_EXPIRE', 'Expire news');
    define('_NEWS_AM_CONTENT_PEDATE', 'Set publish and expiration date');
    define('_NEWS_AM_CONTENT_SETDATETIME', 'Set the date/time of publish');
    define('_NEWS_AM_CONTENT_SETEXPDATETIME', 'Set the date/time of expiration');
    define('_NEWS_AM_CONTENT_SLIDE', 'Set as slide');
    define('_NEWS_AM_CONTENT_MARQUE', 'Set sd margue');
// Tools page
    define('_NEWS_AM_TOOLS_FORMFOLDER_TITLE', 'Clone module');
    define('_NEWS_AM_TOOLS_FORMFOLDER_NAME', 'Folder name');
    define('_NEWS_AM_TOOLS_LOG_TITLE', 'Clone module log');
    define('_NEWS_AM_TOOLS_FORMPURGE_TITLE', 'Purge page of deleted clone');
    define('_NEWS_AM_TOOLS_ALIAS_TITLE', 'Rebuild Alias');
    define('_NEWS_AM_TOOLS_ALIAS_CONTENT', 'Rebuild article alias');
    define('_NEWS_AM_TOOLS_ALIAS_TOPIC', 'Rebuild topic alias');
    define('_NEWS_AM_TOOLS_META_TITLE', 'Rebuild Metas');
    define('_NEWS_AM_TOOLS_META_KEYWORD', 'Rebuild Meta keywords');
    define('_NEWS_AM_TOOLS_META_DESCRIPTION', 'Rebuild Meta Description');
    define('_NEWS_AM_TOOLS_PRUNE', 'Prune news');
    define('_NEWS_AM_TOOLS_PRUNE_BEFORE', 'Prune stories that were published before');
    define('_NEWS_AM_TOOLS_PRUNE_EXPIREDONLY', 'Only remove stories who have expired');
    define('_NEWS_AM_TOOLS_PRUNE_TOPICS', 'Limit to the following topics');
    define('_NEWS_AM_TOOLS_PRUNE_EXPORT_DSC', 'If you dont check anything then all the topics will be used else only the selected topics will be used');
// Permissions
    define('_NEWS_AM_PERMISSIONS_ACCESS', 'Access permissions');
    define('_NEWS_AM_PERMISSIONS_SUBMIT', 'Submit permissions');
    define('_NEWS_AM_PERMISSIONS_GLOBAL', 'Global permissions');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_4', 'Rate');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_8', 'Submit from user side');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_16', 'Auto approve');
// Attach files
	 define('_NEWS_AM_FILE', 'File');
    define('_NEWS_AM_FILE_ID', 'ID');
	 define('_NEWS_AM_FILE_ONLINE', 'Online');
	 define('_NEWS_AM_FILE_ACTION', 'Action');
    define('_NEWS_AM_FILE_FORM', 'Attach file');
	 define('_NEWS_AM_FILE_TITLE', 'Title');
	 define('_NEWS_AM_FILE_CONTENT', 'File Article');
	 define('_NEWS_AM_FILE_STATUS', 'Active');
	 define('_NEWS_AM_FILE_SELECT', 'Select your file');
	 define('_NEWS_AM_FILE_TYPE', 'Type');
// Admin message
    define('_NEWS_AM_MSG_DBUPDATE', 'Database updated successfully!');
    define('_NEWS_AM_MSG_ERRORDELETE', 'You cannot delete this article! <br />Please move or delete all child of this article');
    define('_NEWS_AM_MSG_WAIT', 'Please wait...');
    define('_NEWS_AM_MSG_DELETE', 'Are you sure you would like to delete: %s ?');
    define('_NEWS_AM_MSG_EDIT_ERROR', 'Could not find page or invalid page id!');
    define('_NEWS_AM_MSG_UPDATE_ERROR', 'Could not update database! Update article error');
    define('_NEWS_AM_MSG_INSERT_ERROR', 'Could not update database! Insert article error ');
    define('_NEWS_AM_MSG_CLONE_ERROR', 'This folder already exists !');
    define('_NEWS_AM_MSG_NOPERMSSET', 'Permission cannot be set: No Topics created yet! Please create a Topic first.');
	 define('_NEWS_AM_MSG_ALIASERROR', 'Your selected Alias is already taken. Please change it and try again');
	 define('_NEWS_AM_MSG_INPROC', 'Rebuilding ... ');
	 define('_NEWS_AM_MSG_PRUNE_DELETED', '%s Articles deleted');
// about	
    define('_NEWS_AM_ABOUT_ADMIN', 'About');
    define('_NEWS_AM_ABOUT_DESCRIPTION', 'Description:');
    define('_NEWS_AM_ABOUT_AUTHOR', 'Author:');
    define('_NEWS_AM_ABOUT_CREDITS', 'Credits:');
    define('_NEWS_AM_ABOUT_LICENSE', 'License:');
    define('_NEWS_AM_ABOUT_MODULE_INFO', 'Module Info:');
    define('_NEWS_AM_ABOUT_RELEASEDATE', 'Released:');
    define("_NEWS_AM_ABOUT_UPDATEDATE", "Updated: ");
    define('_NEWS_AM_ABOUT_MODULE_STATUS', 'Status:');
    define('_NEWS_AM_ABOUT_WEBSITE', 'Website:');
    define('_NEWS_AM_ABOUT_AUTHOR_INFO', 'Author Info');
    define('_NEWS_AM_ABOUT_AUTHOR_NAME', 'Name:');
    define('_NEWS_AM_ABOUT_CHANGELOG', 'Changelog');
}
?>