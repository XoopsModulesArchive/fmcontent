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
 * News action script file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @author      Hossein Azizabadi (AKA Voltan) 
 * @version     $Id$
 */

function xoops_module_pre_install_news($module) {
	

    $db = $GLOBALS["xoopsDB"];
    $error = false;
    
    /*
    if (substr(XOOPS_VERSION, 0, 9) < "XOOPS 2.5") {
        $module->setErrors("The module only works for XOOPS 2.5+");
        return false;
    }
    */
    $sqlfile = array('mysql' => 'sql/mysql.sql');

    $modsDirname = basename(dirname(dirname(__FILE__)));
    $indexFile = XOOPS_ROOT_PATH . "/uploads/index.html";
    $blankFile = XOOPS_ROOT_PATH . "/uploads/blank.gif";
    
    //Creation du fichier creator dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/news";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/index.html");
    }

    //Creation du fichier price dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/index.html");
	    copy($blankFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/blank.gif");
    }
    
    //Creation du fichier price dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/original";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/original/index.html");
	    copy($blankFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/original/blank.gif");
    }
    
    //Creation du fichier price dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/medium";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/medium/index.html");
	    copy($blankFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/medium/blank.gif");
    }
    
    //Creation du fichier price dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/thumb";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/thumb/index.html");
	    copy($blankFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/image/thumb/blank.gif");
    }
    
    //Creation du fichier price dans uploads
    $module_uploads = XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/file";
    if (!is_dir($module_uploads)) {
	    mkdir($module_uploads, 0777);
	    chmod($module_uploads, 0777);
	    copy($indexFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/file/index.html");
	    copy($blankFile, XOOPS_ROOT_PATH . "/uploads/" . $modsDirname . "/file/blank.gif");
    }
    
    if (is_array($sqlfile) && !empty($sqlfile[XOOPS_DB_TYPE])) {
        $sql_file_path = XOOPS_ROOT_PATH . "/modules/" . $modsDirname . "/" . $sqlfile[XOOPS_DB_TYPE];
        
        if (!file_exists($sql_file_path)) {
            $module->setErrors("<p>" . sprintf(_NEWS_MI_SQL_NOT_FOUND, "<strong>{$sql_file_path}</strong>"));
            $error = true;
        } else {
            $msgs[] = "<p>" . sprintf(_NEWS_MI_SQL_FOUND, "<strong>{$sql_file_path}</strong>") . "<br  />" . _NEWS_MI_CREATE_TABLES;

            require_once $GLOBALS['xoops']->path('/class/database/sqlutility.php');
            $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
            $sql_query = trim($sql_query);
            SqlUtility::splitMySqlFile($pieces, $sql_query);
            $created_tables = array();
            foreach ($pieces as $piece) {
                // [0] contains the prefixed query
                // [4] contains unprefixed table name
                $prefixed_query = SqlUtility::prefixQuery($piece, $db->prefix());
                if (!$prefixed_query) {
                    $module->setErrors("<p>" . sprintf(_NEWS_MI_SQL_NOT_VALID, "<strong>" . $piece . "</strong>"));
                    $error = true;
                    break;
                }
                
                if (!isset($reservedTables)) {
                	$reservedTables = array();
                }	
                // check if the table name is reserved
                if (!in_array($prefixed_query[4], $reservedTables)) {
                    // not reserved, so try to create one
                    if (!$db->query($prefixed_query[0])) {
                        $errs[] = $db->error();
                        $error = true;
                        break;
                    } else {
                        if (!in_array($prefixed_query[4], $created_tables)) {
                            $msgs[] = "&nbsp;&nbsp;" . sprintf(_NEWS_MI_TABLE_CREATED, "<strong>" . $db->prefix($prefixed_query[4]) . "</strong>");
                            $created_tables[] = $prefixed_query[4];
                        } else {
                            $msgs[] = "&nbsp;&nbsp;" . sprintf(_NEWS_MI_INSERT_DATA, "<strong>" . $db->prefix($prefixed_query[4]) . "</strong>");
                        }
                    }
                } else {
                    // the table name is reserved, so halt the installation
                    $module->setErrors("&nbsp;&nbsp;" . sprintf(_NEWS_MI_TABLE_RESERVED, "<strong>" . $prefixed_query[4] . "</strong>"));
                    $error = true;
                    break;
                }
            }
            // if there was an error, delete the tables created so far, so the next installation will not fail
            if ($error == true) {
                foreach ($created_tables as $ct) {
                    $db->query("DROP TABLE " . $db->prefix($ct));
                }
                return false;
            }
        }
        return true;
    }
    return false;
}

?>