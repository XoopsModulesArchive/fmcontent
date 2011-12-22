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
 * News Admin page
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

require dirname(__FILE__) . '/header.php';
if (!isset($forMods)) exit('Module not found');

// Display Admin header
xoops_cp_header();
// Define default value
$op = news_CleanVars($_REQUEST, 'op', 'display', 'string');
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $forMods->getVar('dirname') . '/css/admin.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
// Initialize content handler
$topic_handler = xoops_getmodulehandler('topic', 'news');
$story_handler = xoops_getmodulehandler('story', 'news');
        
switch ($op) {

    case 'display':
    default:
        
        // Add clone
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_FORMFOLDER_TITLE, 'tools', 'tools.php', 'post');
        $form->addElement(new XoopsFormText(_NEWS_AM_TOOLS_FORMFOLDER_NAME, 'folder_name', 50, 255, ''), true);
        $form->addElement(new XoopsFormHidden('op', 'clone'));
        $button_tray = new XoopsFormElementTray('', '');
        $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
        $button_tray->addElement($submit_btn);
        $form->addElement($button_tray);
        $xoopsTpl->assign('folder', $form->render());
        
        // remove contents form 
        $module_handler = xoops_gethandler('module');
        $result = $GLOBALS["xoopsDB"]->query("SELECT DISTINCT(story_modid) FROM " . $GLOBALS["xoopsDB"]->prefix('news_story'));
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_FORMPURGE_TITLE, 'tools', 'tools.php', 'post');
        $form->addElement(new XoopsFormHidden('op', 'purge'));
        $clone = array();
        while ($myrow = $GLOBALS["xoopsDB"]->fetchArray($result)) {
            if ($myrow['story_modid'] != $forMods->getVar('mid')) {
                if (!$module_handler->get($myrow['story_modid'])) {
                    $clone[] = $myrow['story_modid'];
                    $form->addElement(new XoopsFormHidden('modid[]', $myrow['story_modid']));
                }
            }
        }
        $button_tray = new XoopsFormElementTray('', '');
        $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
        $button_tray->addElement($submit_btn);
        $form->addElement($button_tray);
        if (count($clone)) {
            $xoopsTpl->assign('purge', $form->render());
        }
        
        // rebuild alias
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_ALIAS_CONTENT, 'tools', 'tools.php', 'post');  
        $form->addElement(new XoopsFormRadioYN ( _NEWS_AM_TOOLS_ALIAS_CONTENT, 'content', "1" ));
        $form->addElement(new XoopsFormHidden('op', 'alias'));
        $form->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
        $xoopsTpl->assign('alias', $form->render());
        
        // rebuild topic alias
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_ALIAS_TOPIC, 'tools', 'tools.php', 'post');  
        $form->addElement(new XoopsFormRadioYN ( _NEWS_AM_TOOLS_ALIAS_TOPIC, 'topic', "1" ));
        $form->addElement(new XoopsFormHidden('op', 'topicalias'));
        $form->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
        $xoopsTpl->assign('topicalias', $form->render());
        
        // rebuild description
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_META_DESCRIPTION, 'tools', 'tools.php', 'post');  
        $form->addElement(new XoopsFormRadioYN ( _NEWS_AM_TOOLS_META_DESCRIPTION, 'description', "1" ));
        $form->addElement(new XoopsFormHidden('op', 'description'));
        $form->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
        $xoopsTpl->assign('description', $form->render());
        
        // rebuild keyword
        $form = new XoopsThemeForm(_NEWS_AM_TOOLS_META_KEYWORD, 'tools', 'tools.php', 'post');  
        $form->addElement(new XoopsFormRadioYN ( _NEWS_AM_TOOLS_META_KEYWORD, 'keyword', "1" ));
        $form->addElement(new XoopsFormHidden('op', 'keyword'));
        $form->addElement(new XoopsFormButton('', 'post', _SUBMIT, 'submit'));
        $xoopsTpl->assign('keyword', $form->render());

        // other options  
        $xoopsTpl->assign('header', true );
        break;

    case 'clone':
        $folder = news_CleanVars($_REQUEST, 'folder_name', '', 'string');
        if (!is_dir(XOOPS_ROOT_PATH . '/modules/' . $folder)) {
            $folder_handler = new FolderHandler(XOOPS_ROOT_PATH . '/modules/' . $folder);
            $optn = array('to' => XOOPS_ROOT_PATH . '/modules/' . $folder, 'from' => XOOPS_ROOT_PATH . '/modules/news');
            $folder_handler->copy($optn);
            if (is_array($folder_handler->messages)) {
                $xoopsTpl->assign('messages', $folder_handler->messages);
            } else {
                $xoopsTpl->assign('messages', $folder_handler->erros);
            }
        } else {
            News_Redirect('tools.php', 1, _NEWS_AM_MSG_CLONE_ERROR);
        }
        break;

    case 'purge':
        $modid = $_REQUEST['modid'];
        foreach ($modid as $id) {
            $story_handler->deleteAll(new Criteria('story_modid', $id));
            $topic_handler->deleteAll(new Criteria('topic_modid', $id));
        }
        News_Redirect('tools.php', 20, _NEWS_AM_MSG_WAIT);
        break;
      
    case 'alias':
        $start_id = news_CleanVars($_REQUEST, 'start_id', '1', 'int');
        $end_id = news_CleanVars($_REQUEST, 'end_id', '1', 'int');	
        NewsUtils::news_rebuild ($story_handler , 'story_id' , 'alias' , 'story_alias' , 'story_title' , $start_id , $end_id);	   
        News_Redirect('tools.php', 20, _NEWS_AM_MSG_WAIT);
	     break;
	         
    case 'topicalias': 
        $start_id = news_CleanVars($_REQUEST, 'start_id', '1', 'int');
        $end_id = news_CleanVars($_REQUEST, 'end_id', '1', 'int');	
        NewsUtils::news_rebuild ($topic_handler , 'topic_id' , 'topicalias' , 'topic_alias' , 'topic_title' , $start_id , $end_id);	   
        News_Redirect('tools.php', 20, _NEWS_AM_MSG_WAIT);
	     break; 
    
    case 'keyword':
        $start_id = news_CleanVars($_REQUEST, 'start_id', '1', 'int');
        $end_id = news_CleanVars($_REQUEST, 'end_id', '1', 'int');	
        NewsUtils::news_rebuild ($story_handler , 'story_id' , 'keyword' , 'story_words' , 'story_title' , $start_id , $end_id);  
        News_Redirect('tools.php', 20, _NEWS_AM_MSG_WAIT);
	     break; 
       
    case 'description':
        $start_id = news_CleanVars($_REQUEST, 'start_id', '1', 'int');
        $end_id = news_CleanVars($_REQUEST, 'end_id', '1', 'int');	
        NewsUtils::news_rebuild ($story_handler , 'story_id' , 'description' , 'story_desc' , 'story_title' , $start_id , $end_id); 
        News_Redirect('tools.php', 20, _NEWS_AM_MSG_WAIT);
	     break; 
}

$xoopsTpl->assign('navigation', 'tools');
$xoopsTpl->assign('navtitle', _NEWS_MI_TOOLS);

// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $forMods->getVar('dirname') . '/templates/admin/news_tools.html');

// Display Xoops footer
include "footer.php";
xoops_cp_footer();

?>