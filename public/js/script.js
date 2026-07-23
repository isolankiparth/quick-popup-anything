/**
 * Quick Popup Anything — Frontend Scripts
 *
 * @since   1.0.0
 * @since   2.0.0 Fixed localStorage bug, plugin-specific storage key.
 * @since   2.1.0 Added exit intent, auto-open delay, scroll trigger, animation effects, .miqpa-open-popup binding.
 * @package Quick_Popup_Anything/public
 */

(function ($) {
	'use strict';

	$(function () {
		var STORAGE_KEY = 'miqpa_popup_shown';

		var $popupContent = $('#miqpa_popup_content');
		if (!$popupContent.length) {
			return;
		}

		var $wrapper       = $('.miqpa_popup_wrap');
		var isDisplayOnce  = $popupContent.hasClass('popup_display_only_once');
		var isHideOnMobile = $popupContent.hasClass('popup_hide_on_mobile');
		var $button        = $wrapper.find('.miqpa_popup_open_button');

		// Read advanced config from data attributes.
		var animation     = $wrapper.attr('data-animation') || 'fade';
		var autoOpenDelay = parseInt($wrapper.attr('data-auto-open-delay'), 10) || 0;
		var exitIntent    = $wrapper.attr('data-exit-intent') === '1';
		var scrollTrigger = parseInt($wrapper.attr('data-scroll-trigger'), 10) || 0;

		// Map animation name to CSS class.
		var animationClassMap = {
			'fade':       'miqpa-mfp-fade',
			'zoom':       'miqpa-mfp-zoom',
			'slide-up':   'miqpa-mfp-slide-up',
			'slide-down': 'miqpa-mfp-slide-down'
		};
		var mainClass = animationClassMap[animation] || 'miqpa-mfp-fade';

		// Track if popup has been triggered this session (to avoid duplicates).
		var popupTriggered = false;

		// Helper: check if "display only once" should block.
		function isOnceBlocked() {
			if (!isDisplayOnce) {
				return false;
			}
			try {
				return localStorage.getItem(STORAGE_KEY) === 'shown';
			} catch (e) {
				return false;
			}
		}

		// Helper: mark popup as shown in localStorage.
		function markShown() {
			if (isDisplayOnce) {
				try {
					localStorage.setItem(STORAGE_KEY, 'shown');
				} catch (e) {
					// Private browsing — fail silently.
				}
			}
		}

		// Helper: should hide on mobile?
		function isMobileBlocked() {
			return isHideOnMobile && $(window).width() <= 600;
		}

		// Popup config builder.
		function getPopupConfig() {
			return {
				removalDelay: 300,
				mainClass: mainClass,
				closeOnBgClick: true,
				enableEscapeKey: true,
				items: {
					src: '#miqpa_popup_content',
					type: 'inline'
				}
			};
		}

		// Open popup (smart — respects once, mobile, and duplicate guards).
		function openPopupSmart() {
			if (popupTriggered || isMobileBlocked() || isOnceBlocked()) {
				return;
			}
			popupTriggered = true;
			$.magnificPopup.open(getPopupConfig(), 0);
			markShown();
		}

		// --- Set button position class ---
		if ($button.length) {
			$button.removeClass('right_center left_center bottom_left bottom_right');
			var position   = $button.attr('data-btn-position');
			var outerWidth = $button.outerWidth();
			var halfWidth  = outerWidth / 2;

			switch (position) {
				case 'right':
					$button.css('top', 'calc(50% - ' + $button.width() + 'px)');
					$button.addClass('right_center');
					break;
				case 'left':
					$button.css('top', 'calc(50% + ' + halfWidth + 'px)');
					$button.addClass('left_center');
					break;
				case 'bottom_left':
					$button.addClass('bottom_left');
					break;
				case 'bottom_right':
					$button.addClass('bottom_right');
					break;
				default:
					$button.css('top', 'calc(50% - ' + $button.width() + 'px)');
					$button.addClass('right_center');
			}
		}

		// --- Mode: Display Only Once (auto-open on page load) ---
		if (isDisplayOnce) {
			if (!isMobileBlocked() && !isOnceBlocked()) {
				popupTriggered = true;
				$.magnificPopup.open(getPopupConfig(), 0);
				markShown();
			}
		} else {
			// --- Mode: Button-triggered ---
			if ($button.length && $.fn.magnificPopup) {
				$button.magnificPopup(getPopupConfig());
			}
		}

		// --- Feature: Auto-Open Delay ---
		if (autoOpenDelay > 0 && !isDisplayOnce) {
			setTimeout(function () {
				openPopupSmart();
			}, autoOpenDelay * 1000);
		}

		// --- Feature: Exit Intent ---
		if (exitIntent && !isDisplayOnce) {
			var exitIntentFired = false;
			$(document).on('mouseleave.miqpa', function (e) {
				if (e.clientY <= 0 && !exitIntentFired) {
					exitIntentFired = true;
					openPopupSmart();
				}
			});
		}

		// --- Feature: Scroll Trigger ---
		if (scrollTrigger > 0 && scrollTrigger <= 100 && !isDisplayOnce) {
			var scrollFired = false;
			$(window).on('scroll.miqpa', function () {
				if (scrollFired) {
					return;
				}
				var scrollPercent = ($(window).scrollTop() / ($(document).height() - $(window).height())) * 100;
				if (scrollPercent >= scrollTrigger) {
					scrollFired = true;
					openPopupSmart();
					$(window).off('scroll.miqpa');
				}
			});
		}

		// --- Feature: Open via CSS class (.miqpa-open-popup) ---
		$(document).on('click', '.miqpa-open-popup', function (e) {
			e.preventDefault();
			if (isMobileBlocked()) {
				return;
			}
			$.magnificPopup.open(getPopupConfig(), 0);
		});

	});

})(jQuery);
