<?php
/* MasterCategory Test cases generated on: 2010-11-16 00:11:28 : 1289840788*/
App::import('Model', 'MasterCategory');

class MasterCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.master_category');

	function startTest() {
		$this->MasterCategory =& ClassRegistry::init('MasterCategory');
	}

	function endTest() {
		unset($this->MasterCategory);
		ClassRegistry::flush();
	}

}
?>