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
 * @author      Hossein Azizabadi (AKA Voltan) 
 * @version     $Id$
 */

/**
 * This function work just for update version 1.68 ( or 1.66 ) to version 1.8 and upper. 
 * If your version is under 1.68 ( or 1.66 ) please frist update your old version to 1.68.
 */
function xoops_module_update_news($module, $version) {

    // start update to version 1.81
    if($version < 181) {
    	 
    	$db = $GLOBALS["xoopsDB"];
	   $error = false;
	   
		include_once XOOPS_ROOT_PATH . '/modules/news/class/utils.php';
		 
		if(!NewsUtils::News_FieldExists('story_slide' ,$db->prefix('news_story')))
		{
		 	 NewsUtils::News_AddField('`story_slide` TINYINT( 1 ) NOT NULL AFTER `story_status`' ,$db->prefix('news_story'));
		}
		
		if(!NewsUtils::News_FieldExists('story_marque' ,$db->prefix('news_story')))
		{
		 	 NewsUtils::News_AddField('`story_marque` TINYINT( 1 ) NOT NULL AFTER `story_slide`' ,$db->prefix('news_story'));
		}	
		    	
    }	
    // end update to version 1.81	
    
    // start update to version 1.80
	 if($version < 180) {
	 	
	 	 $modsDirname = basename(dirname(dirname(__FILE__)));
		 if($modsDirname != 'news') {
			 return false;
		 }	 
	 
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
	    
		$db = $GLOBALS["xoopsDB"];
	   $error = false;
	    
		include_once XOOPS_ROOT_PATH . '/modules/news/include/functions.php';
		include_once XOOPS_ROOT_PATH . '/modules/news/class/perm.php';
		include_once XOOPS_ROOT_PATH . '/modules/news/class/utils.php';
		include_once XOOPS_ROOT_PATH . '/class/template.php';
		include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
	
	    
	
		if(!NewsUtils::News_TableExists($db->prefix('news_story')))
		{
			$sql = "CREATE TABLE " . $db->prefix('news_story') . " (
				`story_id` int(10) NOT NULL auto_increment,
				`story_title` varchar(255) NOT NULL,
				`story_subtitle` varchar(255) NOT NULL,
				`story_titleview` tinyint(1) NOT NULL default '1',
				`story_topic` int(11) NOT NULL,
				`story_type` varchar(25) NOT NULL,
				`story_short` text NOT NULL,
				`story_text` text NOT NULL,
				`story_link` varchar(255) NOT NULL,
				`story_words` varchar(255) NOT NULL,
				`story_desc` varchar(255) NOT NULL,
				`story_alias` varchar(255) NOT NULL,
				`story_important` tinyint(1) NOT NULL,
				`story_default` tinyint(1) NOT NULL,
				`story_status` tinyint(1) NOT NULL,
				`story_slide` tinyint(1) NOT NULL,
            `story_marque` tinyint(1) NOT NULL,
				`story_create` int (10) NOT NULL default '0',
				`story_update` int (10) NOT NULL default '0',
				`story_publish` int (10) NOT NULL default '0',
				`story_expire` int (10) NOT NULL default '0',
				`story_uid` int(11) NOT NULL,
				`story_author` varchar(255) NOT NULL,
				`story_source` varchar(255) NOT NULL,
				`story_groups` varchar(255) NOT NULL,
				`story_order` int(11) NOT NULL,
				`story_next` int(11) NOT NULL default '0',
				`story_prev` int(11) NOT NULL default '0',
				`story_modid` int(11) NOT NULL,
				`story_hits` int(11) NOT NULL,
				`story_img` varchar(255) NOT NULL,
				`story_comments` int(11) unsigned NOT NULL default '0',
				`story_file` tinyint(3) NOT NULL,
				`dohtml` tinyint(1) NOT NULL,
				`dobr` tinyint(1) NOT NULL,
				`doimage` tinyint(1) NOT NULL,
				`dosmiley` tinyint(1) NOT NULL,
				`doxcode` tinyint(1) NOT NULL,
				PRIMARY KEY (`story_id`),
				KEY `idxstoriestopic` (`story_topic`),
				KEY `story_title` (`story_title`),
				KEY `story_create` (`story_create`),
				FULLTEXT KEY `search` (`story_title`,`story_short`,`story_text`,`story_subtitle`)
				) ENGINE=MyISAM;";
			if (!$db->queryF($sql)) {
				return false;
			}
		}
		
		if(!NewsUtils::News_TableExists($db->prefix('news_topic')))
		{
			$sql = "CREATE TABLE " . $db->prefix('news_topic') . " (
				`topic_id` int (11) unsigned NOT NULL  auto_increment,
				`topic_pid` int (5) unsigned NOT NULL ,
				`topic_title` varchar (255)   NOT NULL ,
				`topic_desc` text   NOT NULL ,
				`topic_img` varchar (255)   NOT NULL ,
				`topic_weight` int (5)   NOT NULL ,
				`topic_showtype` tinyint (4)   NOT NULL ,
				`topic_perpage` tinyint (4)   NOT NULL ,
				`topic_columns` tinyint (4)   NOT NULL ,
				`topic_submitter` int (10)   NOT NULL default '0',
				`topic_date_created` int (10)   NOT NULL default '0',
				`topic_date_update` int (10)   NOT NULL default '0',
				`topic_asmenu` tinyint (1)   NOT NULL default '1',
				`topic_online` tinyint (1)   NOT NULL default '1',
				`topic_modid` int(11) NOT NULL,
				`topic_showtopic` tinyint (1)   NOT NULL default '0',
				`topic_showauthor` tinyint (1)   NOT NULL default '1',
				`topic_showdate` tinyint (1)   NOT NULL default '1',
				`topic_showpdf` tinyint (1)   NOT NULL default '1',
				`topic_showprint` tinyint (1)   NOT NULL default '1',
				`topic_showmail` tinyint (1)   NOT NULL default '1',
				`topic_shownav` tinyint (1)   NOT NULL default '1',
				`topic_showhits` tinyint (1)   NOT NULL default '1',
				`topic_showcoms` tinyint (1)   NOT NULL default '1',
				`topic_alias` varchar(255) NOT NULL,
				`topic_homepage` tinyint (4)   NOT NULL ,
				`topic_show` tinyint (1)   NOT NULL default '1',
				PRIMARY KEY (`topic_id`,`topic_modid`),
				UNIQUE KEY `file_id` (`topic_id`,`topic_modid`)
				) ENGINE=MyISAM;";
			if (!$db->queryF($sql)) {
				return false;
			}
		}
		
		if(!NewsUtils::News_TableExists($db->prefix('news_file')))
		{
			$sql = "CREATE TABLE " . $db->prefix('news_file') . " (
				`file_id` int (11) unsigned NOT NULL  auto_increment,
				`file_modid` int(11) NOT NULL,
				`file_title` varchar (255)   NOT NULL ,
				`file_name` varchar (255)   NOT NULL ,
				`file_content` int(11) NOT NULL,
				`file_date` int(10) NOT NULL default '0',
				`file_type` varchar(64) NOT NULL default '',
				`file_status` tinyint(1) NOT NULL,
				`file_hits` int(11) NOT NULL,
				PRIMARY KEY (`file_id`,`file_modid`),
				UNIQUE KEY `file_id` (`file_id`,`file_modid`)
				) ENGINE=MyISAM;";
			if (!$db->queryF($sql)) {
				return false;
			}
		}
	
		//load needed handler
		$module_handler = xoops_gethandler('module');
		$comment_handler = xoops_gethandler('comment');
		$notification_handler = xoops_gethandler('notification');
		$topic_handler = xoops_getmodulehandler('topic', 'news');
	   $story_handler = xoops_getmodulehandler('story', 'news');
	   $file_handler = xoops_getmodulehandler('file', 'news');
	   $newsModule = $module_handler->getByDirname('news');
		$news_mid = $newsModule->getVar('mid');
	    
		$old_topics = $db->prefix('topics');
		$old_articles = $db->prefix('stories');
		$old_files = $db->prefix('stories_files');
		$old_rating = $db->prefix('stories_votedata');
		
		$new_news_topics = array();
		$mytree = new XoopsTree($old_topics,'topic_id','topic_pid');
	   $old_topics = $mytree->getChildTreeArray(0,'topic_id');

	   foreach($old_topics as $topic) {
	
			$topicobj = $topic_handler->create ();
			$topicobj->setVar ( 'topic_id', $topic['topic_id'] );
			$topicobj->setVar ( 'topic_pid', $topic['topic_pid'] );
			$topicobj->setVar ( 'topic_title', $topic['topic_title'] );
			$topicobj->setVar ( 'topic_img', $topic['topic_imgurl'] );
			$topicobj->setVar ( 'topic_desc', $topic['topic_description'] );
			$topicobj->setVar ( 'topic_modid', $news_mid);
			$topicobj->setVar ( 'topic_alias', NewsUtils::News_AliasFilter($topic['topic_title']));
			
	      if (! $topic_handler->insert ( $topicobj )) {
			   return false;
			}
			
			$result = $db->query('SELECT * FROM '.$old_articles.' WHERE topicid = '.$topic['topic_id'].' ORDER BY created');
			
			while ( $article = $db->fetchArray($result) ) {
	         
	         $storyobj = $story_handler->create ();			
				$storyobj->setVar ( 'story_id', $article['storyid']);
				$storyobj->setVar ( 'story_title', $article['title']);
				$storyobj->setVar ( 'story_titleview', '1' );
				$storyobj->setVar ( 'story_topic', $article['topicid']);
				$storyobj->setVar ( 'story_type', 'news' );
				$storyobj->setVar ( 'story_short', $article['hometext']);
				$storyobj->setVar ( 'story_text', $article['bodytext']);
				$storyobj->setVar ( 'story_words', $article['keywords']);
				$storyobj->setVar ( 'story_desc', $article['description']);
				$storyobj->setVar ( 'story_alias', NewsUtils::News_AliasFilter($article['title']));
				$storyobj->setVar ( 'story_status', '1');
				$storyobj->setVar ( 'story_create', $article['created']);
				$storyobj->setVar ( 'story_update', $article['created']);
				$storyobj->setVar ( 'story_publish', $article['published']);
				$storyobj->setVar ( 'story_expire', $article['expired']);
				$storyobj->setVar ( 'story_uid',  $article['uid']);
				$storyobj->setVar ( 'story_groups', '1 2 3');
				$storyobj->setVar ( 'story_modid', $news_mid );
				$storyobj->setVar ( 'story_hits', $article['counter']);
				$storyobj->setVar ( 'story_img', $article['picture']);
				$storyobj->setVar ( 'story_comments', $article['comments']);
				$storyobj->setVar ( 'dohtml', !$article['nohtml']);
				$storyobj->setVar ( 'dobr', 1);
				$storyobj->setVar ( 'doimage', 1);
				$storyobj->setVar ( 'dosmiley', !$article['nosmiley']);
				$storyobj->setVar ( 'doxcode', 1);
	         
		      if (! $story_handler->insert ( $storyobj )) {
			      return false;
				}
				
				// The files
				$result4 = $db->query('SELECT * FROM '.$old_files.' WHERE storyid='.$article['storyid']);
				while ( $file = $db->fetchArray($result4) ) {
		         $fileobj = $file_handler->create ();
		         $fileobj->setVar ( 'file_id', $file['fileid']);
		         $fileobj->setVar ( 'file_modid', $news_mid);
					$fileobj->setVar ( 'file_title', $file['filerealname']);
					$fileobj->setVar ( 'file_name', $file['downloadname']);
					$fileobj->setVar ( 'file_content', $file['storyid']);
					$fileobj->setVar ( 'file_date', $file['date']);
					$fileobj->setVar ( 'file_type', $file['mimetype']);
					$fileobj->setVar ( 'file_status', '1');
					$fileobj->setVar ( 'file_hits', $file['counter']);
	
			      if (! $file_handler->insert ( $fileobj )) {
			         return false;
					}
				}
			}	
	   }
	}
	// end update to version 1.80	
}

?>