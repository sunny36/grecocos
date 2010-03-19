<?php 
/* SVN FILE: $Id$ */
/* Grecocos schema generated on: 2010-03-19 19:03:13 : 1269003433*/
class GrecocosSchema extends CakeSchema {
	var $name = 'Grecocos';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $products = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'short_description' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'long_description' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'buying_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'selling_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'quantity' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'stock' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'image' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'display' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
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
		'status' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
}
?>