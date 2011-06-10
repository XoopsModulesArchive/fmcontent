<?php
// $Id: fpdf.inc.php,v 1.2 2005/04/18 01:22:28 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

define('CONTENT_FPDF_PATH', XOOPS_TRUST_PATH . '/modules/fmcontent/fpdf');
define('FPDF_FONTPATH', CONTENT_FPDF_PATH . '/font/');

require CONTENT_FPDF_PATH . '/gif.php';
require CONTENT_FPDF_PATH . '/fpdf.php';

if (is_readable(CONTENT_FPDF_PATH . '/language/' . $xoopsConfig['language'] . '.php')) {
    include_once(CONTENT_FPDF_PATH . '/language/' . $xoopsConfig['language'] . '.php');
} elseif (is_readable(CONTENT_FPDF_PATH . '/language/english.php')) {
    include_once(CONTENT_FPDF_PATH . '/language/english.php');
} else {
    die('No Language File Readable!');
}
include CONTENT_FPDF_PATH . '/makepdf_class.php';
?>