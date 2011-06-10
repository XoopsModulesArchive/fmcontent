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
 * @version     $Id:$
 */
function fmcontent_list_show($options) {

    $content_handler = xoops_getmodulehandler('page', 'fmcontent');

    global $xoTheme;

    $block = array();
    $forMods = $options[0];
    $show = $options[1];
    $content_limit = $options[2];
    $lenght_title = $options[3];
    $showimg = $options[4];
    $showdescription = $options[5];
    $showdate = $options[6];
    $content_sort = $options[7];
    $width = $options[8];
    $float = $options[9];
    $content_order = $options[10];

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

    $module_handler = xoops_gethandler('module');
    $forMods = $module_handler->getByDirname($forMods);

    $options0 = $options[0];

    $contents = $content_handler->getContentBlockList($forMods, $content_limit, $content_sort, $content_order, $options, $lenght_title);

    // Add block data
	 $block['show'] = $show;
    $block['img'] = $showimg;
    $block['imgurl'] = XOOPS_URL . xoops_getModuleOption('img_dir', 'fmcontent');
    $block['description'] = $showdescription;
    $block['date'] = $showdate;
    $block['contents'] = $contents;
    $block['width'] = $width;
    $block['float'] = $float;

    // Add styles
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/blocks.css', null);

    return $block;

}

function fmcontent_list_edit($options) {

    //appel de la class
    $content_handler = xoops_getmodulehandler('page', 'fmcontent');
    $topic_handler = xoops_getmodulehandler('topic', 'fmcontent');
    $module_handler = xoops_gethandler('module');
    $forMods = $module_handler->getByDirname($options[0]);

    $criteria = new CriteriaCompo();
    $criteria->setSort('topic_weight ASC, topic_title');
    $criteria->setOrder('ASC');
    $topic_arr = $topic_handler->getall($criteria);

    //$form = _MI_FMCONTENT_DISP . "&nbsp;\n";
    $form = "<input type=\"hidden\" name=\"options[]\" value=\"" . $options[0] . "\" />";
    
    $show_select = new XoopsFormSelect(_FMCONTENT_SHOWTYPE, 'options[]', $options[1]);
    $show_select->addOption("news", _FMCONTENT_SHOWTYPE_1);
    //$show_select->addOption("table", _FMCONTENT_SHOWTYPE_2);
    //$show_select->addOption("photo", _FMCONTENT_SHOWTYPE_3);
    $show_select->addOption("list", _FMCONTENT_SHOWTYPE_4);
	 $form .= _FMCONTENT_SHOWTYPE . " : " . $show_select->render() . '<br />';

    $form .= _MI_FMCONTENT_NUMBER . " : <input name=\"options[2]\" size=\"5\" maxlength=\"255\" value=\"" . $options[2] . "\" type=\"text\" /><br />\n";
    $form .= _MI_FMCONTENT_CHARS . " : <input name=\"options[3]\" size=\"5\" maxlength=\"255\" value=\"" . $options[3] . "\" type=\"text\" /><br />\n";

    if ($options[4] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _MI_FMCONTENT_IMG . " : <input name=\"options[4]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[4]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    if ($options[5] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _MI_FMCONTENT_DESCRIPTION . " : <input name=\"options[5]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[5]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    if ($options[6] == false) {
        $checked_yes = '';
        $checked_no = 'checked="checked"';
    } else {
        $checked_yes = 'checked="checked"';
        $checked_no = '';
    }
    $form .= _MI_FMCONTENT_DATE . " : <input name=\"options[6]\" value=\"1\" type=\"radio\" " . $checked_yes . "/>" . _YES . "&nbsp;\n";
    $form .= "<input name=\"options[6]\" value=\"0\" type=\"radio\" " . $checked_no . "/>" . _NO . "<br />\n";

    $content_sort = new XoopsFormSelect(_FMCONTENT_SHOWSORT, 'options[]', $options[7]);
    $content_sort->addOption("content_id", _FMCONTENT_SHOWSORT_1);
    $content_sort->addOption("content_create", _FMCONTENT_SHOWSORT_2);
    $content_sort->addOption("content_update", _FMCONTENT_SHOWSORT_3);
    $content_sort->addOption("content_title", _FMCONTENT_SHOWSORT_4);
    $content_sort->addOption("content_order", _FMCONTENT_SHOWSORT_5);
    $content_sort->addOption("RAND()", _FMCONTENT_SHOWSORT_6);
    $form .= _FMCONTENT_SHOWSORT . " : " . $content_sort->render() . '<br />';

    $form .= _MI_FMCONTENT_WIDTH . " : <input name=\"options[8]\" size=\"5\" maxlength=\"255\" value=\"" . $options[8] . "\" type=\"text\" /><br />\n";

    $float_select = new XoopsFormSelect(_FMCONTENT_IMAGE_FLOAT, 'options[]', $options[9]);
    $float_select->addOption("left", _FMCONTENT_IMAGE_LEFT);
    $float_select->addOption("right", _FMCONTENT_IMAGE_RIGHT);
    $form .= _FMCONTENT_IMAGE_FLOAT . " : " . $float_select->render() . '<br />';
    
    $order_select = new XoopsFormSelect(_FMCONTENT_SHOWORDER, 'options[]', $options[10]);
    $order_select->addOption("DESC", _FMCONTENT_DESC);
    $order_select->addOption("ASC", _FMCONTENT_ASC);
    $form .= _FMCONTENT_SHOWORDER . " : " . $order_select->render() . '<br />';
		
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

    $form .= "<br />" . _MI_FMCONTENT_TOPICDISPLAY . "<br /><select name=\"options[]\" multiple=\"multiple\" size=\"5\">\n";
    $form .= "<option value=\"0\" " . (array_search(0, $options) === false ? '' : 'selected="selected"') . ">" . _MI_FMCONTENT_ALLMENUS . "</option>\n";
    foreach (array_keys($topic_arr) as $i) {
        $form .= "<option value=\"" . $topic_arr[$i]->getVar('topic_id') . "\" " . (array_search($topic_arr[$i]->getVar('topic_id'), $options) === false ? '' : 'selected="selected"') . ">" . $topic_arr[$i]->getVar('topic_title') . "</option>\n";
    }
    $form .= "</select>\n";
    return $form;
}

?>