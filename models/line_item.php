<?php
class LineItem extends AppModel {
	var $name = 'LineItem';
	var $belongsTo = array('Product', 'Order');
	
}
?>