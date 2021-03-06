CREATE TABLE `fmcontent_content` (
`content_id` int(10) NOT NULL auto_increment,
`content_title` varchar(255) NOT NULL,
`content_titleview` tinyint(1) NOT NULL default '1',
`content_topic` int(11) NOT NULL,
`content_menu` varchar(255) NOT NULL,
`content_type` varchar(25) NOT NULL,
`content_short` text NOT NULL,
`content_text` text NOT NULL,
`content_link` varchar(255) NOT NULL,
`content_words` text NOT NULL,
`content_desc` text NOT NULL,
`content_alias` varchar(255) NOT NULL,
`content_display` tinyint(1) NOT NULL,
`content_default` tinyint(1) NOT NULL,
`content_status` tinyint(1) NOT NULL,
`content_create` int (10) NOT NULL default '0',
`content_update` int (10) NOT NULL default '0',
`content_uid` int(11) NOT NULL,
`content_author` varchar(255) NOT NULL,
`content_source` varchar(255) NOT NULL,
`content_groups` varchar(255) NOT NULL,
`content_order` int(11) NOT NULL,
`content_next` int(11) NOT NULL default '0',
`content_prev` int(11) NOT NULL default '0',
`content_modid` int(11) NOT NULL,
`content_hits` int(11) NOT NULL,
`content_img` varchar(255) NOT NULL,
`content_comments` int(11) unsigned NOT NULL default '0',
`content_file` tinyint(3) NOT NULL,
`dohtml` tinyint(1) NOT NULL,
`dobr` tinyint(1) NOT NULL,
`doimage` tinyint(1) NOT NULL,
`dosmiley` tinyint(1) NOT NULL,
`doxcode` tinyint(1) NOT NULL,
PRIMARY KEY  (`content_id`,`content_modid`),
UNIQUE KEY `content_id` (`content_id`,`content_modid`)
) ENGINE=MyISAM ;


CREATE TABLE `fmcontent_topic` (
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

CREATE TABLE `fmcontent_file` (
`file_id` int (11) unsigned NOT NULL  auto_increment,
`file_modid` int(11) NOT NULL,
`file_title` varchar (255)   NOT NULL ,
`file_name` varchar (255)   NOT NULL ,
`file_content` int(11) NOT NULL,
`file_date` int(10) NOT NULL default '0',
`file_type` varchar(64) NOT NULL default '',
`file_status` tinyint(1) NOT NULL,
PRIMARY KEY (`file_id`,`file_modid`),
UNIQUE KEY `file_id` (`file_id`,`file_modid`)
) ENGINE=MyISAM;