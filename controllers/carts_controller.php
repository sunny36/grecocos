<?php
class CartsController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem');
 	var $components = array('Email');

	function beforeFilter(){
		parent::beforeFilter();
	}
  
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
		if(!$this->Session->check('cart')){
			$this->Session->setFlash('Your cart is currently empty.!!');
			$this->redirect(array('controller' => 'carts', 'action' => 'index'));
		}
		$cart = $this->Session->read('cart');
		foreach ($cart as $cartItem) {
			$conditions['id'][] = $cartItem['id'];
		}
		$products = $this->Product->find('all', array('conditions' => $conditions, 'recursive' => 0));
		foreach ($cart as $cartItem) {
			foreach($products as $product){
				if($cartItem['id'] == $product['Product']['id']){
					$cartItem['name'] = $product['Product']['name'];
				}
			}
		}
		$total = $this->Session->read('cart_total');
		$order = array('Order' => array('status' => 'unpaid', 
																		'ordered_date' => date('Y-m-d H:i:s'), 
																		'complete' => false,
																		'user_id' => $this->currentUser['User']['id']));
		$this->Order->create();
		$this->Order->save($order);
		$orderId = $this->Order->id;
		
		$cart = $this->Session->read('cart');			
		foreach($cart as $cartItem){
			$lineItems['Order'][] = array('product_id' => $cartItem['id'], 
																		'order_id' => $orderId, 
																		'quantity' => $cartItem['quantity'],
																		'total_price' =>  $cartItem['subtotal']);
		}
		$this->LineItem->saveAll($lineItems['Order']);

		App::import('Lib', 'pdf' );
		$pdf = new PDF_reciept();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetY(100);
		
		$pdf->Cell(100, 13, "Order ID");
		$pdf->SetFont('Arial', '');
		
		$orderId = str_pad($orderId, 6, '0', STR_PAD_LEFT);
		$pdf->Cell(200, 13, $orderId);
		
		$pdf->Ln(100);
		
		
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->SetY(120);
		
		$pdf->Cell(100, 13, "Ordered By");
		$pdf->SetFont('Arial', '');
		
		$pdf->Cell(200, 13, $this->currentUser['User']['firstname'] . ' ' . $this->currentUser['User']['lastname']);
		
		$pdf->SetFont('Arial', 'B');
		$pdf->Cell(50, 13, "Date:");
		$pdf->SetFont('Arial', '');
		$pdf->Cell(100, 13, date('F j, Y'), 0, 1);
		
		$pdf->SetFont('Arial', '');
		$pdf->SetX(140);
		$pdf->Cell(200, 15, $this->currentUser['User']['address1'], 0, 2);
		$pdf->Cell(200, 15, $this->currentUser['User']['address2'], 0, 2);
		$pdf->Cell(200, 15, $this->currentUser['User']['address3'], 0, 2);
		$pdf->Cell(200, 15, $this->currentUser['User']['city'] . ', ' . $this->currentUser['User']['postalcode'] , 0, 2);
		
		$pdf->Ln(100);
		
		$pdf->PriceTable($cart, $total);
		
		$pdf->Ln(50);
		
		$message = "Please pay cash to the co-ordinator.";
		
		$pdf->MultiCell(0, 15, $message);

		$fileName = $orderId . '_' . 'invoice.pdf';
		$pdf->Output($fileName, 'F');
		
		$this->sendEmail($fileName, $orderId);
		
		$this->Session->delete('cart');
		$this->Session->delete('cart_total');
	
		$this->Session->write('filename', $fileName); 
		$this->redirect(array('controller' => 'carts', 'action' => 'checkout'));
	}
	
	function checkout(){
		$this->layout = 'cart';
		$this->set('filename', $this->Session->read('filename'));
		$this->Session->delete('filename');
	}
	
 
	function sendEmail($filename, $orderID){
			$this->Email->to = 'coordinator@grecocos.co.cc'; 
			$this->Email->subject = 'Order ID:' . ' ' . $orderID; 
			$this->Email->replyTo = 'admin@grecocos.co.cc'; 
			$this->Email->from = 'Somchok Sakjiraphong <somchok.sakjiraphong@ait.ac.th>'; 
			$this->Email->sendAs = 'html';
			$this->Email->template = 'order';
			$this->Email->attachments = array($filename);
	   /* SMTP Options */
	   $this->Email->smtpOptions = array(
	        'port'=>'25', 
	        'timeout'=>'30',
	        'host' => 'smtp.ait.ac.th',
	        'username'=>'st108660',
	        'password'=>'m2037compaq'
	   );
	    /* Set delivery method */
	    $this->Email->delivery = 'smtp';
			$this->Email->send();		
	}
	
}