<?php
/* Product Fixture generated on: 
Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'Asia/Bangkok' for 'ICT/7.0/no DST' instead in /Users/somchok/Sites/cake/1.3.0-RC2/cake/console/templates/default/classes/fixture.ctp on line 24
2010-03-19 19:03:39 : 1269003339 */
class ProductFixture extends CakeTestFixture {
	var $name = 'Product';

	var $fields = array(
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

	var $records = array(
		array(
			'id' => 1,
			'short_description' => 'Lorem ipsum dolor sit amet',
			'long_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'buying_price' => 1,
			'selling_price' => 1,
			'quantity' => 'Lorem ipsum dolor sit amet',
			'stock' => 1,
			'image' => 'Lorem ipsum dolor sit amet',
			'display' => 1,
			'active' => 1
		),
	);
}
?>