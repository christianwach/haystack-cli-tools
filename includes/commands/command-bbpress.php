<?php
/**
 * BBPress utilities.
 *
 * ## EXAMPLES
 *
 *       # Remove a role that BBPress added.
 *       $ wp haystack bbpress role-delete --name=bbp_keymaster
 *       Deleting role bbp_keymaster
 *       Success: Role deleted.
 *
 *       # Remove all roles that BBPress added.
 *       $ wp haystack bbpress role-delete
 *       Deleting role bbp_keymaster
 *       Deleting role bbp_spectator
 *       Deleting role bbp_blocked
 *       Deleting role bbp_moderator
 *       Deleting role bbp_participant
 *       Success: All roles deleted.
 *
 * @since 1.0.0
 *
 * @package Haystack_Command_Line_Tools
 */
class CLI_Tools_Haystack_Command_BBPress extends CLI_Tools_Haystack_Command {

	/**
	 * Delete the roles that BBPress added.
	 *
	 * ## OPTIONS
	 *
	 * [--name=<name>]
	 * : Specify the name of role to remove.
	 *
	 * [--all]
	 * : Run the command for all roles.
	 *
	 * ## EXAMPLES
	 *
	 *       # Remove a role that BBPress added.
	 *       $ wp haystack bbpress role-delete --name=bbp_keymaster
	 *       Deleting role bbp_keymaster
	 *       Success: Role deleted.
	 *
	 *       # Remove all roles that BBPress added.
	 *       $ wp haystack bbpress role-delete
	 *       Deleting role bbp_keymaster
	 *       Deleting role bbp_spectator
	 *       Deleting role bbp_blocked
	 *       Deleting role bbp_moderator
	 *       Deleting role bbp_participant
	 *       Success: All roles deleted.
	 *
	 * @subcommand role-delete
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The WP-CLI positional arguments.
	 * @param array $assoc_args The WP-CLI associative arguments.
	 */
	public function role_delete( $args, $assoc_args ) {

		// Grab associative arguments.
		$all  = (bool) \WP_CLI\Utils\get_flag_value( $assoc_args, 'all', false );
		$name = (string) \WP_CLI\Utils\get_flag_value( $assoc_args, 'name', '' );

		// Define BBPress Roles.
		$roles = [
			'bbp_keymaster',
			'bbp_spectator',
			'bbp_blocked',
			'bbp_moderator',
			'bbp_participant',
		];

		// Maybe process all Roles.
		if ( ! empty( $all ) ) {

			// Delete all Roles.
			foreach ( $roles as $role ) {
				WP_CLI::log( sprintf( WP_CLI::colorize( '%GDeleting role %Y%s%n' ), $role ) );
				$this->role_delete_from_users( $role );
				remove_role( $role );
			}

			WP_CLI::success( 'All roles deleted.' );

		} else {

			// Show feedback.
			WP_CLI::log( sprintf( WP_CLI::colorize( '%GDeleting role %Y%s%n' ), $name ) );

			// Bail if not a BBPress role.
			if ( empty( $name ) ) {
				WP_CLI::error( 'You must specify a role or use the "--all" argument.' );
			}

			// Bail if not a BBPress role.
			if ( ! in_array( $name, $roles, true ) ) {
				WP_CLI::error( sprintf( WP_CLI::colorize( 'Unknown role: %Y%s%n' ), $name ) );
			}

			// Remove from Users first.
			$this->role_delete_from_users( $name );

			// Now remove the Role.
			remove_role( $name );

			WP_CLI::success( 'Role deleted.' );

		}

	}

	/**
	 * Deletes a role for all WordPress Users.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of the Role.
	 */
	private function role_delete_from_users( $name = '' ) {

		// Build query to get all Users that have the role.
		$args = [
			'role' => $name,
		];

		// Get the Users.
		$users = get_users( $args );

		// Remove the role from any Users that have it.
		foreach ( $users as $user ) {
			$user->remove_role( $name );
		}

	}

}
