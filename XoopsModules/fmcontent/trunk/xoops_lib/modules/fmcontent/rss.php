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
 * FmContent index file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version   $Id$
 */

if (!isset($forMods)) exit('Module not found');

error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}
header('Content-Type:text/xml; charset=utf-8');
$xoopsTpl = new XoopsTpl();
$xoopsTpl->xoops_setCaching(2);
$xoopsTpl->xoops_setCacheTime(xoops_getModuleOption('rss_timecache', $forMods->getVar('dirname')) * 1);
$myts = MyTextSanitizer::getInstance();
if (!$xoopsTpl->is_cached('db:fmcontent_rss.html')) {
    if ($content_topic != 0) {
        $channel_category .= " > " . $topic_obj->getVar('topic_title');
    } else {
        $channel_category = $forMods->getVar('dirname');
    }
    // Check if ML Hack is installed, and if yes, parse the $content in formatForML
    if (method_exists($myts, 'formatForML')) {
        $xoopsConfig['sitename'] = $myts->formatForML($xoopsConfig['sitename']);
        $xoopsConfig['slogan'] = $myts->formatForML($xoopsConfig['slogan']);
        $channel_category = $myts->formatForML($channel_category);
    }
    $xoopsTpl->assign('channel_charset', _CHARSET);
    $xoopsTpl->assign('docs', 'http://cyber.law.harvard.edu/rss/rss.html');
    $xoopsTpl->assign('channel_title', htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
    $xoopsTpl->assign('channel_link', XOOPS_URL . '/');
    $xoopsTpl->assign('channel_desc', htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES));
    $xoopsTpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
    $xoopsTpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
    $xoopsTpl->assign('channel_editor', $xoopsConfig['adminmail']);
    $xoopsTpl->assign('channel_category', htmlspecialchars($channel_category));
    $xoopsTpl->assign('channel_generator', $forMods->getVar('dirname'));
    $xoopsTpl->assign('channel_language', _LANGCODE);
    //$xoopsTpl->assign('pubDate', formatTimestamp($content_create, 'rss'));
    $xoopsTpl->assign('image_url', XOOPS_URL . xoops_getModuleOption('rss_logo', $forMods->getVar('dirname')));
    $dimention = getimagesize(XOOPS_ROOT_PATH . xoops_getModuleOption('rss_logo', $forMods->getVar('dirname')));

    if (empty($dimention[0])) {
        $width = 140;
        $height = 140;
    } else {
        $width = ($dimention[0] > 140) ? 140 : $dimention[0];
        $dimention[1] = $dimention[1] * $width / $dimention[0];
        $height = ($dimention[1] > 140) ? $dimention[1] * $dimention[0] / 140 : $dimention[1];
    }

    $xoopsTpl->assign('image_width', $width);
    $xoopsTpl->assign('image_height', $height);

    if (isset($_REQUEST["user"])) {
        $content_user = fmcontent_CleanVars($_REQUEST, 'user', 0, 'int');
    } else {
        $content_user = null;
    }

    if (isset($_REQUEST["topic"])) {
        $content_topic = fmcontent_CleanVars($_REQUEST, 'topic', 0, 'int');

    } else {
        $content_topic = null;


    }

    $content_handler = xoops_getmodulehandler('page', 'fmcontent');
    $topic_handler = xoops_getmodulehandler('topic', 'fmcontent');

    if ($content_topic != 0) {
        $permHandler = fmcontentPermission::getHandler();
        if ($permHandler->isAllowed($xoopsUser, 'fmcontent_access', $content_topic)) {
            $topic_obj = $topic_handler->get($content_topic);
        }
    }

    $content_infos = array(
        'topics' => $topic_handler->getall($content_topic), // get all topic informations
        'content_limit' => xoops_getModuleOption('rss_perpage', $forMods->getVar('dirname')),
        'content_topic' => $content_topic,
        'content_user' => $content_user,
        'content_start' => 0,
        'content_order' => 'DESC',
        'content_sort' => 'content_create',
        'content_status' => '1',
        'content_static' => true,
        'admin_side' => false
    );

    $contents = $content_handler->getContentList($forMods, $content_infos);

    $xoopsTpl->assign('contents', $contents);
}
$xoopsTpl->display('db:fmcontent_rss.html');
?>