<?php
class Delivery extends AppModel {
  var $name = 'Delivery';
  var $displayField = 'date';
  var $hasMany = 'Order';

  var $validate = array(
    'date' => array(
      'notEmpty' => array(
        'rule' => 'notEmpty', 'message' => 'Please select a date'
      ),
      'unique' => array(
        'rule' => 'isUnique',
        'message' => 'This date has already been selected'
      )
    )
  );

  function changeNextDelivery($nextDeliveryId) {
    $dataSource = $this->getDataSource();
    $currentNextDelivery = $this->findByNextDelivery(true);
    $currentNextDelivery['Delivery']['next_delivery'] = false; 
    $nextDelivery = $this->findById($nextDeliveryId);
    $nextDelivery['Delivery']['next_delivery'] = true; 
    if ($this->save($currentNextDelivery) && $this->save($nextDelivery)) {
      $dataSource->commit($this);
    }
    else {
      $dataSource->rollback($this);
    }
  }

  function isDatesConsecutive($ids) {
    //Payment for 1 delivery is always guranteed to be consecutive 
    if (count($ids) == 1) {
      return true;
    }
    $deliveries = $this->find('all', array(
      'conditions' => array('Delivery.id' => $ids), 
      'order' => array('Delivery.date'), 'recursive' => 0));
    $valid = false; 
    if (count($deliveries) >= 2) {
      $minDelivery = $deliveries[0];
      $maxDelivery = $deliveries[count($deliveries) -1];
      $allDeliveries = $this->find(
        'all', array(
          'conditions' => array(
            'Delivery.date BETWEEN ? AND ?' => array(
              $minDelivery['Delivery']['date'], $maxDelivery['Delivery']['date']
            )
          ),
          'recursive' => 0)
        );
      if (count($deliveries) == count($allDeliveries)) {
        $valid = true; 
      } else {
        $valid = false; 
      }
    }  
    return $valid; 
  }

  function getMinAndMaxDates($ids) {
    $deliveries = $this->find(
      'all', array(
        'conditions' => array('Delivery.id' => $ids), 
        'order' => array('Delivery.date'), 'recursive' => 0)
      );
    return array($deliveries[0], $deliveries[count($deliveries) -1]);
  }

  function getAllDeliveriesAfterNextDelivery() {
    $currentDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $nextDelivery = $this->find('all', array(
      'conditions' => array(
      'Delivery.date >' => $currentDelivery['Delivery']['date']), 
    'order' => array('Delivery.date')));
    return $nextDelivery; 
  }

  function getDeliveryDatesList($includeAll=false) {
    $nextDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $deliveryDates = $this->find(
      'list', array(
        'conditions' => array(
          'Delivery.date <= ' => date('Y-m-d', strtotime($nextDelivery['Delivery']['date']))), 
        'order' => array('Delivery.date DESC'))
      ); 
    if ($includeAll) {
      $deliveryDates = array(-1 => 'All') + $deliveryDates;
    }
    return $deliveryDates; 
  }

  #TODO Fix this bug due to missing Email table
  function sendEmailArrivalOfShipment($deliveryId, $organizationId) {
    $Order = ClassRegistry::init('Order'); 
    $orders = $Order->findAllByStatusAndDeliveryIdAndUserOrganizationId(
      'packed', $deliveryId, $organizationId); 
    $to = "s@sunny.in.th";
    //foreach ($orders as $order) {
    //$to = $to . $order['User']['email'] . ", ";
    //}
    $Email = ClassRegistry::init('Email'); 
    $email = $Email->findByName('arrival_of_shipment'); 
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail(
      $to, $email['Email']['subject'], $email['Email']['body']); 
  }

  function sendConfirmationEmail($deliveryId) {
    $Order = ClassRegistry::init('Order'); 
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    App::import('Lib', 'supplier_pdf' );
    $orders = $Order->find('all', array('conditions' => array(
      'Order.delivery_id' => $deliveryId, 'Order.status' => 'packed'))); 
    foreach ($orders as $order) {
      $to = $order['User']['email'];
      $subject = "GRECOCOS: Order Confirmation"; 
      $body = "Dear {$order['User']['firstname']},\n\nI am pleased to inform you that your order has been confirmed.\n\n" . 
        "Please see the attachments for details.\n\nKind regards,\nYour supplier"; 
      $products = $Order->getProducts($order['Order']['id']);      
      $filename = "Order_" . $order['Order']['id'] . ".pdf";
      $supplierPdf = new SupplierPDF($products, $order, $filename, true); //true -> save to disk 
      $attachment = $filename; 
      $AppengineEmail->sendEmail($to, $subject, $body, $attachment);       
    }    
  }

  function getNextDelivery() {
    return $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
  }

  function isNextDeliveryDateInFuture() {
    $nextDelivery = $this->findByNextDelivery(true);
    if (strtotime($nextDelivery['Delivery']['date']) < time()) {
      return false;
    }
    if (strtotime($nextDelivery['Delivery']['date']) > time()) {
      return true;
    }    
  }
  
  function findNextDeliveryByOrganizationId($organizationId) {
    return $this->find('first', array(
      'conditions' => array('Delivery.next_delivery' => true, 'Delivery.organization_id' => $organizationId)
      ));
  }

  function beforeValidate() {
    if (!empty($this->data['Delivery']['date'])) {
      $this->data['Delivery']['date'] = $this->dateFormatBeforeSave($this->data['Delivery']['date']);
    }
    return true;
  }

  function afterFind($results) {
    foreach ($results as $key => $val) {
      if (isset($val['Delivery']['date'])) {
        $results[$key]['Delivery']['date'] = $this->dateFormatAfterFind($val['Delivery']['date']);
      }
    }
    return $results;
  }

  private function dateFormatAfterFind($dateString) {
    $configuration = ClassRegistry::init('Configuration')->findByKey('date_format');
    return date($configuration['Configuration']['value'], strtotime($dateString));
  }

  private function dateFormatBeforeSave($dateString) {
    return date('Y-m-d', strtotime($dateString));
  }
}
?>
