/**
 *
 * @package Post Numbers
 * @version 1.1.1
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

jQuery(function($) {
	// Clipboard plugin
	$.fn.toClipboard = function(o) {
		return this.each(function() {
			var success = false;
			var text = o.text.call(this);
			if (document.execCommand) {
				var temp = document.createElement('input');
				temp.value = text;
				temp.style.position = 'fixed';
				temp.style.opacity = 0;
				temp.style.top = 0;
				document.body.appendChild(temp);
				try {
					temp.select();
					success = document.execCommand('cut') && temp.value === '';
				} catch (e) {
					if (typeof console !== 'undefined' && console.log) {
						console.log('execCommand() error: ' + e);
					}
				} finally {
					document.body.removeChild(temp);
				}
			}
			o[success ? 'success' : 'error'].call(this, text);
		});
	};

	// Tooltip plugin
	$.fn.tooltip = function(o) {
		return this.each(function() {
			var $container = $('<div class="tooltip-container"><div class="tooltip-pointer"><div class="tooltip-text">' + o.text + '</div></div></div>');
			$container
				.appendTo(this)
				.css({
					'margin-top': '-=' + ($container.height() - this.offsetHeight / 2) + 'px',
					'margin-left': '+=' + this.offsetWidth  + 'px'
				})
				.fadeIn(o.speedIn, function() {
					setTimeout(function() {
						$container.fadeOut(o.speedOut, function() {
							$container.remove();
						});
					}, o.alive);
				});
		});
	};

	$('.postbody').on('click', '.post-number', function(e) {
		e.preventDefault();
		$(this).toClipboard({
			text: function() {
				return $(this).find('a').get(0).href;
			},
			success: function(text) {
				$(this).tooltip({
					text		: postNumbers.lang.copied,
					speedIn		: 100,
					alive		: 500,
					speedOut	: 1000
				});
			},
			error: function(text) {
				var $input = $('<input>', {
					type		: 'text',
					value		: text,
					css			: { width: '100%' }
				});
				phpbb.alert(postNumbers.lang.copyManually, $input);
				setTimeout(function() {
					$input.focus().select();
				}, 1);
			}
		});
	});
});
