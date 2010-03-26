<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Asia/Bangkok' for 'ICT/7.0/no DST' instead in /Users/somchok/Sites/cake/1.3.0-RC2/cake/console/templates/default/classes/test.ctp on line 22
/* Delivery Test cases generated on: 2010-03-27 02:03:56 : 1269633116*/
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