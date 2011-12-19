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
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($forMods)) exit('Module not found');

function news_page_show($options) {
    global $xoTheme, $xoopsTpl, $module_header;
    // Create Module Instance
    $module_handler =& xoops_gethandler('module');
    $forMods =& $module_handler->getByDirname('news');
    // Initialize content handler
    $story_handler = xoops_getmodulehandler ( 'story', 'news' );
    $topic_handler = xoops_getmodulehandler ( 'topic', 'news' );
    // Get the content menu
    $content = $story_handler->get($options[0]);
    // Add block data
    $block = $content->toArray();
    $topic = $topic_handler->get($block['story_topic']);
    $topic = $topic->toArray();
    $block['topic_id'] = $topic['topic_id'];
    $block['topic_title'] = $topic['topic_title'];
    $block['topic_alias'] = $topic['topic_alias'];
    $block['link'] = News_Url( $forMods->getVar('dirname'), $block );
    $block['imageurl'] = XOOPS_URL . xoops_getModuleOption('img_dir', $forMods->getVar('dirname')) . '/medium/';
    $block['thumburl'] = XOOPS_URL . xoops_getModuleOption('img_dir', $forMods->getVar('dirname')) . '/thumb/';
    $block['width'] = xoops_getModuleOption('imgwidth', $forMods->getVar('dirname'));
    $block['float'] = xoops_getModuleOption('imgfloat', $forMods->getVar('dirname'));
    // Add styles
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/blocks.css', null);
    // Return block array
    return $block;
}

function news_page_edit($options) {
    require_once XOOPS_ROOT_PATH . '/modules/news/class/registry.php';
    $registry =& ForRegistry::getInstance();
    // Initialize content handler
    $story_handler = xoops_getmodulehandler('story', 'news');

    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('story_status', '1'));
    $content = $story_handler->getObjects($criteria);
    $form = _NEWS_MB_SELECTPAGE . '<select name="options[]">';
    foreach (array_keys($content) as $i) {
        $form .= '<option value="' . $content[$i]->getVar('story_id') . '"';
        if ($options[0] == $content[$i]->getVar('story_id')) {
            $form .= " selected='selected'";
        }
        $form .= ">" . $content[$i]->getVar('story_title') . "</option>\n";
    }
    $form .= "</select>\n";
    //$form .= "<input type='hidden' value='" . $options[1] . "'>\n";
    return $form;
}

?>