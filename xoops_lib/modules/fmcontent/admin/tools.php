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
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id:$
 */

if (!isset($forMods)) exit('Module not found');

// Display Admin header
xoops_cp_header();
// Define default value
$op = fmcontent_CleanVars($_REQUEST, 'op', 'display', 'string');

// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

switch ($op) {

    case 'display':
    default:
        $form = new XoopsThemeForm(_FMCONTENT_FORMFOLDER_TITLE, 'tools', 'tools.php', 'post');
        $form->addElement(new XoopsFormText(_FMCONTENT_FORMFOLDER_NAME, 'folder_name', 50, 255, ''), true);
        $form->addElement(new XoopsFormHidden('op', 'clone'));
        $button_tray = new XoopsFormElementTray('', '');
        $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
        $button_tray->addElement($submit_btn);
        $form->addElement($button_tray);
        $xoopsTpl->assign('folder', $form->render());

        $module_handler = xoops_gethandler('module');
        $content_handler = xoops_getmodulehandler('page', 'fmcontent');
        //$clone = $content_handler->getAll( new Criteria('content_modid', $forMods->getVar('mid'), '!=' ), array('DISTINCT(content_modid)') );
        $result = $GLOBALS["xoopsDB"]->query("SELECT DISTINCT(content_modid) FROM " . $GLOBALS["xoopsDB"]->prefix('fmcontent'));
        //$myrow = $GLOBALS["xoopsDB"]->fetchArray($result);
        //echo count($myrow);
        $form = new XoopsThemeForm(_FMCONTENT_FORMPURGE_TITLE, 'tools', 'tools.php', 'post');
        $form->addElement(new XoopsFormHidden('op', 'purge'));
        $clone = array();
        while ($myrow = $GLOBALS["xoopsDB"]->fetchArray($result)) {
            if ($myrow['content_modid'] != $forMods->getVar('mid')) {
                if (!$module_handler->get($myrow['content_modid'])) {
                    $clone[] = $myrow['content_modid'];
                    $form->addElement(new XoopsFormHidden('modid[]', $myrow['content_modid']));
                }
            }
        }
        $button_tray = new XoopsFormElementTray('', '');
        $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
        $button_tray->addElement($submit_btn);
        $form->addElement($button_tray);
        if (count($clone)) {
            $xoopsTpl->assign('purge', $form->render());
        }
        break;

    case 'clone':
        $folder = fmcontent_CleanVars($_REQUEST, 'folder_name', '', 'string');
        if (!is_dir(XOOPS_ROOT_PATH . '/modules/' . $folder)) {
            $folder_handler = new FolderHandler(XOOPS_ROOT_PATH . '/modules/' . $folder);
            $optn = array('to' => XOOPS_ROOT_PATH . '/modules/' . $folder, 'from' => XOOPS_ROOT_PATH . '/modules/fmcontent');
            $folder_handler->copy($optn);
            if (is_array($folder_handler->messages)) {
                $xoopsTpl->assign('messages', $folder_handler->messages);
            } else {
                $xoopsTpl->assign('messages', $folder_handler->erros);
            }
        } else {
            fmcontent_Redirect('tools.php', 1, _FMCONTENT_MSG_CLONE_ERROR);
        }
        break;

    case 'purge':
        $content_handler = xoops_getmodulehandler('page', 'fmcontent');
        $modid = $_REQUEST['modid'];
        foreach ($modid as $id) {
            $content_handler->deleteAll(new Criteria('content_modid', $id));
        }
        fmcontent_Redirect('tools.php', 1, _FMCONTENT_MSG_WAIT);
        break;
}

$xoopsTpl->assign('navigation', 'tools');
$xoopsTpl->assign('navtitle', _FMCONTENT_TOOLS);

// Call template file
echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/fmcontent_tools.html');

// Display Xoops footer
include "footer.php";
xoops_cp_footer();

?>