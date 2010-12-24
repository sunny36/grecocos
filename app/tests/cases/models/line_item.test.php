<?php

App::import('Model', 'LineItem');

class LineItemTestCase extends CakeTestCase {
	var $fixtures = array('app.line_item');

	function startTest() {
		$this->LineItem =& ClassRegistry::init('LineItem');
	}

	function endTest() {
		unset($this->LineItem);
		ClassRegistry::flush();
	}

}
?>