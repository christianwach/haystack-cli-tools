<?php
/**
 * Miscellaneous useful command-line utilities.
 *
 * ## EXAMPLES
 *
 *       # Delete spam Jetpack Form Submissions on a specific site in a network.
 *       $ wp haystack spam delete --type=feedback --url=https://example.org
 *       Success: All spam feedback deleted.
 *
 *       # Delete spam Comments on a specific site in a network.
 *       $ wp haystack spam delete --type=comment --url=https://example.org
 *       Success: All spam comments deleted.
 *
 * @since 1.0.0
 *
 * @package Haystack_Command_Line_Tools
 */
class CLI_Tools_Haystack_Command extends CLI_Tools_Haystack_Command_Base {

	/**
	 * Adds our description and sub-commands.
	 *
	 * @since 1.0.0
	 *
	 * @param object $command The command.
	 * @return array $info The array of information about the command.
	 */
	private function command_to_array( $command ) {

		$info = [
			'name'        => $command->get_name(),
			'description' => $command->get_shortdesc(),
			'longdesc'    => $command->get_longdesc(),
		];

		foreach ( $command->get_subcommands() as $subcommand ) {
			$info['subcommands'][] = $this->command_to_array( $subcommand );
		}

		if ( empty( $info['subcommands'] ) ) {
			$info['synopsis'] = (string) $command->get_synopsis();
		}

		return $info;

	}

}
