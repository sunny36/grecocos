<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Asia/Bangkok' for 'ICT/7.0/no DST' instead in /Users/somchok/Sites/cake/1.3.0-RC2/cake/console/templates/default/classes/test.ctp on line 22
/* Deliveries Test cases generated on: 2010-03-27 02:03:26 : 1269633146*/
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