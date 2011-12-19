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
    define('_MI_NEWS_NAME', 'محتوا');
    define('_MI_NEWS_DESC', 'برای مدییت صفحات ایستا و پویا');
// Menu
    define("_NEWS_MI_HOME", "صفحه اصلی");
    define("_NEWS_MI_TOPIC", "شاخه");
    define("_NEWS_MI_CONTENT", "محتوا");
    define("_NEWS_MI_PERM", "دسترسی ها");
    define("_NEWS_MI_TOOLS", "ابزار");
    define("_NEWS_MI_ABOUT", "درباره");
    define("_NEWS_MI_HELP", "راهنما");
    define("_NEWS_MI_SUBMIT", "ارسال");
    define('_NEWS_MI_FILE', 'فایل');
// Block
    define("_NEWS_MI_BLOCK_PAGE", "صفحه");
    define("_NEWS_MI_BLOCK_LIST", "فهرست");
// Editor
    define("_NEWS_MI_FORM_EDITOR", "انتخاب فرم");
    define("_NEWS_MI_FORM_EDITOR_DESC", "انتخاب ویرایشگر برای استفاده در صفحه ارسال مطلب.");
// Urls
    define('_NEWS_MI_FRIENDLYURL', 'انتخاب آدرس کاربر پسند');
    define('_NEWS_MI_FRIENDLYURL_DESC', 'Select the URL rewrite mode you want to use.<ul>
    <li>"Standard Mode": Module standard URL</li>
    <li>"Rewrite Mode": you must use .htaccess file and edit .htaccess sample code if you change SEO / URL Rewrite options</li>
    <li>"Short Rewrite": you can make URL whit out page id and module use alias for get page info. you must edit .htaccess, you can remove module name and Url extension and use Root base for have short URL</li></ul>');
    define('_NEWS_MI_URL_STANDARD', 'Standard Mode');
    define('_NEWS_MI_URL_REWRITE', 'Rewrite Mode');
    define('_NEWS_MI_URL_SHORT', 'Short Rewrite');
    define('_NEWS_MI_URL_ID', 'ID Mode');
// Rewrite Mode
    define('_NEWS_MI_REWRITEBASE', 'آدرسی که به طور پایه قابل نوشتن است انتخاب کنید');
    define('_NEWS_MI_REWRITEBASE_DESC', '"Module base": شما باید یک .htacces در شاخه ماژول قرار دهید.<br />"Root base": شما باید یک .htacces در شاخه ROOT_PATH قرار دهید.');
    define('_NEWS_MI_REWRITEBASE_MODS', 'Module base');
    define('_NEWS_MI_REWRITEBASE_ROOT', 'Root base');
// Rewrite Name
    define('_NEWS_MI_REWRITENAME', 'نام ماژول در حالت دوباره نویسی شده');
    define('_NEWS_MI_REWRITENAME_DESC', 'نام ماژول را در آدرس تولیدی انتخاب کنید (rewrite mode). اگر این نام را تغییر دهید باید فایل .htaccess را هم ویرایش کنید');
// Rewrite Extension
    define('_NEWS_MI_REWRITEEXT', 'پسوند پایانی آدرس');
    define('_NEWS_MI_REWRITEEXT_DESC', 'پسوند پایانی آدرس را انتخاب کنید (.html) ');
// static name
    define('_NEWS_MI_STATICNAME', 'نام نام استاتیک');
    define('_NEWS_MI_STATICNAME_DESC', 'نام شاخه برای صفحات استاتیک در هنگام تولید آدرس');
// Lenght Id
    define('_NEWS_MI_LENGHTID', 'طول شماره صفحه');
    define('_NEWS_MI_LENGHTID_DESC', 'تعداد ارقام تولید شماره برای صفحه');
// Group Access
    define('_NEWS_MI_GROUPS', 'دسترسی گروه ها');
    define('_NEWS_MI_GROUPS_DESC', 'دسترسی سراسری گروه ها را مشخص کنید.');
//Advertisement 
    define('_NEWS_MI_ADVERTISEMENT', 'تبلیغات');
    define('_NEWS_MI_ADVERTISEMENT_DESC', 'یک متن یا کد جاوا در این بخش قرار دهید تا در تمام صفحات شما نمایش داده شود');
// Edit in place
    define('_NEWS_MI_EDITINPLACE', 'ویرایش در صفحه؟');
    define('_NEWS_MI_EDITINPLACE_DESC', 'شما میتوانید صفحات حاوی کد html را در خود صفحه به صورت ای جکس ویرایش کنید');
// Tell a friend
    define('_NEWS_MI_TELLAFRIEND', 'استفاده از ماژول معرفی به دوستان');
    define('_NEWS_MI_TELLAFRIEND_DESC', '');
// Tell a friend
    define('_NEWS_MI_USETAG', 'استفاده از ماژول TAG برای تولید تگ ها');
    define('_NEWS_MI_USETAG_DESC', 'برای استفاده از این گزینه باید ماژول TAG را نصب کرده باشید');
// minimum length of single words
    define('_NEWS_MI_MINWORDLENGHT', 'کلمات کلیدی');
    define('_NEWS_MI_MINWORDLENGHT_DESC', 'Choose the minimum length of single words');
// minimum length of single words
    define('_NEWS_MI_MINWORDOCCUR', 'توضیح متا');
    define('_NEWS_MI_MINWORDOCCUR_DESC', 'Choose the minimum occur of single words');
// Show options
    define('_NEWS_MI_DISP_OPTION', 'حالت نمایش');
    define('_NEWS_MI_DISP_OPTION_DESC', 'حالت نمایش تنضیمات را انتخاب کنید. این حالت میتواند بر اساس تنظیمات در ویژگی های ماژول باشد یا تنظیمات برای هر شاخه');
    define('_NEWS_MI_DISP_OPTION_MODULE', 'تنظیمات ماژول');
    define('_NEWS_MI_DISP_OPTION_TOPIC', 'تنظیمات شاخه');
// Title
    define('_NEWS_MI_DISPTITLE', 'نمایش عنوان؟');
    define('_NEWS_MI_DISPTITLE_DESC', '');
// Title
    define('_NEWS_MI_DISPTOPIC', 'نمایش شاخه؟');
    define('_NEWS_MI_DISPTOPIC_DESC', '');
// Date
    define('_NEWS_MI_DISPDATE', 'نمایش تاریخ؟');
    define('_NEWS_MI_DISPDATE_DESC', '');
// Author
    define('_NEWS_MI_DISPAUTHOR', 'نمایش نویسنده؟');
    define('_NEWS_MI_DISPAUTHOR_DESC', '');
// Navigation Link
    define('_NEWS_MI_DISPNAV', 'نمایش لینک های ناوبری؟');
    define('_NEWS_MI_DISPNAV_DESC', '');
// PDF Link
    define('_NEWS_MI_DISPPDF', 'نمایش لینک پی دی اف؟');
    define('_NEWS_MI_DISPPDF_DESC', '');
// Print Link
    define('_NEWS_MI_DISPPRINT', 'نمایش لینک چاپ؟');
    define('_NEWS_MI_DISPPRINT_DESC', '');
// Hits Link
    define('_NEWS_MI_DISHITS', 'نمایش بازدید؟');
    define('_NEWS_MI_DISHITS_DESC', '');
// Mail Link
    define('_NEWS_MI_DISPMAIL', 'نمایش لینک معرفی به دوستان؟');
    define('_NEWS_MI_DISPMAIL_DESC', '');
// Mail Link
    define('_NEWS_MI_DISPCOMS', 'نمایش تعداد نظرات؟');
    define('_NEWS_MI_DISPCOMS_DESC', '');
// Per page
    define('_NEWS_MI_PERPAGE', 'در هر صفحه');
    define('_NEWS_MI_PERPAGE_DESC', 'تعداد مطالب در هر صفحه');
// Columns
    define('_NEWS_MI_COLUMNS', 'ستون');
    define('_NEWS_MI_COLUMNS_DESC', 'تعداد ستون در هر صفحه');
// Show type
    define('_NEWS_MI_SHOWTYPE', 'حالت نمایش');
    define('_NEWS_MI_SHOWTYPE_DESC', 'حالت نمایش الگو شاخه ها');
    define('_NEWS_MI_SHOWTYPE_0', 'برپایه ماژول');
    define('_NEWS_MI_SHOWTYPE_1', 'حالت خبری');
    define('_NEWS_MI_SHOWTYPE_2', 'حالت جدولی');
    define('_NEWS_MI_SHOWTYPE_3', 'حالت تصویر');
    define('_NEWS_MI_SHOWTYPE_4', 'حالت لیست');
    define('_NEWS_MI_SHOWTYPE_5', 'Spotlight');
//Template
    define('_NEWS_MI_TEMPLATE', 'الگو');
    define('_NEWS_MI_TEMPLATE_DESC', 'نوع الگو مورد استفاده را انتخاب کنید');
    define('_NEWS_MI_TEMPLATE_1', 'Legacy');
    define('_NEWS_MI_TEMPLATE_2', 'jQuery UI');
    define('_NEWS_MI_TEMPLATE_3', 'Html 5');
// Show order
    define('_NEWS_MI_SHOWORDER', 'اولویت نمایشی');
    define('_NEWS_MI_SHOWORDER_DESC', 'اولیت نمایش را در حالت صعودی یا نزولی انتخاب کنید');
    define("_NEWS_MI_DESC", "نزولی");
    define("_NEWS_MI_ASC", "صعودی");
// Show sort
    define('_NEWS_MI_SHOWSORT', 'مرتب کردن بر اساس نمایش');
    define('_NEWS_MI_SHOWSORT_DESC', 'مرتب کردن بر اساس انتخاب نمایش');
    define('_NEWS_MI_SHOWSORT_1', 'content id');
    define('_NEWS_MI_SHOWSORT_2', 'content create');
    define('_NEWS_MI_SHOWSORT_3', 'content update');
    define('_NEWS_MI_SHOWSORT_4', 'content title');
    define('_NEWS_MI_SHOWSORT_5', 'content order');
    define('_NEWS_MI_SHOWSORT_6', 'Random content');
    define('_NEWS_MI_SHOWSORT_7', 'content Hits');
// Admin page
    define('_NEWS_MI_ADMIN_PERPAGE', 'سند در هر صفحه');
    define('_NEWS_MI_ADMIN_PERPAGE_DESC', 'تعداد اسناد در هر صفحه بخش مدیریت');
// Admin Show order
    define('_NEWS_MI_ADMIN_SHOWORDER', 'اولویت نمایش مطالب');
    define('_NEWS_MI_ADMIN_SHOWORDER_DESC', 'اولیت نمایش را در حالت صعودی یا نزولی انتخاب کنید');
// Admin sort
    define('_NEWS_MI_ADMIN_SHOWSORT', 'مرتب کردن بر اساس نمایش صفحات');
    define('_NEWS_MI_ADMIN_SHOWSORT_DESC', 'مرتب کردن بر اساس انتخاب نمایش');
// Admin topic page
    define('_NEWS_MI_ADMIN_PERPAGE_TOPIC', 'شاخه در هر صفحه');
    define('_NEWS_MI_ADMIN_PERPAGE_TOPIC_DESC', 'تعداد صاخه ها در هر صفحه در بخش مدیریت');
// Admin topic Show order
    define('_NEWS_MI_ADMIN_SHOWORDER_TOPIC', 'مرتب کردن بر اساس نمایش شاخه ها');
    define('_NEWS_MI_ADMIN_SHOWORDER_TOPIC_DESC', 'اولیت نمایش را در حالت صعودی یا نزولی انتخاب کنید');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_1', 'topic id');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_2', 'topic weight');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_3', 'topic created');
// Admin topic sort
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC', 'اولویت نمایشی شاخه ها');
    define('_NEWS_MI_ADMIN_SHOWSORT_TOPIC_DESC', 'مرتب کردن بر اساس انتخاب نمایش');
// Admin index limit
    define('_NEWS_MI_ADMIN_INDEX_LIMIT', 'تعداد موارد در صفحع اول مدیریت');
    define('_NEWS_MI_ADMIN_INDEX_LIMIT_DESC', 'تعداد موارد در صفحع اول مدیریت');
//rss
    define('_NEWS_MI_RSS_SHOW', 'نمایش آیکن خوراک');
    define('_NEWS_MI_RSS_SHOW_DESC', 'نمایش یا عدم نمایش آیکن خوراک در ماژول');
    define('_NEWS_MI_RSS_TIMECACHE', 'زمان کش خوراک');
    define('_NEWS_MI_RSS_TIMECACHE_DESC', 'زمان کش برای صفحه خوراک بر حسب دقیقه');
    define('_NEWS_MI_RSS_PERPAGE', 'تعداد موارد خوراک');
    define('_NEWS_MI_RSS_PERPAGE_DESC', 'تعداد خروجی های خوراک در صفحه را انتخاب کنید');
    define('_NEWS_MI_RSS_LOGO', 'لوگو صفحه خوراک');
    define('_NEWS_MI_RSS_LOGO_DESC', 'لوگو سایت در صفحه خوراک');
// Print    
    define('_NEWS_MI_PRINT_LOGO', 'نمایش لوگو سایت');
    define('_NEWS_MI_PRINT_LOGO_DESC', 'نمایش یا عدم نمایش لوگو سایت در صفحه چاپ');
    define('_NEWS_MI_PRINT_LOGOFLOAT', 'محل لوگو سایت');
    define('_NEWS_MI_PRINT_LOGOFLOAT_DESC', 'محل لوگو سایت در صفحه پرینت میتواند راست یا چپ یا وسط باشد');
    define('_NEWS_MI_PRINT_LEFT', 'چپ');
    define('_NEWS_MI_PRINT_RIGHT', 'راست');
    define('_NEWS_MI_PRINT_CENTER', 'مرکز');
    define('_NEWS_MI_PRINT_LOGOURL', 'محل لوگو سایت');
    define('_NEWS_MI_PRINT_LOGOURL_DESC', 'لوگو سایت در صفحه چاپ');
    define('_NEWS_MI_PRINT_TITLE', 'نمایش عنوان؟');
    define('_NEWS_MI_PRINT_TITLE_DESC', '');
    define('_NEWS_MI_PRINT_IMG', 'نمایش تصویر؟');
    define('_NEWS_MI_PRINT_IMG_DESC', '');
    define('_NEWS_MI_PRINT_SHORT', 'نمایش متن اولیه؟');
    define('_NEWS_MI_PRINT_SHORT_DESC', '');
    define('_NEWS_MI_PRINT_TEXT', 'نمایش متن اصلی؟');
    define('_NEWS_MI_PRINT_TEXT_DESC', '');
    define('_NEWS_MI_PRINT_DATE', 'نمایش تاریخ؟');
    define('_NEWS_MI_PRINT_DATE_DESC', '');
    define('_NEWS_MI_PRINT_AUTHOR', 'نمایش نویسنده؟');
    define('_NEWS_MI_PRINT_AUTHOR_DESC', '');
    define('_NEWS_MI_PRINT_LINK', 'نمایش لینک صفحه؟');
    define('_NEWS_MI_PRINT_LINK_DESC', '');
//img
    define('_NEWS_MI_IMAGE_DIR', 'مسیر بارگذاری صفحه');
    define('_NEWS_MI_IMAGE_DIR_DESC', 'مسیر بارکذاری تصویر برای مطالب . اگر این مسیر را تغییر دهید باید تصاویر قدیمی را هم به مسیر جدید منتقل کنید تا نمایش داده شوند.');
    define('_NEWS_MI_IMAGE_SIZE', 'اندازه تصویر');
    define('_NEWS_MI_IMAGE_SIZE_DESC', 'انتخاب بیشترین اندازه تصویر');
    define('_NEWS_MI_IMAGE_MAXWIDTH', 'بیشترین عرض تصویر');
    define('_NEWS_MI_IMAGE_MAXWIDTH_DESC', 'بیشترین عرض در هنگام بارگذاری تصویر');
    define('_NEWS_MI_IMAGE_MAXHEIGHT', 'بیشترین ارتفاع تصویر');
    define('_NEWS_MI_IMAGE_MAXHEIGHT_DESC', 'بیشترین ارتفاع در هنگام بارگذاری تصویر');
    define('_NEWS_MI_IMAGE_MEDIUMWIDTH', 'Image medium width (pixel)');
    define('_NEWS_MI_IMAGE_MEDIUMWIDTH_DESC', 'Medium allowed width for image resize');
    define('_NEWS_MI_IMAGE_MEDIUMHEIGHT', 'Image medium height (pixel)');
    define('_NEWS_MI_IMAGE_MEDIUMHEIGHT_DESC', 'Medium allowed height for image resize');
    define('_NEWS_MI_IMAGE_THUMBWIDTH', 'Image thumb width (pixel)');
    define('_NEWS_MI_IMAGE_THUMBWIDTH_DESC', 'Thumb allowed width for image resize');
    define('_NEWS_MI_IMAGE_THUMBHEIGHT', 'Image thumb height (pixel)');
    define('_NEWS_MI_IMAGE_THUMBHEIGHT_DESC', 'Thumb allowed height for image resize');
    define('_NEWS_MI_IMAGE_MIME', 'پسوند های مجاز برای بارگذاری');
    define('_NEWS_MI_IMAGE_MIME_DESC', 'پسوند های مورد تایید را انتخاب کنید');
    define('_NEWS_MI_IMAGE_WIDTH', 'عرض تصویر');
    define('_NEWS_MI_IMAGE_WIDTH_DESC', 'انتخاب عرض تصویر برای نمایش در صفحه');
    define('_NEWS_MI_IMAGE_FLOAT', 'محل تصویر');
    define('_NEWS_MI_IMAGE_FLOAT_DESC', 'انتخاب محل راست یا چپ برای تصاویر براگذاری شده توسط ماژول');
    define('_NEWS_MI_IMAGE_LEFT', 'چپ');
    define('_NEWS_MI_IMAGE_RIGHT', 'راست');
    define('_NEWS_MI_IMAGE_LIGHTBOX', 'استفاده از lightbox');
    define('_NEWS_MI_IMAGE_LIGHTBOX_DESC', 'استفاده از lightbox برای نمایش تصاویر');
//social
    define('_NEWS_MI_SOCIAL', 'استفاده از گزینه های شبکه های اجتماعی');
    define('_NEWS_MI_SOCIAL_DESC', 'شما میتوانید از لینک های شبکه های اجتماعی و بوکمارک در هر صفحه استفاده کنید');
    define('_NEWS_MI_BOOKMARK', 'بوکمارک');
    define('_NEWS_MI_SOCIALNETWORM', 'شبکه های اجتماعی');
    define('_NEWS_MI_NONE', 'هیچ کدام');
    define('_NEWS_MI_BOTH', 'هردو');
//Multiple Columns 
    define('_NEWS_MI_MULTIPLE_COLUMNS', 'متن چند ستونه');
    define('_NEWS_MI_MULTIPLE_COLUMNS_DESC', 'انتخاب تعداد ستون هابرای نمایش متن هر سند . این تنظیم فقط برای متن اصلی کار خواهد کرد');
    define('_NEWS_MI_MULTIPLE_COLUMNS_1', 'یک ستون');
    define('_NEWS_MI_MULTIPLE_COLUMNS_2', 'دو ستون');
    define('_NEWS_MI_MULTIPLE_COLUMNS_3', 'سه ستون');
    define('_NEWS_MI_MULTIPLE_COLUMNS_4', 'چهار ستون');
// All user posts
    define('_NEWS_MI_ALLUSERPOST', 'تمام پست های این کاربر');
    define('_NEWS_MI_ALLUSERPOST_DESC', 'نمایش / مخفی کردن لینک تمام پست های کاربر در هر صفحه');
// regular expression
    define('_NEWS_MI_REGULAR_EXPRESSION', 'نام مستعار خودکار الگوی آدرس');
    define('_NEWS_MI_REGULAR_EXPRESSION_DESC', '.عبارت با قاعده برای ساخت نام مستعار خودکار الگوی آدرس . اگر زبان مورد استفاده شما در هنگام ساخت خودکار آدرس با نام مستعار پشتیبانی نمیشود الفبای زبان خود را به این قسمت اضافه کنید. مقدار پیش فرض زبان های انگلیسی و فارسی و عربی را پشتیبانی می کند. <br />مقدار پیش فرض : <b>`[^a-z0-9۰-۹آا-ی]`u</b>');
    define('_NEWS_MI_REGULAR_EXPRESSION_CONFIG', '`[^a-z0-9۰-۹آا-ی]`u');
// Breadcrumb
    define('_NEWS_MI_BREADCRUMB_SHOW', 'نمایش ناوبری');
    define('_NEWS_MI_BREADCRUMB_MODNAME', 'نمایش نام ماژول');
    define('_NEWS_MI_BREADCRUMB_TOHOME', 'نمایش لینک صفحه اصلی');
// Files
    define('_NEWS_MI_FILE_DIR', 'مسیر بارگذاری فایل');
    define('_NEWS_MI_FILE_DIR_DESC', 'مسیر بارکذاری فایل برای مطالب . اگر این مسیر را تغییر دهید باید فایل قدیمی را هم به مسیر جدید منتقل کنید تا نمایش داده شوند.');
    define('_NEWS_MI_FILE_SIZE', 'اندازه فایل');
    define('_NEWS_MI_FILE_SIZE_DESC', 'انتخاب بیشترین اندازه فایل (1048576 bytes = 1 MegaByte)');
    define('_NEWS_MI_FILE_MIME', 'پسوند های مجاز');
    define('_NEWS_MI_FILE_MIME_DESC', 'پسوند های مجاز برای آپلود . با | از هم جدا کنید');
// break 
    define('_NEWS_MI_BREAK_GENERAL', 'سراسری');
    define('_NEWS_MI_BREAK_SEO', 'SEO');
    define('_NEWS_MI_BREAK_DISPLAY', 'نمایش');
    define('_NEWS_MI_BREAK_RSS', 'خوراک');
    define('_NEWS_MI_BREAK_IMAGE', 'تصویر');
    define('_NEWS_MI_BREAK_ADMIN', 'مدیریت');
    define('_NEWS_MI_BREAK_PRINT', 'چاپ');
    define('_NEWS_MI_BREAK_BREADCRUMB', 'ناوبری');
    define('_NEWS_MI_BREAK_COMNOTI', 'نظر و آگاهی رسانی');
    define('_NEWS_MI_BREAK_FILE', 'File');
//install/action
    define('_NEWS_MI_SQL_FOUND', 'دیتابیس SQL پیدا شد');
    define('_NEWS_MI_CREATE_TABLES', 'ساخت جدول');
    define('_NEWS_MI_TABLE_CREATED', 'جدول ساخته شد');
    define('_NEWS_MI_TABLE_RESERVED', 'Table reserved');
    define('_NEWS_MI_SQL_NOT_FOUND', 'پایگاه داده های SQL پیدا نشد');
    define('_NEWS_MI_SQL_NOT_VALID', 'پایگاه داده های SQL صحیح نیست');
    define('_NEWS_MI_INSERT_DATA', ',وارد کردن اطلاعات');
// homepage   
    define('_NEWS_MI_HOMEPAGE', 'Homepage seting');
    define('_NEWS_MI_HOMEPAGE_DESC', 'Seting content show type in module index page');
    define('_NEWS_MI_HOMEPAGE_1', 'List all contents from all topics');
    define('_NEWS_MI_HOMEPAGE_2', 'List all topics');
    define('_NEWS_MI_HOMEPAGE_3', 'List all static pages');
    define('_NEWS_MI_HOMEPAGE_4', 'Show selected static content');
// topic name
	 define('_NEWS_MI_TOPICNAME', 'نام شاخه');
	 define('_NEWS_MI_TOPICNAME_DESC', 'انتخاب نام شاخه برای آدرس');  
// related news
	 define('_NEWS_MI_RELATED', 'Related table');
	 define('_NEWS_MI_RELATED_DESC', 'When you use this option, a summary containing links to all the recent published articles is visible at the bottom of each article');  
	 define('_NEWS_MI_RELATED_LIMIT', 'Related limit');
	 define('_NEWS_MI_RELATED_LIMIT_DESC', 'Number of contents for show in Related table');  	 
}
?>