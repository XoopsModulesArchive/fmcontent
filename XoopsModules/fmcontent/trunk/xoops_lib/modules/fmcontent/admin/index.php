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

$topic_handler = xoops_getmodulehandler('topic', 'fmcontent');
$content_handler = xoops_getmodulehandler('page', 'fmcontent');

$folder = array(
	XOOPS_ROOT_PATH . '/uploads/fmcontent/', 
	XOOPS_ROOT_PATH . '/uploads/fmcontent/img',
	XOOPS_ROOT_PATH . '/uploads/fmcontent/file'
);

$index_admin = new ModuleAdmin();
$index_admin->addInfoBox(_FMCONTENT_ADMENU1);
$index_admin->addInfoBox(_FMCONTENT_ADMENU2);
$index_admin->addInfoBoxLine(_FMCONTENT_ADMENU1, _FMCONTENT_INDEX_TOPICS, $topic_handler->getTopicCount($forMods));
$index_admin->addInfoBoxLine(_FMCONTENT_ADMENU2, _FMCONTENT_INDEX_CONTENTS, $content_handler->getContentItemCount($forMods));

foreach (array_keys( $folder) as $i) {
    $index_admin->addConfigBoxLine($folder[$i], 'folder');
    $index_admin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
    
$xoopsTpl->assign('navigation', 'index');
$xoopsTpl->assign('navtitle', _FMCONTENT_HOME);
$xoopsTpl->assign('renderindex', $index_admin->renderIndex());

// Call template file
echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/fmcontent_index.html');

// Display Xoops footer
include "footer.php";
xoops_cp_footer();
?>