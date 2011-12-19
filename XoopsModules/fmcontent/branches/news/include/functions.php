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
 * News Functions
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

/**
 * Get variables passed by GET or POST method
 *
 */
function news_CleanVars(&$global, $key, $default = '', $type = 'int') {

    switch ($type) {
        case 'array':
            $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
            break;
        case 'date':
            $ret = (isset($global[$key])) ? strtotime($global[$key]) : $default;
            break;
        case 'string':
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int': default:
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if ($ret === false) {
        return $default;
    }
    return $ret;
}

function News_isEditorHTML($module) {
    $editor = xoops_getModuleOption('form_editor', $module);
    if (isset($editor) && in_array($editor, array('tinymce', 'fckeditor', 'koivi', 'inbetween', 'spaw', 'ckeditor'))) {
        return true;
    }
    return false;
}

/**
 * Replace all escape, character, ... for display a correct url
 *
 * @String  $url    string to transform
 * @String  $type   string replacement for any blank case
 * @return  $url
 */
function News_Filter($url, $type = '', $module = 'news') {

    // Get regular expression from module setting. default setting is : `[^a-z0-9]`i
    $regular_expression = xoops_getModuleOption('regular_expression', $module);
    
    $url = strip_tags($url);
    $url = preg_replace("`\[.*\]`U", "", $url);
    $url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $url);
    $url = htmlentities($url, ENT_COMPAT, 'utf-8');
    $url = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $url);
    $url = preg_replace(array($regular_expression, "`[-]+`"), "-", $url);
    $url = ($url == "") ? $type : strtolower(trim($url, '-'));
    return $url;
}

/**
 * Replace all escape, character, ... for display a correct Meta
 *
 * @String  $meta    string to transform
 * @String  $type   string replacement for any blank case
 * @return  $meta
 */
function News_MetaFilter($meta, $type = '', $module = 'news') {

    // Get regular expression from module setting. default setting is : `[^a-z0-9]`i
    $regular_expression = xoops_getModuleOption('regular_expression', $module);
    
    $meta = strip_tags($meta);
    $meta = preg_replace("`\[.*\]`U", "", $meta);
    $meta = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', ',', $meta);
    $meta = htmlentities($meta, ENT_COMPAT, 'utf-8');
    $meta = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $meta);
    $meta = preg_replace(array($regular_expression, "`[,]+`"), ",", $meta);
    $meta = ($meta == "") ? $type : strtolower(trim($meta, ','));
    return $meta;
}

/**
 * Replace all escape, character, ... for display a correct text
 *
 * @String  $text    string to transform
 * @String  $type   string replacement for any blank case
 * @return  $text
 */
function News_AjaxFilter($text, $type = '') {
	 $text = strip_tags($text);
    $text = preg_replace("`\[.*\]`U", "", $text);
    $text = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $text);
    $text = htmlentities($text, ENT_COMPAT, 'utf-8');
    $text = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i", "\\1", $text);
    $text = stripslashes($text);
    return $text;
}

function News_Redirect($url, $time = 3, $message = '') {
    global $xoopsModule;
    if (preg_match("/[\\0-\\31]|about:|script:/i", $url)) {
        if (!preg_match('/^\b(java)?script:([\s]*)history\.go\(-[0-9]*\)([\s]*[;]*[\s]*)$/si', $url)) {
            $url = XOOPS_URL;
        }
    }
    // Create Template instance
    $tpl = new XoopsTpl();
    // Assign Vars
    $tpl->assign('url', $url);
    $tpl->assign('time', $time);
    $tpl->assign('message', $message);
    $tpl->assign('ifnotreload', sprintf(_IFNOTRELOAD, $url));
    // Call template file
    echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/news_redirect.html');
    // Force redirection
    header("refresh: " . $time . "; url=" . $url);
}

function News_Message($page, $message = '', $id , $handler) {
    global $xoopsModule;
    $tpl = new XoopsTpl();
    //ob_start();
    $tpl->assign('message', $message);
    $tpl->assign('id', $id);
    $tpl->assign('url', $page);
    $tpl->assign('handler', $handler);
    $tpl->assign('ifnotreload', sprintf(_IFNOTRELOAD, $page));
    echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/admin/news_confirm.html');
    //ob_flush();
}

function News_TopicUrl($module, $array) {
    $lenght_id = xoops_getModuleOption('lenght_id', $module);
    $friendly_url = xoops_getModuleOption('friendly_url', $module);
    if ($lenght_id != 0) {
        $id = $array['topic_id'];
        while (strlen($id) < $lenght_id)
            $id = "0" . $id;
    } else {
        $id = $array['topic_id'];
    }

    switch ($friendly_url) {

        case 'none':
            $rewrite_base = '/modules/';
            $page = 'page=' . $array['topic_alias'];
            return XOOPS_URL . $rewrite_base . $module . '/index.php?storytopic=' . $id . '&amp;' . $page;
            break;

        case 'rewrite':
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if(xoops_getModuleOption('rewrite_name', $module)) {
	            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }	
            $page = $array['topic_alias'];
            $type = xoops_getModuleOption('topic_name', $module) . '/';
            $id = $id . '/';
            return XOOPS_URL . $rewrite_base . $module_name . $type . $id . $page . $rewrite_ext;
            break;
            
         case 'short':  
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if(xoops_getModuleOption('rewrite_name', $module)) {
	            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }	
            $page = $array['topic_alias'];
            $type = xoops_getModuleOption('topic_name', $module) . '/';
            return XOOPS_URL . $rewrite_base . $module_name . $type . $page . $rewrite_ext;
            break; 
         
         case 'id': 
            return XOOPS_URL . '/modules/' . $module . '/index.php?storytopic=' . $id;
            break;  
    }
    
}

function News_Url($module, $array , $type = 'article') {
    $comment = '';
    $lenght_id = xoops_getModuleOption('lenght_id', $module);
    $friendly_url = xoops_getModuleOption('friendly_url', $module);

    if ($lenght_id != 0) {
        $id = $array['story_id'];
        while (strlen($id) < $lenght_id)
            $id = "0" . $id;
    } else {
        $id = $array['story_id'];
    }

    if (isset($array['topic_alias']) && $array['topic_alias']) {
        $topic_name = $array['topic_alias'];
    } else {
        $topic_name = News_Filter(xoops_getModuleOption('static_name', $module));
    }

    switch ($friendly_url) {

        case 'none':
            if($topic_name) {
	             $topic_name = 'topic=' . $topic_name . '&amp;';
            }
            $rewrite_base = '/modules/';
            $page = 'page=' . $array['story_alias'];
            return XOOPS_URL . $rewrite_base . $module . '/' . $type . '.php?' . $topic_name . 'storyid=' . $id . '&amp;' . $page . $comment;
            break;

        case 'rewrite':
            if($topic_name) {
                $topic_name = $topic_name . '/';
            }   
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if(xoops_getModuleOption('rewrite_name', $module)) {
	            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }	
            $page = $array['story_alias'];
            $type = $type . '/';
            $id = $id . '/';
            if ($type == 'content/') $type = '';

            if ($type == 'comment-edit/' || $type == 'comment-reply/' || $type == 'comment-delete/') {
                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
            }
            
            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name  . $id . $page . $rewrite_ext;
            break;
            
         case 'short':  
            if($topic_name) {
                $topic_name = $topic_name . '/';
            }   
            $rewrite_base = xoops_getModuleOption('rewrite_mode', $module);
            $rewrite_ext = xoops_getModuleOption('rewrite_ext', $module);
            $module_name = '';
            if(xoops_getModuleOption('rewrite_name', $module)) {
	            $module_name = xoops_getModuleOption('rewrite_name', $module) . '/';
            }	
            $page = $array['story_alias'];
            $type = $type . '/';
            if ($type == 'content/') $type = '';

            if ($type == 'comment-edit/' || $type == 'comment-reply/' || $type == 'comment-delete/') {
                return XOOPS_URL . $rewrite_base . $module_name . $type . $id . '/';
            }
            
            return XOOPS_URL . $rewrite_base . $module_name . $type . $topic_name . $page . $rewrite_ext;
            break;
          
         case 'id': 
            return XOOPS_URL . '/modules/' . $module . '/' . $type . '.php?storyid=' . $id;
            break;     
    }
}

function order_array_num($array, $key, $order = "ASC") {
    $tmp = array();
    foreach ($array as $akey => $array2)
    {
        $tmp[$akey] = $array2[$key];
    }

    if ($order == "DESC") {
        arsort($tmp, SORT_NUMERIC);
    }
    else
    {
        asort($tmp, SORT_NUMERIC);
    }

    $tmp2 = array();
    foreach ($tmp as $key => $value)
    {
        $tmp2[$key] = $array[$key];
    }

    return $tmp2;
}

?>