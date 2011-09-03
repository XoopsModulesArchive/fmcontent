<?php
/**
 * Menu configuration file
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id:$
 * @since       2.5.0
 */

$i = 1;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_HOME,
    'link' => 'admin/index.php',
	 'icon' => 'images/admin/home.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_TOPIC,
    'link' => 'admin/topic.php',
	 'icon' => 'images/admin/category.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_CONTENT,
    'link' => 'admin/content.php',
	 'icon' => 'images/admin/content.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_FILE,
    'link' => 'admin/file.php',
	 'icon' => 'images/admin/file.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_TOOLS,
    'link' => 'admin/tools.php',
	 'icon' => 'images/admin/administration.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_PERM,
    'link' => 'admin/permissions.php',
	 'icon' => 'images/admin/permissions.png');
$i++;
$adminmenu[$i] = array(
    'title' => _FMCONTENT_ABOUT,
    'link' => 'admin/about.php',
	 'icon' => 'images/admin/about.png');

?>