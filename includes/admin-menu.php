<?php
/**
 * Register admin menu for Quick Popup Anything.
 *
 * @since   1.0.0
 * @since   2.0.0 Added ABSPATH check.
 * @package Quick_Popup_Anything/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register menu in admin.
 * miqpa_settings_page_html function is defined in admin-settings.php.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'miqpa_admin_menu' ) ) {

	function miqpa_admin_menu() {
		add_menu_page(
			__( 'Quick Popup Settings', 'quick-popup-anything' ),
			__( 'Quick Popup', 'quick-popup-anything' ),
			'manage_options',
			'miqpa-settings',
			'miqpa_settings_page_html',
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNy41IiBoZWlnaHQ9IjI3LjUiIHZpZXdCb3g9IjAgMCAyNy41IDI3LjUiPjxkZWZzPjxzdHlsZT4uYXtmaWxsOiM5ZmE0YWE7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT5Bc3NldCA3PC90aXRsZT48cmVjdCBjbGFzcz0iYSIgeT0iOC41IiB3aWR0aD0iMTkiIGhlaWdodD0iMTkiIHJ4PSIyIi8+PHBhdGggY2xhc3M9ImEiIGQ9Ik04LjUsN2gtMVYyYTIsMiwwLDAsMSwyLTJoMTZhMiwyLDAsMCwxLDIsMlYxOGEyLDIsMCwwLDEtMiwyaC01VjE5aDRhMiwyLDAsMCwwLDItMlYzYTIsMiwwLDAsMC0yLTJoLTE0YTIsMiwwLDAsMC0yLDJaIi8+PC9zdmc+',
			30
		);
	}
	add_action( 'admin_menu', 'miqpa_admin_menu' );

}