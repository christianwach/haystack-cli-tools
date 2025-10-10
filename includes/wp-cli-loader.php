<?php
/**
 * WP-CLI tools for the Spirit of Football website.
 *
 * @package Haystack_Command_Line_Tools
 */

// Bail if WP-CLI is not present.
if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Sets up WP-CLI commands for this plugin.
 *
 * @since 1.0.0
 */
function haystack_cli_bootstrap() {

	// Include files.
	require_once __DIR__ . '/commands/command-base.php';
	require_once __DIR__ . '/commands/command-haystack.php';
	require_once __DIR__ . '/commands/command-spam.php';
	require_once __DIR__ . '/commands/command-bbpress.php';

	// Add commands.
	WP_CLI::add_command( 'haystack', 'CLI_Tools_Haystack_Command' );
	WP_CLI::add_command( 'haystack spam', 'CLI_Tools_Haystack_Command_Spam' );
	WP_CLI::add_command( 'haystack bbpress', 'CLI_Tools_Haystack_Command_BBPress' );

}

// Set up commands.
WP_CLI::add_hook( 'before_wp_load', 'haystack_cli_bootstrap' );
