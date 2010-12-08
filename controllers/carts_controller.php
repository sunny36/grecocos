<?php
class CartsController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem', 'Delivery', 'Category', 
              'Cart', 'Transaction');
  var $components = array('Email');
  var $helpers = array('Html', 'Form', 'Javascript', 'Cart');

  function beforeFilter(){
    parent::beforeFilter();
  }

  function index(){
    $MasterCategory = ClassRegistry::init('MasterCategory');
    $masterCategories = $MasterCategory->find('all', array(
      'order' => array('MasterCategory.priority'),
      'recursive' => -1));
   
    $this->layout = 'cart'; 
    $this->Category->Behaviors->attach('Containable'); 
    foreach($masterCategories as &$masterCategory) {
      $products = $this->Category->find('all', array(
        'contain' => array(
          'Product' => array(
            'conditions' => array(
              'AND' => array(
                'Product.display = ' => '1', 'Product.stock > ' => '0',
                'Product.master_category_id' => $masterCategory['MasterCategory']['id'])
              )
            )
          ),
        'order' => 'Category.priority'));
      $masterCategory['Products'] = $products;
    }
     $this->log($masterCategories );
    $this->set('products', $masterCategories);
    if (Configure::read('Grecocos.closed') == "yes") {
      $closed = true;
      $nextDelivery = $this->Delivery->find('first', array(
                        'conditions' => array(
                          'Delivery.next_delivery' => true)));
      App::import( 'Helper', 'Time' );
      $time = new TimeHelper;
      $nextDeliveryDate = $time->format($format = 'd-m-Y', 
                          $nextDelivery['Delivery']['date'],
                          null, 
                          "+7.0");
      $this->set('nextDeliveryDate', $nextDeliveryDate);
    } else {
      $closed = false;
    }
    $this->set('closed', $closed);
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
    $notEmpty = false; 
    $isIntegerOnly = true; 
    for ($i = 1; $i <= count($this->data); $i++) {
      if (ctype_digit($this->data[$i]['quantity']) == false) {
        $isIntegerOnly = false; 
      } else {
        if ($this->data[$i]['quantity'] > 0) {
          $notEmpty = true; 
        }
      }
    }
    if ($this->currentUser['User']['role'] == "supplier") {
      $this->Session->setFlash('Sorry suppliers cannot make order.', 'system_message');
      $this->redirect(array('controller' => 'carts', 'action' => 'index'));       
    }    
    if ($isIntegerOnly == false) {
      $this->Session->setFlash('Quantity must be integer only.', 'system_message');
      $this->redirect(array('controller' => 'carts', 'action' => 'index'));       
    }
    if ($notEmpty == false) {
      $this->Session->setFlash('Nothing to check out - thank you', 'system_message');
      $this->redirect(array('controller' => 'carts', 'action' => 'index'));      
    }
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
    $products = $this->Product->find('all', array('conditions' => $conditions, 'recursive' => -1));
    foreach ($cart as $cartItem) {
      foreach($products as $product){
        if($cartItem['id'] == $product['Product']['id']){
          $cartItem['name'] = $product['Product']['short_description'];
        }
      }
    }
    $total = $this->Session->read('cart_total');
    $total2 = $this->Session->read('cart_total2');
    $delivery = $this->Delivery->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $order = array('Order' => array('status' => 'entered', 'ordered_date' => date('Y-m-d H:i:s'), 'complete' => false,
                            'user_id' => $this->currentUser['User']['id'],
                            'delivery_id' => $delivery['Delivery']['id'], 'total' => $total,'total2' => $total2,
                            'total_supplied' => $total, 'total2_supplied' => $total2, 'refund' => false));
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
                              'total_price_supplied' => $cartItem['subtotal'], 
                              'total2_price' => $cartItem['subtotal2'],
                              'total2_price_supplied' => $cartItem['subtotal2']);
    }
    $this->LineItem->saveAll($lineItems['Order']);
    $transaction = array('Transaction' => array('type' => 'Order', 'user_id' => $this->currentUser['User']['id'], 
                                        'order_id' => $orderId, 'delivery_id' => $delivery['Delivery']['id'])); 
    $this->Transaction->create(); 
    $this->Transaction->save($transaction); 
    $deliveryDate = $this->Delivery->find('first', array('conditions' => array('Delivery.next_delivery' => 1)));
    $this->Session->write('deliveryDate', $deliveryDate);
    $this->Session->write('orderId', $orderId);
    $this->redirect(array('controller' => 'carts', 'action' => 'checkout'));
  }

  function checkout(){
    $this->layout = 'cart';
  }
  
  function getInvoice() {
    $this->layout = "fpdf";
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
