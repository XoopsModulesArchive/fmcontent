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
 * News Admin page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

// Display Admin header
xoops_cp_header();
// Define default value
$op = NewsUtils::News_CleanVars($_REQUEST, 'op', '', 'string');
// Initialize content handler
$file_handler = xoops_getmodulehandler('file', 'news');
$story_handler = xoops_getmodulehandler('story', 'news');
// Define scripts
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/order.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/admin.js');
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

switch ($op)
{
    case 'new_file':
		$obj = $file_handler->create();
		$obj->getForm($NewsModule);
		break;
		
	 case 'edit_file':
        $file_id = NewsUtils::News_CleanVars($_REQUEST, 'file_id', 0, 'int');
        if ($file_id > 0) {
            $obj = $file_handler->get($file_id);
            $obj->getForm($NewsModule);
        } else {
            NewsUtils::News_Redirect('file.php', 1, _NEWS_AM_MSG_EDIT_ERROR);
        }
        break;
     
    case 'delete_file':
        $file_id = NewsUtils::News_CleanVars($_REQUEST, 'file_id', 0, 'int');
        if ($file_id > 0) {
            $file = $file_handler->get($file_id);
            // Prompt message
            NewsUtils::News_Message('backend.php', sprintf(_NEWS_AM_MSG_DELETE, '"' . $file->getVar('file_title') . '"'), $file_id, 'file');
            // Display Admin footer
            xoops_cp_footer();
        }  
     
    default:
        $file = array();
        // get module configs
        
        /*
        $file['perpage'] = xoops_getModuleOption('admin_perpage_file', $NewsModule->getVar('dirname'));
        $file['order'] = xoops_getModuleOption('admin_showorder_file', $NewsModule->getVar('dirname'));
        $file['sort'] = xoops_getModuleOption('admin_showsort_file', $NewsModule->getVar('dirname'));
        */
        
        $file['perpage'] = '10';
        $file['order'] = 'DESC';
        $file['sort'] = 'file_id';
        
        // get limited information
        if (isset($_REQUEST['limit'])) {
            $file['limit'] = NewsUtils::News_CleanVars($_REQUEST, 'limit', 0, 'int');
        } else {
            $file['limit'] = $file['perpage'];
        }

        // get start information
        if (isset($_REQUEST['start'])) {
            $file['start'] = NewsUtils::News_CleanVars($_REQUEST, 'start', 0, 'int');
        } else {
            $file['start'] = 0;
        }
        
        // get content
        if (isset($_REQUEST['content'])) {
            $file['content'] = NewsUtils::News_CleanVars($_REQUEST, 'content', 0, 'int');
            $content = $story_handler->get($file['content']);
        } else {
            $content = $story_handler->getall();
        }

        
        $files = $file_handler->News_GetAdminFiles($NewsModule, $file , $content);
        
        $file_numrows = $file_handler->News_GetFileCount($NewsModule);

        if ($file_numrows > $file['limit']) {
            $file_pagenav = new XoopsPageNav($file_numrows, $file['limit'], $file['start'], 'start', 'limit=' . $file['limit']);
            $file_pagenav = $file_pagenav->renderNav(4);
        } else {
            $file_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'file');
        $xoopsTpl->assign('navtitle', _NEWS_MI_FILE);
        $xoopsTpl->assign('files', $files);
        $xoopsTpl->assign('file_pagenav', $file_pagenav);
        $xoopsTpl->assign('xoops_dirname', $NewsModule->getVar('dirname'));
        $xoopsTpl->assign('news_tips', _NEWS_AM_FILE_TIPS);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar('dirname') . '/templates/admin/news_file.html');

        break;
}

// Display Xoops footer
include "footer.php";
xoops_cp_footer();

?> 
