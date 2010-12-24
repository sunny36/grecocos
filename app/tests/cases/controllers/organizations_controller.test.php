<?php
/* Organizations Test cases generated on: 2010-12-11 02:12:34 : 1292007694*/
App::import('Controller', 'Organizations');

class TestOrganizationsController extends OrganizationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class OrganizationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.organization', 'app.user', 'app.order', 'app.delivery', 'app.line_item', 'app.product', 'app.category', 'app.master_category', 'app.configuration');

	function startTest() {
		$this->Organizations =& new TestOrganizationsController();
		$this->Organizations->constructClasses();
	}

	function endTest() {
		unset($this->Organizations);
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