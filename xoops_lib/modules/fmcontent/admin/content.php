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
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

// Display Admin header
xoops_cp_header();
// Define default value
$op = fmcontent_CleanVars($_REQUEST, 'op', '', 'string');
// Initialize content handler
$topic_handler = xoops_getmodulehandler('topic', 'fmcontent');
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
    case 'new_content':
        $content_type = fmcontent_CleanVars($_REQUEST, 'content_type', 'content', 'string');
        $obj = $content_handler->create();
        $obj->getContentForm($forMods, $content_type);
        break;

    case 'edit_content':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $obj = $content_handler->get($content_id);
            $obj->getContentForm($forMods);
        } else {
            fmcontent_Redirect('content.php', 1, _FMCONTENT_MSG_EDIT_ERROR);
        }
        break;

    case 'new_link':
        $content_type = fmcontent_CleanVars($_REQUEST, 'content_type', 'link', 'string');
        $obj = $content_handler->create();
        $obj->getMenuForm($forMods, $content_type);
        break;

    case 'edit_link':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $obj = $content_handler->get($content_id);
            $obj->getMenuForm($forMods);
        } else {
            fmcontent_Redirect('content.php', 1, _FMCONTENT_MSG_EDIT_ERROR);
        }
        break;

    case 'delete':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', '0', 'int');
        if ($content_id > 0) {
            $content = $content_handler->get($content_id);
            // Prompt message
            fmcontent_Message('backend.php', sprintf(_FMCONTENT_MSG_DELETE, $content->getVar('content_type') . ': "' . $content->getVar('content_title') . '"'), $content_id, 'content');
            // Display Admin footer
            xoops_cp_footer();
        }
        break;

    case 'order':
        if (isset($_POST['mod'])) {
            $i = 1;
            foreach ($_POST['mod'] as $order) {
                if ($order > 0) {
                    $contentorder = $content_handler->get($order);
                    $contentorder->setVar('content_order', $i);
                    if (!$content_handler->insert($contentorder)) {
                        $error = true;
                    }
                    $i++;
                }
            }
        }
        exit;
        break;

    default:

        // get module configs
        $content_perpage = xoops_getModuleOption('admin_perpage', $forMods->getVar('dirname'));
        $content_order = xoops_getModuleOption('admin_showorder', $forMods->getVar('dirname'));
        $content_sort = xoops_getModuleOption('admin_showsort', $forMods->getVar('dirname'));

        if (isset($_REQUEST["user"])) {
            $content_user = fmcontent_CleanVars($_REQUEST, 'user', 0, 'int');
        } else {
            $content_user = null;
        }

        // get limited information
        if (isset($_REQUEST['limit'])) {
            $content_limit = fmcontent_CleanVars($_REQUEST, 'limit', 0, 'int');
        } else {
            $content_limit = $content_perpage;
        }

        // get start information
        if (isset($_REQUEST['start'])) {
            $content_start = fmcontent_CleanVars($_REQUEST, 'start', 0, 'int');
        } else {
            $content_start = 0;
        }

        // get topic information
        if (isset($_REQUEST['topic'])) {
            $content_topic = fmcontent_CleanVars($_REQUEST, 'topic', 0, 'int');
            if ($content_topic) {
                $topics = $topic_handler->getall($content_topic);
                $topic_title = fmcontentTopicHandler::getTopicFromId ( $content_topic );
            } else {
                $topics = $topic_title = _FMCONTENT_STATICS;
            }
        } else {
            $content_topic = null;
            $topic_title = null;
            // get all topic informations
            $topics = $topic_handler->getall($content_topic);

        }

        $content_infos = array(
            'topics' => $topics,
            'content_limit' => $content_limit,
            'content_topic' => $content_topic,
            'content_user' => $content_user,
            'content_start' => $content_start,
            'content_order' => $content_order,
            'content_sort' => $content_sort,
            'content_status' => false,
            'content_static' => false,
            'admin_side' => true
        );

        $contents = $content_handler->getContentList($forMods, $content_infos);
        $content_numrows = $content_handler->getContentCount($forMods, $content_infos);

        if ($content_numrows > $content_limit) {
            if ($content_topic) {
                $content_pagenav = new XoopsPageNav($content_numrows, $content_limit, $content_start, 'start', 'limit=' . $content_limit . '&topic=' . $content_topic);
            } else {
                $content_pagenav = new XoopsPageNav($content_numrows, $content_limit, $content_start, 'start', 'limit=' . $content_limit);
            }
            $content_pagenav = $content_pagenav->renderNav(4);
        } else {
            $content_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'content');
        $xoopsTpl->assign('navtitle', _FMCONTENT_CONTENT);
        $xoopsTpl->assign('topic_title', $topic_title);
        $xoopsTpl->assign('contents', $contents);
        $xoopsTpl->assign('content_pagenav', $content_pagenav);
        $xoopsTpl->assign('xoops_dirname', $forMods->getVar('dirname'));
        $xoopsTpl->assign('fmcontent_tips', _FMCONTENT_CONTENT_TIPS);

        // Call template file
        echo $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/fmcontent_content.html');

        break;

}

// Admin Footer
include "footer.php";
xoops_cp_footer();

?>