<?php
/* Transaction Test cases generated on: 2010-05-27 09:05:22 : 1274926462*/
App::import('Model', 'Transaction');

class TransactionTestCase extends CakeTestCase {
	var $fixtures = array('app.transaction');

	function startTest() {
		$this->Transaction =& ClassRegistry::init('Transaction');
	}

	function endTest() {
		unset($this->Transaction);
		ClassRegistry::flush();
	}

}
?>