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
 * FmContent edit in place file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

if (!isset($forMods)) exit('Module not found');

error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

$content_id = fmcontent_CleanVars($_REQUEST, 'id', '', 'string');
$content_text = fmcontent_CleanVars($_REQUEST, 'value', '', 'string');

list($root, $id) = explode('_', $content_id);

if (intval($id) > 0) {
    // Initialize content handler
    $content_handler = xoops_getmodulehandler('page', $forMods->getVar('dirname'));
    $content = $content_handler->get($id);
    $content->setVar('content_text', $content_text);
    if (!$content_handler->insert($content)) {
        echo 'Error';
    } else {
        echo $content_text;
    }
}
?>