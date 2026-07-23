<?php
/**
 * Plugin Name:       Quick Popup Anything
 * Plugin URI:        https://wordpress.org/plugins/quick-popup-anything/
 * Description:       Lightweight popup & modal plugin with exit intent, auto-open delay, scroll trigger, animations, and shortcode support. No coding needed.
 * Version:           2.0.0
 * Author:            Monster Infotech
 * Author URI:        https://monsterinfotech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quick-popup-anything
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Tested up to:      6.7
 * Requires PHP:      7.4
 *
 * @since             1.0.0
 * @author            Parth Solanki
 * @package           Quick_Popup_Anything
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 2.0.0
 * Define plugin version.
 */
define( 'MIQPA_VERSION', '2.0.0' );

/**
 * @since 1.0.0
 * Define plugin main file path (used for activation hooks, etc.).
 */
define( 'MIQPA_PLUGIN_FILE_URL', __FILE__ );

/**
 * @since 2.0.0
 * Define plugin directory URL (for enqueuing assets).
 */
define( 'MIQPA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * @since 1.0.0
 * @deprecated 2.0.0 Use MIQPA_PLUGIN_URL instead.
 * Kept for backward compatibility.
 */
define( 'MIQPA_PLUGIN_DIR', MIQPA_PLUGIN_URL );

/**
 * @since 2.0.0
 * Define plugin directory filesystem path.
 */
define( 'MIQPA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * @since 2.0.0
 * Define plugin basename (for settings links, etc.).
 */
define( 'MIQPA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * @since 1.0.0
 * Register enqueue scripts.
 */
require_once MIQPA_PLUGIN_PATH . 'includes/load-scripts.php';

/**
 * @since 1.0.0
 * Register admin menu.
 */
require_once MIQPA_PLUGIN_PATH . 'includes/admin-menu.php';

/**
 * @since 1.0.0
 * Include Quick Popup Anything settings.
 */
require_once MIQPA_PLUGIN_PATH . 'includes/admin-settings.php';

/**
 * @since 1.0.0
 * Include MIQPA client side.
 */
require_once MIQPA_PLUGIN_PATH . 'includes/front-popup.php';

/**
 * @since 1.0.0
 * Plugin activation.
 */
require_once MIQPA_PLUGIN_PATH . 'includes/set-options.php';
