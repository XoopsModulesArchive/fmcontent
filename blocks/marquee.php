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
 * Module block marquee file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (Aka Voltan)
 * @version     $Id$
 */ 

function news_marquee_show($options) {
	
    $story_handler = xoops_getmodulehandler ( 'story', 'news' );
    $topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
    $module_handler = xoops_gethandler('module');
    
    require_once XOOPS_ROOT_PATH . '/modules/news/include/functions.php';
	 require_once XOOPS_ROOT_PATH . '/modules/news/class/perm.php';
	 require_once XOOPS_ROOT_PATH . '/modules/news/class/utils.php';

    global $xoTheme;

    $block = array();
    $story_infos = array();
    $NewsModule = $options[0];
    $story_infos['story_limit'] = $options[1];
    $story_infos['title_lenght'] = $options[2];
    $block['show_date'] = $options[3];

    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $NewsModule = $module_handler->getByDirname($NewsModule);
    $story_infos['topics'] = $topic_handler->getall ();
    $block['marquee'] = $story_handler->News_Marquee($NewsModule, $story_infos ,$options);
    
    $xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
	 $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/marquee/marquee.js');
	 $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/marquee/setting.js');
	 $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/marquee.css');
		    
    return $block;
}

function news_marquee_edit($options) {
	
	 //appel de la class
    $story_handler = xoops_getmodulehandler('story', 'news');
    $topic_handler = xoops_getmodulehandler('topic', 'news');
    $module_handler = xoops_gethandler('module');
    $NewsModule = $module_handler->getByDirname($options[0]);

    $criteria = new CriteriaCompo();
    $criteria->setSort('topic_weight ASC, topic_title');
    $criteria->setOrder('ASC');
    $topic_arr = $topic_handler->getall($criteria);

    $form = "<input type=\"hidden\" name=\"options[]\" value=\"" . $options[0] . "\" />";
    $form .= _NEWS_MB_NUMBER . " : <input type=\"text\" name=\"options[1]\" size=\"5\" maxlength=\"10\" value=\"" . $options[1] . "\" type=\"text\" /><br />\n";
	 $form .= _NEWS_MB_CHARS . ":<input type=\"text\" name=\"options[2]\" size=\"5\" maxlength=\"10\" value=\"" . $options[2] . "\" /><br />";
	
	 if ($options[3] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _NEWS_MB_DATE . " : <input name=\"options[3]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[3]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";
    
    array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
    
    $form .=  _NEWS_MB_TOPICDISPLAY . "<br /><select name=\"options[]\" multiple=\"multiple\" size=\"5\">\n";
    $form .= "<option value=\"0\" " . (array_search(0, $options) === false ? '' : 'selected="selected"') . ">" . _NEWS_MB_ALLMENUS . "</option>\n";
    foreach (array_keys($topic_arr) as $i) {
        $form .= "<option value=\"" . $topic_arr[$i]->getVar('topic_id') . "\" " . (array_search($topic_arr[$i]->getVar('topic_id'), $options) === false ? '' : 'selected="selected"') . ">" . $topic_arr[$i]->getVar('topic_title') . "</option>\n";
    }
    $form .= "</select>\n";
    return $form;
}
?>