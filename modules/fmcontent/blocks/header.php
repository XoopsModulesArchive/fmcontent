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
 * FmContent header file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @package     forcontent
 * @version     $Id:$
 */

if (!defined('XOOPS_TRUST_PATH')) die('set XOOPS_TRUST_PATH into mainfile.php');

require_once $GLOBALS['xoops']->path('/class/tree.php');

require_once XOOPS_TRUST_PATH . '/modules/fmcontent/include/functions.php';

$module_handler =& xoops_gethandler('module');
$forMods =& $module_handler->getByDirname(basename(dirname(dirname(__FILE__))));

?>