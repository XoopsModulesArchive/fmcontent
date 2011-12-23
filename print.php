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
 * News print file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

// Initialize content handler
$story_handler = xoops_getmodulehandler('story', 'news');$topic_handler = xoops_getmodulehandler('topic', 'news');

if(isset($_REQUEST['storyid'])) {
	$story_id = NewsUtils::News_CleanVars ( $_REQUEST, 'storyid', 0, 'int' );
} else {
	$story_alias = NewsUtils::News_CleanVars ( $_REQUEST, 'story', 0, 'string' );
	if($story_alias) {
		$story_id = $story_handler->News_GetId($story_alias);
	}
}

// Initialize template
$xoopsTpl = new XoopsTpl();

$obj = $story_handler->get($story_id);

// Get user right
$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$groups = explode(" ", $obj->getVar('story_groups'));
if (count(array_intersect($group, $groups)) <= 0) {
    redirect_header('index.php', 2, _NOPERM);
    exit();
}
if ($group[0] == XOOPS_GROUP_ADMIN) {
    $xoopsTpl->assign('admin', 1);
}

$page = array();
$page = $obj->toArray();
$story_topic = $obj->getVar('story_topic');

if (isset($story_topic) && $story_topic > 0) {

    $view_topic = $topic_handler->get($story_topic);

    if (!isset($view_topic)) {
        redirect_header('index.php', 3, _NEWS_MD_TOPIC_ERROR);
        exit();
    }

    if ($view_topic->getVar('topic_modid') != $NewsModule->getVar('mid')) {
        redirect_header('index.php', 3, _NEWS_MD_TOPIC_ERROR);
        exit();
    }

    if ($view_topic->getVar('topic_online') == '0') {
        redirect_header('index.php', 3, _NEWS_MD_TOPIC_ERROR);
        exit();
    }

    // Check the access permission
    $perm_handler = NewsPermission::getHandler();
    if (!$perm_handler->News_IsAllowed($xoopsUser, 'news_access', $view_topic->getVar('topic_id'), $NewsModule)) {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    }

    if (xoops_getModuleOption('disp_option', $NewsModule->getVar('dirname')) && $view_topic->getVar('topic_showprint') == '0') {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    } elseif (xoops_getModuleOption('disp_printlink', $NewsModule->getVar('dirname')) == '0') {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    }
}

$page['title'] = $obj->getVar('story_title');
$page['alias'] = $obj->getVar('story_alias');
$page['short'] = $obj->getVar('story_short');
$page['text'] = $obj->getVar('story_text');
$page['img'] = $obj->getVar('story_img');
$page['thumburl'] = XOOPS_URL . xoops_getModuleOption('img_dir', $NewsModule->getVar('dirname')) . '/thumb/' . $obj->getVar('story_img');
$page['author'] = XoopsUser::getUnameFromId($obj->getVar('story_uid'));
$page['date'] = formatTimestamp($obj->getVar('story_create'), _MEDIUMDATESTRING);
$page['link'] = NewsUtils::News_Url($NewsModule->getVar('dirname'), $page);

$xoopsTpl->assign('content', $page);
$xoopsTpl->assign('module', $NewsModule->getVar('dirname'));
$xoopsTpl->assign('imgwidth', xoops_getModuleOption('imgwidth', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('imgfloat', xoops_getModuleOption('imgfloat', $NewsModule->getVar('dirname')));

// Index Variable
$xoopsTpl->assign('xoops_sitename', $xoopsConfig['sitename']);
$xoopsTpl->assign('xoops_pagetitle', $page['title']);
$xoopsTpl->assign('meta_author', XoopsUser::getUnameFromId($obj->getVar('story_uid')));
$xoopsTpl->assign('meta_copyright', $xoopsConfig['sitename']);
$xoopsTpl->assign('meta_keywords', $obj->getVar('story_words'));
$xoopsTpl->assign('meta_description', $obj->getVar('story_desc'));

// Set xoops page title
$xoopsTpl->assign('xoops_pagetitle', $page['title'] . ' - ' . $NewsModule->getVar('name', 's'));

// Set local style
if (file_exists(XOOPS_ROOT_PATH . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css')) {
    $xoopsTpl->assign('localstyle', XOOPS_URL . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
} else {
    $xoopsTpl->assign('localstyle', XOOPS_URL . '/language/english/style.css');
}

// Print page config
$xoopsTpl->assign('print_logo', xoops_getModuleOption('print_logo', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_logofloat', xoops_getModuleOption('print_logofloat', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_logourl', XOOPS_URL . xoops_getModuleOption('print_logourl', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_img', xoops_getModuleOption('print_img', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_short', xoops_getModuleOption('print_short', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_text', xoops_getModuleOption('print_text', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_date', xoops_getModuleOption('print_date', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_author', xoops_getModuleOption('print_author', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_link', xoops_getModuleOption('print_link', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_title', xoops_getModuleOption('print_title', $NewsModule->getVar('dirname')));
$xoopsTpl->assign('print_columns', xoops_getModuleOption('print_columns', $NewsModule->getVar('dirname')));

// Display print page
echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getInfo('dirname') . '/templates/news_print.html');

?>