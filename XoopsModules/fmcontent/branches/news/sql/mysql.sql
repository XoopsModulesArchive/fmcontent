CREATE TABLE `news_story` (
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
PRIMARY KEY  (`story_id`,`story_modid`),
UNIQUE KEY `story_id` (`story_id`,`story_modid`)
) ENGINE=MyISAM ;


CREATE TABLE `news_topic` (
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
UNIQUE KEY `topic_id` (`topic_id`,`topic_modid`)
) ENGINE=MyISAM;

CREATE TABLE `news_file` (
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
) ENGINE=MyISAM;