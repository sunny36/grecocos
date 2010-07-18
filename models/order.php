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
	
	function updateOrderStatus($id, $status) {
	  $this->recursive = 2;
    $order = $this->findById($id);
    if($status == 'Yes') {
      //Update status to packed
      $order['Order']['status'] = 'packed';
      //Update total for each line item as well as the order total 
      $total_supplied = 0; 
      foreach($order['LineItem'] as &$line_item) {
        $line_item['total_price_supplied'] = $line_item['quantity_supplied'] * $line_item['Product']['selling_price'];
        $line_item['total_price_supplied2'] = $line_item['quantity_supplied'] * $line_item['Product']['buying_price'];
        $total_supplied += $line_item['total_price_supplied'];
        $total2_supplied += $line_item['total_price_supplied2'];
      }
      $order['Order']['total_supplied'] = $total_supplied;
      $order['Order']['total2_supplied'] = $total2_supplied;
      $this->log($order, 'activity');   
      $this->save($order);
    }
    if($status == 'No') {
      $order['Order']['status'] = 'paid';
      $this->save($order);
    }
	}
	
	function updateTotalSupplied($id) {
	  $this->recursive = 2;
	  $order = $this->findById($id);
	  $total_supplied = 0; 
    foreach($order['LineItem'] as &$line_item) {
      $total_supplied += $line_item['total_price_supplied'];
    }
    $order['Order']['total_supplied'] = $total_supplied;
    $this->save($order);
	}
}
?>
