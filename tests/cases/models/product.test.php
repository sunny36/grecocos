<?php

App::import('Model', 'Product');

class ProductTestCase extends CakeTestCase {
	var $fixtures = array('app.product');

	function startTest() {
		$this->Product =& ClassRegistry::init('Product');
	}

	function endTest() {
		unset($this->Product);
		ClassRegistry::flush();
	}

}
?>