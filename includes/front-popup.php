<?php
/**
 * All Quick Popup Anything client-side popup rendering.
 *
 * @since   1.0.0
 * @since   2.0.0 Full security hardening, all output escaped, logic bug fixes.
 * @since   2.1.0 Added advanced triggers, animations, overlay, shortcode.
 * @package Quick_Popup_Anything/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the popup HTML in the footer.
 *
 * @since 1.0.0
 * @since 2.0.0 Escaped all output, fixed logic bugs, uses wp_add_inline_style.
 * @since 2.1.0 Added data attributes for JS triggers, overlay CSS, animation class.
 */
if ( ! function_exists( 'miqpa_add_code_in_footer' ) ) {

	function miqpa_add_code_in_footer() {
		// Early return if popup is disabled.
		$popup_disable = get_option( 'miqpa_popup_disable', '' );
		if ( '1' === $popup_disable ) {
			return;
		}

		// --- Gather all options (single call each) ---

		// Content.
		$raw_content = get_option( 'miqpa_editor_content', '' );
		$content     = ! empty( $raw_content )
			? apply_filters( 'the_content', $raw_content )
			: '<p>' . esc_html__( 'Thank you for using Quick Popup Anything.', 'quick-popup-anything' ) . '</p>';

		// Button.
		$btn_label       = get_option( 'miqpa_button_label', 'Quick Popup' );
		$btn_position    = get_option( 'miqpa_button_position', 'right' );
		$btn_id          = get_option( 'miqpa_button_id', '' );
		$btn_class       = get_option( 'miqpa_button_class', '' );
		$btn_bg          = get_option( 'miqpa_button_bg', '#3498db' );
		$btn_color       = get_option( 'miqpa_button_color', '#ffffff' );
		$btn_hover_bg    = get_option( 'miqpa_button_hover_bg', '#333333' );
		$btn_hover_color = get_option( 'miqpa_button_hover_color', '#ffffff' );
		$btn_zindex      = get_option( 'miqpa_button_zindex', '99' );

		// Popup.
		$popup_width              = get_option( 'miqpa_popup_width', '' );
		$popup_id                 = get_option( 'miqpa_popup_id', '' );
		$popup_class              = get_option( 'miqpa_popup_class', '' );
		$popup_bg                 = get_option( 'miqpa_popup_bg', '' );
		$popup_text_color         = get_option( 'miqpa_popup_text_color', '' );
		$popup_display_only_once  = get_option( 'miqpa_popup_display_only_once', '' );
		$popup_hide_on_mobile     = get_option( 'miqpa_popup_hide_on_mobile', '' );

		// Advanced features (v2.1.0).
		$auto_open_delay   = absint( get_option( 'miqpa_popup_auto_open_delay', '0' ) );
		$exit_intent       = get_option( 'miqpa_popup_exit_intent', '' );
		$scroll_trigger    = absint( get_option( 'miqpa_popup_scroll_trigger', '0' ) );
		$animation         = get_option( 'miqpa_popup_animation', 'fade' );
		$overlay_color     = get_option( 'miqpa_popup_overlay_color', '#000000' );
		$overlay_opacity   = absint( get_option( 'miqpa_popup_overlay_opacity', '80' ) );
		$trigger_class     = miqpa_sanitize_css_identifier( get_option( 'miqpa_popup_trigger_class', '' ) );

		// --- Sanitize values for output ---

		// Validate the button position against whitelist.
		$allowed_positions = array( 'left', 'right', 'bottom_left', 'bottom_right' );
		if ( ! in_array( $btn_position, $allowed_positions, true ) ) {
			$btn_position = 'right';
		}

		// Validate z-index is numeric.
		$btn_zindex = absint( $btn_zindex );
		if ( $btn_zindex < 1 ) {
			$btn_zindex = 99;
		}

		// Validate animation.
		$allowed_animations = array( 'fade', 'zoom', 'slide-up', 'slide-down' );
		if ( ! in_array( $animation, $allowed_animations, true ) ) {
			$animation = 'fade';
		}

		// Validate colors.
		$btn_bg          = miqpa_validate_color_output( $btn_bg, '#3498db' );
		$btn_color       = miqpa_validate_color_output( $btn_color, '#ffffff' );
		$btn_hover_bg    = miqpa_validate_color_output( $btn_hover_bg, '#333333' );
		$btn_hover_color = miqpa_validate_color_output( $btn_hover_color, '#ffffff' );
		$popup_bg_color  = miqpa_validate_color_output( $popup_bg, '' );
		$popup_txt_color = miqpa_validate_color_output( $popup_text_color, '' );
		$overlay_color   = miqpa_validate_color_output( $overlay_color, '#000000' );

		// Clamp overlay opacity.
		$overlay_opacity = min( 100, max( 0, $overlay_opacity ) );

		// Build popup inline styles.
		$popup_styles = array();
		if ( ! empty( $popup_width ) && preg_match( '/^\d+(\.\d+)?(px|%|em|rem|vw|vh)$/', $popup_width ) ) {
			$popup_styles[] = 'max-width:' . esc_attr( $popup_width );
		}
		if ( ! empty( $popup_bg_color ) ) {
			$popup_styles[] = 'background-color:' . esc_attr( $popup_bg_color );
		}
		if ( ! empty( $popup_txt_color ) ) {
			$popup_styles[] = 'color:' . esc_attr( $popup_txt_color );
		}
		$popup_style_attr = ! empty( $popup_styles ) ? ' style="' . esc_attr( implode( ';', $popup_styles ) ) . '"' : '';

		// Determine display mode.
		$is_display_once    = ( '1' === $popup_display_only_once );
		$is_hide_on_mobile  = ( '1' === $popup_hide_on_mobile );
		$is_exit_intent     = ( '1' === $exit_intent );

		// CSS classes for popup content div.
		$popup_content_classes = array( 'miqpa-white-popup', 'mfp-hide' );
		if ( $is_display_once ) {
			$popup_content_classes[] = 'popup_display_only_once';
		}
		if ( $is_hide_on_mobile ) {
			$popup_content_classes[] = 'popup_hide_on_mobile';
		}

		// --- Build dynamic CSS via wp_add_inline_style ---
		$dynamic_css = sprintf(
			'button.miqpa_popup_open_button{background-color:%1$s;color:%2$s;z-index:%3$d}' .
			'button.miqpa_popup_open_button:hover{background-color:%4$s;color:%5$s}' .
			'.miqpa-mfp-fade.mfp-close-btn-in .mfp-close{background-color:%1$s;color:%2$s}' .
			'.miqpa-mfp-fade.mfp-close-btn-in .mfp-close:hover{background-color:%4$s;color:%5$s}',
			esc_attr( $btn_bg ),
			esc_attr( $btn_color ),
			intval( $btn_zindex ),
			esc_attr( $btn_hover_bg ),
			esc_attr( $btn_hover_color )
		);

		// Overlay color and opacity CSS.
		$overlay_opacity_decimal = $overlay_opacity / 100;
		$dynamic_css .= sprintf(
			'.miqpa-mfp-fade.mfp-bg{background-color:%s}' .
			'.miqpa-mfp-fade.mfp-bg.mfp-ready{opacity:%s}',
			esc_attr( $overlay_color ),
			esc_attr( number_format( $overlay_opacity_decimal, 2 ) )
		);

		if ( $is_hide_on_mobile ) {
			$dynamic_css .= '@media screen and (max-width:600px){button.miqpa_popup_open_button{display:none!important}}';
		}

		wp_add_inline_style( 'miqpa-public-css', $dynamic_css );

		// --- Build data attributes for JS ---
		$data_attrs = array(
			'data-animation="' . esc_attr( $animation ) . '"',
		);
		if ( $auto_open_delay > 0 ) {
			$data_attrs[] = 'data-auto-open-delay="' . intval( $auto_open_delay ) . '"';
		}
		if ( $is_exit_intent ) {
			$data_attrs[] = 'data-exit-intent="1"';
		}
		if ( $scroll_trigger > 0 && $scroll_trigger <= 100 ) {
			$data_attrs[] = 'data-scroll-trigger="' . intval( $scroll_trigger ) . '"';
		}
		if ( ! empty( $trigger_class ) ) {
			$data_attrs[] = 'data-trigger-class="' . esc_attr( $trigger_class ) . '"';
		}

		// --- Render HTML ---
		echo '<div class="miqpa_popup_wrap" ' . implode( ' ', $data_attrs ) . '>';

		// Button (hidden when display-only-once is enabled).
		if ( ! $is_display_once ) {
			$btn_id_attr    = ! empty( $btn_id ) ? ' id="' . esc_attr( $btn_id ) . '"' : '';
			$btn_class_attr = 'miqpa_popup_open_button';
			if ( ! empty( $btn_class ) ) {
				$btn_class_attr .= ' ' . esc_attr( $btn_class );
			}

			printf(
				'<button%1$s data-btn-position="%2$s" class="%3$s"><span>%4$s</span></button>',
				$btn_id_attr,
				esc_attr( $btn_position ),
				esc_attr( $btn_class_attr ),
				esc_html( $btn_label )
			);
		}

		// Popup content.
		$popup_id_attr = ! empty( $popup_id ) ? ' id="' . esc_attr( $popup_id ) . '"' : '';

		printf(
			'<div id="miqpa_popup_content" class="%1$s"%2$s>',
			esc_attr( implode( ' ', $popup_content_classes ) ),
			$popup_style_attr
		);

		$popup_class_attr = 'wrap-miqpa';
		if ( ! empty( $popup_class ) ) {
			$popup_class_attr .= ' ' . esc_attr( $popup_class );
		}

		printf(
			'<div%1$s class="%2$s">%3$s</div>',
			$popup_id_attr,
			esc_attr( $popup_class_attr ),
			wp_kses_post( $content )
		);

		echo '</div>'; // #miqpa_popup_content
		echo '</div>'; // .miqpa_popup_wrap
	}
	add_action( 'wp_footer', 'miqpa_add_code_in_footer' );

}

/**
 * Validate a color value for safe CSS output.
 *
 * @since 2.0.0
 * @param string $color   The color value to validate.
 * @param string $default Fallback color if validation fails.
 * @return string Valid hex color or the default.
 */
function miqpa_validate_color_output( $color, $default = '' ) {
	if ( ! empty( $color ) && preg_match( '/^#([A-Fa-f0-9]{3}){1,2}$/', $color ) ) {
		return $color;
	}
	return $default;
}

/*
|--------------------------------------------------------------------------
| Shortcode: [quick_popup_button]
|--------------------------------------------------------------------------
*/

/**
 * Shortcode to render a popup trigger button anywhere in content.
 *
 * Usage: [quick_popup_button label="Click Me" class="my-btn" id="my-id"]
 *
 * @since 2.1.0
 * @param array $atts Shortcode attributes.
 * @return string Button HTML.
 */
if ( ! function_exists( 'miqpa_shortcode_popup_button' ) ) {

	function miqpa_shortcode_popup_button( $atts ) {
		// Don't render if popup is disabled.
		if ( '1' === get_option( 'miqpa_popup_disable', '' ) ) {
			return '';
		}

		$atts = shortcode_atts( array(
			'label' => get_option( 'miqpa_button_label', 'Quick Popup' ),
			'class' => '',
			'id'    => '',
		), $atts, 'quick_popup_button' );

		// Sanitize.
		$label = esc_html( sanitize_text_field( $atts['label'] ) );
		$class = 'miqpa-open-popup miqpa-shortcode-btn';
		if ( ! empty( $atts['class'] ) ) {
			$class .= ' ' . esc_attr( preg_replace( '/[^a-zA-Z0-9_\- ]/', '', $atts['class'] ) );
		}
		$id_attr = '';
		if ( ! empty( $atts['id'] ) ) {
			$id_attr = ' id="' . esc_attr( preg_replace( '/[^a-zA-Z0-9_\-]/', '', $atts['id'] ) ) . '"';
		}

		return sprintf(
			'<button%1$s class="%2$s" type="button">%3$s</button>',
			$id_attr,
			esc_attr( $class ),
			$label
		);
	}
	add_shortcode( 'quick_popup_button', 'miqpa_shortcode_popup_button' );

}