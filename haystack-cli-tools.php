<?php
/**
 * Haystack Command Line Tools
 *
 * Plugin Name:       Haystack Command Line Tools
 * Description:       Miscellaneous useful command line utilities.
 * Version:           1.0.0
 * Plugin URI:        https://github.com/christianwach/haystack-cli-tools
 * GitHub Plugin URI: https://github.com/christianwach/haystack-cli-tools
 * Author:            Christian Wach
 * Author URI:        https://haystack.co.uk
 * Requires at least: 5.7
 * Requires PHP:      7.4
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @package Haystack_Command_Line_Tools
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set our version here.
define( 'HAYSTACK_CLI_TOOLS_VERSION', '1.0.0' );

// Store reference to this file.
if ( ! defined( 'HAYSTACK_CLI_TOOLS_FILE' ) ) {
	define( 'HAYSTACK_CLI_TOOLS_FILE', __FILE__ );
}

// Store URL to this plugin's directory.
if ( ! defined( 'HAYSTACK_CLI_TOOLS_URL' ) ) {
	define( 'HAYSTACK_CLI_TOOLS_URL', plugin_dir_url( HAYSTACK_CLI_TOOLS_FILE ) );
}

// Store PATH to this plugin's directory.
if ( ! defined( 'HAYSTACK_CLI_TOOLS_PATH' ) ) {
	define( 'HAYSTACK_CLI_TOOLS_PATH', plugin_dir_path( HAYSTACK_CLI_TOOLS_FILE ) );
}

/**
 * Command Line Tools for SOF Class.
 *
 * A class that encapsulates plugin functionality.
 *
 * @since 1.0.0
 */
class Haystack_Command_Line_Tools {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Load wp-cli tools.
		$this->include_files();

	}

	/**
	 * Loads the wp-cli tools.
	 *
	 * @since 1.0.0
	 */
	public function include_files() {

		// Bail if not wp-cli context.
		if ( ! defined( 'WP_CLI' ) ) {
			return;
		}

		// Bail if not PHP 5.6+.
		if ( ! version_compare( phpversion(), '5.6.0', '>=' ) ) {
			return;
		}

		// Load our wp-cli tools.
		require HAYSTACK_CLI_TOOLS_PATH . 'includes/wp-cli-loader.php';

	}

}

/**
 * Bootstrap plugin if not yet loaded and returns reference.
 *
 * @since 1.0.0
 *
 * @return Haystack_Command_Line_Tools $plugin The plugin reference.
 */
function haystack_command_line_tools() {

	// Maybe bootstrap plugin.
	static $plugin;
	if ( ! isset( $plugin ) ) {
		$plugin = new Haystack_Command_Line_Tools();
	}

	// Return reference.
	return $plugin;

}

// Bootstrap immediately.
haystack_command_line_tools();
