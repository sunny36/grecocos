<?php

App::import('Model', 'Order');

class OrderTestCase extends CakeTestCase {
	var $fixtures = array('app.order');

	function startTest() {
		$this->Order =& ClassRegistry::init('Order');
	}

  function testFindAllByStatusAndDeliveryIdAndUserOrganizationId() {
    $orders = $this->Order->findAllByStatusAndDeliveryIdAndUserOrganizationId('delivered', 7, 1);
    $this->assertEqual(count($orders), 9); 
  }

	function endTest() {
		unset($this->Order);
		ClassRegistry::flush();
  }


}
?>
