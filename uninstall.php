<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since   1.0.0
 * @since   2.0.0 Replaced wp_load_alloptions() loop with explicit deletes.
 * @package Quick_Popup_Anything
 */

// If uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Explicitly delete all known plugin options.
$miqpa_options = array(
	'miqpa_editor_content',
	'miqpa_button_label',
	'miqpa_button_position',
	'miqpa_button_id',
	'miqpa_button_class',
	'miqpa_button_zindex',
	'miqpa_button_bg',
	'miqpa_button_color',
	'miqpa_button_hover_bg',
	'miqpa_button_hover_color',
	'miqpa_popup_disable',
	'miqpa_popup_hide_on_mobile',
	'miqpa_popup_width',
	'miqpa_popup_id',
	'miqpa_popup_class',
	'miqpa_popup_bg',
	'miqpa_popup_text_color',
	'miqpa_popup_display_only_once',
	// Advanced features (v2.1.0).
	'miqpa_popup_auto_open_delay',
	'miqpa_popup_exit_intent',
	'miqpa_popup_scroll_trigger',
	'miqpa_popup_animation',
	'miqpa_popup_overlay_color',
	'miqpa_popup_overlay_opacity',
);

foreach ( $miqpa_options as $option ) {
	delete_option( $option );
}