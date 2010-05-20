<?php

App::import('Model', 'Order');

class OrderTestCase extends CakeTestCase {
	var $fixtures = array('app.order');

	function startTest() {
		$this->Order =& ClassRegistry::init('Order');
	}

	function endTest() {
		unset($this->Order);
		ClassRegistry::flush();
	}

}
?>