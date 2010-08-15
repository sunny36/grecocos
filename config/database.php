<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'root',
		'database' => 'frames_grecocos',
	);
	
	var $test = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'root',
		'database' => 'grecocos_test',
	);
	
}
?>