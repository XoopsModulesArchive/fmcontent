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
// Define default value
$op = fmcontent_CleanVars($_REQUEST, 'op', 'new', 'string');
// Admin header
xoops_cp_header();
// Redirect to content page
if (!isset($_POST['post']) && isset($_POST['content_type'])) {

    $content_type = $_POST['content_type'];
    fmcontent_Redirect('navigation.php?content_type=' . $content_type, 0, _FMCONTENT_MSG_WAIT);
    // Include footer
    xoops_cp_footer();
    exit;
}

// Initialize content handler
$content_handler = xoops_getmodulehandler('page', 'fmcontent');
$topic_handler = xoops_getmodulehandler('topic', 'fmcontent');

switch ($op) {

    case 'add_topic':
        $obj = $topic_handler->create();
        $obj->setVars($_REQUEST);
        $obj->setVar('topic_date_created', time());
        $obj->setVar('topic_date_update', time());

        if (!$topic_handler->insert($obj)) {
            echo 'error';
        }

        $new_topic = $obj->db->getInsertId();

        //permission pour voir
        $gperm_handler = &xoops_gethandler('groupperm');
        if (isset($_REQUEST['groups_view'])) {
            foreach ($_REQUEST['groups_view'] as $onegroup_id) {
                $gperm_handler->addRight('fmcontent_access', $new_topic, $onegroup_id, $xoopsModule->getVar('mid'));
            }
        }

        //permission pour editer
        $gperm_handler = &xoops_gethandler('groupperm');
        if (isset($_POST['groups_submit'])) {
            foreach ($_POST['groups_submit'] as $onegroup_id) {
                $gperm_handler->addRight('fmcontent_submit', $new_topic, $onegroup_id, $xoopsModule->getVar('mid'));
            }
        }

        // Redirect page
        fmcontent_Redirect('topic.php', 1, _FMCONTENT_MSG_WAIT);
        xoops_cp_footer();
        exit();
        break;

    case 'edit_topic':
        $topic_id = fmcontent_CleanVars($_REQUEST, 'topic_id', 0, 'int');
        if ($topic_id > 0) {

            $obj = $topic_handler->get($topic_id);
            $obj->setVars($_POST);
            $obj->setVar('topic_date_update', time());

            //permission pour voir
            $gperm_handler = &xoops_gethandler('groupperm');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $topic_id, '='));
            $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
            $criteria->add(new Criteria('gperm_name', 'fmcontent_access', '='));
            $gperm_handler->deleteAll($criteria);
            if (isset($_REQUEST['groups_view'])) {
                foreach ($_REQUEST['groups_view'] as $onegroup_id) {
                    $gperm_handler->addRight('fmcontent_access', $topic_id, $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }

            //permission pour editer
            $gperm_handler = &xoops_gethandler('groupperm');
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $topic_id, '='));
            $criteria->add(new Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
            $criteria->add(new Criteria('gperm_name', 'fmcontent_submit', '='));
            $gperm_handler->deleteAll($criteria);
            if (isset($_POST['groups_submit'])) {
                foreach ($_POST['groups_submit'] as $onegroup_id) {
                    $gperm_handler->addRight('fmcontent_submit', $topic_id, $onegroup_id, $xoopsModule->getVar('mid'));
                }

            }

            if (!$topic_handler->insert($obj)) {
                echo 'error';
            }
        }

        // Redirect page
        fmcontent_Redirect('topic.php', 1, _FMCONTENT_MSG_WAIT);
        xoops_cp_footer();
        exit();
        break;

    case 'add':
        $groups = (isset($_POST['content_groups'])) ? $_POST['content_groups'] : '';
        $groups = (is_array($groups)) ? implode(" ", $groups) : '';

        $obj = $content_handler->create();
        $obj->setVars($_REQUEST);

        if($_REQUEST['content_type'] = 'link') {
	         $obj->setVar('content_title', $_REQUEST['content_menu']);	  
        }
        	
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('content_modid', $forMods->getVar('mid')));
        $criteria->setSort('content_order');
        $criteria->setOrder('DESC');
        $criteria->setLimit(1);
        $last = $content_handler->getObjects($criteria);
        $order = 1;
        foreach ($last as $item) {
            $order = $item->getVar('content_order') + 1;
        }
        $obj->setVar('content_order', $order);
        $obj->setVar('content_groups', $groups);
        $obj->setVar('content_create', time());
        $obj->setVar('content_update', time());

        //Form topic_img	
        include_once XOOPS_ROOT_PATH . "/class/uploader.php";
        $uploaddir_content_img = XOOPS_ROOT_PATH . xoops_getModuleOption('img_dir', $forMods->getVar('dirname'));
        $uploader_content_img = new XoopsMediaUploader($uploaddir_content_img, xoops_getModuleOption('img_mime', $forMods->getVar('dirname')), xoops_getModuleOption('img_size', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxwidth', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxheight', $forMods->getVar('dirname')));
        if ($uploader_content_img->fetchMedia('content_img')) {
            $uploader_content_img->setPrefix("content_img_");
            $uploader_content_img->fetchMedia('content_img');
            if (!$uploader_content_img->upload()) {
                $errors = $uploader_content_img->getErrors();
                redirect_header("javascript:history.go(-1)", 3, $errors);
            } else {
                $obj->setVar('content_img', $uploader_content_img->getSavedFileName());
            }
        } else {
            if (isset($_REQUEST['content_img'])) {
                $obj->setVar('content_img', $_REQUEST['content_img']);
            }
        }

        $content_handler->updateposts($_REQUEST['content_uid'], $_REQUEST['content_status'], $content_action = 'add');

        if (!$content_handler->insert($obj)) {
            echo 'error';
        }

        if ((xoops_getModuleOption('usetag', $forMods->getVar('dirname'))) and (is_dir(XOOPS_ROOT_PATH . '/modules/tag'))) {
            $tag_handler = xoops_getmodulehandler('tag', 'tag');
            $tag_handler->updateByItem($_POST["item_tag"], $obj->getVar('content_id'), $forMods->getVar("dirname"), 0);
        }

        // Redirect page
        fmcontent_Redirect('content.php', 1, _FMCONTENT_MSG_WAIT);
        xoops_cp_footer();
        exit();
        break;

    case 'edit':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $groups = (isset($_POST['content_groups'])) ? $_POST['content_groups'] : '';
            $groups = (is_array($groups)) ? implode(" ", $groups) : '';

            $obj = $content_handler->get($content_id);
            $obj->setVars($_REQUEST);

	         if($_REQUEST['content_type'] = 'link') {
		          $obj->setVar('content_title', $_REQUEST['content_menu']);	  
	         }
        
            if (!isset($_REQUEST['content_titleview'])) {
                $obj->setVar('content_titleview', 0);
            }

            if (!isset($_REQUEST['dohtml'])) {
                $obj->setVar('dohtml', 0);
            }

            if (!isset($_REQUEST['dobr'])) {
                $obj->setVar('dobr', 0);
            }

            if (!isset($_REQUEST['doimage'])) {
                $obj->setVar('doimage', 0);
            }

            if (!isset($_REQUEST['dosmiley'])) {
                $obj->setVar('dosmiley', 0);
            }

            if (!isset($_REQUEST['doxcode'])) {
                $obj->setVar('doxcode', 0);
            }

            //Form topic_img
            include_once XOOPS_ROOT_PATH . "/class/uploader.php";
            $uploaddir_content_img = XOOPS_ROOT_PATH . xoops_getModuleOption('img_dir', $forMods->getVar('dirname'));
            $uploader_content_img = new XoopsMediaUploader($uploaddir_content_img, xoops_getModuleOption('img_mime', $forMods->getVar('dirname')), xoops_getModuleOption('img_size', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxwidth', $forMods->getVar('dirname')), xoops_getModuleOption('img_maxheight', $forMods->getVar('dirname')));
            if ($uploader_content_img->fetchMedia('content_img')) {
                $uploader_content_img->setPrefix("content_img_");
                $uploader_content_img->fetchMedia('content_img');
                if (!$uploader_content_img->upload()) {
                    $errors = $uploader_content_img->getErrors();
                    redirect_header("javascript:history.go(-1)", 3, $errors);
                } else {
                    $obj->setVar('content_img', $uploader_content_img->getSavedFileName());
                }
            } else {
                if (isset($_REQUEST['content_img'])) {
                    $obj->setVar('content_img', $_REQUEST['content_img']);
                }
            }

            if (!$content_handler->insert($obj)) {
                echo 'error';
            }

            //tag
            if ((xoops_getModuleOption('usetag', $forMods->getVar('dirname'))) and (is_dir(XOOPS_ROOT_PATH . '/modules/tag'))) {
                $tag_handler = xoops_getmodulehandler('tag', 'tag');
                $tag_handler->updateByItem($_POST["item_tag"], $content_id, $forMods->getVar("dirname"), $catid = 0);
            }

            $obj->setVar('content_groups', $groups);
            $obj->setVar('content_update', time());

            if (!$content_handler->insert($obj)) {
                echo 'error';
            }
        }

        // Redirect page
        fmcontent_Redirect('content.php', 1, _FMCONTENT_MSG_WAIT);
        xoops_cp_footer();
        exit();
        break;

    case 'status':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $obj =& $content_handler->get($content_id);
            $old = $obj->getVar('content_status');
            $content_handler->updateposts($obj->getVar('content_uid'), $obj->getVar('content_status'), $content_action = 'status');
            $obj->setVar('content_status', !$old);
            if ($content_handler->insert($obj)) {
                exit;
            }
            echo $obj->getHtmlErrors();
        }
        break;


    case 'default':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        $topic_id = fmcontent_CleanVars($_REQUEST, 'topic_id', 0, 'int');
        if ($content_id > 0) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('content_topic', $topic_id));
            $content_handler->updateAll('content_default', 0, $criteria);
            $obj =& $content_handler->get($content_id);
            $obj->setVar('content_default', 1);
            if ($content_handler->insert($obj)) {
                exit;
            }
            echo $obj->getHtmlErrors();
        }
        break;

    case 'display':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $obj =& $content_handler->get($content_id);
            $old = $obj->getVar('content_display');
            $obj->setVar('content_display', !$old);
            if ($content_handler->insert($obj)) {
                exit;
            }
            echo $obj->getHtmlErrors();
        }
        break;


    case 'topic_asmenu':
        $topic_id = fmcontent_CleanVars($_REQUEST, 'topic_id', 0, 'int');
        if ($topic_id > 0) {
            $obj =& $topic_handler->get($topic_id);
            $old = $obj->getVar('topic_asmenu');
            $obj->setVar('topic_asmenu', !$old);
            if ($topic_handler->insert($obj)) {
                exit;
            }
            echo $obj->getHtmlErrors();
        }
        break;


    case 'topic_online':
        $topic_id = fmcontent_CleanVars($_REQUEST, 'topic_id', 0, 'int');
        if ($topic_id > 0) {
            $obj =& $topic_handler->get($topic_id);
            $old = $obj->getVar('topic_online');
            $obj->setVar('topic_online', !$old);
            if ($topic_handler->insert($obj)) {
                exit;
            }
            echo $obj->getHtmlErrors();
        }
        break;


    case 'delete':
        $content_id = fmcontent_CleanVars($_REQUEST, 'content_id', 0, 'int');
        if ($content_id > 0) {
            $obj = $content_handler->get($content_id);
            $content_handler->updateposts($obj->getVar('content_uid'), $obj->getVar('content_status'), $content_action = 'delete');
            if (!$content_handler->delete($obj)) {
                echo $obj->getHtmlErrors();
            }
        }

        // Redirect page
        fmcontent_Redirect('content.php', 1, _FMCONTENT_MSG_WAIT);
        xoops_cp_footer();
        exit();
        break;
}

// Redirect page
fmcontent_Redirect('index.php', 1, _FMCONTENT_MSG_WAIT);
// Include footer
xoops_cp_footer();

?>