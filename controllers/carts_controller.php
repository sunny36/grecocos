<?php
class CartsController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem', 'Delivery', 'Category', 
    'Cart', 'Transaction');
  var $components = array('Email');
  var $helpers = array('Html', 'Form', 'Javascript');

  function beforeFilter(){
    parent::beforeFilter();
  }

  function index(){
    $this->layout = 'cart'; 
    $this->Category->Behaviors->attach('Containable'); 
    $products = $this->Category->find('all', array(
      'contain' => array('Product' => array(
        'conditions' => array('AND' => array(
          'Product.display = ' => '1', 
          'Product.stock > ' => '0'))))));
    $this->set('products', $products);
  }

  function getCartTotalPrice(){
    $total = 0; 
    $total2 = 0; 
    $cart = $this->Session->read('cart');			
    foreach ($cart as $cartItem) {
      $total += $cartItem['subtotal'];
      $total2 += $cartItem['subtotal2'];
    }
    return array($total, $total2); 
  }

  function confirm() {
    $cart = $this->Cart->update($this->data);
    if($cart){
      $this->Session->write('cart', $cart);
      list($cart_total, $cart_total2) = $this->getCartTotalPrice();
      $this->Session->write('cart_total', $cart_total);
      $this->Session->write('cart_total2', $cart_total2);
    }		
    
    if(!$this->Session->check('cart')){
      $this->Session->setFlash('Your cart is currently empty.!!');
      $this->redirect(array('controller' => 'carts', 'action' => 'index'));
    }
    $cart = $this->Session->read('cart');
    foreach ($cart as $cartItem) {
      $conditions['id'][] = $cartItem['id'];
    }
    $products = $this->Product->find('all',
      array('conditions' => $conditions, 
      'recursive' => -1));
    foreach ($cart as $cartItem) {
      foreach($products as $product){
        if($cartItem['id'] == $product['Product']['id']){
          $cartItem['name'] = $product['Product']['short_description'];
        }
      }
    }
    $total = $this->Session->read('cart_total');
    $total2 = $this->Session->read('cart_total2');
    $delivery = $this->Delivery->find('first', 
      array('conditions' => array('Delivery.next_delivery' => true)));
    $order = array('Order' => array('status' => 'entered', 
      'ordered_date' => date('Y-m-d H:i:s'), 
      'complete' => false,
      'user_id' => $this->currentUser['User']['id'],
      'delivery_id' => $delivery['Delivery']['id'],
      'total' => $total,
      'total2' => $total2,
      'total_supplied' => $total));
    $this->Order->create();
    $this->Order->save($order);
    $orderId = $this->Order->id;

    $cart = $this->Session->read('cart');			
    foreach($cart as $cartItem){
      $lineItems['Order'][] = array('product_id' => $cartItem['id'], 
        'order_id' => $orderId, 
        'quantity' => $cartItem['quantity'],
        'total_price' =>  $cartItem['subtotal'],
        'quantity_supplied' => $cartItem['quantity'],
        'total_price_supplied' => $cartItem['subtotal']);
    }
    $this->LineItem->saveAll($lineItems['Order']);
    $transaction = array('Transaction' => array(
      'type' => 'Order', 
      'user_id' => $this->currentUser['User']['id'], 
      'order_id' => $orderId,
      'delivery_id' => $delivery['Delivery']['id'])); 
    $this->Transaction->create(); 
    $this->Transaction->save($transaction); 
    
    $deliveryDate = $this->Delivery->find('first', array(
      'conditions' => array('Delivery.next_delivery' => 1)));
    $this->Session->write('deliveryDate', $deliveryDate);
    $this->Session->write('orderId', $orderId);
    $this->redirect(array('controller' => 'carts', 'action' => 'checkout'));
  }

  function checkout(){
    $this->layout = 'cart';
  }
  
  function getInvoice() {
    $this ->layout = "fpdf";
    $this->set('cart', $this->Session->read('cart'));
    $this->set('deliveryDate', $this->Session->read('deliveryDate'));
    $this->set('orderId', $this->Session->read('orderId'));
    $User = ClassRegistry::init('User');
    $user = $User->getUser($this->currentUser['User']['id']);
    $this->set('currentUser', $user);
    $this->set('total', $this->Session->read('cart_total'));    
    
    $this->Session->delete('cart');
    $this->Session->delete('deliveryDate');
    $this->Session->delete('currentUser');
    $this->Session->delete('orderId');
    $this->Session->delete('cart_total');
    $this->render('/elements/invoice_pdf');
  }
  
}
