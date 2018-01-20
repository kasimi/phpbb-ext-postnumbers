/**
 *
 * @package Post Numbers
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

jQuery(function($) {
	/**
	 * Compatibility with the Quickedit extension by Marc
	 *
	 * When clicking on a post's Edit icon, the Quickedit extension adds the text
	 * editor after the .author element. Since the Post Numbers extension adds
	 * an element that also has this .author CSS class, the editor is added twice.
	 * This is why we remove the .author CSS class before the Quickedit extension
	 * adds the editor, and add it back afterwards.
	 */
	var quickEdit = phpbb.ajaxCallbacks['quickedit_post'];
	if (quickEdit) {
		phpbb.addAjaxCallback('quickedit_post', function(res) {
			var $postNumber = $('#p' + res.POST_ID).find('p.post-number');
			$postNumber.removeClass('author');
			quickEdit.apply(this, arguments);
			$postNumber.addClass('author');
		});
	}
});
