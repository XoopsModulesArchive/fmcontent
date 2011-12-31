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
 * Module block page file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Gregory Mage (Aka Mage)
 * @author      Hossein Azizabadi (Aka Voltan)
 * @version     $Id$
 */
 
function news_list_show($options) {

    $story_handler = xoops_getmodulehandler ( 'story', 'news' );
    $topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
    $module_handler = xoops_gethandler('module');
    
	 require_once XOOPS_ROOT_PATH . '/modules/news/include/functions.php';
	 require_once XOOPS_ROOT_PATH . '/modules/news/class/perm.php';
	 require_once XOOPS_ROOT_PATH . '/modules/news/class/utils.php';

    global $xoTheme;

    $block = array();
    $NewsModule = $options[0];
    $show = $options[1];
    $story_infos['story_limit'] = $options[2];
    $story_infos['lenght_title'] = $options[3];
    $showimg = $options[4];
    $showdescription = $options[5];
    $showdate = $options[6];
    $story_infos['story_sort'] = $options[7];
    $width = $options[8];
    $float = $options[9];
    $story_infos['story_order'] = $options[10];
    $block['showmore'] = $options[11];
    $block['morelink'] = $options[12];
    
    array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
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
    

    $options0 = $options[0];
    $story_infos ['topics'] = $topic_handler->getall ();
    $contents = $story_handler->News_GetContentBlockList($NewsModule, $story_infos ,$options);

    // Add block data
	 $block['show'] = $show;
    $block['img'] = $showimg;
    $block['imageurl'] = XOOPS_URL . xoops_getModuleOption('img_dir', $NewsModule->getVar('dirname')) . '/medium/';
    $block['thumburl'] = XOOPS_URL . xoops_getModuleOption('img_dir', $NewsModule->getVar('dirname')) . '/thumb/';
    $block['description'] = $showdescription;
    $block['date'] = $showdate;
    $block['contents'] = $contents;
    $block['width'] = $width;
    $block['float'] = $float;

    // Add styles
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $NewsModule->getVar('dirname') . '/css/blocks.css', null);

    return $block;

}

function news_list_edit($options) {

    //appel de la class
    $story_handler = xoops_getmodulehandler('story', 'news');
    $topic_handler = xoops_getmodulehandler('topic', 'news');
    $module_handler = xoops_gethandler('module');
    $NewsModule = $module_handler->getByDirname($options[0]);

    $criteria = new CriteriaCompo();
    $criteria->setSort('topic_weight ASC, topic_title');
    $criteria->setOrder('ASC');
    $topic_arr = $topic_handler->getall($criteria);

    //$form = _NEWS_MB_DISP . "&nbsp;\n";
    $form = "<input type=\"hidden\" name=\"options[]\" value=\"" . $options[0] . "\" />";
    
    $show_select = new XoopsFormSelect(_NEWS_MI_SHOWTYPE, 'options[]', $options[1]);
    $show_select->addOption("news", _NEWS_MI_SHOWTYPE_1);
    //$show_select->addOption("table", _NEWS_MI_SHOWTYPE_2);
    //$show_select->addOption("photo", _NEWS_MI_SHOWTYPE_3);
    $show_select->addOption("list", _NEWS_MI_SHOWTYPE_4);
    $show_select->addOption("spotlight", _NEWS_MI_SHOWTYPE_5);
	 $form .= _NEWS_MI_SHOWTYPE . " : " . $show_select->render() . '<br />';

    $form .= _NEWS_MB_NUMBER . " : <input name=\"options[2]\" size=\"5\" maxlength=\"255\" value=\"" . $options[2] . "\" type=\"text\" /><br />\n";
    $form .= _NEWS_MB_CHARS . " : <input name=\"options[3]\" size=\"5\" maxlength=\"255\" value=\"" . $options[3] . "\" type=\"text\" /><br />\n";

    if ($options[4] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _NEWS_MB_IMG . " : <input name=\"options[4]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[4]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    if ($options[5] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _NEWS_MB_DESCRIPTION . " : <input name=\"options[5]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[5]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    if ($options[6] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _NEWS_MB_DATE . " : <input name=\"options[6]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[6]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    $story_sort = new XoopsFormSelect(_NEWS_MI_SHOWSORT, 'options[]', $options[7]);
    $story_sort->addOption("story_id", _NEWS_MI_SHOWSORT_1);
    $story_sort->addOption("story_publish", _NEWS_MI_SHOWSORT_2);
    $story_sort->addOption("story_update", _NEWS_MI_SHOWSORT_3);
    $story_sort->addOption("story_title", _NEWS_MI_SHOWSORT_4);
    $story_sort->addOption("story_order", _NEWS_MI_SHOWSORT_5);
    $story_sort->addOption("RAND()", _NEWS_MI_SHOWSORT_6);
    $story_sort->addOption("story_hits", _NEWS_MI_SHOWSORT_7);
    $form .= _NEWS_MI_SHOWSORT . " : " . $story_sort->render() . '<br />';

    $form .= _NEWS_MB_WIDTH . " : <input name=\"options[8]\" size=\"5\" maxlength=\"255\" value=\"" . $options[8] . "\" type=\"text\" /><br />\n";

    $float_select = new XoopsFormSelect(_NEWS_MI_IMAGE_FLOAT, 'options[]', $options[9]);
    $float_select->addOption("left", _NEWS_MI_IMAGE_LEFT);
    $float_select->addOption("right", _NEWS_MI_IMAGE_RIGHT);
    $form .= _NEWS_MI_IMAGE_FLOAT . " : " . $float_select->render() . '<br />';
    
    $order_select = new XoopsFormSelect(_NEWS_MI_SHOWORDER, 'options[]', $options[10]);
    $order_select->addOption("DESC", _NEWS_MI_DESC);
    $order_select->addOption("ASC", _NEWS_MI_ASC);
    $form .= _NEWS_MI_SHOWORDER . " : " . $order_select->render() . '<br />';
		
	 if ($options[11] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _NEWS_MB_SHOE_MORELINK . " : <input name=\"options[11]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[11]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";
    	
    $form .= _NEWS_MB_MORELINK . " : <input name=\"options[12]\" size=\"50\" maxlength=\"255\" value=\"" . $options[12] . "\" type=\"text\" /><br />\n";
    	
	 array_shift($options);
	 array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);
    array_shift($options);

    $form .= "<br />" . _NEWS_MB_TOPICDISPLAY . "<br /><select name=\"options[]\" multiple=\"multiple\" size=\"5\">\n";
    $form .= "<option value=\"0\" " . (array_search(0, $options) === false ? '' : 'selected="selected"') . ">" . _NEWS_MB_ALLMENUS . "</option>\n";
    foreach (array_keys($topic_arr) as $i) {
        $form .= "<option value=\"" . $topic_arr[$i]->getVar('topic_id') . "\" " . (array_search($topic_arr[$i]->getVar('topic_id'), $options) === false ? '' : 'selected="selected"') . ">" . $topic_arr[$i]->getVar('topic_title') . "</option>\n";
    }
    $form .= "</select>\n";
    return $form;
}

?>