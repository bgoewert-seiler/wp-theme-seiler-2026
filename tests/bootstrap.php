<?php
// @generated seiler-phpunit-setup

require dirname( __DIR__ ) . '/vendor/seilerinstrument/wp-test-utils/src/Bootstrap/integration.php';

\Seiler\Test\Bootstrap\BootstrapBuilder::create()
	->onMupluginLoaded( function () {
		require dirname( __DIR__ ) . '/src/functions.php';
	} )
	->run();
