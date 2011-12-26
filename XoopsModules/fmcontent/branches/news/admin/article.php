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
 * @author      Andricq Nicolas (AKA MusS)
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
$topic_handler = xoops_getmodulehandler('topic', 'news');
$story_handler = xoops_getmodulehandler('story', 'news');

// Define scripts
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
$xoTheme->addScript('browse.php?modules/' . $NewsModule->getVar('dirname') . '/js/order.js');
$xoTheme->addScript('browse.php?modules/' . $NewsModule->getVar('dirname') . '/js/admin.js');

// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

// get module configs
$story_perpage = xoops_getModuleOption('admin_perpage', $NewsModule->getVar('dirname'));
$story_order = xoops_getModuleOption('admin_showorder', $NewsModule->getVar('dirname'));
$story_sort = xoops_getModuleOption('admin_showsort', $NewsModule->getVar('dirname'));
 
// get user id content 
if (isset($_REQUEST["user"])) {
   $story_user = NewsUtils::News_CleanVars($_REQUEST, 'user', 0, 'int');
} else {
   $story_user = null;
}

// get limited information
if (isset($_REQUEST['limit'])) {
   $story_limit = NewsUtils::News_CleanVars($_REQUEST, 'limit', 0, 'int');
} else {
   $story_limit = $story_perpage;
}

// get start information
if (isset($_REQUEST['start'])) {
   $story_start = NewsUtils::News_CleanVars($_REQUEST, 'start', 0, 'int');
} else {
   $story_start = 0;
}
   
// get topic information
if (isset($_REQUEST['topic'])) {
   $story_topic = NewsUtils::News_CleanVars($_REQUEST, 'topic', 0, 'int');
   if ($story_topic) {
       $topics = $topic_handler->getall($story_topic);
       $topic_title = NewsTopicHandler::News_GetTopicFromId ( $story_topic );
   } else {
       $topics = $topic_title = _NEWS_AM_CONTENT_STATICS;
   }
} else {
   $story_topic = null;
   $topic_title = null;
   $topics = $topic_handler->getall($story_topic);
}
                     
switch ($op)
{
    case 'new_content':
        $story_type = NewsUtils::News_CleanVars($_REQUEST, 'story_type', 'news', 'string');
        $obj = $story_handler->create();
        $obj->News_GetContentForm($NewsModule, $story_type);
        break;

    case 'edit_content':
        $story_id = NewsUtils::News_CleanVars($_REQUEST, 'story_id', 0, 'int');
        if ($story_id > 0) {
            $obj = $story_handler->get($story_id);
            $obj->News_GetContentForm($NewsModule);
        } else {
            NewsUtils::News_Redirect('article.php', 1, _NEWS_AM_MSG_EDIT_ERROR);
        }
        break;

    case 'delete':
        $story_id = NewsUtils::News_CleanVars($_REQUEST, 'story_id', '0', 'int');
        if ($story_id > 0) {
            $content = $story_handler->get($story_id);
            // Prompt message
            NewsUtils::News_Message('backend.php', sprintf(_NEWS_AM_MSG_DELETE, $content->getVar('story_type') . ': "' . $content->getVar('story_title') . '"'), $story_id, 'content');
            // Display Admin footer
            xoops_cp_footer();
        }
        break;

    case 'order':
        if (isset($_POST['mod'])) {
            $i = 1;
            foreach ($_POST['mod'] as $order) {
                if ($order > 0) {
                    $contentorder = $story_handler->get($order);
                    $contentorder->setVar('story_order', $i);
                    if (!$story_handler->insert($contentorder)) {
                        $error = true;
                    }
                    $i++;
                }
            }
        }
        exit;
        break;
        
    case 'expire':
    
        $story_infos = array(
            'topics' => $topics,
            'story_limit' => $story_limit,
            'story_topic' => $story_topic,
            'story_user' => $story_user,
            'story_start' => $story_start,
            'story_order' => $story_order,
            'story_sort' => $story_sort,
            'story_status' => 1,
            'story_static' => false,
        );
        
        $contents = $story_handler->News_GetExpireContentList($NewsModule, $story_infos);
        $story_numrows = $story_handler->News_GetExpireContentCount($NewsModule, $story_infos);
        
        if ($story_numrows > $story_limit) {
            $story_pagenav = new XoopsPageNav($story_numrows, $story_limit, $story_start, 'start', 'limit=' . $story_limit . '&op=offline');
            $story_pagenav = $story_pagenav->renderNav(4);
        } else {
            $story_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'content');
        $xoopsTpl->assign('navtitle', _NEWS_MI_CONTENT);
        $xoopsTpl->assign('topic_title', $topic_title);
        $xoopsTpl->assign('contents', $contents);
        $xoopsTpl->assign('story_pagenav', $story_pagenav);
        $xoopsTpl->assign('xoops_dirname', $NewsModule->getVar('dirname'));
        $xoopsTpl->assign('news_tips', _NEWS_AM_CONTENT_TIPS);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar('dirname') . '/templates/admin/news_article.html');
        
        break;
         
    case 'offline':

        $story_infos = array(
            'topics' => $topics,
            'story_limit' => $story_limit,
            'story_topic' => $story_topic,
            'story_user' => $story_user,
            'story_start' => $story_start,
            'story_order' => $story_order,
            'story_sort' => $story_sort,
            'story_status' => 0,
            'story_static' => false,
        );

        $contents = $story_handler->News_GetAdminContentList($NewsModule, $story_infos);
        $story_numrows = $story_handler->News_GetOfflineContentCount($NewsModule, $story_infos);

        if ($story_numrows > $story_limit) {
            $story_pagenav = new XoopsPageNav($story_numrows, $story_limit, $story_start, 'start', 'limit=' . $story_limit . '&op=offline');
            $story_pagenav = $story_pagenav->renderNav(4);
        } else {
            $story_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'content');
        $xoopsTpl->assign('navtitle', _NEWS_MI_CONTENT);
        $xoopsTpl->assign('topic_title', $topic_title);
        $xoopsTpl->assign('contents', $contents);
        $xoopsTpl->assign('story_pagenav', $story_pagenav);
        $xoopsTpl->assign('xoops_dirname', $NewsModule->getVar('dirname'));
        $xoopsTpl->assign('news_tips', _NEWS_AM_CONTENT_TIPS);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar('dirname') . '/templates/admin/news_article.html');
        
	    break;
	    
    default:

        $story_infos = array(
            'topics' => $topics,
            'story_limit' => $story_limit,
            'story_topic' => $story_topic,
            'story_user' => $story_user,
            'story_start' => $story_start,
            'story_order' => $story_order,
            'story_sort' => $story_sort,
            'story_status' => false,
            'story_static' => false,
        );

        $contents = $story_handler->News_GetAdminContentList($NewsModule, $story_infos);
        $story_numrows = $story_handler->News_GetAdminContentCount($NewsModule, $story_infos);

        if ($story_numrows > $story_limit) {
            if ($story_topic) {
                $story_pagenav = new XoopsPageNav($story_numrows, $story_limit, $story_start, 'start', 'limit=' . $story_limit . '&topic=' . $story_topic);
            } else {
                $story_pagenav = new XoopsPageNav($story_numrows, $story_limit, $story_start, 'start', 'limit=' . $story_limit);
            }
            $story_pagenav = $story_pagenav->renderNav(4);
        } else {
            $story_pagenav = '';
        }

        $xoopsTpl->assign('navigation', 'content');
        $xoopsTpl->assign('navtitle', _NEWS_MI_ARTICLE);
        $xoopsTpl->assign('topic_title', $topic_title);
        $xoopsTpl->assign('contents', $contents);
        $xoopsTpl->assign('story_pagenav', $story_pagenav);
        $xoopsTpl->assign('xoops_dirname', $NewsModule->getVar('dirname'));
        $xoopsTpl->assign('news_tips', _NEWS_AM_CONTENT_TIPS);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $NewsModule->getVar('dirname') . '/templates/admin/news_article.html');

        break;

}

// Admin Footer
include "footer.php";
xoops_cp_footer();

?>