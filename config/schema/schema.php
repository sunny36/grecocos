<?php 
/* SVN FILE: $Id$ */
/* Grecocos schema generated on: 2010-03-19 15:03:25 : 1268986945*/
class GrecocosSchema extends CakeSchema {
	var $name = 'Grecocos';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'middlename' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'address1' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'address2' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'address3' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'postalcode' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6),
		'phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 12),
		'status' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 3),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
}
?>