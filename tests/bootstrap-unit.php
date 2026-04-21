<?php
// @generated seiler-phpunit-setup
/**
 * PHPUnit bootstrap for unit tests (WordPress NOT loaded).
 *
 * Loads autoloaders (root vendor/ + src/vendor/), optionally sources a legacy
 * tests/stubs.php if present, and initializes Brain Monkey if it's installed.
 * Tests stub WP functions via Brain\Monkey\Functions\when(), expectAction, etc.
 *
 * If you add brain/monkey to src/composer.json require-dev:
 *   composer require --dev brain/monkey mockery/mockery --working-dir src
 */

// Root vendor (dev deps like brain/monkey if installed at project root).
$rootAutoloader = dirname( __DIR__ ) . '/vendor/autoload.php';
if ( file_exists( $rootAutoloader ) ) {
	require_once $rootAutoloader;
}

// Plugin/theme runtime deps (and, by convention, brain/monkey if in src/composer.json require-dev).
$srcAutoloader = dirname( __DIR__ ) . '/src/vendor/autoload.php';
if ( file_exists( $srcAutoloader ) ) {
	require_once $srcAutoloader;
}

// Optional legacy stubs file — useful as a migration shim when lifting hand-rolled
// WP function fakes out of bootstrap.php before every test is converted to Brain Monkey.
$stubsFile = __DIR__ . '/stubs.php';
if ( file_exists( $stubsFile ) ) {
	require_once $stubsFile;
}

// Brain Monkey — initialize once per process. Per-test setUp/tearDown is still the
// preferred pattern (via a base TestCase), but a shutdown-function tearDown keeps
// the bootstrap self-contained.
if ( class_exists( \Brain\Monkey::class ) ) {
	\Brain\Monkey\setUp();
	register_shutdown_function( function () {
		\Brain\Monkey\tearDown();
	} );
}
