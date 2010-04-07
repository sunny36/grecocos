<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'date';
	var $hasMany = 'Order';
}
?>