<?php
/* Configuration Test cases generated on: 2010-08-01 00:08:22 : 1280597962*/
App::import('Model', 'Configuration');

class ConfigurationTestCase extends CakeTestCase {
	var $fixtures = array('app.configuration');

	function startTest() {
		$this->Configuration =& ClassRegistry::init('Configuration');
	}

	function endTest() {
		unset($this->Configuration);
		ClassRegistry::flush();
	}

}
?>