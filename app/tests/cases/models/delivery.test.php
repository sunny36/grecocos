<?php

App::import('Model', 'Delivery');

class DeliveryTestCase extends CakeTestCase {
	var $fixtures = array('app.delivery');

	function startTest() {
		$this->Delivery =& ClassRegistry::init('Delivery');
	}

  function testChangeNextDelivery() {
    $delivery = $this->Delivery->findByNextDelivery(true);
    debug($delivery);
    //$this->assertEqual(true, $delivery['Delivery']['next_delivery']);
  }

	function endTest() {
		unset($this->Delivery);
		ClassRegistry::flush();
	}

}
?>
