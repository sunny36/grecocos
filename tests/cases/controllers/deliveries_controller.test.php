<?php

App::import('Controller', 'Deliveries');

class TestDeliveriesController extends DeliveriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DeliveriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.delivery');

	function startTest() {
		$this->Deliveries =& new TestDeliveriesController();
		$this->Deliveries->constructClasses();
	}

	function endTest() {
		unset($this->Deliveries);
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

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>