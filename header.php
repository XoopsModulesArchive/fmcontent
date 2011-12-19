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
 * News header file
 * Manage content page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @package     forcontent
 * @version     $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) {
    include_once '../../mainfile.php';
}

require_once XOOPS_ROOT_PATH . '/modules/news/include/functions.php';
include_once XOOPS_ROOT_PATH . '/modules/news/class/perm.php';
require_once XOOPS_ROOT_PATH . '/modules/news/class/utils.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';

$modsDirname = basename(dirname(__FILE__));

$module_handler =& xoops_gethandler('module');
$forMods =& $module_handler->getByDirname($modsDirname);
?>