<?php
class Order extends AppModel {
	var $name = 'Order';
	var $hasMany = 'LineItem';
	var $belongsTo = 'User';
}
?>