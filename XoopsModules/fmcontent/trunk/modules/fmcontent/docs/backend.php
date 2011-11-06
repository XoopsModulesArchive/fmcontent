<?php
/**
 * XOOPS feed creator
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.0.0
 * @version         $Id$
 */
 
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mainfile.php';

require_once XOOPS_TRUST_PATH . '/modules/fmcontent/include/functions.php';
include_once XOOPS_TRUST_PATH . '/modules/fmcontent/class/perm.php';
// Load template class
require_once XOOPS_ROOT_PATH . '/class/template.php';

$modsDirname = basename(XOOPS_TRUST_PATH . '/modules/fmcontent');

$module_handler =& xoops_gethandler('module');
$forMods =& $module_handler->getByDirname($modsDirname);
require_once XOOPS_TRUST_PATH . '/modules/fmcontent/rss.php';

?>