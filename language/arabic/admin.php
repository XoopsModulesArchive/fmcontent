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
 * News language file
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id$
 */

// Global page
define('_NEWS_AM_GLOBAL_ADD_CONTENT', 'إنشاء الصفحة');
define('_NEWS_AM_GLOBAL_ADD_TOPIC', 'أنشاء الفئة');
define('_NEWS_AM_GLOBAL_ADD_FILE', 'إنشاء الملف');
define('_NEWS_AM_GLOBAL_IMG', 'الصورة');
define('_NEWS_AM_GLOBAL_FORMUPLOAD', 'إختیار الصورة');
// Index page
define("_NEWS_AM_INDEX_ADMENU1", "الفئات");
define("_NEWS_AM_INDEX_ADMENU2", "الصفحات");
define("_NEWS_AM_INDEX_TOPICS", "<span class='green'>%s</span> تقع الفئة في قاعدة البیانات");
define("_NEWS_AM_INDEX_CONTENTS", "<span class='green'>%s</span> تقع الصفحة في قاعدة البیانات ");
define("_NEWS_AM_INDEX_CONTENTS_OFFLINE", "There are <span class='red'>%s</span> Offline news in our database");
define("_NEWS_AM_INDEX_CONTENTS_EXPIRE", "There are <span class='red'>%s</span> Expire news in our database");
// Topic page
define('_NEWS_AM_TOPIC_FORM', 'إدارة الفئات');
define('_NEWS_AM_TOPIC_ID', 'ID');
define('_NEWS_AM_TOPIC_NUM', 'وزن');
define('_NEWS_AM_TOPIC_NAME', 'العنوان');
define('_NEWS_AM_TOPIC_PARENT', 'الفئة الرئیسیة');
define('_NEWS_AM_TOPIC_DESC', 'الوصف');
define('_NEWS_AM_TOPIC_IMG', 'الصورة');
define('_NEWS_AM_TOPIC_WEIGHT', 'العرض');
define('_NEWS_AM_TOPIC_SHOWTYPE','طریقة العرض');
define('_NEWS_AM_TOPIC_SHOWTYPE_DESC', 'إذا كنت تريد استخدام الإعدادات التالية.<br /> یجب تغییر <b>طریقة العرض</b> من وحدة القاعدة <br />الی خیارات أخری ها.');
define('_NEWS_AM_TOPIC_PERPAGE', 'کل الصفحة');
define('_NEWS_AM_TOPIC_COLUMNS', 'عمود');
define('_NEWS_AM_TOPIC_ONLINE', 'نشیط');
define('_NEWS_AM_TOPIC_MENU', 'القائمة');
define('_NEWS_AM_TOPIC_SHOW', 'العرض');
define('_NEWS_AM_TOPIC_ACTION', 'نشیط');
define('_NEWS_AM_TOPIC_PID', 'والد');
define('_NEWS_AM_TOPIC_DATE_CREATED','ساعة الإنشاء');
define('_NEWS_AM_TOPIC_DATE_UPDATE', 'ساعة التحدیث');
define('_NEWS_AM_TOPIC_SHOWTOPIC', 'عرض الفئة');
define('_NEWS_AM_TOPIC_SHOWAUTHOR', 'عرض المحرر');
define('_NEWS_AM_TOPIC_SHOWDATE', 'عرض التاریخ');
define('_NEWS_AM_TOPIC_SHOWDPF', 'عرض PDF');
define('_NEWS_AM_TOPIC_SHOWPRINT', 'عرض الطباعة');
define('_NEWS_AM_TOPIC_SHOWMAIL', 'عرض أخبار الأصدقاء');
define('_NEWS_AM_TOPIC_SHOWNAV', 'نمایش ناوبری');
define('_NEWS_AM_TOPIC_SHOWHITS', 'عرض الزایارات');
define('_NEWS_AM_TOPIC_SHOWCOMS', 'عرض التعلیقات المنشورة ');
define('_NEWS_AM_TOPIC_HOMEPAGE', 'خیارات الصفحة الأولی للفئة');
define('_NEWS_AM_TOPIC_HOMEPAGE_DESC', 'Seting content show type in topic pages');
define('_NEWS_AM_TOPIC_HOMEPAGE_1', 'List all contents from this topic and subtopics');
define('_NEWS_AM_TOPIC_HOMEPAGE_2', 'List all subtopics');
define('_NEWS_AM_TOPIC_HOMEPAGE_3', 'List all contents from just this topic');
define('_NEWS_AM_TOPIC_HOMEPAGE_4', 'Show selected content from this topic');
define('_NEWS_AM_TOPIC_OPTIONS', 'Sellect topic show options');
define('_NEWS_AM_TOPIC_OPTIONS_DESC', 'Sellect topic show options');
define('_NEWS_AM_TOPIC_ALIAS', 'الاسم المستعار');
define('_NEWS_AM_TOPIC_SHOWTYPE_0', 'Module based');
define('_NEWS_AM_TOPIC_SHOWTYPE_1', 'News type');
define('_NEWS_AM_TOPIC_SHOWTYPE_2', 'Table type');
define('_NEWS_AM_TOPIC_SHOWTYPE_3', 'Photo type');
define('_NEWS_AM_TOPIC_SHOWTYPE_4', 'List type');
define('_NEWS_AM_TOPIC_SHOWTYPE_5', 'Spotlight');
// Content page
define('_NEWS_AM_CONTENT_FORM', 'إدارة المحتوى');
define('_NEWS_AM_CONTENT_FORMTITLE', 'العنوان');
define('_NEWS_AM_CONTENT_FORMTITLE_DISP', 'عرض عنوان الصفحة؟');
define('_NEWS_AM_CONTENT_FORMAUTHOR', 'سازنده ( الإسم)');
define('_NEWS_AM_CONTENT_FORMSOURCE', 'مصدر ( الرابط)');
define('_NEWS_AM_CONTENT_FORMTEXT', 'النص');
define('_NEWS_AM_CONTENT_FORMTEXT_DESC', ' إنشاء أو تحرير صفحة');
define('_NEWS_AM_CONTENT_FORMGROUP', 'المجموعات');
define('_NEWS_AM_CONTENT_FORMALIAS', 'الإسم  المستعار');
define('_NEWS_AM_CONTENT_FORMACTIF', 'نشیط');
define('_NEWS_AM_CONTENT_IMPORTANT', 'عاجل');
define('_NEWS_AM_CONTENT_FORMDEFAULT', 'الإفتراضي');
define('_NEWS_AM_CONTENT_FORMPREV', 'السابقة');
define('_NEWS_AM_CONTENT_FORMNEXT', 'اللاحقة');
define('_NEWS_AM_CONTENT_DOHTML', 'العرض علی شکل Html');
define('_NEWS_AM_CONTENT_BREAKS', 'تبدیل خط شکسته فعال');
define('_NEWS_AM_CONTENT_DOIMAGE', 'عرض صورة النص');
define('_NEWS_AM_CONTENT_DOXCODE', 'عرض کود النص');
define('_NEWS_AM_CONTENT_DOSMILEY', 'عرض لبخند های محتوا');
define('_NEWS_AM_CONTENT_SHORT', 'الملخص');
define('_NEWS_AM_CONTENT_TITLE', 'العنوان');
define('_NEWS_AM_CONTENT_MANAGER', 'إدارة المحتوی');
define('_NEWS_AM_CONTENT_FILE', 'File');
define('_NEWS_AM_CONTENT_ID', 'ID');
define('_NEWS_AM_CONTENT_NUM', 'وزن');
define('_NEWS_AM_CONTENT_PAGE', 'الصفحة');
define('_NEWS_AM_CONTENT_TYPE', 'النوع');
define('_NEWS_AM_CONTENT_OWNER', 'سازنده');
define('_NEWS_AM_CONTENT_ACTIF', 'نشیط');
define('_NEWS_AM_CONTENT_DEFAULT', 'المقترض');
define('_NEWS_AM_CONTENT_ORDER', 'النظام');
define('_NEWS_AM_CONTENT_ACTION', 'العامل');
define('_NEWS_AM_CONTENT_VIEW', 'العرض');
define('_NEWS_AM_CONTENT_EDIT', 'ویرایش');
define('_NEWS_AM_CONTENT_DELETE', 'الغاء');
define('_NEWS_AM_CONTENT_SHORTDESC', 'بیان الملخص');
define('_NEWS_AM_CONTENT_TOPIC', 'فئة');
define('_NEWS_AM_CONTENT_TOPIC_DESC', 'إذ لم یتم إختیار فئة معینة، ستکون صفحتک ثابتة');
define('_NEWS_AM_CONTENT_STATIC', 'صفحة ثابتة');
define('_NEWS_AM_CONTENT_STATICS', 'صفحات متغیرة');
define('_NEWS_AM_CONTENT_ALL_ITEMS', 'جمیع الصفحات و الفهرسة من جمیع الفئات');
define('_NEWS_AM_CONTENT_ALL_ITEMS_FROM', 'جمیع الصفحات و الفهرسة من فئة :');
define('_NEWS_AM_CONTENT_FILE_DESC', 'For add more files you must use admin file system in admin side');
define('_NEWS_AM_CONTENT_SUBTITLE', 'Subtitle');
define('_NEWS_AM_CONTENT_ALL', 'All News');
define('_NEWS_AM_CONTENT_OFFLINE', 'Offline news');
define('_NEWS_AM_CONTENT_EXPIRE', 'Expire news');
define('_NEWS_AM_CONTENT_PEDATE', 'Set publish and expiration date');
define('_NEWS_AM_CONTENT_SETDATETIME', 'Set the date/time of publish');
define('_NEWS_AM_CONTENT_SETEXPDATETIME', 'Set the date/time of expiration');
define('_NEWS_AM_CONTENT_SLIDE', 'Set as slide');
define('_NEWS_AM_CONTENT_MARQUE', 'Set sd margue');
// Tools page
define('_NEWS_AM_TOOLS_FORMFOLDER_TITLE', 'استنساخ النسخ المتماثلة');
define('_NEWS_AM_TOOLS_FORMFOLDER_NAME', 'اسم المجلد');
define('_NEWS_AM_TOOLS_LOG_TITLE', 'تقریر استنساخ الوحدة');
define('_NEWS_AM_TOOLS_FORMPURGE_TITLE', 'Purge page of deleted clone');
define('_NEWS_AM_TOOLS_ALIAS_TITLE', 'تحدیث الإسم');
define('_NEWS_AM_TOOLS_ALIAS_CONTENT', 'تحدیث إسم الصفحة');
define('_NEWS_AM_TOOLS_ALIAS_TOPIC', 'تحدیث إسم الفئة');
define('_NEWS_AM_TOOLS_META_TITLE', 'Rebuild Metas');
define('_NEWS_AM_TOOLS_META_KEYWORD', 'Rebuild Meta keywords');
define('_NEWS_AM_TOOLS_META_DESCRIPTION', 'Rebuild Meta Description');
define('_NEWS_AM_TOOLS_PRUNE', 'Prune news');
define('_NEWS_AM_TOOLS_PRUNE_BEFORE', 'Prune stories that were published before');
define('_NEWS_AM_TOOLS_PRUNE_EXPIREDONLY', 'Only remove stories who have expired');
define('_NEWS_AM_TOOLS_PRUNE_TOPICS', 'Limit to the following topics');
define('_NEWS_AM_TOOLS_PRUNE_EXPORT_DSC', 'If you dont check anything then all the topics will be used else only the selected topics will be used');
// Permissions
define('_NEWS_AM_PERMISSIONS_ACCESS', 'إتاحة العرض');
define('_NEWS_AM_PERMISSIONS_SUBMIT', 'إتاحة الإرسال');
define('_NEWS_AM_PERMISSIONS_GLOBAL', 'أتاحة عامة');
define('_NEWS_AM_PERMISSIONS_GLOBAL_4', 'مشارکة');
define('_NEWS_AM_PERMISSIONS_GLOBAL_8', 'الإرسال في قسم المستخدمین');
define('_NEWS_AM_PERMISSIONS_GLOBAL_16', 'الموافقة التلقائية ');
// Attach files
define('_NEWS_AM_FILE', 'File');
define('_NEWS_AM_FILE_ID', 'ID');
define('_NEWS_AM_FILE_ONLINE', 'اونلاین');
define('_NEWS_AM_FILE_ACTION', 'نشیط');
define('_NEWS_AM_FILE_FORM', ' إضافة ملف ');
define('_NEWS_AM_FILE_TITLE', 'العنوان');
define('_NEWS_AM_FILE_CONTENT', 'الصفحة');
define('_NEWS_AM_FILE_STATUS', 'نشیط');
define('_NEWS_AM_FILE_SELECT', 'اختیار ملف');
define('_NEWS_AM_FILE_TYPE', 'النوع');
// Admin message
define('_NEWS_AM_MSG_DBUPDATE', 'تم تحدیث قاعدة بیانات!');
define('_NEWS_AM_MSG_ERRORDELETE', 'لایمکنک إلغاء هذه الوثیقة <br />الرجاء إلغاء أو نقل جمیع الوثائق التالیة');
define('_NEWS_AM_MSG_WAIT', 'انتظر قلیلا !');
define('_NEWS_AM_MSG_DELETE', 'هل أنت متأکد للحذف؟');
define('_NEWS_AM_MSG_EDIT_ERROR', ' لم يتم العثور على هذه الصفحة أورقم الصفحة غير صحيح !');
define('_NEWS_AM_MSG_UPDATE_ERROR', ' غير قادر على تحديث قاعدة البيانات! خطأ في تحديث الصفحة ');
define('_NEWS_AM_MSG_INSERT_ERROR', 'غير قادر على تحديث قاعدة البيانات! خطأ في الموضوع ');
define('_NEWS_AM_MSG_CLONE_ERROR', 'هذا الدليل هو متاح الآن !');
define("_NEWS_AM_MSG_NOPERMSSET", "لایمکن تعدیل الإتاحات: لم یتم تحدیث أي فئة ! الرجاء تحدیث فئة أولا.");
define('_NEWS_AM_MSG_ALIASERROR', 'لقد تم اختیار هذا الإسم. الرجاء اختیار اسم آخر.');
define('_NEWS_AM_MSG_INPROC', 'Rebuilding ... ');
define('_NEWS_AM_MSG_PRUNE_DELETED', '%s Articles deleted');
// about	
define('_NEWS_AM_ABOUT_ADMIN', 'درباره');
define('_NEWS_AM_ABOUT_DESCRIPTION', 'وصف:');
define('_NEWS_AM_ABOUT_AUTHOR', 'المتنج:');
define('_NEWS_AM_ABOUT_CREDITS', 'معارفه:');
define('_NEWS_AM_ABOUT_LICENSE', 'إتاحة:');
define('_NEWS_AM_ABOUT_MODULE_INFO', 'معلومات الوحدة:');
define('_NEWS_AM_ABOUT_RELEASEDATE', 'ساعة النشر:');
define("_NEWS_AM_ABOUT_UPDATEDATE", "ساعة التحدیث: ");
define('_NEWS_AM_ABOUT_MODULE_STATUS', 'الوضع:');
define('_NEWS_AM_ABOUT_WEBSITE', 'الموقع:');
define('_NEWS_AM_ABOUT_AUTHOR_INFO', 'معلومات المنتج');
define('_NEWS_AM_ABOUT_AUTHOR_NAME', 'الإسم:');
define('_NEWS_AM_ABOUT_CHANGELOG', 'قائمة التعدیلات');

?>