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
 * Module block slide file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (Aka Voltan)
 * @version     $Id$
 */ 

function news_slide_show($options) {
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
    $block['slidetype'] = $options[2];
    $story_infos['title_lenght'] = $options[3];
    $story_infos['desc_lenght'] = $options[4];    
    $block['slidewidth'] = $options[5];
    $block['slideheight'] = $options[6];
    $block['imagewidth'] = $options[7];
    $block['imageheight'] = $options[8];
    
    array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $NewsModule = $module_handler->getByDirname($NewsModule);
    $story_infos['topics'] = $topic_handler->getall ();
    $block['slide'] = $story_handler->News_Slide($NewsModule, $story_infos ,$options);
    
    switch($block['slidetype']) {
    	
	    case 'scrollable':
		    $style = '
	         .slider {
					width: '. $block['slidewidth'] .'px;
					height: '. $block['slideheight']*1.06 .'px;
				}
				.slider .main {
					height: '. $block['slideheight']*1.06 .'px;
				}
				.slider .page {
					width: '. $block['slidewidth'] .'px;
					height: '. $block['slideheight'] .'px;
				}	
				.slider .scrollable {
					width: '. $block['slidewidth'] .'px;
					height: '. $block['slideheight'] .'px;
				}
				.slider .item {
					width: '. $block['slidewidth'] .'px;
					height: '. $block['slideheight'] .'px;
				}
				.slider .item .itemleft img {
					width: '. $block['slidewidth']/2 .'px;
				}';
			 $xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
		    $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/scrollable/scrollable.js');
		    $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/scrollable/setting.js');
			 $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/scrollable.css');
			 $xoTheme->addStylesheet( null, array ('rel' => 'stylesheet'), $style );
		    break;
		    
		 case 'sliderkit':
	       $xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
		    $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/sliderkit/sliderkit.min.js');
		    $xoTheme->addScript(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/js/sliderkit/sliderkitsetting.js');
			 $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/sliderkit-core.css');	
			 $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/sliderkit-demos.css');
		    break;   	
    }	
    
    return $block;
	
}

function news_slide_edit($options) {
	
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
    $slide = new XoopsFormSelect(_NEWS_MB_SLIDETYPE, 'options[]', $options[2]);
    $slide->addOption("scrollable", _NEWS_MB_SLIDETYPE_1);
    $slide->addOption("sliderkit", _NEWS_MB_SLIDETYPE_2);
	 $form .= _NEWS_MB_SLIDETYPE . " : " . $slide->render() . '<br />';
	 $form .= _NEWS_MB_CHARS . ":<input type=\"text\" name=\"options[3]\" size=\"5\" maxlength=\"10\" value=\"" . $options[3] . "\" /><br />";
    $form .= _NEWS_MB_CHARS_DESC . ":<input type=\"text\" name=\"options[4]\" size=\"5\" maxlength=\"10\" value=\"" . $options[4] . "\" /><br />";
    
    $form .= _NEWS_MB_SLIDEW . ":<input type=\"text\" name=\"options[5]\" size=\"5\" maxlength=\"10\" value=\"" . $options[5] . "\" /><br />";
    $form .= _NEWS_MB_SLIDEh . ":<input type=\"text\" name=\"options[6]\" size=\"5\" maxlength=\"10\" value=\"" . $options[6] . "\" /><br />";
    $form .= _NEWS_MB_IMAGEW . ":<input type=\"text\" name=\"options[7]\" size=\"5\" maxlength=\"10\" value=\"" . $options[7] . "\" /><br />";
    $form .= _NEWS_MB_IMAGEH . ":<input type=\"text\" name=\"options[8]\" size=\"5\" maxlength=\"10\" value=\"" . $options[8] . "\" /><br />";

	 array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
	 array_shift($options);
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