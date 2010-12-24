<?php
/* Organization Test cases generated on: 2010-05-17 03:05:06 : 1274040066*/
App::import('Model', 'Organization');

class OrganizationTestCase extends CakeTestCase {
	var $fixtures = array('app.organization');

	function startTest() {
		$this->Organization =& ClassRegistry::init('Organization');
	}

	function endTest() {
		unset($this->Organization);
		ClassRegistry::flush();
	}

}
?>