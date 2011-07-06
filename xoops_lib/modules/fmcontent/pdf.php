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
 * FmContent pdf file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id:$
 */

if (!isset($forMods)) exit('Module not found');

// Initialize content handler
$content_handler = xoops_getmodulehandler('page', 'fmcontent');$topic_handler = xoops_getmodulehandler('topic', 'fmcontent');

if(isset($_REQUEST['id'])) {
	$content_id = fmcontent_CleanVars ( $_REQUEST, 'id', 0, 'int' );
} else {
	$content_alias = fmcontent_CleanVars ( $_REQUEST, 'page', 0, 'string' );
	if($content_alias) {
		$content_id = $content_handler->getId($content_alias);
	}
}

// Deprecate
$myts =& MyTextSanitizer::getInstance();
// Include pdf library
require_once XOOPS_TRUST_PATH . '/modules/fmcontent/fpdf/fpdf.inc.php';
$obj = $content_handler->get($content_id);
// Get user right
$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$groups = explode(" ", $obj->getVar('content_groups'));
if (count(array_intersect($group, $groups)) <= 0) {
    redirect_header('index.php', 2, _NOPERM);
    exit();
}

// Construct page array
$page = array();
//$page = $obj->toArray();
$content_topic = $obj->getVar('content_topic');

if (isset($content_topic) && $content_topic > 0) {

    $view_topic = $topic_handler->get($content_topic);

    if (!isset($view_topic)) {
        redirect_header('index.php', 3, _FMCONTENT_TOPIC_ERROR);
        exit();
    }

    if ($view_topic->getVar('topic_modid') != $forMods->getVar('mid')) {
        redirect_header('index.php', 3, _FMCONTENT_TOPIC_ERROR);
        exit();
    }

    if ($view_topic->getVar('topic_online') == '0') {
        redirect_header('index.php', 3, _FMCONTENT_TOPIC_ERROR);
        exit();
    }

    // Check the access permission
    $perm_handler = fmcontentPermission::getHandler();
    if (!$perm_handler->isAllowed($xoopsUser, 'fmcontent_access', $view_topic->getVar('topic_id'), $forMods)) {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    }

    if (xoops_getModuleOption('disp_option', $forMods->getVar('dirname')) && $view_topic->getVar('topic_showpdf') == '0') {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    } elseif (xoops_getModuleOption('disp_pdflink', $forMods->getVar('dirname')) == '0') {
        redirect_header("index.php", 3, _NOPERM);
        exit;
    }

}

$page['title'] = $obj->getVar('content_title');
$page['alias'] = $obj->getVar('content_alias');
$page['text'] = $obj->getVar('content_text', 's');

// Generate content data
$contentmain = str_replace('[pagebreak]', '<br /><br />', $page['text']);
$contentmain = html_entity_decode($page['text']);
// Because fpdf does not support some tags as ul and li and other extended
// characters : hack by Jef - www.aquaportail.com
$smallthings = array("<ul>", "</ul>", "<li>", "</li>", "&#39;", "&#039;",
    "&rsquo;", "&lsquo;", "&bull;", "&oelig;", "&ndash;", "[pagebreak]");
$betterthings = array("", "", "->", "\n", "'", "'", "'", "'", "->", "oe",
    "*", "<br /><br />");
$contentmain = str_replace($smallthings, $betterthings, $contentmain);

$pdf_config['slogan'] = $myts->displayTarea($xoopsConfig['sitename'] . ' - ' . $xoopsConfig['slogan']);
//$pdf_data['title'] = $xoopsConfig['sitename'];
//$pdf_data['title'] = $myts->htmlSpecialChars($page['title']);
$pdf_data['title'] = str_replace("&#039;", "'", $page['title']);
$pdf_data['subsubtitle'] = '';
$pdf_data['date'] = formatTimestamp($obj->getVar('content_create'), _MEDIUMDATESTRING);
$pdf_data['filename'] = preg_replace("/[^0-9a-z\-_\.]/i", '', $page['alias']);
$pdf_data['content'] = str_replace("&#39;", "'", $contentmain);
$pdf_data['author'] = XoopsUser::getUnameFromId($obj->getVar('content_uid'));

//Other stuff
$puff = '<br />';
$puffer = '<br /><br /><br />';

//Date / Author display
if (isset($content_topic) && $content_topic > 0  &&  $view_topic->getVar('topic_showtype') != '0') {
  if ($view_topic->getVar('topic_showdate')) {
      $page_date = $pdf_data['date'];
  }
  if ($view_topic->getVar('topic_showauthor')) {
       $page_author = ' - '.$pdf_data['author'];
  }
}else {
  if (xoops_getModuleOption('disp_date', $forMods->getVar('dirname'))) {
      $page_date = $pdf_data['date'];
  }
  if (xoops_getModuleOption('disp_author', $forMods->getVar('dirname'))) {
      $page_author = ' - '.$pdf_data['author'];
  }
}

//create the A4-PDF...
$pdf = new PDF();
if (method_exists($pdf, "encoding")) {
    $pdf->encoding($pdf_data, _CHARSET);
}
$pdf->SetCreator($pdf_config['creator']);
$pdf->SetTitle($pdf_data['title']);
$pdf->SetAuthor($pdf_data['author']);
$pdf->SetSubject();
$out = $pdf_config['url'] . ', ' . $pdf_data['author'] . ', ' . $pdf_data['title'] . ', ' . $pdf_data['subtitle'] . ', ' . $pdf_data['subsubtitle'];
$pdf->SetKeywords($out);
$pdf->SetAutoPageBreak(true, 25);
$pdf->SetMargins($pdf_config['margin']['left'], $pdf_config['margin']['top'], $pdf_config['margin']['right']);
$pdf->Open();

//First page
$pdf->AddPage();
$pdf->SetXY(24, 25);
$pdf->SetTextColor(10, 60, 160);
$pdf->SetFont($pdf_config['font']['slogan']['family'], $pdf_config['font']['slogan']['style'], $pdf_config['font']['slogan']['size']);
$pdf->WriteHTML($pdf_config['slogan'], $pdf_config['scale']);
$pdf->Line(25, 30, 190, 30);
$pdf->SetXY(25, 35);
$pdf->SetFont($pdf_config['font']['title']['family'], $pdf_config['font']['title']['style'], $pdf_config['font']['title']['size']);
$pdf->WriteHTML($pdf_data['title'], $pdf_config['scale']);

if ($pdf_data['subtitle'] != '') {
    $pdf->WriteHTML($puff, $pdf_config['scale']);
    $pdf->SetFont($pdf_config['font']['subtitle']['family'], $pdf_config['font']['subtitle']['style'], $pdf_config['font']['subtitle']['size']);
    $pdf->WriteHTML($pdf_data['subtitle'], $pdf_config['scale']);
}
if ($pdf_data['subsubtitle'] != '') {
    $pdf->WriteHTML($puff, $pdf_config['scale']);
    $pdf->SetFont($pdf_config['font']['subsubtitle']['family'], $pdf_config['font']['subsubtitle']['style'], $pdf_config['font']['subsubtitle']['size']);
    $pdf->WriteHTML($pdf_data['subsubtitle'], $pdf_config['scale']);
}
$pdf->WriteHTML($puff, $pdf_config['scale']);
$pdf->SetFont($pdf_config['font']['author']['family'], $pdf_config['font']['author']['style'], $pdf_config['font']['author']['size']);
//$out = _FMCONTENT_AUTHOR.': ';
$out = $page_date;
$out .= $page_author;
$pdf->WriteHTML($out, $pdf_config['scale']);
$pdf->WriteHTML($puff, $pdf_config['scale']);
//$out = _FMCONTENT_DATE.': ';
//$out = $pdf_data['date'];
//$pdf->WriteHTML($out, $pdf_config['scale']);
//$pdf->WriteHTML($puff, $pdf_config['scale']);

$pdf->SetTextColor(0, 0, 0);
$pdf->WriteHTML($puff, $pdf_config['scale']);

$pdf->SetFont($pdf_config['font']['content']['family'], $pdf_config['font']['content']['style'], $pdf_config['font']['content']['size']);
$pdf->WriteHTML($pdf_data['content'], $pdf_config['scale']);

$pdf->Output();
?>