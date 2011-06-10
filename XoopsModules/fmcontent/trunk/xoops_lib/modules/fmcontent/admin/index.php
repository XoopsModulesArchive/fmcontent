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
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

if (!isset($forMods)) exit('Module not found');
$index_admin = new ModuleAdmin();
// Display Admin header
xoops_cp_header();
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

// Add module scripts
// $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
// $xoTheme->addScript('browse.php?modules/' . $forMods->getVar('dirname') . '/js/admin.js');

//$xoopsTpl->assign('fmcontent_tips', _FMCONTENT_HOME_TIPS);
$xoopsTpl->assign('navigation', 'index');
$xoopsTpl->assign('navtitle', _FMCONTENT_HOME);
$index_admin->addConfigLabel(_FMCONTENT_CONFIG_CHECK);
$index_admin->addLineConfigLabel(_FMCONTENT_CONFIG_PHP, 5.2, 'php');
$index_admin->addLineConfigLabel(_FMCONTENT_CONFIG_XOOPS, 'XOOPS 2.5', 'xoops');
$xoopsTpl->assign('renderindex', $index_admin->renderIndex());

// Call template file
echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/fmcontent_index.html');

// Display Xoops footer
include "footer.php";
xoops_cp_footer();
?>