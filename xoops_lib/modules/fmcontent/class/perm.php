<?php

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class fmcontentPermHandler {

    function &getHandler() {
        static $permHandler;
        if (!isset($permHandler)) {
            $permHandler = new fmcontentPermHandler();
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

    function getAuthorizedPublicCat(&$user, $perm, $forMods) {
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
        $autorizedCat = $this->getAuthorizedPublicCat($user, $perm, $forMods);
        return in_array($topic_id, $autorizedCat);
    }

}

?>