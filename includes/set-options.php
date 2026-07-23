<?php
/**
 * Set plugin default options on activation.
 *
 * @since   1.0.0
 * @since   2.0.0 Removed duplicate option checks, added missing defaults.
 * @package Quick_Popup_Anything/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin activation — set default settings.
 *
 * @since 1.0.0
 * @since 2.0.0 Fixed duplicate defaults, added popup bg/text color defaults.
 */
function miqpa_activation_plugin() {
	$defaults = array(
		'miqpa_editor_content'   => 'Thank you for using Quick Popup Anything.',
		'miqpa_button_label'     => 'Quick Popup',
		'miqpa_button_position'  => 'right',
		'miqpa_button_bg'        => '#3498db',
		'miqpa_button_color'     => '#ffffff',
		'miqpa_button_hover_bg'  => '#333333',
		'miqpa_button_hover_color' => '#ffffff',
		'miqpa_button_zindex'    => '99',
		'miqpa_popup_width'      => '600px',
		'miqpa_popup_bg'         => '#ffffff',
		'miqpa_popup_text_color' => '#000000',
		// Advanced features (v2.1.0).
		'miqpa_popup_auto_open_delay' => '0',
		'miqpa_popup_exit_intent'     => '',
		'miqpa_popup_scroll_trigger'  => '0',
		'miqpa_popup_animation'       => 'fade',
		'miqpa_popup_overlay_color'   => '#000000',
		'miqpa_popup_overlay_opacity' => '80',
	);

	foreach ( $defaults as $option_name => $default_value ) {
		if ( false === get_option( $option_name ) ) {
			update_option( $option_name, $default_value );
		}
	}
}
register_activation_hook( MIQPA_PLUGIN_FILE_URL, 'miqpa_activation_plugin' );