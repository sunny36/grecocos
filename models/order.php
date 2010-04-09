<?php
class Order extends AppModel {
	var $name = 'Order';
	var $hasMany = 'LineItem';
	var $belongsTo = array('User', 'Delivery');
	
	function getProducts($id){
	  $query = "SELECT * FROM line_items LineItem, products Product " .
	           "WHERE LineItem.order_id = ". $id . " " .
	           "AND LineItem.product_id = Product.id;";
	  $products = $this->query($query);
	  return $products;
	}
	
	function getProductsByOrderId($id, $offset = null, $limit = null) {
    $params = array('conditions' => array('LineItem.order_id' => $id)); 
    if($offset) $params['offset'] = $offset;
    if($limit) $params['limit'] = $limit;
    $products = ClassRegistry::init('LineItem')->find('all',$params);
	  return $products;
	}
}
?>
