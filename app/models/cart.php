<?php
class Cart extends AppModel{
  var $useTable = false; 
  
  function update($data) {
    //TODO Optimize query
    for($i = 1; $i <= count($data); $i++){
      if($data[$i]['quantity'] > 0) {
        $product = ClassRegistry::init('Product')->find('first' , array(
        	'conditions' => array('Product.id' => $data[$i]['id'])
        ));
        $item = array('rowid' => md5($product['Product']['id']),
                      'id' => $product['Product']['id'], 
    									'quantity' => $data[$i]['quantity'],
    									'price' => $product['Product']['selling_price'],
    									'name' => $product['Product']['short_description'],
    									'subtotal' => $data[$i]['quantity'] * 
    									              $product['Product']['selling_price'],
    									'subtotal2' => $data[$i]['quantity'] * 
    									               $product['Product']['buying_price']);
    	$cart[$item['rowid']] = $item;
      }
		}
		return $cart;
  }
}
?>