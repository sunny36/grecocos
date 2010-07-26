<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'date';
	var $hasMany = 'Order';

  var $validate = array('date' => array('notEmpty' => array('rule' => 'notEmpty',
                                                            'message' => 'Please select a date'),
                                        'unique' => array('rule' => 'isUnique',
                                                          'message' => 'This date has already been selected')));
                                                          
  function changeNextDelivery($nextDeliveryId) {
    $currentNextDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $currentNextDelivery['Delivery']['next_delivery'] = false; 
    $this->save($currentNextDelivery);
    $nextDelivery = $this->find('first', array('conditions' => array('Delivery.id' => $nextDeliveryId)));
    $nextDelivery['Delivery']['next_delivery'] = true; 
    $this->save($nextDelivery);
  }
  
  function isDatesConsecutive($ids) {
    //Payment for 1 delivery is always guranteed to be consecutive 
    if (count($ids) == 1) return true;    
    $deliveries = $this->find('all', array('conditions' => array('Delivery.id' => $ids), 
                              'order' => array('Delivery.date'), 'recursive' => 0));
    $valid = false; 
    if (count($deliveries) >= 2) {
      $minDelivery = $deliveries[0];
      $maxDelivery = $deliveries[count($deliveries) -1];
      $allDeliveries = $this->find('all', array('conditions' => array(
        'Delivery.date BETWEEN ? AND ?' => array($minDelivery['Delivery']['date'], $maxDelivery['Delivery']['date'])),
        'recursive' => 0));
      if (count($deliveries) == count($allDeliveries)) {
        $valid = true; 
      } else {
        $valid = false; 
      }
    }  
    return $valid; 
  }

  function getMinAndMaxDates($ids) {
    $deliveries = $this->find('all', array('conditions' => array('Delivery.id' => $ids), 
                              'order' => array('Delivery.date'), 'recursive' => 0));
    return array($deliveries[0], $deliveries[count($deliveries) -1]);
  }
  
  function getNextDelivery() {
    $currentDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $nextDelivery = $this->find('all', array('conditions' => array(
      'Delivery.date >' => $currentDelivery['Delivery']['date']), 
      'order' => array('Delivery.date')));
    return $nextDelivery; 
  }

  function getDeliveryDatesList() {
    $nextDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $delivery_dates = $this->find('list', array('conditions' => array(
      'Delivery.date <= ' => $nextDelivery['Delivery']['date']), 'order' => array('Delivery.date DESC'))); 
    return $delivery_dates; 
  }
  
  function sendEmailArrivalOfShipment($deliveryId) {
    $Order = ClassRegistry::init('Order'); 
    $orders = $Order->find('all', array('conditions' => array('Order.delivery_id' => $deliveryId, 
    'Order.status' => 'packed'))); 
    $to = "";
    foreach ($orders as $order) {
      $to = $to . $order['User']['email'] . ", ";
    }
    $subject = "GRECOCOS: Order has arrived"; 
    $body = "Dear member,\n\nI am pleased to inform you that your order has arrived.\n\n" . 
    "You can come to collect it now.\n\nKind regards,\nYour coordinator"; 
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail($to, $subject, $body); 
  }
}
?>
