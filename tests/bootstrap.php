<?php
// @generated seiler-phpunit-setup
/**
 * PHPUnit bootstrap for WordPress integration tests.
 *
 * Requires the WordPress test library to be installed. Typical setups:
 *   - wp-env:  WP_TESTS_DIR is pre-wired inside the container
 *   - ddev:    set WP_TESTS_DIR to /var/www/html/wp-content/plugins/wordpress-tests-lib
 *   - local:   run bin/install-wp-tests.sh, or point WP_TESTS_DIR at your checkout
 */

$tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $tests_dir ) {
	$tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $tests_dir . '/includes/functions.php' ) ) {
	fwrite(
		STDERR,
		"Could not find the WordPress test library at {$tests_dir}\n" .
		"Set WP_TESTS_DIR to the location of wordpress-tests-lib.\n"
	);
	exit( 1 );
}

require_once $tests_dir . '/includes/functions.php';

tests_add_filter( 'muplugins_loaded', function () {
	require dirname( __DIR__ ) . '/src/style.css';
} );

require $tests_dir . '/includes/bootstrap.php';
