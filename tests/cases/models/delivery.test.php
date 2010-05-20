<?php

App::import('Model', 'Delivery');

class DeliveryTestCase extends CakeTestCase {
	var $fixtures = array('app.delivery');

	function startTest() {
		$this->Delivery =& ClassRegistry::init('Delivery');
	}

	function endTest() {
		unset($this->Delivery);
		ClassRegistry::flush();
	}

}
?>