<?php
/**
 * Source file was changed on the Fri Nov 24 13:30:07 2023 +0100
 */

defined( 'ABSPATH' ) || exit;

/**
 * Indicate to bypass rocket optimizations.
 *
 * Checks for "noclsop" query string in the url to bypass rocket processes.
 *
 * @since 3.7
 *
 * @return bool True to indicate should bypass; false otherwise.
 */
function rocket_bypass() {
	static $bypass = null;

	if ( rocket_get_constant( 'WP_ROCKET_IS_TESTING', false ) ) {
		$bypass = null;
	}

	if ( ! is_null( $bypass ) ) {
		return $bypass;
	}

	$bypass = isset( $_GET['noclsop'] ) && 0 !== $_GET['noclsop']; // phpcs:ignore WordPress.Security.NonceVerification

	return $bypass;
}
