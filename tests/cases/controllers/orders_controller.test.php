<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Asia/Bangkok' for 'ICT/7.0/no DST' instead in /Users/somchok/Sites/cake/1.3.0-RC2/cake/console/templates/default/classes/test.ctp on line 22
/* Orders Test cases generated on: 2010-03-26 02:03:31 : 1269544471*/
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