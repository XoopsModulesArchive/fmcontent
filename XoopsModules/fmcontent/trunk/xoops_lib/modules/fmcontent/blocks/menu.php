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
 * @version     $Id:$
 */
if (!function_exists('fmcontent_menu_show')) {
    function fmcontent_menu_show($options) {
        global $xoTheme, $xoopsTpl, $module_header;
        $myts =& MyTextSanitizer::getInstance();

        $block = array();
        $forMods = $options[0];
        $menutype = $options[1];
        $content_sort = $options[3];
        $order_select = $options[4];
        $content_infos['menu_id'] = $options[2];
        $content_infos['menu_sort'] = $content_sort;
        $content_infos['menu_order'] = $order_select;

        array_shift($options);
        array_shift($options);
        array_shift($options);
        array_shift($options);
        array_shift($options);

        $module_handler = xoops_gethandler('module');
        $forMods = $module_handler->getByDirname($forMods);

        // Initialize content handler
        $topic_handler = xoops_getmodulehandler('topic', 'fmcontent');
        $content_handler = xoops_getmodulehandler('page', 'fmcontent');

        $content = $content_handler->getMenuList($forMods, $content_infos);

        // Add block data
        $block['menu'] = $content;
        $block['module'] = $forMods;
        $block['type'] = $menutype;
        $block['current_url'] = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];

        // Add menu script in module header
        switch ($menutype) {
            case 'mainmenu':
                $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/' . $menutype . '.css', null);
                break;
            /*case 'vertical':

                break;
            case 'horizontal':

                break;*/
        }

        // Return the block array
        return $block;
    }
}
if (!function_exists('fmcontent_menu_edit')) {
    function fmcontent_menu_edit($options) {

        // Initialize content handler
        $content_handler = xoops_getmodulehandler('page', 'fmcontent');
        $topic_handler = xoops_getmodulehandler('topic', 'fmcontent');
        $module_handler = xoops_gethandler('module');
        $forMods = $module_handler->getByDirname($options[0]);

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('topic_modid', $forMods->getVar('mid')));
        $criteria->add(new Criteria('topic_asmenu', '1'));
        $criteria->add(new Criteria('topic_online', '1'));
        $criteria->setSort("topic_id");
        $criteria->setOrder("ASC");
        $topics = $topic_handler->getall($criteria);

        $form = "<input type=\"hidden\" name=\"options[]\" value=\"" . $options[0] . "\" />";

        $menutype = new XoopsFormSelect(_MI_FMCONTENT_TYPE, 'options[]', $options[1]);
        $menutype->addOption("mainmenu", _MI_FMCONTENT_SIMPLE);
        //$menutype->addOption("vertical", _MI_FMCONTENT_VERT);
        //$menutype->addOption("horizontal", _MI_FMCONTENT_HORIZ);
        $form .= _MI_FMCONTENT_TYPE . " : " . $menutype->render() . '<br />';

        $menu_id = new XoopsFormSelect(_MI_FMCONTENT_MENUTODISPLAY, 'options[]', $options[2]);
        $menu_id->addOption("-1", _MI_FMCONTENT_MENU_ALL);
        $menu_id->addOption("0", _MI_FMCONTENT_MENU_DEFAULT);
        $i = 1;
        foreach (array_keys($topics) as $i) {
            $menu_id->addOption($topics[$i]->getVar("topic_id"), $topics[$i]->getVar("topic_title"));
        }
        $form .= _MI_FMCONTENT_MENUTODISPLAY . " : " . $menu_id->render() . '<br />';

        $content_sort = new XoopsFormSelect(_FMCONTENT_SHOWSORT, 'options[]', $options[3]);
        $content_sort->addOption("content_id", _FMCONTENT_SHOWSORT_1);
        $content_sort->addOption("content_create", _FMCONTENT_SHOWSORT_2);
        $content_sort->addOption("content_update", _FMCONTENT_SHOWSORT_3);
        $content_sort->addOption("content_title", _FMCONTENT_SHOWSORT_4);
        $content_sort->addOption("content_order", _FMCONTENT_SHOWSORT_5);
        $content_sort->addOption("RAND()", _FMCONTENT_SHOWSORT_6);
        $form .= _FMCONTENT_SHOWSORT . " : " . $content_sort->render() . '<br />';

        $order_select = new XoopsFormSelect(_FMCONTENT_SHOWORDER, 'options[]', $options[4]);
        $order_select->addOption("DESC", _FMCONTENT_DESC);
        $order_select->addOption("ASC", _FMCONTENT_ASC);
        $form .= _FMCONTENT_SHOWORDER . " : " . $order_select->render() . '<br /><br />';

        array_shift($options);
        array_shift($options);
        array_shift($options);
        array_shift($options);
        array_shift($options);

        return $form;
    }
}
?>