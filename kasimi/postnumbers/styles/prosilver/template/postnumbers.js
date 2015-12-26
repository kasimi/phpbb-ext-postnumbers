/**
 *
 * @package Post Numbers
 * @version 1.0.3
 * @copyright (c) 2015 kasimi
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
jQuery(function($) {
	// Clipboard plugin
	$.fn.toClipboard = function(o) {
		return this.each(function() {
			var success = false;
			var text = o.text(this);
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
			o[success ? 'success' : 'error'](this, text);
		});
	};

	// Tooltip plugin
	$.fn.tooltip = function(o) {
		return this.each(function() {
			var $this = $(this);
			var $container = $('<div class="tooltip-container"><div class="tooltip-pointer"><div class="tooltip-text">' + o.text + '</div></div></div>');
			$container
				.insertBefore($this)
				.css('margin-left', $this.position().left + $this.width() / 2 - $container.width() / 2 + 'px')
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
		var $this = $(this);
		$this.parent().toClipboard({
			text: function(trigger) {
				return $(trigger).get(0).href;
			},
			success: function(trigger, text) {
				$(trigger).tooltip({
					text		: $this.data('tooltip'),
					speedIn		: 100,
					alive		: 500,
					speedOut	: 1000
				});
			},
			error: function(trigger, text) {
				window.prompt($this.data('copy-manually'), text);
			}
		});
		e.preventDefault();
	});
});
