<?php
/* Configurations Test cases generated on: 2010-08-01 01:08:31 : 1280599651*/
App::import('Controller', 'Configurations');

class TestConfigurationsController extends ConfigurationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ConfigurationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.configuration');

	function startTest() {
		$this->Configurations =& new TestConfigurationsController();
		$this->Configurations->constructClasses();
	}

	function endTest() {
		unset($this->Configurations);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testCoordinatorIndex() {

	}

	function testCoordinatorView() {

	}

	function testCoordinatorAdd() {

	}

	function testCoordinatorEdit() {

	}

	function testCoordinatorDelete() {

	}

}
?>