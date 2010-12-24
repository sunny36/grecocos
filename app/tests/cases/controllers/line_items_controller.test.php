<?php
/* LineItems Test cases generated on: 2010-08-03 04:08:34 : 1280783974*/
App::import('Controller', 'LineItems');

class TestLineItemsController extends LineItemsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class LineItemsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.line_item', 'app.product', 'app.category', 'app.order', 'app.user', 'app.organization', 'app.delivery', 'app.configuration');

	function startTest() {
		$this->LineItems =& new TestLineItemsController();
		$this->LineItems->constructClasses();
	}

	function endTest() {
		unset($this->LineItems);
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