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
 * FmContent submit file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

if (!isset($forMods)) exit('Module not found');

include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";

$op = fmcontent_CleanVars($_REQUEST, 'op', '', 'string');

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php';

$content_handler = xoops_getmodulehandler('page', 'fmcontent');
$topic_handler = xoops_getmodulehandler('topic', 'fmcontent');

// Include language file
xoops_loadLanguage('admin', $forMods->getVar('dirname', 'e'));

// Check the access permission
global $xoopsUser;
$perm_handler = fmcontentPermHandler::getHandler();
if (!$perm_handler->isAllowed($xoopsUser, 'fmcontent_ac', '8', $forMods)) {
    redirect_header("index.php", 3, _NOPERM);
    exit;
}

switch ($op) {
    case 'add':

        if (!isset($_POST['post'])) {
            redirect_header("index.php", 3, _NOPERM);
            exit;
        }

        if ($_REQUEST['content_modid'] != $forMods->getVar('mid')) {
            redirect_header('index.php', 3, _NOPERM);
            exit();
        }

        $groups = xoops_getModuleOption('groups', $forMods->getVar('dirname'));
        $groups = (isset($groups)) ? $groups : '';
        $groups = (is_array($groups)) ? implode(" ", $groups) : '';

        $obj = $content_handler->create();
        $obj->setVars($_REQUEST);

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

        $obj->setVar('content_menu', fmcontent_AjaxFilter($_REQUEST['content_title']));
        $obj->setVar('content_alias', fmcontent_Filter($_REQUEST['content_title']));
        $obj->setVar('content_words', fmcontent_MetaFilter($_REQUEST['content_title']));
        $obj->setVar('content_desc', fmcontent_AjaxFilter($_REQUEST['content_title']));

        $obj->setVar('content_create', time());
        $obj->setVar('content_update', time());
        $obj->setVar('content_groups', $groups);

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

        if ($perm_handler->isAllowed($xoopsUser, 'fmcontent_ac', '16', $forMods)) {
            $obj->setVar('content_status', '1');
            $content_handler->updateposts($_REQUEST['content_uid'], '1', $content_action = 'add');
        }

        if (!$content_handler->insert($obj)) {
            echo 'error';
        }

        if ((xoops_getModuleOption('usetag', $forMods->getVar('dirname'))) and (is_dir(XOOPS_ROOT_PATH . '/modules/tag'))) {
            $tag_handler = xoops_getmodulehandler('tag', 'tag');
            $tag_handler->updateByItem($_POST["item_tag"], $obj->getVar('content_id'), $forMods->getVar("dirname"), 0);
        }

        // Redirect page
        redirect_header('index.php', 1, _FMCONTENT_MSG_WAIT);

        break;

    default:

        $content_type = fmcontent_CleanVars($_REQUEST, 'content_type', 'content', 'string');
        $obj = $content_handler->create();
        $obj->getContentSimpleForm($forMods, $content_type);
        break;

}

// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php';

?>