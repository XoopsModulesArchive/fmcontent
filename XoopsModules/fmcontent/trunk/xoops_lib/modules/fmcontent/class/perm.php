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
 * FmContent page class
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Zoullou (http://www.zoullou.net)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id:$
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class fmcontentPermission {

    function &getHandler() {
        static $permHandler;
        if (!isset($permHandler)) {
            $permHandler = new fmcontentPermission();
        }
        return $permHandler;
    }

    function _getUserGroup(&$user) {
        if (is_a($user, 'XoopsUser')) {
            return $user->getGroups();
        } else {
            return XOOPS_GROUP_ANONYMOUS;
        }
    }

    function getAuthorizedTopic(&$user, $perm, $forMods) {
        static $authorizedCat;
        $userId = ($user) ? $user->getVar('uid') : 0;
        if (!isset($authorizedCat[$perm][$userId])) {
            $groupPermHandler =& xoops_gethandler('groupperm');
            $moduleHandler =& xoops_gethandler('module');
            $dirname = $forMods->getVar('dirname');
            $module = $moduleHandler->getByDirname($dirname);
            $authorizedCat[$perm][$userId] = $groupPermHandler->getItemIds($perm, $this->_getUserGroup($user), $module->getVar("mid"));
        }
        return $authorizedCat[$perm][$userId];
    }

    function isAllowed(&$user, $perm, $topic_id, $forMods) {
        $autorizedCat = $this->getAuthorizedTopic($user, $perm, $forMods);
        return in_array($topic_id, $autorizedCat);
    }
    
	function setpermission($forMods,$gperm_name , $groups_action ,$id,$new) {

            $gperm_handler = &xoops_gethandler('groupperm');
            
            if(!$new) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $id, '='));
            $criteria->add(new Criteria('gperm_modid', $forMods->getVar('mid'), '='));
            $criteria->add(new Criteria('gperm_name', $gperm_name, '='));
            $gperm_handler->deleteAll($criteria);
            }
            
            if (isset($groups_action)) {
                foreach ($groups_action as $onegroup_id) {
                    $gperm_handler->addRight($gperm_name, $id, $onegroup_id, $forMods->getVar('mid'));
                }
            }

	}	

}

?>