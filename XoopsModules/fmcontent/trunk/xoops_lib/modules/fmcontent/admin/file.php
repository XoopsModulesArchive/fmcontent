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
 * FmContent Admin page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

if (!isset($forMods)) exit('Module not found');
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

// Display Admin header
xoops_cp_header();
// Define default value
$op = fmcontent_CleanVars($_REQUEST, 'op', '', 'string');
// Initialize content handler
$file_handler = xoops_getmodulehandler('file', 'fmcontent');
$content_handler = xoops_getmodulehandler('page', 'fmcontent');
// Define scripts
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
$xoTheme->addScript('browse.php?modules/' . $forMods->getVar('dirname') . '/js/order.js');
$xoTheme->addScript('browse.php?modules/' . $forMods->getVar('dirname') . '/js/admin.js');
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

switch ($op)
{
    case 'new_file':
		$obj = $file_handler->create();
		$obj->getForm($forMods);
		break;
		
	 case 'edit_file':
        $file_id = fmcontent_CleanVars($_REQUEST, 'file_id', 0, 'int');
        if ($file_id > 0) {
            $obj = $file_handler->get($file_id);
            $obj->getForm($forMods);
        } else {
            fmcontent_Redirect('file.php', 1, _FMCONTENT_MSG_EDIT_ERROR);
        }
        break;
     
    case 'delete_file':
        $file_id = fmcontent_CleanVars($_REQUEST, 'file_id', 0, 'int');
        if ($file_id > 0) {
            $file = $file_handler->get($file_id);
            // Prompt message
            fmcontent_Message('backend.php', sprintf(_FMCONTENT_MSG_DELETE, '"' . $file->getVar('file_title') . '"'), $file_id, 'file');
            // Display Admin footer
            xoops_cp_footer();
        }  
     
    default:
        $file = array();
        // get module configs
        
        /*
        $file['perpage'] = xoops_getModuleOption('admin_perpage_file', $forMods->getVar('dirname'));
        $file['order'] = xoops_getModuleOption('admin_showorder_file', $forMods->getVar('dirname'));
        $file['sort'] = xoops_getModuleOption('admin_showsort_file', $forMods->getVar('dirname'));
        */
        
        $file['perpage'] = '10';
        $file['order'] = 'DESC';
        $file['sort'] = 'file_id';
        
        // get limited information
        if (isset($_REQUEST['limit'])) {
            $file['limit'] = fmcontent_CleanVars($_REQUEST, 'limit', 0, 'int');
        } else {
            $file['limit'] = $file['perpage'];
        }

        // get start information
        if (isset($_REQUEST['start'])) {
            $file['start'] = fmcontent_CleanVars($_REQUEST, 'start', 0, 'int');
        } else {
            $file['start'] = 0;
        }

        $content = $content_handler->getfile($forMods);
        $files = $file_handler->getFiles($forMods, $file , $content);
        
        $file_numrows = $file_handler->getFileCount($forMods);

        if ($file_numrows > $file['limit']) {
            $file_pagenav = new XoopsPageNav($file_numrows, $file['limit'], $file['start'], 'start', 'limit=' . $file['limit']);
            $file_pagenav = $file_pagenav->renderNav(4);
        } else {
            $file_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'file');
        $xoopsTpl->assign('navtitle', _FMCONTENT_FILE);
        $xoopsTpl->assign('files', $files);
        $xoopsTpl->assign('file_pagenav', $file_pagenav);
        $xoopsTpl->assign('xoops_dirname', $forMods->getVar('dirname'));
        $xoopsTpl->assign('fmcontent_tips', _FMCONTENT_FILE_TIPS);

        // Call template file
        echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/fmcontent_file.html');

        break;
}

// Display Xoops footer
include "footer.php";
xoops_cp_footer();

?> 
