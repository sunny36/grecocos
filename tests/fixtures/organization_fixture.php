<?php
/* Organization Fixture generated on: 2010-05-17 03:05:06 : 1274040066 */
class OrganizationFixture extends CakeTestFixture {
	var $name = 'Organization';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'delivery_address' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'delivery_address' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>