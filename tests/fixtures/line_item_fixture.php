<?php
/* LineItem Fixture generated on: 
Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Asia/Bangkok' for 'ICT/7.0/no DST' instead in /Users/somchok/Sites/cake/1.3.0-RC2/cake/console/templates/default/classes/fixture.ctp on line 24
2010-03-22 03:03:29 : 1269204089 */
class LineItemFixture extends CakeTestFixture {
	var $name = 'LineItem';

	var $fields = array(
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'total_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => 10),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'product_id' => 1,
			'order_id' => 1,
			'quantity' => 1,
			'total_price' => 1,
			'id' => 1
		),
	);
}
?>