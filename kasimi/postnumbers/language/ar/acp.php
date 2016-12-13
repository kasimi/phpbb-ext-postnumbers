<?php

/**
 *
 * @package phpBB Extension - Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 * Translated By : Bassel Taha Alhitary - www.alhitary.net
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'POSTNUMBERS_ENABLED_VIEWTOPIC'			=> 'عرض أرقام المُشاركات عند مُشاهدة المواضيع ',
	'POSTNUMBERS_ENABLED_REVIEW_REPLY'		=> 'عرض أرقام المُشاركات في استعراض الموضوع عند إضافة رد ',
	'POSTNUMBERS_ENABLED_REVIEW_MCP'		=> 'عرض أرقام المُشاركات عند استعراض الموضوع في لوحة تحكم المشرف ',
	'POSTNUMBERS_SKIP_NONAPPROVED'			=> 'تجاهل المُشاركات قيد الموافقة ',
	'POSTNUMBERS_SKIP_NONAPPROVED_EXP'		=> 'عدم تخصيص الأرقام للمُشاركات التي قيد الموافقة و المُشاركات المحذوفة حذف غير نهائي',
	'POSTNUMBERS_DISPLAY_IDS'				=> 'عرض عدد المُشاركات بدلاً من أرقام المُشاركات ',
	'POSTNUMBERS_DISPLAY_IDS_EXP'			=> 'لو أخترت "نعم" , سيتم تعطيل الخيار السابق <span style="font-style: italic;">تجاهل المُشاركات قيد الموافقة</span><br />عدد المشاركات : عدد المشاركة في جميع مُشاركات المنتدى والذي يظهر في شريط الرابط للمتصفح<br />أرقام المشاركات : رقم المشاركة في الموضوع فقط.',
	'POSTNUMBERS_LOCATION'					=> 'مكان أرقام المُشاركات  ',
	'POSTNUMBERS_LOCATION_AUTHOR'			=> 'بين صورة المُشاركة و إسم الكاتب',
	'POSTNUMBERS_LOCATION_SUBJECT'			=> 'في عنوان المُشاركة',
	'POSTNUMBERS_CLIPBOARD'					=> 'نسخ رابط المُشاركة ',
	'POSTNUMBERS_CLIPBOARD_EXP'				=> 'نسخ رابط المُشاركة إلى الحافظة عند النقر على رقم المُشاركة. مناسب فقط في حالة ظهور أرقام المًشاركة بين صورة المُشاركة و إسم الكاتب. هذا الخيار يعمل فقط عند استخدامك للمتصفحات الحديثة , على الأقل : الكروم 42 , الفايرفوكس 41 , الإكسبلورر 9 , الأوبرا 29. أما في المُتصفحات الغير مدعومة , مثل : متصفح السفاري , ستظهر نافذة تحتوي على رابط المُشاركة عند النقر على رقم المُشاركة.',
	'POSTNUMBERS_BOLD'						=> 'أعداد وأرقام المشاركات يكون بخط سميك ',
	'POSTNUMBERS_BOLD_EXP'					=> 'يكون مناسب فقط في حالة ظهور أرقام المًشاركة بين صورة المُشاركة و إسم الكاتب.',
));
