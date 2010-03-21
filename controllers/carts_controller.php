<?php
class CartsController extends AppController{
  var $uses = array('Product', 'Order');
  
  
  function index(){
    $this->layout = 'cart'; 
    $products = $this->Product->find('all');
    $this->set('products', $products);
  }
  
  function add() {
    $id = $this->data['Product']['id'];
    $quantity = $this->data['Product']['quantity'];
    //TODO validate that the product exists 
		if ($quantity < 1) {
			$this->redirect(array('controller' => 'carts', 'action' => 'index'));
		}

    $product = $this->Product->find('first' , array(
    	'conditions' => array('Product.id' => $id)
    ));
		$item = array('rowid' => md5($product['Product']['id']), 
									'id' => $product['Product']['id'], 
									'quantity' => $quantity,
									'price' => $product['Product']['price'],
									'name' => $product['Product']['name'],
									'subtotal' => $quantity * $product['Product']['price']);

		if($this->Session->check('cart')) {
			$cart = $this->Session->read('cart');			
			foreach ($cart as $cartItem) {
				if($cartItem['id'] == $product['Product']['id']){
					unset($cart[$cartItem['rowid']]);	
				}
			}
			
			$cart[$item['rowid']] = $item;
		}
		else {
			$cart[$item['rowid']] = $item;
		}
			
    $this->Session->write('cart', $cart);
		$this->Session->write('cart_total', $this->getCartTotalPrice());
		$this->redirect(array('controller' => 'carts', 'action' => 'index'));
  }
	
	function getCartTotalPrice(){
		$total = 0; 
		$cart = $this->Session->read('cart');			
		foreach ($cart as $cartItem) {
			$total += $cartItem['subtotal'];
		}
		return $total; 
	}
	
	function update() {
		$cart = $this->Session->read('cart');
		for($i = 1; $i <= count($this->data); $i++){
			$item = $this->Session->read('cart.'. $this->data[$i]['rowid']);
			if($this->data[$i]['quantity'] == 0) {
				$rowid = $this->data[$i]['rowid'];
				unset($cart[$rowid]);
			} 
			else {
				$item['quantity'] = $this->data[$i]['quantity'];
				$item['subtotal'] = $this->data[$i]['quantity'] * $item['price'];
				$cart[$this->data[$i]['rowid']] = $item;
			}
			$this->Session->write('cart', $cart);
		}
		
		if(count($this->Session->read('cart')) == 0){
			$this->Session->delete('cart_total');
			$this->Session->delete('cart');
		}
		else {
			$this->Session->write('cart_total', $this->getCartTotalPrice());
		}
		
		$this->redirect(array('controller' => 'carts', 'action' => 'index'));
	}
	
	function empty_cart() {
	  $this->Session->delete('cart');
		$this->Session->delete('cart_total');
		$this->redirect(array('controller' => 'carts', 'action' => 'index'));
	}
	
	function confirm() {
		$order = array('Order' => array('status' => 'unpaid', 'ordered_date' => date('Y-m-d H:i:s')));
		$this->Order->save($order);
		debug($order);
	}
}