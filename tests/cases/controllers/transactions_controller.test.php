<?php
/* Transactions Test cases generated on: 2010-05-27 10:05:01 : 1274929381*/
App::import('Controller', 'Transactions');

class TestTransactionsController extends TransactionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TransactionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.transaction');

	function startTest() {
		$this->Transactions =& new TestTransactionsController();
		$this->Transactions->constructClasses();
	}

	function endTest() {
		unset($this->Transactions);
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

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>