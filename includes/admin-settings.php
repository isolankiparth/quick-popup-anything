<?php
/**
 * All Quick Popup Anything admin settings.
 *
 * @since   1.0.0
 * @since   2.0.0 Security hardening, sanitize callbacks, UI redesign, i18n.
 * @package Quick_Popup_Anything/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
|--------------------------------------------------------------------------
| Sanitization Helpers
|--------------------------------------------------------------------------
*/

/**
 * Sanitize a hex color value.
 *
 * @since 2.0.0
 * @param string $color Raw color value.
 * @return string Sanitized hex color or empty string.
 */
function miqpa_sanitize_hex_color( $color ) {
	$color = sanitize_text_field( $color );
	if ( preg_match( '/^#([A-Fa-f0-9]{3}){1,2}$/', $color ) ) {
		return $color;
	}
	return '';
}

/**
 * Sanitize a CSS dimension value (e.g. 600px, 50%, 80vw).
 *
 * @since 2.0.0
 * @param string $value Raw CSS value.
 * @return string Sanitized CSS dimension or empty string.
 */
function miqpa_sanitize_css_dimension( $value ) {
	$value = sanitize_text_field( $value );
	if ( preg_match( '/^\d+(\.\d+)?(px|%|em|rem|vw|vh)$/', $value ) ) {
		return $value;
	}
	return '';
}

/**
 * Sanitize a CSS identifier (ID or class name).
 * Allows letters, numbers, hyphens, and underscores only.
 *
 * @since 2.0.0
 * @param string $value Raw CSS identifier.
 * @return string Sanitized identifier.
 */
function miqpa_sanitize_css_identifier( $value ) {
	return preg_replace( '/[^a-zA-Z0-9_\-]/', '', sanitize_text_field( $value ) );
}

/**
 * Sanitize a z-index value (positive integer).
 *
 * @since 2.0.0
 * @param string $value Raw z-index.
 * @return string Sanitized numeric string.
 */
function miqpa_sanitize_zindex( $value ) {
	$int = absint( $value );
	return $int > 0 ? (string) $int : '99';
}

/**
 * Sanitize a checkbox value (returns '1' or '').
 *
 * @since 2.0.0
 * @param mixed $value Raw checkbox value.
 * @return string '1' if checked, '' otherwise.
 */
function miqpa_sanitize_checkbox( $value ) {
	return ( '1' === (string) $value ) ? '1' : '';
}

/**
 * Sanitize button position (whitelist).
 *
 * @since 2.0.0
 * @param string $value Raw position value.
 * @return string Valid position or 'right'.
 */
function miqpa_sanitize_button_position( $value ) {
	$allowed = array( 'left', 'right', 'bottom_left', 'bottom_right' );
	return in_array( $value, $allowed, true ) ? $value : 'right';
}

/**
 * Sanitize animation effect (whitelist).
 *
 * @since 2.1.0
 * @param string $value Raw animation value.
 * @return string Valid animation or 'fade'.
 */
function miqpa_sanitize_animation( $value ) {
	$allowed = array( 'fade', 'zoom', 'slide-up', 'slide-down' );
	return in_array( $value, $allowed, true ) ? $value : 'fade';
}

/**
 * Sanitize overlay opacity (0–100 integer).
 *
 * @since 2.1.0
 * @param mixed $value Raw opacity value.
 * @return string Clamped integer string.
 */
function miqpa_sanitize_opacity( $value ) {
	$int = absint( $value );
	return (string) min( 100, max( 0, $int ) );
}

/**
 * Sanitize a non-negative integer (for delay seconds, scroll %).
 *
 * @since 2.1.0
 * @param mixed $value Raw value.
 * @return string Non-negative integer as string.
 */
function miqpa_sanitize_non_negative_int( $value ) {
	return (string) absint( $value );
}

/*
|--------------------------------------------------------------------------
| Settings Page HTML
|--------------------------------------------------------------------------
*/

/**
 * Generate the settings page HTML.
 *
 * @since 1.0.0
 * @since 2.0.0 Sanitized tab parameter, redesigned UI.
 */
if ( ! function_exists( 'miqpa_settings_page_html' ) ) {

	function miqpa_settings_page_html() {
		// Whitelist the active tab.
		$allowed_tabs = array( 'popup-content', 'button-settings', 'popup-settings' );
		$active_tab   = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'popup-content';
		if ( ! in_array( $active_tab, $allowed_tabs, true ) ) {
			$active_tab = 'popup-content';
		}
		?>
		<div class="wrap miqpa-wrap">
			<div class="miqpa-header">
				<div class="miqpa-header-inner">
					<h1 class="miqpa-title">
						<span class="miqpa-title-icon dashicons dashicons-slides"></span>
						<?php echo esc_html( get_admin_page_title() ); ?>
					</h1>
					<span class="miqpa-version"><?php echo esc_html( 'v' . MIQPA_VERSION ); ?></span>
				</div>
			</div>

			<?php settings_errors(); ?>

			<form action="options.php" method="post" name="miqpa_form" class="miqpa_form">
				<div class="miqpa-tabs-wrapper">
					<nav class="miqpa-tab-nav">
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=miqpa-settings&tab=popup-content' ) ); ?>"
						   class="miqpa-tab-link <?php echo ( 'popup-content' === $active_tab ) ? 'miqpa-tab-active' : ''; ?>">
							<span class="dashicons dashicons-edit-page"></span>
							<?php esc_html_e( 'Popup Content', 'quick-popup-anything' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=miqpa-settings&tab=button-settings' ) ); ?>"
						   class="miqpa-tab-link <?php echo ( 'button-settings' === $active_tab ) ? 'miqpa-tab-active' : ''; ?>">
							<span class="dashicons dashicons-button"></span>
							<?php esc_html_e( 'Button Settings', 'quick-popup-anything' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=miqpa-settings&tab=popup-settings' ) ); ?>"
						   class="miqpa-tab-link <?php echo ( 'popup-settings' === $active_tab ) ? 'miqpa-tab-active' : ''; ?>">
							<span class="dashicons dashicons-admin-settings"></span>
							<?php esc_html_e( 'Popup Settings', 'quick-popup-anything' ); ?>
						</a>
					</nav>

					<div class="miqpa-tab-content">
						<?php
						if ( 'popup-content' === $active_tab ) {
							echo '<div class="miqpa-card">';
							echo '<div class="miqpa-card-header"><h2>' . esc_html__( 'Popup Content', 'quick-popup-anything' ) . '</h2>';
							echo '<p class="miqpa-card-desc">' . esc_html__( 'Add HTML, text, shortcodes, or any content to display inside the popup.', 'quick-popup-anything' ) . '</p></div>';
							echo '<div class="miqpa-card-body">';
							settings_fields( 'miqpa-content-settings' );
							$content = get_option( 'miqpa_editor_content', '' );
							wp_editor( $content, 'miqpa_editor_content', array(
								'textarea_rows' => 15,
								'media_buttons' => true,
								'teeny'         => false,
							) );
							echo '</div></div>';
						} elseif ( 'button-settings' === $active_tab ) {
							echo '<div class="miqpa-card">';
							echo '<div class="miqpa-card-header"><h2>' . esc_html__( 'Button Settings', 'quick-popup-anything' ) . '</h2>';
							echo '<p class="miqpa-card-desc">' . esc_html__( 'Customize the floating button that triggers the popup.', 'quick-popup-anything' ) . '</p></div>';
							echo '<div class="miqpa-card-body">';
							settings_fields( 'miqpa-button-settings' );
							do_settings_sections( 'miqpa-button-settings' );
							echo '</div></div>';
						} else {
							echo '<div class="miqpa-card">';
							echo '<div class="miqpa-card-header"><h2>' . esc_html__( 'Popup Settings', 'quick-popup-anything' ) . '</h2>';
							echo '<p class="miqpa-card-desc">' . esc_html__( 'Control popup behavior, smart triggers (exit intent, auto-open, scroll), animations, and appearance.', 'quick-popup-anything' ) . '</p></div>';
							echo '<div class="miqpa-card-body">';
							settings_fields( 'miqpa-popup-settings' );
							do_settings_sections( 'miqpa-popup-settings' );
							echo '</div></div>';
						}
						?>

						<?php submit_button( __( 'Save Settings', 'quick-popup-anything' ), 'primary miqpa-save-btn', 'submit', true ); ?>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

}

/*
|--------------------------------------------------------------------------
| Content Settings (Tab 1)
|--------------------------------------------------------------------------
*/

/**
 * Register content settings.
 *
 * @since 1.0.0
 * @since 2.0.0 Added sanitize callback.
 */
if ( ! function_exists( 'miqpa_content_settings_init' ) ) {

	function miqpa_content_settings_init() {
		register_setting( 'miqpa-content-settings', 'miqpa_editor_content', array(
			'type'              => 'string',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => '',
		) );

		add_settings_section( 'miqpa_editor_section', '', '__return_false', 'miqpa-content-settings' );
	}
	add_action( 'admin_init', 'miqpa_content_settings_init' );

}

/*
|--------------------------------------------------------------------------
| Button Settings (Tab 2)
|--------------------------------------------------------------------------
*/

/**
 * Register button settings.
 *
 * @since 1.0.0
 * @since 2.0.0 Added sanitize callbacks, field descriptions.
 */
if ( ! function_exists( 'miqpa_button_settings_init' ) ) {

	function miqpa_button_settings_init() {
		// Register settings with sanitize callbacks.
		register_setting( 'miqpa-button-settings', 'miqpa_button_label', array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Quick Popup',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_position', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_button_position',
			'default'           => 'right',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_id', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_identifier',
			'default'           => '',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_class', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_identifier',
			'default'           => '',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_zindex', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_zindex',
			'default'           => '99',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_bg', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#3498db',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_color', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#ffffff',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_hover_bg', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#333333',
		) );
		register_setting( 'miqpa-button-settings', 'miqpa_button_hover_color', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#ffffff',
		) );

		// Section.
		add_settings_section(
			'miqpa_button_section',
			'',
			'__return_false',
			'miqpa-button-settings'
		);

		// Fields.
		add_settings_field( 'miqpa_button_section_btn_label', __( 'Label', 'quick-popup-anything' ), 'miqpa_button_section_btn_label_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_position', __( 'Position', 'quick-popup-anything' ), 'miqpa_button_section_btn_position_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_id', __( 'Custom ID', 'quick-popup-anything' ), 'miqpa_button_section_btn_id_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_class', __( 'Custom Class', 'quick-popup-anything' ), 'miqpa_button_section_btn_class_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_zindex', __( 'Z-index', 'quick-popup-anything' ), 'miqpa_button_section_btn_zindex_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_bg', __( 'Background Color', 'quick-popup-anything' ), 'miqpa_button_section_btn_bg_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_color', __( 'Label Color', 'quick-popup-anything' ), 'miqpa_button_section_btn_color_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_hover_bg', __( 'Hover Background', 'quick-popup-anything' ), 'miqpa_button_section_btn_hover_bg_cb', 'miqpa-button-settings', 'miqpa_button_section' );
		add_settings_field( 'miqpa_button_section_btn_hover_color', __( 'Hover Label Color', 'quick-popup-anything' ), 'miqpa_button_section_btn_hover_color_cb', 'miqpa-button-settings', 'miqpa_button_section' );
	}
	add_action( 'admin_init', 'miqpa_button_settings_init' );

	/* Callback functions */

	function miqpa_button_section_btn_label_cb() {
		$value = esc_attr( get_option( 'miqpa_button_label', '' ) );
		?>
		<input type="text" name="miqpa_button_label" value="<?php echo $value; ?>" class="regular-text">
		<p class="description"><?php esc_html_e( 'Text displayed on the floating button.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_button_section_btn_position_cb() {
		$value = get_option( 'miqpa_button_position', 'right' );
		?>
		<select name="miqpa_button_position" class="miqpa-select">
			<option value="left" <?php selected( $value, 'left' ); ?>><?php esc_html_e( 'Center Left', 'quick-popup-anything' ); ?></option>
			<option value="right" <?php selected( $value, 'right' ); ?>><?php esc_html_e( 'Center Right', 'quick-popup-anything' ); ?></option>
			<option value="bottom_left" <?php selected( $value, 'bottom_left' ); ?>><?php esc_html_e( 'Bottom Left', 'quick-popup-anything' ); ?></option>
			<option value="bottom_right" <?php selected( $value, 'bottom_right' ); ?>><?php esc_html_e( 'Bottom Right', 'quick-popup-anything' ); ?></option>
		</select>
		<p class="description"><?php esc_html_e( 'Where to place the floating popup button on the page.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_button_section_btn_id_cb() {
		$value = esc_attr( get_option( 'miqpa_button_id', '' ) );
		?>
		<input type="text" name="miqpa_button_id" value="<?php echo $value; ?>" class="regular-text">
		<p class="description"><?php esc_html_e( 'Optional. CSS ID attribute for the button (letters, numbers, hyphens, underscores only).', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_button_section_btn_class_cb() {
		$value = esc_attr( get_option( 'miqpa_button_class', '' ) );
		?>
		<input type="text" name="miqpa_button_class" value="<?php echo $value; ?>" class="regular-text">
		<p class="description"><?php esc_html_e( 'Optional. CSS class for custom styling (letters, numbers, hyphens, underscores only).', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_button_section_btn_zindex_cb() {
		$value = esc_attr( get_option( 'miqpa_button_zindex', '99' ) );
		?>
		<input type="number" name="miqpa_button_zindex" value="<?php echo $value; ?>" class="small-text" min="1" max="2147483647">
		<p class="description"><?php esc_html_e( 'Controls the stacking order. Higher values appear on top. Default: 99.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_button_section_btn_bg_cb() {
		$value = esc_attr( get_option( 'miqpa_button_bg', '#3498db' ) );
		?>
		<input type="text" name="miqpa_button_bg" value="<?php echo $value; ?>" data-default-color="#3498db" class="miqpa-color-field">
		<?php
	}

	function miqpa_button_section_btn_color_cb() {
		$value = esc_attr( get_option( 'miqpa_button_color', '#ffffff' ) );
		?>
		<input type="text" name="miqpa_button_color" value="<?php echo $value; ?>" data-default-color="#ffffff" class="miqpa-color-field">
		<?php
	}

	function miqpa_button_section_btn_hover_bg_cb() {
		$value = esc_attr( get_option( 'miqpa_button_hover_bg', '#333333' ) );
		?>
		<input type="text" name="miqpa_button_hover_bg" value="<?php echo $value; ?>" data-default-color="#333333" class="miqpa-color-field">
		<?php
	}

	function miqpa_button_section_btn_hover_color_cb() {
		$value = esc_attr( get_option( 'miqpa_button_hover_color', '#ffffff' ) );
		?>
		<input type="text" name="miqpa_button_hover_color" value="<?php echo $value; ?>" data-default-color="#ffffff" class="miqpa-color-field">
		<?php
	}

}

/*
|--------------------------------------------------------------------------
| Popup Settings (Tab 3)
|--------------------------------------------------------------------------
*/

/**
 * Register popup settings.
 *
 * @since 1.0.0
 * @since 2.0.0 Added sanitize callbacks, field descriptions.
 */
if ( ! function_exists( 'miqpa_popup_settings_init' ) ) {

	function miqpa_popup_settings_init() {
		// Register settings with sanitize callbacks.
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_disable', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_checkbox',
			'default'           => '',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_hide_on_mobile', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_checkbox',
			'default'           => '',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_width', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_dimension',
			'default'           => '600px',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_id', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_identifier',
			'default'           => '',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_class', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_identifier',
			'default'           => '',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_bg', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#ffffff',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_text_color', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#000000',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_display_only_once', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_checkbox',
			'default'           => '',
		) );

		// Advanced features (v2.1.0).
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_auto_open_delay', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_non_negative_int',
			'default'           => '0',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_exit_intent', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_checkbox',
			'default'           => '',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_scroll_trigger', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_non_negative_int',
			'default'           => '0',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_animation', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_animation',
			'default'           => 'fade',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_overlay_color', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_hex_color',
			'default'           => '#000000',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_overlay_opacity', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_opacity',
			'default'           => '80',
		) );
		register_setting( 'miqpa-popup-settings', 'miqpa_popup_trigger_class', array(
			'type'              => 'string',
			'sanitize_callback' => 'miqpa_sanitize_css_identifier',
			'default'           => '',
		) );

		// Sections.
		add_settings_section(
			'miqpa_popup_section',
			__( 'Behavior', 'quick-popup-anything' ),
			'__return_false',
			'miqpa-popup-settings'
		);
		add_settings_section(
			'miqpa_popup_triggers_section',
			__( 'Smart Triggers', 'quick-popup-anything' ),
			'__return_false',
			'miqpa-popup-settings'
		);
		add_settings_section(
			'miqpa_popup_appearance_section',
			__( 'Appearance', 'quick-popup-anything' ),
			'__return_false',
			'miqpa-popup-settings'
		);

		// Behavior fields.
		add_settings_field( 'miqpa_popup_section_popup_disable', __( 'Disable Popup', 'quick-popup-anything' ), 'miqpa_popup_section_popup_disable_cb', 'miqpa-popup-settings', 'miqpa_popup_section' );
		add_settings_field( 'miqpa_popup_section_popup_hide_on_mobile', __( 'Hide on Mobile', 'quick-popup-anything' ), 'miqpa_popup_section_popup_hide_on_mobile_cb', 'miqpa-popup-settings', 'miqpa_popup_section' );
		add_settings_field( 'miqpa_popup_section_popup_display_only_once', __( 'Display Only Once', 'quick-popup-anything' ), 'miqpa_popup_section_popup_display_only_once_cb', 'miqpa-popup-settings', 'miqpa_popup_section' );

		// Smart Triggers fields.
		add_settings_field( 'miqpa_popup_section_auto_open_delay', __( 'Auto-Open Delay', 'quick-popup-anything' ), 'miqpa_popup_section_auto_open_delay_cb', 'miqpa-popup-settings', 'miqpa_popup_triggers_section' );
		add_settings_field( 'miqpa_popup_section_exit_intent', __( 'Exit Intent', 'quick-popup-anything' ), 'miqpa_popup_section_exit_intent_cb', 'miqpa-popup-settings', 'miqpa_popup_triggers_section' );
		add_settings_field( 'miqpa_popup_section_scroll_trigger', __( 'Scroll Trigger', 'quick-popup-anything' ), 'miqpa_popup_section_scroll_trigger_cb', 'miqpa-popup-settings', 'miqpa_popup_triggers_section' );
		add_settings_field( 'miqpa_popup_section_trigger_class', __( 'Custom Trigger Class', 'quick-popup-anything' ), 'miqpa_popup_section_trigger_class_cb', 'miqpa-popup-settings', 'miqpa_popup_triggers_section' );

		// Appearance fields.
		add_settings_field( 'miqpa_popup_section_popup_animation', __( 'Animation Effect', 'quick-popup-anything' ), 'miqpa_popup_section_popup_animation_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_popup_width', __( 'Max Width', 'quick-popup-anything' ), 'miqpa_popup_section_popup_width_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_popup_bg', __( 'Background Color', 'quick-popup-anything' ), 'miqpa_popup_section_popup_bg_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_popup_text_color', __( 'Text Color', 'quick-popup-anything' ), 'miqpa_popup_section_popup_text_color_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_overlay_color', __( 'Overlay Color', 'quick-popup-anything' ), 'miqpa_popup_section_overlay_color_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_overlay_opacity', __( 'Overlay Opacity', 'quick-popup-anything' ), 'miqpa_popup_section_overlay_opacity_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_popup_id', __( 'Custom ID', 'quick-popup-anything' ), 'miqpa_popup_section_popup_id_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
		add_settings_field( 'miqpa_popup_section_popup_class', __( 'Custom Class', 'quick-popup-anything' ), 'miqpa_popup_section_popup_class_cb', 'miqpa-popup-settings', 'miqpa_popup_appearance_section' );
	}
	add_action( 'admin_init', 'miqpa_popup_settings_init' );

	/* Callback functions */

	function miqpa_popup_section_popup_disable_cb() {
		$value = get_option( 'miqpa_popup_disable', '' );
		?>
		<label class="miqpa-toggle">
			<input type="checkbox" name="miqpa_popup_disable" value="1" <?php checked( '1', $value ); ?>>
			<span class="miqpa-toggle-slider"></span>
			<span class="miqpa-toggle-label"><?php esc_html_e( 'Completely disable the popup on the frontend.', 'quick-popup-anything' ); ?></span>
		</label>
		<?php
	}

	function miqpa_popup_section_popup_hide_on_mobile_cb() {
		$value = get_option( 'miqpa_popup_hide_on_mobile', '' );
		?>
		<label class="miqpa-toggle">
			<input type="checkbox" name="miqpa_popup_hide_on_mobile" value="1" <?php checked( '1', $value ); ?>>
			<span class="miqpa-toggle-slider"></span>
			<span class="miqpa-toggle-label"><?php esc_html_e( 'Hide the popup and button on screens smaller than 600px.', 'quick-popup-anything' ); ?></span>
		</label>
		<?php
	}

	function miqpa_popup_section_popup_display_only_once_cb() {
		$value = get_option( 'miqpa_popup_display_only_once', '' );
		?>
		<label class="miqpa-toggle">
			<input type="checkbox" name="miqpa_popup_display_only_once" value="1" <?php checked( '1', $value ); ?>>
			<span class="miqpa-toggle-slider"></span>
			<span class="miqpa-toggle-label"><?php esc_html_e( 'Auto-open popup once per visitor (uses localStorage). The button will be hidden.', 'quick-popup-anything' ); ?></span>
		</label>
		<?php
	}

	function miqpa_popup_section_popup_width_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_width', '600px' ) );
		?>
		<input type="text" name="miqpa_popup_width" value="<?php echo $value; ?>" class="regular-text" placeholder="600px">
		<p class="description"><?php esc_html_e( 'Maximum width of the popup. Accepts: px, %, em, rem, vw, vh. Example: 600px or 50%', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_popup_id_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_id', '' ) );
		?>
		<input type="text" name="miqpa_popup_id" value="<?php echo $value; ?>" class="regular-text">
		<p class="description"><?php esc_html_e( 'Optional. CSS ID attribute for the popup container.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_popup_class_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_class', '' ) );
		?>
		<input type="text" name="miqpa_popup_class" value="<?php echo $value; ?>" class="regular-text">
		<p class="description"><?php esc_html_e( 'Optional. CSS class for custom popup styling.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_popup_bg_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_bg', '#ffffff' ) );
		?>
		<input type="text" name="miqpa_popup_bg" value="<?php echo $value; ?>" data-default-color="#ffffff" class="miqpa-color-field">
		<?php
	}

	function miqpa_popup_section_popup_text_color_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_text_color', '#000000' ) );
		?>
		<input type="text" name="miqpa_popup_text_color" value="<?php echo $value; ?>" data-default-color="#000000" class="miqpa-color-field">
		<?php
	}

	/* Advanced feature callbacks (v2.1.0) */

	function miqpa_popup_section_auto_open_delay_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_auto_open_delay', '0' ) );
		?>
		<input type="number" name="miqpa_popup_auto_open_delay" value="<?php echo $value; ?>" class="small-text" min="0" max="300" step="1">
		<span class="miqpa-field-suffix"><?php esc_html_e( 'seconds', 'quick-popup-anything' ); ?></span>
		<p class="description"><?php esc_html_e( 'Automatically open the popup after this many seconds. Set to 0 to disable. Works great for welcome messages and announcements.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_exit_intent_cb() {
		$value = get_option( 'miqpa_popup_exit_intent', '' );
		?>
		<label class="miqpa-toggle">
			<input type="checkbox" name="miqpa_popup_exit_intent" value="1" <?php checked( '1', $value ); ?>>
			<span class="miqpa-toggle-slider"></span>
			<span class="miqpa-toggle-label"><?php esc_html_e( 'Show popup when the visitor is about to leave the page (mouse exits viewport on desktop).', 'quick-popup-anything' ); ?></span>
		</label>
		<?php
	}

	function miqpa_popup_section_scroll_trigger_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_scroll_trigger', '0' ) );
		?>
		<input type="number" name="miqpa_popup_scroll_trigger" value="<?php echo $value; ?>" class="small-text" min="0" max="100" step="5">
		<span class="miqpa-field-suffix">%</span>
		<p class="description"><?php esc_html_e( 'Show popup after the visitor scrolls past this percentage of the page. Set to 0 to disable. Example: 50 = halfway down the page.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_popup_animation_cb() {
		$value = get_option( 'miqpa_popup_animation', 'fade' );
		?>
		<select name="miqpa_popup_animation" class="miqpa-select">
			<option value="fade" <?php selected( $value, 'fade' ); ?>><?php esc_html_e( 'Fade', 'quick-popup-anything' ); ?></option>
			<option value="zoom" <?php selected( $value, 'zoom' ); ?>><?php esc_html_e( 'Zoom', 'quick-popup-anything' ); ?></option>
			<option value="slide-up" <?php selected( $value, 'slide-up' ); ?>><?php esc_html_e( 'Slide Up', 'quick-popup-anything' ); ?></option>
			<option value="slide-down" <?php selected( $value, 'slide-down' ); ?>><?php esc_html_e( 'Slide Down', 'quick-popup-anything' ); ?></option>
		</select>
		<p class="description"><?php esc_html_e( 'Choose the animation effect for the popup open and close transitions.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_overlay_color_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_overlay_color', '#000000' ) );
		?>
		<input type="text" name="miqpa_popup_overlay_color" value="<?php echo $value; ?>" data-default-color="#000000" class="miqpa-color-field">
		<p class="description"><?php esc_html_e( 'Color of the dimmed background overlay behind the popup.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_overlay_opacity_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_overlay_opacity', '80' ) );
		?>
		<div class="miqpa-range-wrap">
			<input type="range" name="miqpa_popup_overlay_opacity" value="<?php echo $value; ?>" class="miqpa-range" min="0" max="100" step="5">
			<span class="miqpa-range-value"><?php echo $value; ?>%</span>
		</div>
		<p class="description"><?php esc_html_e( 'Opacity of the background overlay. 0% = fully transparent, 100% = fully opaque.', 'quick-popup-anything' ); ?></p>
		<?php
	}

	function miqpa_popup_section_trigger_class_cb() {
		$value = esc_attr( get_option( 'miqpa_popup_trigger_class', '' ) );
		?>
		<input type="text" name="miqpa_popup_trigger_class" value="<?php echo $value; ?>" class="regular-text" placeholder="e.g. my-custom-trigger">
		<p class="description"><?php esc_html_e( 'Optional. Add a custom CSS class to trigger the popup on click. The default class miqpa-open-popup will always work.', 'quick-popup-anything' ); ?></p>
		<?php
	}

}