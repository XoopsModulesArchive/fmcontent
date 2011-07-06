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

if (!defined('_MI_FMCONTENT_NAME')) {
    // Module info
    define('_MI_FMCONTENT_NAME', 'fmContent');
    define('_MI_FMCONTENT_DESC', 'Manage page content');
// Menu
    define('_FMCONTENT_HOME', 'Home');
    define('_FMCONTENT_TOPIC', 'Topic');
    define('_FMCONTENT_CONTENT', 'Content');
    define('_FMCONTENT_PERM', 'Permissions');
    define('_FMCONTENT_TOOLS', 'Tools');
    define('_FMCONTENT_ABOUT', 'About');
    define('_FMCONTENT_HELP', 'Help');
    define('_FMCONTENT_SUBMIT', 'Submit');
// Block
    define('_FMCONTENT_MENU', 'Content menu');
    define('_FMCONTENT_PAGE', 'Content page');
    define('_FMCONTENT_LIST', 'Content list');
// Editor
    define("_FMCONTENT_FORM_EDITOR", "Form Option");
    define("_FMCONTENT_FORM_EDITOR_DESC", "Select the editor to use for editing your content.");
// Urls
    define('_FMCONTENT_FRIENDLYURL', 'URL rewrite method');
    define('_FMCONTENT_FRIENDLYURL_DESC', 'Select the URL rewrite mode you want to use.<ul>
    <li>"Standard Mode": Module standard URL</li>
    <li>"Rewrite Mode": you must use .htaccess file and edit .htaccess sample code if you change SEO / URL Rewrite options</li>
    <li>"Short Rewrite": you can make URL whit out page id and module use alias for get page info. you must edit .htaccess, you can remove module name and Url extension and use Root base for have short URL</li></ul>');
    define('_FMCONTENT_URL_STANDARD', 'Standard Mode');
    define('_FMCONTENT_URL_REWRITE', 'Rewrite Mode');
    define('_FMCONTENT_URL_SHORT', 'Short Rewrite');
// Rewrite Mode
    define('_FMCONTENT_REWRITEBASE', 'Rewrite Mode: .htaccess file position');
    define('_FMCONTENT_REWRITEBASE_DESC', '
      "Module": .htaccess file must be in the module directory.<br />
      "Root": .htaccess file must be in your XOOPS root directory.');
    define('_FMCONTENT_REWRITEBASE_MODS', 'Module');
    define('_FMCONTENT_REWRITEBASE_ROOT', 'Root');
// Rewrite Name
    define('_FMCONTENT_REWRITENAME', 'Rewrite mode: module name');
    define('_FMCONTENT_REWRITENAME_DESC', 'Define the module name used in rewritten urls.<br />If you change this value, you must edit the .htaccess file');
// Rewrite Extension
    define('_FMCONTENT_REWRITEEXT', 'Rewrite mode: Url extension');
    define('_FMCONTENT_REWRITEEXT_DESC', 'Define extension of rewritten url (typically .html)<br />If you change/remove this value, you must edit the .htaccess file ');
// static name
    define('_FMCONTENT_STATICNAME', 'Rewrite mode: static pages topic');
    define('_FMCONTENT_STATICNAME_DESC', 'Topic name of static page in rewritten URL');
// Lenght Id
    define('_FMCONTENT_LENGHTID', 'Rewrite mode:: length for page ID');
    define('_FMCONTENT_LENGHTID_DESC', 'Number of digit used in url for page ID');
// Group Access
    define('_FMCONTENT_GROUPS', 'Groups access');
    define('_FMCONTENT_GROUPS_DESC', 'Select general access permission for groups.');
//Advertisement 
    define('_FMCONTENT_ADVERTISEMENT', 'Advertisement');
    define('_FMCONTENT_ADVERTISEMENT_DESC', 'Enter text or html/Javascript code for your contents');
// Edit in place
    define('_FMCONTENT_EDITINPLACE', 'Use edit in place?');
    define('_FMCONTENT_EDITINPLACE_DESC', 'Allow inline edits of your contents');
// Tell a friend
    define('_FMCONTENT_TELLAFRIEND', 'Use module Tell a friend?');
    define('_FMCONTENT_TELLAFRIEND_DESC', '');
// Tell a friend
    define('_FMCONTENT_USETAG', 'Use TAG module to generate tags');
    define('_FMCONTENT_USETAG_DESC', 'You have to install TAG module for this option to work');
// minimum length of single words
    define('_FMCONTENT_MINWORDLENGHT', 'Meta Keywords lenght');
    define('_FMCONTENT_MINWORDLENGHT_DESC', 'Choose the minimum length of single words');
// minimum length of single words
    define('_FMCONTENT_MINWORDOCCUR', 'Meta Keywords occur');
    define('_FMCONTENT_MINWORDOCCUR_DESC', 'Choose the minimum occurrence of single words');
// Show options
    define('_FMCONTENT_DISP_OPTION', 'General display method');
    define('_FMCONTENT_DISP_OPTION_DESC', 'Select which display options will be used in contents<br />"Topic based" will use display options defined in topic preferences');
    define('_FMCONTENT_DISP_OPTION_MODULE', 'Module based');
    define('_FMCONTENT_DISP_OPTION_TOPIC', 'Topic based');
// Title
    define('_FMCONTENT_DISPTITLE', 'Display Title');
    define('_FMCONTENT_DISPTITLE_DESC', '');
// Topic
    define('_FMCONTENT_DISPTOPIC', 'Display Topic title');
    define('_FMCONTENT_DISPTOPIC_DESC', '');
// Date
    define('_FMCONTENT_DISPDATE', 'Display Date');
    define('_FMCONTENT_DISPDATE_DESC', '');
// Author
    define('_FMCONTENT_DISPAUTHOR', 'Display Author');
    define('_FMCONTENT_DISPAUTHOR_DESC', '');
// Navigation Link
    define('_FMCONTENT_DISPNAV', 'Display Prev/Next navigation');
    define('_FMCONTENT_DISPNAV_DESC', '');
// PDF Link
    define('_FMCONTENT_DISPPDF', 'Display PDF Icon');
    define('_FMCONTENT_DISPPDF_DESC', '');
// Print Link
    define('_FMCONTENT_DISPPRINT', 'Display Print Icon');
    define('_FMCONTENT_DISPPRINT_DESC', '');
// Hits Link
    define('_FMCONTENT_DISHITS', 'Display Hits');
    define('_FMCONTENT_DISHITS_DESC', '');
// Mail Link
    define('_FMCONTENT_DISPMAIL', 'Display Mail Icon');
    define('_FMCONTENT_DISPMAIL_DESC', '');
// Comments
    define('_FMCONTENT_DISPCOMS', 'Display Comments count');
    define('_FMCONTENT_DISPCOMS_DESC', '');
// Per page
    define('_FMCONTENT_PERPAGE', 'Per page contents');
    define('_FMCONTENT_PERPAGE_DESC', 'Number of contents listed in topic/index page');
// Columns
    define('_FMCONTENT_COLUMNS', 'Columns');
    define('_FMCONTENT_COLUMNS_DESC', 'Number of Columns in each page');
// Show type
    define('_FMCONTENT_SHOWTYPE', 'Display mode');
    define('_FMCONTENT_SHOWTYPE_DESC', 'Display template for contents listed in topic/index page');
    define('_FMCONTENT_SHOWTYPE_0', 'Module based');
    define('_FMCONTENT_SHOWTYPE_1', 'News type');
    define('_FMCONTENT_SHOWTYPE_2', 'Table type');
    define('_FMCONTENT_SHOWTYPE_3', 'Photo type');
    define('_FMCONTENT_SHOWTYPE_4', 'List type');
//Template
    define('_FMCONTENT_TEMPLATE', 'Template');
    define('_FMCONTENT_TEMPLATE_DESC', 'Set general template for the module');
    define('_FMCONTENT_TEMPLATE_1', 'Legacy');
    define('_FMCONTENT_TEMPLATE_2', 'jQuery UI');
    define('_FMCONTENT_TEMPLATE_3', 'HTML 5');
// Show order
    define('_FMCONTENT_SHOWORDER', 'Display order');
    define('_FMCONTENT_SHOWORDER_DESC', 'Select Descendant/Ascendant order');
    define('_FMCONTENT_DESC', 'DESC');
    define('_FMCONTENT_ASC', 'ASC');
// Show sort
    define('_FMCONTENT_SHOWSORT', 'Sort by');
    define('_FMCONTENT_SHOWSORT_DESC', 'Ordering method for contents displayed in the module');
    define('_FMCONTENT_SHOWSORT_1', 'Content id');
    define('_FMCONTENT_SHOWSORT_2', 'Content create');
    define('_FMCONTENT_SHOWSORT_3', 'Content update');
    define('_FMCONTENT_SHOWSORT_4', 'Content title');
    define('_FMCONTENT_SHOWSORT_5', 'Admin Content page order');
    define('_FMCONTENT_SHOWSORT_6', 'Random order');
// Admin page
    define('_FMCONTENT_ADMIN_PERPAGE', 'Admin Content page items number');
    define('_FMCONTENT_ADMIN_PERPAGE_DESC', 'Number of items listed in admin Content page');
// Admin Show order
    define('_FMCONTENT_ADMIN_SHOWORDER', 'Admin Content page display order');
    define('_FMCONTENT_ADMIN_SHOWORDER_DESC', 'Select Descendant/Ascendant order for admin Content page');
// Admin sort
    define('_FMCONTENT_ADMIN_SHOWSORT', 'Admin Content page sort');
    define('_FMCONTENT_ADMIN_SHOWSORT_DESC', 'Ordering method for items listed in admin Content page<br />Any option except "Admin content order" will modify all manual sort of content page at each reload.');
// Admin topic page
    define('_FMCONTENT_ADMIN_PERPAGE_TOPIC', 'Admin Topic page items number');
    define('_FMCONTENT_ADMIN_PERPAGE_TOPIC_DESC', 'Number of items listed in admin Topic page');
// Admin topic Show order
    define('_FMCONTENT_ADMIN_SHOWORDER_TOPIC', 'Admin Topic page display order');
    define('_FMCONTENT_ADMIN_SHOWORDER_TOPIC_DESC', 'Select Descendant/Ascendant order for admin Topic page');
    define('_FMCONTENT_ADMIN_SHOWSORT_TOPIC_1', 'Topic ID');
    define('_FMCONTENT_ADMIN_SHOWSORT_TOPIC_2', 'Topic weight');
    define('_FMCONTENT_ADMIN_SHOWSORT_TOPIC_3', 'Topic creation date');
// Admin topic sort
    define('_FMCONTENT_ADMIN_SHOWSORT_TOPIC', 'Admin Topic page sort');
    define('_FMCONTENT_ADMIN_SHOWSORT_TOPIC_DESC', 'Ordering method for items listed in admin Topic page');
// Admin index limit
    define('_FMCONTENT_ADMIN_INDEX_LIMIT', 'Items in Admin index');
    define('_FMCONTENT_ADMIN_INDEX_LIMIT_DESC', 'Number of items in admin index page');
//rss
    define('_FMCONTENT_RSS_SHOW', 'Show RSS icon');
    define('_FMCONTENT_RSS_SHOW_DESC', 'Display/hide RSS icon in module');
    define('_FMCONTENT_RSS_TIMECACHE', 'RSS cache time');
    define('_FMCONTENT_RSS_TIMECACHE_DESC', 'Cache time for RSS pages in minutes');
    define('_FMCONTENT_RSS_PERPAGE', 'RSS number');
    define('_FMCONTENT_RSS_PERPAGE_DESC', 'Select number of items in RSS page');
    define('_FMCONTENT_RSS_LOGO', 'RSS logo URL');
    define('_FMCONTENT_RSS_LOGO_DESC', 'Path for site logo displayed in RSS pages (relative to Xoops root directory)');
// Print    
    define('_FMCONTENT_PRINT_LOGO', 'Display site title');
    define('_FMCONTENT_PRINT_LOGO_DESC', 'Show/hide site title in print page');
    define('_FMCONTENT_PRINT_LOGOFLOAT', 'Print logo align');
    define('_FMCONTENT_PRINT_LOGOFLOAT_DESC', 'Select left or right or center position for print logo');
    define('_FMCONTENT_PRINT_LEFT', 'Left');
    define('_FMCONTENT_PRINT_RIGHT', 'Right');
    define('_FMCONTENT_PRINT_CENTER', 'Center');
    define('_FMCONTENT_PRINT_LOGOURL', 'Print logo URL');
    define('_FMCONTENT_PRINT_LOGOURL_DESC', 'Path for site logo displayed in print page (relative to Xoops root directory)');
    define('_FMCONTENT_PRINT_TITLE', 'Display Title');
    define('_FMCONTENT_PRINT_TITLE_DESC', '');
    define('_FMCONTENT_PRINT_IMG', 'Display Image');
    define('_FMCONTENT_PRINT_IMG_DESC', '');
    define('_FMCONTENT_PRINT_SHORT', 'Display short text');
    define('_FMCONTENT_PRINT_SHORT_DESC', '');
    define('_FMCONTENT_PRINT_TEXT', 'Display main text');
    define('_FMCONTENT_PRINT_TEXT_DESC', '');
    define('_FMCONTENT_PRINT_DATE', 'Display date');
    define('_FMCONTENT_PRINT_DATE_DESC', '');
    define('_FMCONTENT_PRINT_AUTHOR', 'Display author');
    define('_FMCONTENT_PRINT_AUTHOR_DESC', '');
    define('_FMCONTENT_PRINT_LINK', 'Display page URL');
    define('_FMCONTENT_PRINT_LINK_DESC', '');
//img
    define('_FMCONTENT_IMAGE_DIR', 'Image upload path');
    define('_FMCONTENT_IMAGE_DIR_DESC', 'Upload path for images attached to content');
    define('_FMCONTENT_IMAGE_SIZE', 'Image file size (in bytes)');
    define('_FMCONTENT_IMAGE_SIZE_DESC', 'Max allowed size for image file (1048576 bytes = 1 MegaByte)');
    define('_FMCONTENT_IMAGE_MAXWIDTH', 'Image max width (pixel)');
    define('_FMCONTENT_IMAGE_MAXWIDTH_DESC', 'Max allowed width for image upload');
    define('_FMCONTENT_IMAGE_MAXHEIGHT', 'Image max height (pixel)');
    define('_FMCONTENT_IMAGE_MAXHEIGHT_DESC', 'Max allowed height for image upload');
    define('_FMCONTENT_IMAGE_MIME', 'Image mime types');
    define('_FMCONTENT_IMAGE_MIME_DESC', 'Allowed myme-types for image upload');
    define('_FMCONTENT_IMAGE_WIDTH', 'Content list max image width (pixel)');
    define('_FMCONTENT_IMAGE_WIDTH_DESC', 'Max allowed width for images in content listed in index/topic pages<br /> A max width/height for images in content pages is set in /css/style.css');
    define('_FMCONTENT_IMAGE_FLOAT', 'Image align');
    define('_FMCONTENT_IMAGE_FLOAT_DESC', 'Select left or right position for images attached to content');
    define('_FMCONTENT_IMAGE_LEFT', 'Left');
    define('_FMCONTENT_IMAGE_RIGHT', 'Right');
    define('_FMCONTENT_IMAGE_LIGHTBOX', 'Use lightbox');
    define('_FMCONTENT_IMAGE_LIGHTBOX_DESC', 'Use lightbox effect to display images at original size');
//social
    define('_FMCONTENT_SOCIAL', 'Display Bookmark/Social links');
    define('_FMCONTENT_SOCIAL_DESC', 'You can display Social network and bookmark icons in each content');
    define('_FMCONTENT_BOOKMARK', 'Bookmark');
    define('_FMCONTENT_SOCIALNETWORM', 'Social Networks');
    define('_FMCONTENT_NONE', 'None');
    define('_FMCONTENT_BOTH', 'Both');
//Multiple Columns 
    define('_FMCONTENT_MULTIPLE_COLUMNS', 'Multiple Columns');
    define('_FMCONTENT_MULTIPLE_COLUMNS_DESC', 'Select number of columns used for displaying contents<br />This option works only in content page and for content in <b>Text</b> field');
    define('_FMCONTENT_MULTIPLE_COLUMNS_1', 'One Column');
    define('_FMCONTENT_MULTIPLE_COLUMNS_2', 'Two Columns');
    define('_FMCONTENT_MULTIPLE_COLUMNS_3', 'Three Columns');
    define('_FMCONTENT_MULTIPLE_COLUMNS_4', 'Four Columns');
// All user posts
    define('_FMCONTENT_ALLUSERPOST', 'Display "All user posts" link');
    define('_FMCONTENT_ALLUSERPOST_DESC', 'Show/Hide all user posts link in each content');
// regular expression
    define('_FMCONTENT_REGULAR_EXPRESSION', 'Auto Alias URL pattern');
    define('_FMCONTENT_REGULAR_EXPRESSION_DESC', 'Regular Expression for generating auto Alias URL pattern. <br />If you your language is not supported in Alias URL you can add appopriate regular expression here. Default setting is : <b>`[^a-z0-9]`i</b>');
    define('_FMCONTENT_REGULAR_EXPRESSION_CONFIG', '`[^a-z0-9]`i');
// Breadcrumb
    define('_FMCONTENT_BREADCRUMB_SHOW', 'Display Breadcrumb');
    define('_FMCONTENT_BREADCRUMB_MODNAME', 'Display Module name');
    define('_FMCONTENT_BREADCRUMB_TOHOME', 'Display Homepage link');
// break 
    define('_FMCONTENT_BREAK_GENERAL', 'General');
    define('_FMCONTENT_BREAK_SEO', 'SEO / URL Rewrite');
    define('_FMCONTENT_BREAK_DISPLAY', 'Display');
    define('_FMCONTENT_BREAK_RSS', 'RSS');
    define('_FMCONTENT_BREAK_IMAGE', 'Image');
    define('_FMCONTENT_BREAK_ADMIN', 'Admin');
    define('_FMCONTENT_BREAK_PRINT', 'Print');
    define('_FMCONTENT_BREAK_BREADCRUMB', 'Breadcrumb');
    define('_FMCONTENT_BREAK_COMNOTI', 'Comments and notifications');
// about	
    define('_FMCONTENT_ADMIN_ABOUT', 'About');
    define('_FMCONTENT_ABOUT_DESCRIPTION', 'Description:');
    define('_FMCONTENT_ABOUT_AUTHOR', 'Author:');
    define('_FMCONTENT_ABOUT_CREDITS', 'Credits:');
    define('_FMCONTENT_ABOUT_LICENSE', 'License:');
    define('_FMCONTENT_ABOUT_MODULE_INFO', 'Module Info:');
    define('_FMCONTENT_ABOUT_RELEASEDATE', 'Released:');
    define("_FMCONTENT_ABOUT_UPDATEDATE", "Updated: ");
    define('_FMCONTENT_ABOUT_MODULE_STATUS', 'Status:');
    define('_FMCONTENT_ABOUT_WEBSITE', 'Website:');
    define('_FMCONTENT_ABOUT_AUTHOR_INFO', 'Author Info');
    define('_FMCONTENT_ABOUT_AUTHOR_NAME', 'Name:');
    define('_FMCONTENT_ABOUT_CHANGELOG', 'Changelog');
//install/action
    define('_FMCONTENT_SQL_FOUND', 'SQL Database found');
    define('_FMCONTENT_CREATE_TABLES', 'Create Tables');
    define('_FMCONTENT_TABLE_CREATED', 'Table Created');
    define('_FMCONTENT_TABLE_RESERVED', 'Table reserved');
    define('_FMCONTENT_SQL_NOT_FOUND', 'SQL Database not found');
    define('_FMCONTENT_SQL_NOT_VALID', 'SQL Database not valid');
    define('_FMCONTENT_INSERT_DATA', 'Inserting data');
    
// homepage   
    define('_FMCONTENT_HOMEPAGE', 'Homepage seting');
    define('_FMCONTENT_HOMEPAGE_DESC', 'Seting content show type in module index page');
    define('_FMCONTENT_HOMEPAGE_1', 'List all contents from all topics');
    define('_FMCONTENT_HOMEPAGE_2', 'List all topics');
    define('_FMCONTENT_HOMEPAGE_3', 'List all static pages');
    define('_FMCONTENT_HOMEPAGE_4', 'Show selected static content');
}
?>