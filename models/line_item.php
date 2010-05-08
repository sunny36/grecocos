<?php
class LineItem extends AppModel {
	var $name = 'LineItem';
	var $belongsTo = array('Product', 'Order');

	function getProductsByOrderId($id, $offset = null, $limit = null) {
    $params = array('conditions' => array('LineItem.order_id' => $id)); 
    if($offset) $params['offset'] = $offset;
    if($limit) $params['limit'] = $limit;
    $products = $this->find('all',$params);
	  return $products;
	}
	
	function updateQuantitySupplied($order_id, $product_id, $quantity_supplied) {
     $lineItems = $this->getProductsByOrderId($order_id);
     foreach($lineItems as $lineItem) {
       if($lineItem['LineItem']['product_id'] == $product_id) {
        $lineItem['LineItem']['quantity_supplied'] = $quantity_supplied;
        $this->save($lineItem);
      }
    }  
	}
	
}
?>