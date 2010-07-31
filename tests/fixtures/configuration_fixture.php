<?php
/* Configuration Fixture generated on: 2010-08-01 00:08:22 : 1280597962 */
class ConfigurationFixture extends CakeTestFixture {
	var $name = 'Configuration';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'value' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'key' => 'Lorem ipsum dolor sit amet',
			'value' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>