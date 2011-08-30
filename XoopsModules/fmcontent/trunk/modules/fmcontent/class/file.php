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
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

if (!defined('XOOPS_TRUST_PATH')) die('set XOOPS_TRUST_PATH into mainfile.php');

$mod_dirname = basename(dirname(dirname(__FILE__)));
$mod_dirpath = dirname(dirname(__FILE__));

require $mod_dirpath . '/header.php';

include_once XOOPS_TRUST_PATH . '/modules/fmcontent/class/file.php';

?>