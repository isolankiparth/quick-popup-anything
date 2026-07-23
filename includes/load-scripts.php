<?php
/**
 * Load Style and JS files in client side and admin side.
 *
 * @since   1.0.0
 * @since   2.0.0 Restricted admin scripts to plugin page, skip frontend when popup disabled.
 * @package Quick_Popup_Anything/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load style and script in admin side — only on the plugin's settings page.
 *
 * @since 1.0.0
 * @since 2.0.0 Added $hook_suffix check so assets only load on plugin page.
 *
 * @param string $hook_suffix The current admin page hook suffix.
 */
if ( ! function_exists( 'miqpa_plugin_admin_scripts' ) ) {

	function miqpa_plugin_admin_scripts( $hook_suffix ) {
		// Only load on our own settings page.
		if ( 'toplevel_page_miqpa-settings' !== $hook_suffix ) {
			return;
		}

		// Color picker CSS.
		wp_enqueue_style( 'wp-color-picker' );

		// Plugin admin CSS.
		wp_enqueue_style(
			'miqpa-admin-css',
			MIQPA_PLUGIN_URL . 'admin/css/style.css',
			array(),
			MIQPA_VERSION
		);

		// Plugin admin JS with color picker dependency.
		wp_enqueue_script(
			'miqpa-admin-js',
			MIQPA_PLUGIN_URL . 'admin/js/script.js',
			array( 'wp-color-picker' ),
			MIQPA_VERSION,
			true
		);
	}
	add_action( 'admin_enqueue_scripts', 'miqpa_plugin_admin_scripts' );

}

/**
 * Load style and script on the frontend — skip when popup is disabled.
 *
 * @since 1.0.0
 * @since 2.0.0 Added disabled check, uses MIQPA_VERSION for cache busting.
 */
if ( ! function_exists( 'miqpa_plugin_public_scripts' ) ) {

	function miqpa_plugin_public_scripts() {
		// Don't load anything if the popup is disabled.
		if ( get_option( 'miqpa_popup_disable' ) === '1' ) {
			return;
		}

		wp_enqueue_style(
			'miqpa-magnific-popup-css',
			MIQPA_PLUGIN_URL . 'public/css/magnific-popup.css',
			array(),
			MIQPA_VERSION
		);

		wp_enqueue_style(
			'miqpa-public-css',
			MIQPA_PLUGIN_URL . 'public/css/style.css',
			array( 'miqpa-magnific-popup-css' ),
			MIQPA_VERSION
		);

		wp_enqueue_script(
			'miqpa-magnific-popup-js',
			MIQPA_PLUGIN_URL . 'public/js/jquery.magnific-popup.min.js',
			array( 'jquery' ),
			MIQPA_VERSION,
			true
		);

		wp_enqueue_script(
			'miqpa-public-js',
			MIQPA_PLUGIN_URL . 'public/js/script.js',
			array( 'jquery', 'miqpa-magnific-popup-js' ),
			MIQPA_VERSION,
			true
		);
	}
	add_action( 'wp_enqueue_scripts', 'miqpa_plugin_public_scripts' );

}
