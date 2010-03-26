<?php
class Order extends AppModel {
	var $name = 'Order';
	var $hasMany = 'LineItem';
	var $belongsTo = 'User';
	
	function getProducts($id){
	  $query = "SELECT * FROM line_items LineItem, products Product " .
	           "WHERE LineItem.order_id = ". $id . " " .
	           "AND LineItem.product_id = Product.id;";
	  $products = $this->query($query);
	  return $products;
	}
}
?>