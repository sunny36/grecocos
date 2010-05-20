<?php

App::import('Controller', 'Orders');

class TestOrdersController extends OrdersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class OrdersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.order', 'app.user', 'app.line_item', 'app.product');

	function startTest() {
		$this->Orders =& new TestOrdersController();
		$this->Orders->constructClasses();
	}

	function endTest() {
		unset($this->Orders);
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

}
?>