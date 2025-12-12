<?php
/**
 * Plugin Name:       WPKO - Where's My Menu?
 * Plugin URI:        https://wpknockout.com/plugins/wpko-wheres-my-menu/
 * Description:       Restores the classic "Appearance > Menus" link for Full Site Editing themes and generates shortcodes for every menu.
 * Version:           1.0.0
 * Requires PHP:      8.4
 * Requires at least: 6.3
 * Author:            WP Knockout
 * Author URI:        https://wpknockout.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpko-wmm
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class for WPKO - Where's My Menu?
 * Follows a secure, modern singleton pattern.
 */
final class WPKO_WMM_Plugin {

	/**
	 * The single instance of the class.
	 *
	 * @var WPKO_WMM_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Singleton instance creation.
	 *
	 * @return WPKO_WMM_Plugin
	 */
	public static function instance(): self {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->define_constants();
		$this->includes();
		$this->hooks();
	}

	/**
	 * Define constants used throughout the plugin.
	 */
	private function define_constants(): void {
		if ( ! defined( 'WPKO_WMM_VERSION' ) ) {
			define( 'WPKO_WMM_VERSION', '1.0.0' );
		}

		if ( ! defined( 'WPKO_WMM_PLUGIN_FILE' ) ) {
			define( 'WPKO_WMM_PLUGIN_FILE', __FILE__ );
		}

		if ( ! defined( 'WPKO_WMM_PLUGIN_DIR' ) ) {
			define( 'WPKO_WMM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
	}

	/**
	 * Include necessary files.
	 */
	private function includes(): void {
		require_once WPKO_WMM_PLUGIN_DIR . 'includes/class-wpko-wmm-menu-shortcodes.php';
		require_once WPKO_WMM_PLUGIN_DIR . 'includes/class-wpko-wmm-admin.php';
	}

	/**
	 * Setup WordPress hooks.
	 */
	private function hooks(): void {
		// Core functionality.
		new WPKO_WMM_Menu_Shortcodes();

		// Admin functionality.
		new WPKO_WMM_Admin();
	}
}

// Initialize the plugin.
add_action(
	'plugins_loaded',
	static function () {
		WPKO_WMM_Plugin::instance();
	}
);
