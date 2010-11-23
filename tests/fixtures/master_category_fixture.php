<?php
/* MasterCategory Fixture generated on: 2010-11-16 00:11:28 : 1289840788 */
class MasterCategoryFixture extends CakeTestFixture {
	var $name = 'MasterCategory';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'priority' => 1
		),
	);
}
?>