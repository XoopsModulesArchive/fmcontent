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
 * @author      Gregory Mage (AKA Mage)
 * @author      Michael Beck (AKA Mamba)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');
// Display Admin header
xoops_cp_header();
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

// Add Changelog 
$file = XOOPS_ROOT_PATH . "/modules/" . $NewsModule->getVar("dirname") . "/docs/changelog.txt";
if (is_readable($file)) {
    $xoopsTpl->assign('module_changelog', utf8_encode(implode("<br />", file($file))));
} else {
    $xoopsTpl->assign('module_changelog', 'File Not find');
}

$xoopsTpl->assign('navigation', 'about');
$xoopsTpl->assign('navtitle', _NEWS_MI_ABOUT);
$xoopsTpl->assign('module_name', $NewsModule->getInfo("name"));
$xoopsTpl->assign('module_description', $NewsModule->getInfo("description"));
$xoopsTpl->assign('module_icon', $NewsModule->getInfo("image"));
$xoopsTpl->assign('module_version', $NewsModule->getInfo("version"));
$xoopsTpl->assign('module_author', $NewsModule->getInfo("author"));
$xoopsTpl->assign('module_credits', $NewsModule->getInfo("credits"));
$xoopsTpl->assign('module_license', $NewsModule->getInfo("license"));
$xoopsTpl->assign('module_license_url', $NewsModule->getInfo("license_url"));
$xoopsTpl->assign('module_release_date', $NewsModule->getInfo("release_date"));
$xoopsTpl->assign('module_last_update', formatTimestamp($xoopsModule->getVar("last_update"), "m"));
$xoopsTpl->assign('module_status', $NewsModule->getInfo("module_status"));
$xoopsTpl->assign('module_website_url', $NewsModule->getInfo("module_website_url"));
$xoopsTpl->assign('module_website_name', $NewsModule->getInfo("module_website_name"));

// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar('dirname') . '/templates/admin/news_about.html');

include "footer.php";
xoops_cp_footer();
?>