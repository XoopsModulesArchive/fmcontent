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
 * news configuration file
 * Manage content page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

$modversion = array(
    // Main setting
    'name' => $modsDirname,
    'description' => _MI_NEWS_DESC,
    'version' => 1.81,
    'author' => '',
    'credits' => '',
    'license' => 'GNU GPL 2.0',
    'license_url' => 'www.gnu.org/licenses/gpl-2.0.html/',
    'image' => 'images/logo.png',
    'dirname' => $modsDirname,
    'release_date' => '2011/12/30',
    'module_website_url' => "",
    'module_website_name' => "",
    'help' => 'page=help',
    'module_status' => "Final",
    // Admin things
    'system_menu' => 1,
    'hasAdmin' => 1,
    'adminindex' => 'admin/index.php',
    'adminmenu' => 'admin/menu.php',
    // Modules scripts
    'onInstall' => 'include/functions_install.php',
    'onUpdate' => 'include/functions_update.php',
    'onUninstall' => 'include/functions_uninstall.php',
    // Main menu
    'hasMain' => 1,
    // Recherche
    'hasSearch' => 1,
    // Commentaires 
    'hasComments' => 1,
    // for module admin class
    'min_php' => '5.2',
    'min_xoops' => '2.5',
    'dirmoduleadmin' => 'Frameworks/moduleclasses',
	 'icons16' => 'Frameworks/moduleclasses/icons/16',
	 'icons32' => 'Frameworks/moduleclasses/icons/32',
     'min_db' => array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7'),
     'min_admin' => '1.1'
);

//Recherche
$modversion["search"]["file"] = "include/search.inc.php";
$modversion["search"]["func"] = "news_search";

// Comments
$modversion['comments']['pageName'] = 'article.php';
$modversion['comments']['itemName'] = 'storyid';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'news_com_approve';
$modversion['comments']['callback']['update'] = 'news_com_update';

// Templates
$modversion['templates'][] = array('file' => 'news_index.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_index_default.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_index_news.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_index_list.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_index_table.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_index_photo.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_article.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_rss.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_bookmarkme.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_header.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_topic.html', 'description' => '');
$modversion['templates'][] = array('file' => 'news_archive.html', 'description' => '');

// Menu
$modversion['sub'][] = array(
    'name' => _NEWS_MI_SUBMIT,
    'url' => 'submit.php');
$modversion['sub'][] = array(
    'name' => _NEWS_MI_TOPIC,
    'url' => 'topic.php');
$modversion['sub'][] = array(
    'name' => _NEWS_MI_ARCHIVE,
    'url' => 'archive.php');    

// Blocks
$modversion['blocks'][] = array(
    'file' => 'page.php',
    'name' => _NEWS_MI_BLOCK_PAGE,
    'description' => '',
    'show_func' => 'news_page_show',
    'edit_func' => 'news_page_edit',
    'options' => '0|' . $modversion['dirname'],
    'template' => 'news_block_page.html');

$modversion['blocks'][] = array(
    'file' => 'list.php',
    'name' => _NEWS_MI_BLOCK_LIST,
    'description' => '',
    'show_func' => 'news_list_show',
    'edit_func' => 'news_list_edit',
    'options' => $modversion['dirname'] . '|news|10|100|1|1|1|story_publish|180|left|DESC|0|'. XOOPS_URL.'|0|0',
    'template' => 'news_block_list.html');

$modversion['blocks'][] = array(
    'file' => 'topic.php',
    'name' => _NEWS_MI_BLOCK_TOPIC,
    'description' => '',
    'show_func' => 'news_topic_show',
    'edit_func' => 'news_topic_edit',
    'options' => $modversion['dirname'] . '|list|0|0|0|left|DESC|topic_id',
    'template' => 'news_block_topic.html');
    
$modversion['blocks'][] = array(
    'file' => 'slide.php',
    'name' => _NEWS_MI_BLOCK_SLIDE,
    'description' => '',
    'show_func' => 'news_slide_show',
    'edit_func' => 'news_slide_edit',
    'options' => $modversion['dirname'] . '|5|scrollable|50|200|400|200|180|180|0',
    'template' => 'news_block_slide.html');
    
$modversion['blocks'][] = array(
    'file' => 'marquee.php',
    'name' => _NEWS_MI_BLOCK_MARQUEE,
    'description' => '',
    'show_func' => 'news_marquee_show',
    'edit_func' => 'news_marquee_edit',
    'options' => $modversion['dirname'] . '|5|50|1|0',
    'template' => 'news_block_marquee.html');            
    
// Settings
// Load class
xoops_load('xoopslists');

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_GENERAL',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'form_editor',
    'title' => '_NEWS_MI_FORM_EDITOR',
    'description' => '_NEWS_MI_FORM_EDITOR_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor'),
    'default' => 'dhtmltextarea');

// Get groups
$member_handler =& xoops_gethandler('member');
$xoopsgroups = $member_handler->getGroupList();
foreach ($xoopsgroups as $key => $group) {
    $groups[$group] = $key;
}
$modversion['config'][] = array(
    'name' => 'groups',
    'title' => '_NEWS_MI_GROUPS',
    'description' => '_NEWS_MI_GROUPS_DESC',
    'formtype' => 'select_multi',
    'valuetype' => 'array',
    'options' => $groups,
    'default' => $groups);
    
// Get Admin groups
$criteria = new CriteriaCompo ();
$criteria->add ( new Criteria ( 'group_type', 'Admin' ) );
$member_handler =& xoops_gethandler('member');
$admin_xoopsgroups = $member_handler->getGroupList($criteria);
foreach ($admin_xoopsgroups as $key => $admin_group) {
    $admin_groups[$admin_group] = $key;
}
$modversion['config'][] = array(
    'name' => 'admin_groups',
    'title' => '_NEWS_MI_ADMINGROUPS',
    'description' => '_NEWS_MI_ADMINGROUPS_DESC',
    'formtype' => 'select_multi',
    'valuetype' => 'array',
    'options' => $admin_groups,
    'default' => $admin_groups);

$modversion['config'][] = array(
    'name' => 'advertisement',
    'title' => '_NEWS_MI_ADVERTISEMENT',
    'description' => '_NEWS_MI_ADVERTISEMENT_DESC',
    'formtype' => 'textarea',
    'valuetype' => 'text',
    'default' => '');

$modversion['config'][] = array(
    'name' => 'tellafriend',
    'title' => '_NEWS_MI_TELLAFRIEND',
    'description' => '_NEWS_MI_TELLAFRIEND_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => '0');

$modversion['config'][] = array(
    'name' => 'usetag',
    'title' => '_NEWS_MI_USETAG',
    'description' => '_NEWS_MI_USETAG_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0);

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_SEO',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'friendly_url',
    'title' => '_NEWS_MI_FRIENDLYURL',
    'description' => '_NEWS_MI_FRIENDLYURL_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_URL_STANDARD => 'none', _NEWS_MI_URL_REWRITE => 'rewrite' , _NEWS_MI_URL_SHORT => 'short' , _NEWS_MI_URL_ID => 'id' , _NEWS_MI_URL_TOPIC => 'topic'),
    'default' => 'none');

$modversion['config'][] = array(
    'name' => 'rewrite_mode',
    'title' => '_NEWS_MI_REWRITEBASE',
    'description' => '_NEWS_MI_REWRITEBASE_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_REWRITEBASE_MODS => '/modules/', _NEWS_MI_REWRITEBASE_ROOT => '/'),
    'default' => '/modules/');

$modversion['config'][] = array(
    'name' => 'lenght_id',
    'title' => '_NEWS_MI_LENGHTID',
    'description' => '_NEWS_MI_LENGHTID_DESC',
    'formtype' => 'select',
    'valuetype' => 'int',
    'options' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
    'default' => '1');

$modversion['config'][] = array(
    'name' => 'rewrite_name',
    'title' => '_NEWS_MI_REWRITENAME',
    'description' => '_NEWS_MI_REWRITENAME_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => $modversion['dirname']);

$modversion['config'][] = array(
    'name' => 'rewrite_ext',
    'title' => '_NEWS_MI_REWRITEEXT',
    'description' => '_NEWS_MI_REWRITEEXT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '.html');

$modversion['config'][] = array(
    'name' => 'static_name',
    'title' => '_NEWS_MI_STATICNAME',
    'description' => '_NEWS_MI_STATICNAME_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => 'static');
    
$modversion['config'][] = array(
    'name' => 'topic_name',
    'title' => '_NEWS_MI_TOPICNAME',
    'description' => '_NEWS_MI_TOPICNAME_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => 'topic');

$modversion['config'][] = array(
    'name' => 'regular_expression',
    'title' => '_NEWS_MI_REGULAR_EXPRESSION',
    'description' => '_NEWS_MI_REGULAR_EXPRESSION_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _NEWS_MI_REGULAR_EXPRESSION_CONFIG);

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_DISPLAY',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'homepage',
    'title' => '_NEWS_MI_HOMEPAGE',
    'description' => '_NEWS_MI_HOMEPAGE_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_HOMEPAGE_1 => 'type1', _NEWS_MI_HOMEPAGE_2 => 'type2', _NEWS_MI_HOMEPAGE_3 => 'type3', _NEWS_MI_HOMEPAGE_4 => 'type4'),
    'default' => 'type1');

$modversion['config'][] = array(
    'name' => 'showtype',
    'title' => '_NEWS_MI_SHOWTYPE',
    'description' => '_NEWS_MI_SHOWTYPE_DESC',
    'formtype' => 'select',
    'valuetype' => 'int',
    'options' => array(_NEWS_MI_SHOWTYPE_1 => '1', _NEWS_MI_SHOWTYPE_2 => '2', _NEWS_MI_SHOWTYPE_3 => '3', _NEWS_MI_SHOWTYPE_4 => '4'),
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_date',
    'title' => '_NEWS_MI_DISPDATE',
    'description' => '_NEWS_MI_DISPDATE_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_topic',
    'title' => '_NEWS_MI_DISPTOPIC',
    'description' => '_NEWS_MI_DISPTOPIC_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_author',
    'title' => '_NEWS_MI_DISPAUTHOR',
    'description' => '_NEWS_MI_DISPAUTHOR_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_navlink',
    'title' => '_NEWS_MI_DISPNAV',
    'description' => '_NEWS_MI_DISPNAV_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_pdflink',
    'title' => '_NEWS_MI_DISPPDF',
    'description' => '_NEWS_MI_DISPPDF_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_printlink',
    'title' => '_NEWS_MI_DISPPRINT',
    'description' => '_NEWS_MI_DISPPRINT_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_hits',
    'title' => '_NEWS_MI_DISHITS',
    'description' => '_NEWS_MI_DISHITS_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_maillink',
    'title' => '_NEWS_MI_DISPMAIL',
    'description' => '_NEWS_MI_DISPMAIL_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'disp_coms',
    'title' => '_NEWS_MI_DISPCOMS',
    'description' => '_NEWS_MI_DISPCOMS_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'perpage',
    'title' => '_NEWS_MI_PERPAGE',
    'description' => '_NEWS_MI_PERPAGE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 10);

$modversion['config'][] = array(
    'name' => 'columns',
    'title' => '_NEWS_MI_COLUMNS',
    'description' => '_NEWS_MI_COLUMNS_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'showsort',
    'title' => '_NEWS_MI_SHOWSORT',
    'description' => '_NEWS_MI_SHOWSORT_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_SHOWSORT_1 => 'story_id', _NEWS_MI_SHOWSORT_2 => 'story_publish', _NEWS_MI_SHOWSORT_3 => 'story_update', _NEWS_MI_SHOWSORT_4 => 'story_title', _NEWS_MI_SHOWSORT_5 => 'story_order', _NEWS_MI_SHOWSORT_6 => 'RAND()' , _NEWS_MI_SHOWSORT_7 => 'story_hits'),
    'default' => 'story_id');

$modversion['config'][] = array(
    'name' => 'showorder',
    'title' => '_NEWS_MI_SHOWORDER',
    'description' => '_NEWS_MI_SHOWORDER_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_DESC => 'DESC', _NEWS_MI_ASC => 'ASC'),
    'default' => 'DESC');

$modversion['config'][] = array(
    'name' => 'show_social_book',
    'title' => '_NEWS_MI_SOCIAL',
    'description' => '_NEWS_MI_SOCIAL_DESC',
    'formtype' => 'select',
    'valuetype' => 'int',
    'options' => array(_NEWS_MI_NONE => 0, _NEWS_MI_SOCIALNETWORM => 1, _NEWS_MI_BOOKMARK => 2, _NEWS_MI_BOTH => 3),
    'default' => 0);

$modversion['config'][] = array(
    'name' => 'multiple_columns',
    'title' => '_NEWS_MI_MULTIPLE_COLUMNS',
    'description' => '_NEWS_MI_MULTIPLE_COLUMNS_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_MULTIPLE_COLUMNS_1 => 'onecolumn', _NEWS_MI_MULTIPLE_COLUMNS_2 => 'twocolumn', _NEWS_MI_MULTIPLE_COLUMNS_3 => 'threecolumn', _NEWS_MI_MULTIPLE_COLUMNS_4 => 'forcolumn'),
    'default' => 'onecolumn');

$modversion['config'][] = array(
    'name' => 'alluserpost',
    'title' => '_NEWS_MI_ALLUSERPOST',
    'description' => '_NEWS_MI_ALLUSERPOST_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0);
    
$modversion['config'][] = array(
    'name' => 'related',
    'title' => '_NEWS_MI_RELATED',
    'description' => '_NEWS_MI_RELATED_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0); 
    
$modversion['config'][] = array(
    'name' => 'related_limit',
    'title' => '_NEWS_MI_RELATED_LIMIT',
    'description' => '_NEWS_MI_RELATED_LIMIT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 10);        

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_RSS',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'rss_show',
    'title' => '_NEWS_MI_RSS_SHOW',
    'description' => '_NEWS_MI_RSS_SHOW_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'rss_timecache',
    'title' => '_NEWS_MI_RSS_TIMECACHE',
    'description' => '_NEWS_MI_RSS_TIMECACHE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 60);

$modversion['config'][] = array(
    'name' => 'rss_perpage',
    'title' => '_NEWS_MI_RSS_PERPAGE',
    'description' => '_NEWS_MI_RSS_PERPAGE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 10);

$modversion['config'][] = array(
    'name' => 'rss_logo',
    'title' => '_NEWS_MI_RSS_LOGO',
    'description' => '_NEWS_MI_RSS_LOGO_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '/images/logo.png');

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_FILE',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');
    
$modversion['config'][] = array(
    'name' => 'file_dir',
    'title' => '_NEWS_MI_FILE_DIR',
    'description' => '_NEWS_MI_FILE_DIR_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => "/uploads/news/file");
 
$modversion['config'][] = array(
    'name' => 'file_size',
    'title' => '_NEWS_MI_FILE_SIZE',
    'description' => '_NEWS_MI_FILE_SIZE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '10485760');  
  
$modversion['config'][] = array(
    'name' => 'file_mime',
    'title' => '_NEWS_MI_FILE_MIME',
    'description' => '_NEWS_MI_FILE_MIME_DESC',
    'formtype' => 'textarea',
    'valuetype' => 'text',
    'default' => 'image/gif|image/jpeg|image/pjpeg|image/x-png|image/png|application/x-zip-compressed|application/zip|application/rar|application/pdf|application/x-gtar|application/x-tar|application/x-gzip|application/msword|application/vnd.ms-excel|application/vnd.ms-powerpoint|application/vnd.oasis.opendocument.text|application/vnd.oasis.opendocument.spreadsheet|application/vnd.oasis.opendocument.presentation|application/vnd.oasis.opendocument.graphics|application/vnd.oasis.opendocument.chart|application/vnd.oasis.opendocument.formula|application/vnd.oasis.opendocument.database|application/vnd.oasis.opendocument.image|application/vnd.oasis.opendocument.text-master|video/mpeg|video/quicktime|video/x-msvideo|video/x-flv|video/mp4|video/x-ms-wmv|video/quicktime|audio/mpeg');

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_IMAGE',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'img_dir',
    'title' => '_NEWS_MI_IMAGE_DIR',
    'description' => '_NEWS_MI_IMAGE_DIR_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => "/uploads/news/image");

$modversion['config'][] = array(
    'name' => 'img_size',
    'title' => '_NEWS_MI_IMAGE_SIZE',
    'description' => '_NEWS_MI_IMAGE_SIZE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '5242880');

$modversion['config'][] = array(
    'name' => 'img_maxwidth',
    'title' => '_NEWS_MI_IMAGE_MAXWIDTH',
    'description' => '_NEWS_MI_IMAGE_MAXWIDTH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '1600');

$modversion['config'][] = array(
    'name' => 'img_maxheight',
    'title' => '_NEWS_MI_IMAGE_MAXHEIGHT',
    'description' => '_NEWS_MI_IMAGE_MAXHEIGHT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '1600');
$modversion['config'][] = array(
    'name' => 'img_mediumwidth',
    'title' => '_NEWS_MI_IMAGE_MEDIUMWIDTH',
    'description' => '_NEWS_MI_IMAGE_MEDIUMWIDTH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '600');

$modversion['config'][] = array(
    'name' => 'img_mediumheight',
    'title' => '_NEWS_MI_IMAGE_MEDIUMHEIGHT',
    'description' => '_NEWS_MI_IMAGE_MEDIUMHEIGHT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '600');

$modversion['config'][] = array(
    'name' => 'img_thumbwidth',
    'title' => '_NEWS_MI_IMAGE_THUMBWIDTH',
    'description' => '_NEWS_MI_IMAGE_THUMBWIDTH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '200');

$modversion['config'][] = array(
    'name' => 'img_thumbheight',
    'title' => '_NEWS_MI_IMAGE_THUMBHEIGHT',
    'description' => '_NEWS_MI_IMAGE_THUMBHEIGHT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '200');
$modversion['config'][] = array(
    'name' => 'img_mime',
    'title' => '_NEWS_MI_IMAGE_MIME',
    'description' => '_NEWS_MI_IMAGE_MIME_DESC',
    'formtype' => 'select_multi',
    'valuetype' => 'array',
    'default' => array("image/gif", "image/jpeg", "image/png"),
    'options' => array(
        "bmp" => "image/bmp",
        "gif" => "image/gif",
        "jpeg" => "image/pjpeg",
        "jpeg" => "image/jpeg",
        "jpg" => "image/jpeg",
        "jpe" => "image/jpeg",
        "png" => "image/png"));

$modversion['config'][] = array(
    'name' => 'imgwidth',
    'title' => '_NEWS_MI_IMAGE_WIDTH',
    'description' => '_NEWS_MI_IMAGE_WIDTH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 180);

$modversion['config'][] = array(
    'name' => 'imgfloat',
    'title' => '_NEWS_MI_IMAGE_FLOAT',
    'description' => '_NEWS_MI_IMAGE_FLOAT_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_IMAGE_LEFT => 'left', _NEWS_MI_IMAGE_RIGHT => 'right'),
    'default' => 'left');

$modversion['config'][] = array(
    'name' => 'img_lightbox',
    'title' => '_NEWS_MI_IMAGE_LIGHTBOX',
    'description' => '_NEWS_MI_IMAGE_LIGHTBOX_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_PRINT',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'print_logo',
    'title' => '_NEWS_MI_PRINT_LOGO',
    'description' => '_NEWS_MI_PRINT_LOGO_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_logofloat',
    'title' => '_NEWS_MI_PRINT_LOGOFLOAT',
    'description' => '_NEWS_MI_PRINT_LOGOFLOAT_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_PRINT_LEFT => 'txtleft', _NEWS_MI_PRINT_RIGHT => 'txtright', _NEWS_MI_PRINT_CENTER => 'txtcenter'),
    'default' => 'txtcenter');

$modversion['config'][] = array(
    'name' => 'print_logourl',
    'title' => '_NEWS_MI_PRINT_LOGOURL',
    'description' => '_NEWS_MI_PRINT_LOGOURL_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '/images/logo.png');

$modversion['config'][] = array(
    'name' => 'print_title',
    'title' => '_NEWS_MI_PRINT_TITLE',
    'description' => '_NEWS_MI_PRINT_TITLE_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_img',
    'title' => '_NEWS_MI_PRINT_IMG',
    'description' => '_NEWS_MI_PRINT_IMG_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_short',
    'title' => '_NEWS_MI_PRINT_SHORT',
    'description' => '_NEWS_MI_PRINT_SHORT_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_text',
    'title' => '_NEWS_MI_PRINT_TEXT',
    'description' => '_NEWS_MI_PRINT_TEXT_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_date',
    'title' => '_NEWS_MI_PRINT_DATE',
    'description' => '_NEWS_MI_PRINT_DATE_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_author',
    'title' => '_NEWS_MI_PRINT_AUTHOR',
    'description' => '_NEWS_MI_PRINT_AUTHOR_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_link',
    'title' => '_NEWS_MI_PRINT_LINK',
    'description' => '_NEWS_MI_PRINT_LINK_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'print_columns',
    'title' => '_NEWS_MI_MULTIPLE_COLUMNS',
    'description' => '_NEWS_MI_MULTIPLE_COLUMNS_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_MULTIPLE_COLUMNS_1 => 'onecolumn', _NEWS_MI_MULTIPLE_COLUMNS_2 => 'twocolumn', _NEWS_MI_MULTIPLE_COLUMNS_3 => 'threecolumn', _NEWS_MI_MULTIPLE_COLUMNS_4 => 'forcolumn'),
    'default' => 'onecolumn');

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_BREADCRUMB',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'bc_show',
    'title' => '_NEWS_MI_BREADCRUMB_SHOW',
    'description' => '_NEWS_MI_BREADCRUMB_SHOW_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'bc_modname',
    'title' => '_NEWS_MI_BREADCRUMB_MODNAME',
    'description' => '_NEWS_MI_BREADCRUMB_MODNAME_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'bc_tohome',
    'title' => '_NEWS_MI_BREADCRUMB_TOHOME',
    'description' => '_NEWS_MI_BREADCRUMB_TOHOME_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_ADMIN',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');

$modversion['config'][] = array(
    'name' => 'admin_index_limit',
    'title' => '_NEWS_MI_ADMIN_INDEX_LIMIT',
    'description' => '_NEWS_MI_ADMIN_INDEX_LIMIT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 5);

$modversion['config'][] = array(
    'name' => 'admin_showorder',
    'title' => '_NEWS_MI_ADMIN_SHOWORDER',
    'description' => '_NEWS_MI_ADMIN_SHOWORDER_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_DESC => 'DESC', _NEWS_MI_ASC => 'ASC'),
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'admin_showsort',
    'title' => '_NEWS_MI_ADMIN_SHOWSORT',
    'description' => '_NEWS_MI_ADMIN_SHOWSORT_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_SHOWSORT_1 => 'story_id', _NEWS_MI_SHOWSORT_2 => 'story_publish', _NEWS_MI_SHOWSORT_3 => 'story_update', _NEWS_MI_SHOWSORT_4 => 'story_title', _NEWS_MI_SHOWSORT_5 => 'story_order', _NEWS_MI_SHOWSORT_6 => 'RAND()'),
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'admin_perpage',
    'title' => '_NEWS_MI_ADMIN_PERPAGE',
    'description' => '_NEWS_MI_ADMIN_PERPAGE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 50);

$modversion['config'][] = array(
    'name' => 'admin_showorder_topic',
    'title' => '_NEWS_MI_ADMIN_SHOWORDER_TOPIC',
    'description' => '_NEWS_MI_ADMIN_SHOWORDER_TOPIC_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_DESC => 'DESC', _NEWS_MI_ASC => 'ASC'),
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'admin_showsort_topic',
    'title' => '_NEWS_MI_ADMIN_SHOWSORT_TOPIC',
    'description' => '_NEWS_MI_ADMIN_SHOWSORT_TOPIC_DESC',
    'formtype' => 'select',
    'valuetype' => 'text',
    'options' => array(_NEWS_MI_ADMIN_SHOWSORT_TOPIC_1 => 'topic_id', _NEWS_MI_ADMIN_SHOWSORT_TOPIC_2 => 'topic_weight', _NEWS_MI_ADMIN_SHOWSORT_TOPIC_3 => 'topic_date_created'),
    'default' => 1);

$modversion['config'][] = array(
    'name' => 'admin_perpage_topic',
    'title' => '_NEWS_MI_ADMIN_PERPAGE_TOPIC',
    'description' => '_NEWS_MI_ADMIN_PERPAGE_TOPIC_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 10);

$modversion['config'][] = array(
    'name' => 'break',
    'title' => '_NEWS_MI_BREAK_COMNOTI',
    'description' => '',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'head');
?>