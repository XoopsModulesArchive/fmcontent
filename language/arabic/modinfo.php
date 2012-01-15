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

if (!defined('_MI_NEWS_NAME')) {
    // Module info
    define('_MI_NEWS_NAME', 'المحتوی');
    define('_MI_NEWS_DESC', 'لإدارة الصفحات الثابتة و الدینامیة');
// Menu
    define("_NEWS_MI_HOME", "الرئیسیة");
    define("_NEWS_MI_TOPIC", "فئة");
    define("_NEWS_MI_ARTICLE", "محتوی");
    define("_NEWS_MI_PERM", "الإتاحات");
    define("_NEWS_MI_TOOLS", "أداة");
    define("_NEWS_MI_ABOUT", "درباره");
    define("_NEWS_MI_HELP", "دلیل");
    define("_NEWS_MI_SUBMIT", "ارسال");
    define('_NEWS_MI_FILE', 'ملف');
    define('_NEWS_MI_ARCHIVE', 'Archive');
// Block
    define("_NEWS_MI_BLOCK_PAGE", "الصفحة");
    define("_NEWS_MI_BLOCK_LIST", "الفهرسة");
    define('_NEWS_MI_BLOCK_TOPIC', 'Topic list');
// Editor
    define("_NEWS_MI_FORM_EDITOR", "اختیار شکل");
    define("_NEWS_MI_FORM_EDITOR_DESC", "تحدید محرر للاستخدام في صفحة إرسال المواضیع.");
// Admin groups
	 define("_NEWS_MI_ADMINGROUPS", "Admin Group Permissions");
	 define("_NEWS_MI_ADMINGROUPS_DESC", "Which groups have access to tools and permissions page");  
// Group Access
    define('_NEWS_MI_GROUPS','اتاحة المجموعات');
    define('_NEWS_MI_GROUPS_DESC', 'عین الإتاحة الکلیة للمجموعات.');	 
// Urls
    define('_NEWS_MI_FRIENDLYURL','تحدید عنوان مفضل للمستخدمین');
    define('_NEWS_MI_FRIENDLYURL_DESC', 'Select the URL rewrite mode you want to use.<ul>
    <li>"Standard Mode": Module standard URL</li>
    <li>"Rewrite Mode": you must use .htaccess file and edit .htaccess sample code if you change SEO / URL Rewrite options</li>
    <li>"Short Rewrite": you can make URL whit out page id and module use alias for get page info. you must edit .htaccess, you can remove module name and Url extension and use Root base for have short URL</li></ul>');
    define('_NEWS_MI_URL_STANDARD', 'Standard Mode');
    define('_NEWS_MI_URL_REWRITE', 'Rewrite Mode');
    define('_NEWS_MI_URL_SHORT', 'Short Rewrite');
    define('_NEWS_MI_URL_ID', 'ID Mode');
// Rewrite Mode
    define('_NEWS_MI_REWRITEBASE', 'اختر عنوانا یمکن کتابته');
    define('_NEWS_MI_REWRITEBASE_DESC', '"Module base": یجب علیک .htacces جعله في فئة الوحدة.<br />"Root base": یجب علیک .htacces في فئةROOT_PATH جعل.');
    define('_NEWS_MI_REWRITEBASE_MODS', 'Module base');
    define('_NEWS_MI_REWRITEBASE_ROOT', 'Root base');
// Rewrite Name
    define('_NEWS_MI_REWRITENAME', 'اسم الوحدة بعد التحدیث');
    define('_NEWS_MI_REWRITENAME_DESC', 'حدد اسم الوحدة في النوان المنتج rewrite mode). إذا تم تعدیل الإسم، یجب تعدیل ملف.htaccess ');
// Rewrite Extension
    define('_NEWS_MI_REWRITEEXT', 'الملحق الختامي للعنوان');
    define('_NEWS_MI_REWRITEEXT_DESC', 'اختر الملحق الختامي للعنوان (.html) ');
// static name
    define('_NEWS_MI_STATICNAME', 'الاسم الثابت');
    define('_NEWS_MI_STATICNAME_DESC', 'إسم فئة للصفحات الثابتة عند انتاج العنوان ');
// Lenght Id
    define('_NEWS_MI_LENGHTID', 'طول رقم الصفحة');
    define('_NEWS_MI_LENGHTID_DESC', 'عدد ارقام المنتجة للصفحة');
//Advertisement 
    define('_NEWS_MI_ADVERTISEMENT', 'الإعلانات');
    define('_NEWS_MI_ADVERTISEMENT_DESC', 'اجعل نصا أو کود جاوا للعرض في جمیع الصفحات');
// Edit in place
    define('_NEWS_MI_EDITINPLACE',' تعدیل في الصفحة؟');
    define('_NEWS_MI_EDITINPLACE_DESC', 'یمکنک تعدیل صفحات مع کود HTML علی شکل أي جکس داخل صفحتک');
// Tell a friend
    define('_NEWS_MI_TELLAFRIEND', 'استخدام وحدة إخبار الأصدقاء');
    define('_NEWS_MI_TELLAFRIEND_DESC', '');
// Tell a friend
    define('_NEWS_MI_USETAG', ' استخدام الوحدة TAG لإنتاج ');
    define('_NEWS_MI_USETAG_DESC', 'لاستخدام هذا الأیقون یجب تثبیت وحدة TAG');
// minimum length of single words
    define('_NEWS_MI_MINWORDLENGHT', 'الکلمات الرئیسیة');
    define('_NEWS_MI_MINWORDLENGHT_DESC', 'Choose the minimum length of single words');
// minimum length of single words
    define('_NEWS_MI_MINWORDOCCUR',' وصف');
    define('_NEWS_MI_MINWORDOCCUR_DESC', 'Choose the minimum occur of single words');
// Show options
    define('_NEWS_MI_DISP_OPTION', 'کیفیة العرض');
    define('_NEWS_MI_DISP_OPTION_DESC', 'اختر حالة عرض الخیارات. إما علی اساس خیارات الوحدة أم خیار الفئات');
    define('_NEWS_MI_DISP_OPTION_MODULE',' خیارات الوحدات');
    define('_NEWS_MI_DISP_OPTION_TOPIC', ' خیارات الفئات');
// Title
    define('_NEWS_MI_DISPTITLE', 'عرض العنوان؟');
    define('_NEWS_MI_DISPTITLE_DESC', '');
// Title
    define('_NEWS_MI_DISPTOPIC', 'عرض الفئة؟');
    define('_NEWS_MI_DISPTOPIC_DESC', '');
// Date
    define('_NEWS_MI_DISPDATE', 'عرض التاریخ؟');
    define('_NEWS_MI_DISPDATE_DESC', '');
// Author
    define('_NEWS_MI_DISPAUTHOR', 'عرذض المحرر؟');
    define('_NEWS_MI_DISPAUTHOR_DESC', '');
// Navigation Link
    define('_NEWS_MI_DISPNAV', 'عرض روابط ناوبری؟');
    define('_NEWS_MI_DISPNAV_DESC', '');
// PDF Link
    define('_NEWS_MI_DISPPDF', 'عرض رابط PDF؟');
    define('_NEWS_MI_DISPPDF_DESC', '');
// Print Link
    define('_NEWS_MI_DISPPRINT', 'عرض رابط الطباعة؟');
    define('_NEWS_MI_DISPPRINT_DESC', '');
// Hits Link
    define('_NEWS_MI_DISHITS', 'عرض الزیارات؟');
    define('_NEWS_MI_DISHITS_DESC', '');
// Mail Link
    define('_NEWS_MI_DISPMAIL', 'عرض رابط إخبار الأصدقاء؟');
    define('_NEWS_MI_DISPMAIL_DESC', '');
// Mail Link
    define('_NEWS_MI_DISPCOMS', 'عرض عدد الآراء ؟');
    define('_NEWS_MI_DISPCOMS_DESC', '');
// Per page
    define('_NEWS_MI_PERPAGE', 'في کل صفحة');
    define('_NEWS_MI_PERPAGE_DESC', 'عدد المواضیع في کل صفحة');
// Columns
    define('_NEWS_MI_COLUMNS', 'عمود');
    define('_NEWS_MI_COLUMNS_DESC', 'عدد الأعمدة في کل صفحة');
// Show type
    define('_NEWS_MI_SHOWTYPE', 'حالة العرض');
    define('_NEWS_MI_SHOWTYPE_DESC', 'حالة عرض نموذج الفئات');
    define('_NEWS_MI_SHOWTYPE_0', 'علی اساس الوحدات');
    define('_NEWS_MI_SHOWTYPE_1', 'الوضع الخبری');
    define('_NEWS_MI_SHOWTYPE_2', 'حالت جدولی');
    define('_NEWS_MI_SHOWTYPE_3', 'وضع الصورة');
    define('_NEWS_MI_SHOWTYPE_4', 'جالت لیست');
    define('_NEWS_MI_SHOWTYPE_5', 'Spotlight');
//Template
    define('_NEWS_MI_TEMPLATE', 'نموذج');
    define('_NEWS_MI_TEMPLATE_DESC', 'اختر نوع النموذج المستخدم');
    define('_NEWS_MI_TEMPLATE_1', 'Legacy');
    define('_NEWS_MI_TEMPLATE_2', 'jQuery UI');
    define('_NEWS_MI_TEMPLATE_3', 'Html 5');
// Show order
    define('_NEWS_MI_SHOWORDER', 'اولویة العرض');
    define('_NEWS_MI_SHOWORDER_DESC', 'اختر اولویة العرض متصاعدا ام متنازلا');
    define("_NEWS_MI_DESC", "متنازلا");
    define("_NEWS_MI_ASC", "متصاعدا");
// Show sort
    define('_NEWS_MI_SHOWSORT', 'تنظیم علی اساس العرض');
    define('_NEWS_MI_SHOWSORT_DESC', 'تنظیم علی اساس اختیار العرض');
    define('_NEWS_MI_SHOWSORT_1', 'content id');
    define('_NEWS_MI_SHOWSORT_2', 'content create');
    define('_NEWS_MI_SHOWSORT_3', 'content update');
    define('_NEWS_MI_SHOWSORT_4', 'content title');
    define('_NEWS_MI_SHOWSORT_5', 'content order');
    define('_NEWS_MI_SHOWSORT_6', 'Random');
    define('_NEWS_MI_SHOWSORT_7', 'content Hits');
// Admin page
    define('_NEWS_MI_ADMIN_PERPAGE', 'الوثیقة في کل صفحة');
    define('_NEWS_MI_ADMIN_PERPAGE_DESC', 'إدارة عدد الوثائق في کل صفحة');
// Admin Show order
    define('_NEWS_MI_ADMIN_SHOWORDER', 'اولویة عرض المواضیع');
    define('_NEWS_MI_ADMIN_SHOWORDER_DESC', 'اختر اولویة العرض متصاعدا ام متنازلا');
// Admin sort
    define('_NEWS_MI_ADMIN_SHOWSORT', 'التنظیم علی اساس عرض الصفحات صفحات');
    define('_NEWS_MI_ADMIN_SHOWSORT_DESC', 'العرض علی اساس اختیار العرض');
// Admin topic page
    define('_NEWS_MI_ADMIN_PERPAGE_TOPIC', 'الفئة في کل صفحة');
    define('_NEWS_MI_ADMIN_PERPAGE_TOPIC_DESC', 'عدد الفئات في کل صفحة في قسم الإدارة');
// Admin topic Show order
    define('_NEWS_MI_ADMIN_SHOWORDER_TOPIC', 'التنظیم علی اساس عرض الفئات');
    define('_NEWS_MI_ADMIN_SHOWORDER_TOPIC_DESC', 'اختر اولویة العرض متصاعدا ام متنازلا ');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_1', 'topic id');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_2', 'topic weight');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_3', 'topic created');
// Admin topic sort
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC', 'اولویة عرض الفئات');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_DESC', 'التنظیم علی اساس اختیار العرض');
// Admin index limit
    define('_NEWS_MI_ADMIN_INDEX_LIMIT', 'عدد المواضیع في الصفحة الاولی للإدارة');
    define('_NEWS_MI_ADMIN_INDEX_LIMIT_DESC', 'عدد الموضایع في الصفحة الاولی للإدارة');
//rss
    define('_NEWS_MI_RSS_SHOW', 'عرض آیقون ال خوراک');
    define('_NEWS_MI_RSS_SHOW_DESC', 'عرض أو عدم عرض آیقون خوراک في الوحدة');
    define('_NEWS_MI_RSS_TIMECACHE', 'زمان کش خوراک');
    define('_NEWS_MI_RSS_TIMECACHE_DESC', 'زمان کش برای صفحه خوراک بر حسب دقیقه');
    define('_NEWS_MI_RSS_PERPAGE', 'عدد موارد خوراک');
    define('_NEWS_MI_RSS_PERPAGE_DESC', 'اختر عدد منتجات خوراک في الصفحة');
    define('_NEWS_MI_RSS_LOGO', 'شعار صفحة خوراک');
    define('_NEWS_MI_RSS_LOGO_DESC', 'شعار الموقع في صفحة خوراک');
// Print    
    define('_NEWS_MI_PRINT_LOGO', 'عرض الشعار في الموقع');
    define('_NEWS_MI_PRINT_LOGO_DESC', 'عرض أو عدم عرض شعار الموقع في صفحة الطباعة');
    define('_NEWS_MI_PRINT_LOGOFLOAT', 'محل شعار الموقع');
    define('_NEWS_MI_PRINT_LOGOFLOAT_DESC', 'محل شعار الموقع في الصفحة ممکن ان تکون الطباعة یمینا أو شمالا أو وسطا');
    define('_NEWS_MI_PRINT_LEFT', 'شمال');
    define('_NEWS_MI_PRINT_RIGHT', 'یمین');
    define('_NEWS_MI_PRINT_CENTER', 'وسط');
    define('_NEWS_MI_PRINT_LOGOURL', 'شعار الموقع');
    define('_NEWS_MI_PRINT_LOGOURL_DESC', 'شعار الموقع في صفحة الطباعة');
    define('_NEWS_MI_PRINT_TITLE', 'عرض العنوان؟');
    define('_NEWS_MI_PRINT_TITLE_DESC', '');
    define('_NEWS_MI_PRINT_IMG', 'عرض الصورة');
    define('_NEWS_MI_PRINT_IMG_DESC', '');
    define('_NEWS_MI_PRINT_SHORT', 'عرض النص الإبتدائي؟');
    define('_NEWS_MI_PRINT_SHORT_DESC', '');
    define('_NEWS_MI_PRINT_TEXT', 'عرض النص النهائي؟');
    define('_NEWS_MI_PRINT_TEXT_DESC', '');
    define('_NEWS_MI_PRINT_DATE', 'عرض التاریخ؟');
    define('_NEWS_MI_PRINT_DATE_DESC', '');
    define('_NEWS_MI_PRINT_AUTHOR', 'عرض المحرر؟');
    define('_NEWS_MI_PRINT_AUTHOR_DESC', '');
    define('_NEWS_MI_PRINT_LINK', 'عرض رابط الصفحة؟');
    define('_NEWS_MI_PRINT_LINK_DESC', '');
//img
    define('_NEWS_MI_IMAGE_DIR', 'الطریق الی هذه الصفحة');
    define('_NEWS_MI_IMAGE_DIR_DESC', 'طریق تحمیل الصور للمواضیع . اذا تم تغییر هذا العنوان ، یجب ان تنقل الصور القدیمة الی هذا العنوان للعرض');
    define('_NEWS_MI_IMAGE_SIZE', 'Image file size (in bytes)');
    define('_NEWS_MI_IMAGE_SIZE_DESC', 'Max allowed size for image file (1048576 bytes = 1 MegaByte)');
    define('_NEWS_MI_IMAGE_MAXWIDTH', 'اکثر عرض الصورة');
    define('_NEWS_MI_IMAGE_MAXWIDTH_DESC', 'اکثر عرض للصورة عند التحمیل ');
    define('_NEWS_MI_IMAGE_MAXHEIGHT', 'اکثر طول التصویر عند تحمیله');
    define('_NEWS_MI_IMAGE_MAXHEIGHT_DESC', 'اکثر طول الصورة عند التحمیل');
    define('_NEWS_MI_IMAGE_MEDIUMWIDTH', 'Image medium width (pixel)');
    define('_NEWS_MI_IMAGE_MEDIUMWIDTH_DESC', 'Medium allowed width for image resize');
    define('_NEWS_MI_IMAGE_MEDIUMHEIGHT', 'Image medium height (pixel)');
    define('_NEWS_MI_IMAGE_MEDIUMHEIGHT_DESC', 'Medium allowed height for image resize');
    define('_NEWS_MI_IMAGE_THUMBWIDTH', 'Image thumb width (pixel)');
    define('_NEWS_MI_IMAGE_THUMBWIDTH_DESC', 'Thumb allowed width for image resize');
    define('_NEWS_MI_IMAGE_THUMBHEIGHT', 'Image thumb height (pixel)');
    define('_NEWS_MI_IMAGE_THUMBHEIGHT_DESC', 'Thumb allowed height for image resize');
    define('_NEWS_MI_IMAGE_MIME', 'الملحق الختامي المتاح للتحمیل');
    define('_NEWS_MI_IMAGE_MIME_DESC', 'اختر الملحق الختامي المتاح');
    define('_NEWS_MI_IMAGE_WIDTH', 'عرض الصورة');
    define('_NEWS_MI_IMAGE_WIDTH_DESC', 'اختیار عرض الصوري للعرض في الصفحة');
    define('_NEWS_MI_IMAGE_FLOAT', 'محل الصورة');
    define('_NEWS_MI_IMAGE_FLOAT_DESC', 'اختیار محل الصورة یمینا او شمالا للصور المحملة من الوحدات');
    define('_NEWS_MI_IMAGE_LEFT', 'شمال');
    define('_NEWS_MI_IMAGE_RIGHT', 'یمین');
    define('_NEWS_MI_IMAGE_LIGHTBOX', 'استخدامlightbox');
    define('_NEWS_MI_IMAGE_LIGHTBOX_DESC', 'استخدامlightbox ل نمایش الصور');
//social
    define('_NEWS_MI_SOCIAL', 'استخدام خیاران الشبکات الإجتماعیة');
    define('_NEWS_MI_SOCIAL_DESC', 'یمکنک استخدامروابط الشبکات الإجتماعیة و بوکمارک في کل صفحة');
    define('_NEWS_MI_BOOKMARK', 'بوکمارک');
    define('_NEWS_MI_SOCIALNETWORM', 'الشبکات الإجتماعیة');
    define('_NEWS_MI_NONE', 'لاشیء');
    define('_NEWS_MI_BOTH', 'کلاهما');
//Multiple Columns 
    define('_NEWS_MI_MULTIPLE_COLUMNS', 'النص في عدة أعمدة');
    define('_NEWS_MI_MULTIPLE_COLUMNS_DESC', 'اختیار عدد الأعمدة لعرض نص کل وثیقة. هذا الخیار سیستخدم فی النص الأصلي فقط');
    define('_NEWS_MI_MULTIPLE_COLUMNS_1', 'عمود واحد');
    define('_NEWS_MI_MULTIPLE_COLUMNS_2', 'عمودین');
    define('_NEWS_MI_MULTIPLE_COLUMNS_3', 'ثلاثة أعمدة');
    define('_NEWS_MI_MULTIPLE_COLUMNS_4', 'أربعة أعمدة');
// All user posts
    define('_NEWS_MI_ALLUSERPOST', 'جمیع مشارکات هذا المستخدم');
    define('_NEWS_MI_ALLUSERPOST_DESC', 'عرض / إخفاء رابط جمیع مشارکات المستخدم في الصفحة');
// regular expression
    define('_NEWS_MI_REGULAR_EXPRESSION', 'اسم المستعار تلقائیا نموذج العنوان');
    define('_NEWS_MI_REGULAR_EXPRESSION_DESC', '.استخدام عبارة با قاعده لإنشاء الإسم المستعار التلقائي نموذج العنوان. اذا لم یتم دعم لغتک المستخدم عند انشاء التلقائي للعنوان ، أضف لغتک الی هذا القسم. المفترض دعم اللغات الانجلیزیة و العربیة و الفارسیة : <b>`[^۰-۹a-z0-9إأآضصثقفغعهخحجدطكمنتالبيسشئءؤرﻻىةوزظذ]`u</b>');
    define('_NEWS_MI_REGULAR_EXPRESSION_CONFIG', '`[^۰-۹a-z0-9إأآضصثقفغعهخحجدطكمنتالبيسشئءؤرﻻىةوزظذ]`u');
// Breadcrumb
    define('_NEWS_MI_BREADCRUMB_SHOW', 'عرض ناوبری');
    define('_NEWS_MI_BREADCRUMB_MODNAME', 'عرض اسم الوحدة');
    define('_NEWS_MI_BREADCRUMB_TOHOME', 'عرض رابط الصفحة الرئیسیة');
// Files
    define('_NEWS_MI_FILE_DIR', 'طریق تحمیل الملف');
    define('_NEWS_MI_FILE_DIR_DESC', 'طریق تحمیل الملف للمواضیع. اذذا تم تغییر هذا الطریق، یجب ان تنقل اللفات السابقي الی عذا العنوان للعرض');
    define('_NEWS_MI_FILE_SIZE', 'اندازه فایل');
    define('_NEWS_MI_FILE_SIZE_DESC', 'اختیار اکثر حجم للملف (1048576 bytes = 1 MegaByte)');
    define('_NEWS_MI_FILE_MIME', 'الملحقات الختامیة المتاحة');
    define('_NEWS_MI_FILE_MIME_DESC', 'افصل بین الملحقات الختامیة المتاحة للتحمیل ');
// break 
    define('_NEWS_MI_BREAK_GENERAL', 'کلي');
    define('_NEWS_MI_BREAK_SEO', 'SEO');
    define('_NEWS_MI_BREAK_DISPLAY', 'عرض');
    define('_NEWS_MI_BREAK_RSS', 'خوراک');
    define('_NEWS_MI_BREAK_IMAGE', 'صورة');
    define('_NEWS_MI_BREAK_ADMIN', 'إدارة');
    define('_NEWS_MI_BREAK_PRINT', 'طباعة');
    define('_NEWS_MI_BREAK_BREADCRUMB', 'ناوبری');
    define('_NEWS_MI_BREAK_COMNOTI', 'آراء و إخبار');
    define('_NEWS_MI_BREAK_FILE', 'File');
//install/action
    define('_NEWS_MI_SQL_FOUND', 'دیتابیس SQL وجد');
    define('_NEWS_MI_CREATE_TABLES', 'إنشاء جدول');
    define('_NEWS_MI_TABLE_CREATED', 'أنشئ جدول ');
    define('_NEWS_MI_TABLE_RESERVED', 'Table reserved');
    define('_NEWS_MI_SQL_NOT_FOUND', 'موقع معلومات SQL لم یوجد');
    define('_NEWS_MI_SQL_NOT_VALID', 'معوماتSQL لیسا صحیحا');
    define('_NEWS_MI_INSERT_DATA', ',وارد کردن اطلاعات');
// homepage   
    define('_NEWS_MI_HOMEPAGE', 'Homepage seting');
    define('_NEWS_MI_HOMEPAGE_DESC', 'Seting content show type in module index page');
    define('_NEWS_MI_HOMEPAGE_1', 'List all contents from all topics');
    define('_NEWS_MI_HOMEPAGE_2', 'List all topics');
    define('_NEWS_MI_HOMEPAGE_3', 'List all static pages');
    define('_NEWS_MI_HOMEPAGE_4', 'Show selected static content');
// topic name
	 define('_NEWS_MI_TOPICNAME', 'اسم الفئة');
	 define('_NEWS_MI_TOPICNAME_DESC', 'اختیار اسم الفئة للعنوان');
// related news
	 define('_NEWS_MI_RELATED', 'Related table');
	 define('_NEWS_MI_RELATED_DESC', 'When you use this option, a summary containing links to all the recent published articles is visible at the bottom of each article');  
	 define('_NEWS_MI_RELATED_LIMIT', 'Related limit');
	 define('_NEWS_MI_RELATED_LIMIT_DESC', 'Number of contents for show in Related table');  	 
}
?>