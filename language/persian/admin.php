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

if (!defined('_NEWS_AM_PREFERENCES')) {
// Global page
    define('_NEWS_AM_GLOBAL_ADD_CONTENT', 'ساخت صفحه');
    define('_NEWS_AM_GLOBAL_ADD_TOPIC', 'ساخت شاخه');
    define('_NEWS_AM_GLOBAL_ADD_FILE', 'ساخت فایل');
    define('_NEWS_AM_GLOBAL_IMG', 'تصویر');
    define('_NEWS_AM_GLOBAL_FORMUPLOAD', 'انتخاب تصویر');
// Index page
    define("_NEWS_AM_INDEX_ADMENU1", "شاخه ها");
    define("_NEWS_AM_INDEX_ADMENU2", "صفحه ها");
    define("_NEWS_AM_INDEX_TOPICS", "<span class='green'>%s</span> شاخه در پایکاه داده ها قرار دارد");
	 define("_NEWS_AM_INDEX_CONTENTS", "<span class='green'>%s</span> صفحه در پایگاه داده ها قرار دارد");
	 define("_NEWS_AM_INDEX_CONTENTS_OFFLINE", "There are <span class='red'>%s</span> Offline news in our database");
	 define("_NEWS_AM_INDEX_CONTENTS_EXPIRE", "There are <span class='red'>%s</span> Expire news in our database");
// Topic page
    define('_NEWS_AM_TOPIC_FORM', 'مدیریت شاخه ها');
    define('_NEWS_AM_TOPIC_ID', 'ID');
    define('_NEWS_AM_TOPIC_NUM', 'وزن');
    define('_NEWS_AM_TOPIC_NAME', 'عنوان');
    define('_NEWS_AM_TOPIC_PARENT', 'شاخه والد');
    define('_NEWS_AM_TOPIC_DESC', 'توضیحات');
    define('_NEWS_AM_TOPIC_IMG', 'تصویر');
    define('_NEWS_AM_TOPIC_WEIGHT', 'عرض');
    define('_NEWS_AM_TOPIC_SHOWTYPE', 'حالت نمایش');
    define('_NEWS_AM_TOPIC_SHOWTYPE_DESC', 'اگر میخواهید از تنظیمات زیر استفاده کنید.<br /> باید گزینه <b>حالت نمایش</b> را از پایه ماژول <br />به یکی دیگر از گزینه ها تغییر دهید.');
    define('_NEWS_AM_TOPIC_PERPAGE', 'هر صفحه');
    define('_NEWS_AM_TOPIC_COLUMNS', 'ستون');
    define('_NEWS_AM_TOPIC_ONLINE', 'فعال');
    define('_NEWS_AM_TOPIC_MENU', 'منو');
    define('_NEWS_AM_TOPIC_SHOW', 'نمایش');
    define('_NEWS_AM_TOPIC_ACTION', 'فعال');
    define('_NEWS_AM_TOPIC_PID', 'والد');
    define('_NEWS_AM_TOPIC_DATE_CREATED', 'زمان ساخت');
    define('_NEWS_AM_TOPIC_DATE_UPDATE', 'زمان به روز رسانی');
    define('_NEWS_AM_TOPIC_SHOWTOPIC', 'نمایش شاخه');
    define('_NEWS_AM_TOPIC_SHOWAUTHOR', 'نمایش نویسنده');
    define('_NEWS_AM_TOPIC_SHOWDATE', 'نمایش تاریخ');
    define('_NEWS_AM_TOPIC_SHOWDPF', 'نمایش پی دی اف');
    define('_NEWS_AM_TOPIC_SHOWPRINT', 'نمایش چاپ');
    define('_NEWS_AM_TOPIC_SHOWMAIL', 'نمایش معرفی به دوستان');
    define('_NEWS_AM_TOPIC_SHOWNAV', 'نمایش ناوبری');
    define('_NEWS_AM_TOPIC_SHOWHITS', 'نمایش بازدید ها');
    define('_NEWS_AM_TOPIC_SHOWCOMS', 'نمایش نظرهای ارسال');
    define('_NEWS_AM_TOPIC_HOMEPAGE', 'تنظیمات صفحه اول شاخه');
    define('_NEWS_AM_TOPIC_HOMEPAGE_DESC', 'Seting content show type in topic pages');
    define('_NEWS_AM_TOPIC_HOMEPAGE_1', 'List all contents from this topic and subtopics');
    define('_NEWS_AM_TOPIC_HOMEPAGE_2', 'List all subtopics');
    define('_NEWS_AM_TOPIC_HOMEPAGE_3', 'List all contents from just this topic');
    define('_NEWS_AM_TOPIC_HOMEPAGE_4', 'Show selected content from this topic');
    define('_NEWS_AM_TOPIC_OPTIONS', 'Sellect topic show options');
    define('_NEWS_AM_TOPIC_OPTIONS_DESC', 'Sellect topic show options');
    define('_NEWS_AM_TOPIC_ALIAS', 'نام مستعار');
    define('_NEWS_AM_TOPIC_SHOWTYPE_0', 'Module based');
    define('_NEWS_AM_TOPIC_SHOWTYPE_1', 'News type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_2', 'Table type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_3', 'Photo type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_4', 'List type');
    define('_NEWS_AM_TOPIC_SHOWTYPE_5', 'Spotlight');
// Content page
    define('_NEWS_AM_CONTENT_FORM', 'مدیریت محتوا');
    define('_NEWS_AM_CONTENT_FORMTITLE', 'عنوان');
    define('_NEWS_AM_CONTENT_FORMTITLE_DISP', 'نمایش عنوان صفحه؟');
    define('_NEWS_AM_CONTENT_FORMAUTHOR', 'سازنده ( نام)');
    define('_NEWS_AM_CONTENT_FORMSOURCE', 'منبع ( لینک)');
    define('_NEWS_AM_CONTENT_FORMTEXT', 'متن');
    define('_NEWS_AM_CONTENT_FORMTEXT_DESC', 'ساخت یا ویرایش صفحه');
    define('_NEWS_AM_CONTENT_FORMGROUP', 'گروه ها');
    define('_NEWS_AM_CONTENT_FORMALIAS', 'نام مستعار');
    define('_NEWS_AM_CONTENT_FORMACTIF', 'فعال');
    define('_NEWS_AM_CONTENT_IMPORTANT', 'مهم');
    define('_NEWS_AM_CONTENT_FORMDEFAULT', 'پیشفرض');
    define('_NEWS_AM_CONTENT_FORMPREV', 'صفحه قبلی');
    define('_NEWS_AM_CONTENT_FORMNEXT', 'صقحه بعدی');
    define('_NEWS_AM_CONTENT_DOHTML', 'نمایش به صورت Html');
    define('_NEWS_AM_CONTENT_BREAKS', 'تبدیل خط شکسته فعال');
    define('_NEWS_AM_CONTENT_DOIMAGE', 'نمایش تصاویر محتوا');
    define('_NEWS_AM_CONTENT_DOXCODE', 'نمایش کدهای محتوا');
    define('_NEWS_AM_CONTENT_DOSMILEY', 'نمایش لبخند های محتوا');
    define('_NEWS_AM_CONTENT_SHORT', 'متن خلاصه');
    define('_NEWS_AM_CONTENT_TITLE', 'عنوان');
    define('_NEWS_AM_CONTENT_MANAGER', 'مدیریت محتوا');
    define('_NEWS_AM_CONTENT_FILE', 'File');
    define('_NEWS_AM_CONTENT_ID', 'ID');
    define('_NEWS_AM_CONTENT_NUM', 'وزن');
    define('_NEWS_AM_CONTENT_PAGE', 'صفحه');
    define('_NEWS_AM_CONTENT_TYPE', 'نوع');
    define('_NEWS_AM_CONTENT_OWNER', 'سازنده');
    define('_NEWS_AM_CONTENT_ACTIF', 'فعال');
    define('_NEWS_AM_CONTENT_DEFAULT', 'پیشفرض');
    define('_NEWS_AM_CONTENT_ORDER', 'چیدمان');
    define('_NEWS_AM_CONTENT_ACTION', 'عملگرها');
    define('_NEWS_AM_CONTENT_VIEW', 'نمایش');
    define('_NEWS_AM_CONTENT_EDIT', 'ویرایش');
    define('_NEWS_AM_CONTENT_DELETE', 'حذف');
    define('_NEWS_AM_CONTENT_SHORTDESC', 'توضیح خلاصه');
    define('_NEWS_AM_CONTENT_TOPIC', 'شاخه');
    define('_NEWS_AM_CONTENT_TOPIC_DESC', 'اگر شاخه ای انتخاب نکنید <br />صفحه شما یک صفحه استاتیک خواهد بود');
    define('_NEWS_AM_CONTENT_STATIC', 'صفحه استاتیک');
    define('_NEWS_AM_CONTENT_STATICS', 'صفحات استاتیک');
    define('_NEWS_AM_CONTENT_ALL_ITEMS', 'تمام صفحه ها و منو ها از تمام شاخه ها');
    define('_NEWS_AM_CONTENT_ALL_ITEMS_FROM', 'تمام صفحه ها و منو ها از شاخه :');
    define('_NEWS_AM_CONTENT_FILE_DESC', 'For add more files you must use admin file system in admin side');
    define('_NEWS_AM_CONTENT_SUBTITLE', 'Subtitle');
    define('_NEWS_AM_CONTENT_ALL', 'All News');
    define('_NEWS_AM_CONTENT_OFFLINE', 'Offline news');
    define('_NEWS_AM_CONTENT_EXPIRE', 'Expire news');
    define('_NEWS_AM_CONTENT_PEDATE', 'Set publish and expiration date');
    define('_NEWS_AM_CONTENT_SETDATETIME', 'Set the date/time of publish');
    define('_NEWS_AM_CONTENT_SETEXPDATETIME', 'Set the date/time of expiration');
// Tools page
    define('_NEWS_AM_TOOLS_FORMFOLDER_TITLE', 'تکثیر ماژول');
    define('_NEWS_AM_TOOLS_FORMFOLDER_NAME', 'نام پوشه');
    define('_NEWS_AM_TOOLS_LOG_TITLE', 'گزارش تکثیر ماژول');
    define('_NEWS_AM_TOOLS_FORMPURGE_TITLE', 'Purge page of deleted clone');
    define('_NEWS_AM_TOOLS_ALIAS_TITLE', 'دوباره سازی نام مستعار');
    define('_NEWS_AM_TOOLS_ALIAS_CONTENT', 'دوباره سازی نام مستعار صفحه');
    define('_NEWS_AM_TOOLS_ALIAS_TOPIC', 'دوباره سازی نام مستعار شاخه');
    define('_NEWS_AM_TOOLS_META_TITLE', 'Rebuild Metas');
    define('_NEWS_AM_TOOLS_META_KEYWORD', 'Rebuild Meta keywords');
    define('_NEWS_AM_TOOLS_META_DESCRIPTION', 'Rebuild Meta Description');
// Permissions
    define('_NEWS_AM_PERMISSIONS_ACCESS', 'دسترسی نمایش');
    define('_NEWS_AM_PERMISSIONS_SUBMIT', 'دسترسی ارسال');
    define('_NEWS_AM_PERMISSIONS_GLOBAL', 'دسترسی سراسری');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_4', 'رای');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_8', 'ارسال در بخش کاربر');
    define('_NEWS_AM_PERMISSIONS_GLOBAL_16', 'تایید خودکار');
// Attach files
    define('_NEWS_AM_FILE', 'File');
	 define('_NEWS_AM_FILE_ID', 'ID');
	 define('_NEWS_AM_FILE_ONLINE', 'آنلاین');
	 define('_NEWS_AM_FILE_ACTION', 'فعال');
    define('_NEWS_AM_FILE_FORM', 'اضافه کردن فایل');
	 define('_NEWS_AM_FILE_TITLE', 'عنوان');
	 define('_NEWS_AM_FILE_CONTENT', 'صفحه');
	 define('_NEWS_AM_FILE_STATUS', 'فعال');
	 define('_NEWS_AM_FILE_SELECT', 'انتخاب فایل');
	 define('_NEWS_AM_FILE_TYPE', 'نوع');
// Admin message
    define('_NEWS_AM_MSG_DBUPDATE', 'پایگاه داده ها با موفقیت به روز شد!');
    define('_NEWS_AM_MSG_ERRORDELETE', 'شما نمیتوایند این سند را حذف کنید <br />لطفا ابتدا تمام زیر سند ها را حذف یا منتقل کنید');
    define('_NEWS_AM_MSG_WAIT', 'لطفا چند لحظه صبر کنید !');
    define('_NEWS_AM_MSG_DELETE', 'آیا اطمینان دارید که میخواهید %s را حذف کنید؟');
    define('_NEWS_AM_MSG_EDIT_ERROR', 'این صفحه پیدا نشد یا آی دی صفحه اشتباه است!');
    define('_NEWS_AM_MSG_UPDATE_ERROR', 'ناتوان در به روز رسانی پایگاه داده ها! خطا در به روز رسانی صفحه');
    define('_NEWS_AM_MSG_INSERT_ERROR', 'ناتوان در به روز رسانی پایگاه داده ها! خطا در مورد محتوا');
    define('_NEWS_AM_MSG_CLONE_ERROR', 'این شاخه هماکنون موجود است!');
    define("_NEWS_AM_MSG_NOPERMSSET", "هیچ دسترسی قابل تنظیم نیست : هنوز هیچ شاخه ای ساخته نشده است! لطفا ابتدا یک شاخه بسازید.");
    define('_NEWS_AM_MSG_ALIASERROR', 'نام مستعار مورد انتخاب شما گرفته شده است. لطفا یک نام دیگر انتخاب کنید.');
// about	
    define('_NEWS_AM_ABOUT_ADMIN', 'درباره');
    define('_NEWS_AM_ABOUT_DESCRIPTION', 'توضیحات:');
    define('_NEWS_AM_ABOUT_AUTHOR', 'سازنده:');
    define('_NEWS_AM_ABOUT_CREDITS', 'معارفه:');
    define('_NEWS_AM_ABOUT_LICENSE', 'مجوز:');
    define('_NEWS_AM_ABOUT_MODULE_INFO', 'اطلاعات ماژول:');
    define('_NEWS_AM_ABOUT_RELEASEDATE', 'زمان انتشار:');
    define("_NEWS_AM_ABOUT_UPDATEDATE", "زمان به روز رسانی: ");
    define('_NEWS_AM_ABOUT_MODULE_STATUS', 'وضعیت:');
    define('_NEWS_AM_ABOUT_WEBSITE', 'وب سایت:');
    define('_NEWS_AM_ABOUT_AUTHOR_INFO', 'اطلاعات سازنده');
    define('_NEWS_AM_ABOUT_AUTHOR_NAME', 'نام:');
    define('_NEWS_AM_ABOUT_CHANGELOG', 'فهرست تغییرات');
// Tips
    define('_NEWS_AM_HOME_TIPS',
    '<ul>
	<li>هنوز چیزی نوشته نشده است</li>
	</ul>');
    define('_NEWS_AM_TOPIC_TIPS',
    '<ul>
	<li>ثبت نمایش ویرایش یا حذف تمام شاخه ها</li>
	<li>استفاده از شاخه ها مشابه منو در سایت</li>
	<li>فعالی سازی و قابلیت استفاده از منو هابه صورت آی جکس</li>
	<li>انتخاب شاخه برای مشاهده تمام صفحات داخل شاخه</li>
	</ul>');
    define('_NEWS_AM_CONTENT_TIPS',
    '<ul>
	<li>ثبت نمایش ویرایش یا حذف تمام صفحات</li>
	<li>ساخت شاخه و لینک</li>
	<li>برای مرتب کردن صفحات (برای مشخص کردن جایگاهشان در منو یا حالت نمایش), کافیست فقط صفحه را گرفته و به محل مناسب بکشید (drag and drop).</li>
	</ul>');
    define('_NEWS_AM_TOOLS_TIPS',
    '<ul>
	<li>هنوز چیزی نوشته نشده است</li>
	</ul>');
    define('_NEWS_AM_PERMISSIONS_TIPS',
    '<ul>
	<li>دسترسی نمایش و ارسال و تایید خودکار برای ماژول</li>
	</ul>');
	define('_NEWS_AM_FILE_TIPS',
    '<ul>
	<li>Not yet</li>
	</ul>');

}
?>