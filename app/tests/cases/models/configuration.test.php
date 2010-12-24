<?php
/* Configuration Test cases generated on: 2010-08-01 00:08:22 : 1280597962*/
App::import('Model', 'Configuration');

class ConfigurationTestCase extends CakeTestCase {
	var $fixtures = array('app.configuration');
  public $dropTables = false;
  
	function startTest() {
		$this->Configuration =& ClassRegistry::init('Configuration');
	}

  function testfindByKeyAndOrganization() {
    $this->Organization =& ClassRegistry::init('Organization');
    $this->Organization->recursive = -1;
    $organization = $this->Organization->findByDeliveryAddress('FAO RAP Bangkok');
    $isClosed = $this->Configuration->findByKeyAndOrganizationId('closed', $organization['Organization']['id']);
    $this->assertTrue(in_array($isClosed, array('yes', 'no')));
  }
  
  function testSetKey() {
    $this->Organization =& ClassRegistry::init('Organization');
    $this->Organization->recursive = -1;    
    $organization = $this->Organization->findByDeliveryAddress('FAO RAP Bangkok');
    $this->assertTrue(method_exists($this->Configuration, 'setKey'));
    $this->assertTrue($this->Configuration->setKey('closed', 'no', $organization['Organization']['id']));
    $isClosed = $this->Configuration->findByKeyAndOrganizationId('closed', $organization['Organization']['id']);
    $this->assertEqual($isClosed, 'no');
  }  
  
	function endTest() {
		unset($this->Configuration);
		ClassRegistry::flush();
	}

}
?>