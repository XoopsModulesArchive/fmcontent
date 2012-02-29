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
 * News index file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */
 
require dirname(__FILE__) . '/header.php';
if (!isset($NewsModule)) exit('Module not found'); 
 
include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php';
 include_once XOOPS_ROOT_PATH . "/class/pagenav.php";
// Initialize content handler
$story_handler = xoops_getmodulehandler ( 'story', 'news' );
$topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
$file_handler = xoops_getmodulehandler('file', 'news');
 
// Include content template
$xoopsOption ['template_main'] = 'news_archive.html'; 

// include Xoops header
include XOOPS_ROOT_PATH . '/header.php'; 
 
// Add Stylesheet
$xoTheme->addStylesheet ( XOOPS_URL . '/modules/' . $NewsModule->getVar ( 'dirname' ) . '/css/style.css' );
 
$lastyear = 0;
$lastmonth = 0;

$months_arr = array(1 => _CAL_JANUARY, 2 => _CAL_FEBRUARY, 3 => _CAL_MARCH, 4 => _CAL_APRIL, 5 => _CAL_MAY, 6 => _CAL_JUNE, 7 => _CAL_JULY, 8 => _CAL_AUGUST, 9 => _CAL_SEPTEMBER, 10 => _CAL_OCTOBER, 11 => _CAL_NOVEMBER, 12 => _CAL_DECEMBER);

$fromyear = NewsUtils::News_CleanVars ( $_GET, 'year', 0, 'int' );
$frommonth = NewsUtils::News_CleanVars ( $_GET, 'month', 0, 'int' );
$start = NewsUtils::News_CleanVars ( $_GET, 'start', 0, 'int' );
$limit = NewsUtils::News_CleanVars ( $_GET, 'limit', 50, 'int' );

$pgtitle = '';
if($fromyear && $frommonth) {
	$pgtitle = sprintf(" - %d - %d", $fromyear, $frommonth);
}

$dateformat='m';

$xoopsTpl->assign('xoops_pagetitle', _NEWS_MD_ARCHIVE . $pgtitle . ' - ' . $xoopsModule->name('s'));
 
$useroffset = '';
if(is_object($xoopsUser)) {
	$timezone = $xoopsUser->timezone();
	if(isset($timezone)){
		$useroffset = $xoopsUser->timezone();
	} else {
		$useroffset = $xoopsConfig['default_TZ'];
	}
}
 
$result = $story_handler->News_GetArchiveMonth($NewsModule);
$years = array();
$months = array();
$i = 0;

while (list($time) = $xoopsDB->fetchRow($result)) {
	$time = formatTimestamp($time, 'mysql', $useroffset);
	if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $time, $datetime)) {
			$this_year  = intval($datetime[1]);
			$this_month = intval($datetime[2]);
		if (empty($lastyear)) {
			$lastyear = $this_year;
		}
		if ($lastmonth == 0) {
			$lastmonth = $this_month;
			$months[$lastmonth]['string'] = $months_arr[$lastmonth];
			$months[$lastmonth]['number'] = $lastmonth;
		}
		if ($lastyear != $this_year) {
			$years[$i]['number'] = $lastyear;
			$years[$i]['months'] = $months;
			$months = array();
			$lastmonth = 0;
			$lastyear = $this_year;
			$i++;
		}
		if ($lastmonth != $this_month) {
			$lastmonth = $this_month;
			$months[$lastmonth]['string'] = $months_arr[$lastmonth];
			$months[$lastmonth]['number'] = $lastmonth;
		}
	}
}
	
	$years[$i]['number'] = $this_year;
	$years[$i]['months'] = $months;
	$xoopsTpl->assign('years', $years);
	$xoopsTpl->assign('module', $NewsModule->getVar ( 'dirname' ));


if ($fromyear != 0 && $frommonth != 0) {
	// must adjust the selected time to server timestamp
	$timeoffset = $useroffset - $xoopsConfig['server_TZ'];
	$monthstart = mktime(0 - $timeoffset, 0, 0, $frommonth, 1, $fromyear);
	$monthend = mktime(23 - $timeoffset, 59, 59, $frommonth + 1, 0, $fromyear);
	$monthend = ($monthend > time()) ? time() : $monthend;
   
   $topics = $topic_handler->getall (); 
	$archive = $story_handler->News_GetArchive($NewsModule , $monthstart, $monthend , $topics , $limit , $start);
	$numrows = $story_handler->News_GetArchiveCount($NewsModule, $publish_start, $publish_end ,$topics);
  
	if ($numrows > $limit) {
		$pagenav = new XoopsPageNav ( $numrows, $limit, $start, 'start', 'limit=' . $limit . '&year=' . $fromyear . '&month=' . $frommonth );
		$pagenav = $pagenav->renderNav ( 4 );
	} else {
		$pagenav = '';
	}
	
	$xoopsTpl->assign('archive', $archive);
	$xoopsTpl->assign('pagenav', $pagenav);
	$xoopsTpl->assign('show_articles', true);
} else {
   $xoopsTpl->assign('show_articles', false);
}


// include Xoops footer
include XOOPS_ROOT_PATH . '/footer.php'; 
?>