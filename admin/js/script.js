/**
 * Quick Popup Anything — Admin Scripts
 *
 * @since   1.0.0
 * @since   2.0.0 Improved color picker initialization.
 * @since   2.1.0 Added range slider live update.
 * @package Quick_Popup_Anything/admin
 */

(function ($) {
	'use strict';

	$(function () {
		// Initialize WP Color Picker on all color fields.
		if ($.fn.wpColorPicker) {
			$('.miqpa-color-field').wpColorPicker();
		}

		// Range slider live value update.
		$('.miqpa-range').on('input', function () {
			$(this).siblings('.miqpa-range-value').text(this.value + '%');
		});
	});

})(jQuery);