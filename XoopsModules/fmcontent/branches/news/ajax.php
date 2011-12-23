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
 * News edit in place file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found');

error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

$story_id = NewsUtils::News_CleanVars($_REQUEST, 'id', '', 'string');
$story_text = NewsUtils::News_CleanVars($_REQUEST, 'value', '', 'string');

list($root, $id) = explode('_', $story_id);

if (intval($id) > 0) {
    // Initialize content handler
    $story_handler = xoops_getmodulehandler('story', $NewsModule->getVar('dirname'));
    $content = $story_handler->get($id);
    $content->setVar('story_text', $story_text);
    if (!$story_handler->insert($content)) {
        echo 'Error';
    } else {
        echo $story_text;
    }
}
?>