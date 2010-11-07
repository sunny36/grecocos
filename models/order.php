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

  function sendEmailConfirmingEmail($id) {
    setlocale(LC_MONETARY, 'th_TH');
	  $this->recursive = 2;
    $order = $this->findById($id); 
    $to = $order['User']['email']; 
    $subject = "GRECOCOS: Payment received for Order #{$order['Order']['id']}"; 
    $amount = money_format("%i", $order['Order']['total']); 
    $body = "Dear {$order['User']['firstname']} \n\n" . 
      "Your payment for Order #{$order['Order']['id']} has been received\n\n" . 
      "Amount Paid: {$amount} Baht \n\nThank You";
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail($to, $subject, $body); 
  }
  
  function findAllByDeliveryIdAndStatus(
    $deliveryId, $status, $limit = 0, $offset = 0) {
      $orders = $this->find('all', array('conditions' => array(
        'AND' => array(
          'Order.status' => $status,
          'Order.delivery_id' => $deliveryId)),
      'limit' => $limit, 
      'offset' => $offset));
      return $orders; 
    }
    
    function findAllByDeliveryIdAndStatusAndOrderedDate(
      $deliveryId, $status, $orderedDate) {
        $orders = $this->find('all', array('conditions' => array(
          'AND' => array(
            'Order.status' => $status,
            'Order.delivery_id' => $deliveryId, 
            'Order.ordered_date < ' => $orderedDate))));
        return $orders; 
    }
    
    function sendReminderEmailForPayment() {
      $Delivery = ClassRegistry::init('Delivery');
      $delivery = $Delivery->getNextDelivery();
      $orders = $this->findAllByDeliveryIdAndStatusAndOrderedDate(
        $delivery['Delivery']['id'],
        array('entered'),
        date('Y-m-d H:i:s', strtotime('-1 hour')));
      $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
      foreach ($orders as $order) {
        $to = "s@sunny.in.th"; 
        $subject = "GRECOCOS: Payment Reminder";
        $body = "Dear {$order['User']['firstname']}<br/><br/>" . 
          "Thank you for your order #{$order['Order']['id']} amounting to " .
          "{$order['Order']['total']} Baht.<br/><br/>" .
          "At the moment of sending this message the order was not yet paid.<br/><br/>" .
          "If in the meantime you have paid this order then we apologize and " .
          "you may ignore this message. Otherwise kindly bring your invoice " .
          "and pay to the Coordinator.<br/><br/>" .
          "Your Grecocos Coordinator";      
        $AppengineEmail->sendEmail($to, $subject, $body); 
        $this->log($order['User']['firstname']);
      }
      
    }
    
}
?>
