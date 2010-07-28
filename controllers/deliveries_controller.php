<?php
class DeliveriesController extends AppController {

  var $name = 'Deliveries';
  var $helpers = array('Html', 'Form', 'Javascript');
  var $uses = array('Delivery', 'Order');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
  }
  
  function supplier_index() {
    $this->layout = "supplier/index";  
    $this->Delivery->recursive = 3;
    $this->paginate = array('order' => array('Delivery.date DESC'));
    $this->set('deliveries', $this->paginate());
  }
  
  function supplier_getalljson() {
    Configure::write('debug', 0);
    if($this->RequestHandler->isAjax()) {
      $params = array('conditions' => array('Delivery.next_delivery' => true)); 
      $next_delivery = $this->Delivery->find('first', $params);
      $params = array('conditions' => array(
        'Delivery.date <=' => $next_delivery['Delivery']['date'])); 
      $temp = $this->Delivery->recursive;
      $this->Delivery->recursive = 0; 
      $delivery_dates = $this->Delivery->find('all', $params); 
      $this->Delivery->recursive = $temp ;
      $delivery_dates = json_encode($delivery_dates);      
      $this->set('delivery_dates', $delivery_dates);
      $this->render('/elements/supplier_getalljson', 'ajax');      
    }
  }

  function coordinator_notify_arrival_of_shipment() {
    $this->layout = "coordinator/index"; 

    $delivery = $this->Delivery->findByOrderStatus("packed");
    
    if(!empty($this->params['form'])) {
      $delivery_id = $this->params['form']['id']; 
      $delivery = $this->Order->find('all', 
                                     array('conditions' => 
                                           array('Delivery.id' => $delivery_id,
                                                 'Order.status' => "packed")                                                    
                                           )
                                     ); 
    } else {
      $this->set('deliveries', $this->paginate()); 
    }
  }

  function coordinator_payments() {
    $this->layout = "coordinator/index"; 
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 

      if(!$sidx) $sidx =1;
      $params = array('conditions' => array('Delivery.closed' => true));
      $count = $this->Delivery->find('count', $params);
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
        $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
    
      $params = array('recursive' => 1, 'offset' => $start, 'limit' => $limit, 
      'conditions' => array('Delivery.closed' => true), 'order' => array('Delivery.date'));
      $deliveries = $this->Delivery->find('all', $params);
      foreach ($deliveries as &$delivery) {
        $total_received = 0; 
        $total_refund = 0; 
        $total_due = 0; 
        foreach($delivery['Order'] as $order) {
          $total_received += $order['total'];
          $total_refund += ($order['total'] - $order['total_supplied']);
          $total_due += $order['total2_supplied'];
        }
        $delivery['Delivery']['total_received'] = $total_received; 
        $delivery['Delivery']['total_refund'] = $total_refund; 
        $delivery['Delivery']['total_due'] = $total_due;
      }
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('deliveries', $deliveries);
      $this->render('/elements/coordinator_deliveries_payments', 'ajax');      
    }
  }
  function admin_view($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'delivery'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('delivery', $this->Delivery->read(null, $id));
  }

  function admin_add() {
    $this->layout = "admin_add";  
    if (!empty($this->data)) {
      $this->Delivery->create();
      if ($this->Delivery->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'));
      }
    }
  }

  function supplier_add() {
    $this->layout = "supplier/add";  
    if (!empty($this->data)) {
      $this->Delivery->create();
      if ($this->Delivery->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'), 'flash_error');
      }
    }
    $this->render('/deliveries/admin_add');
  }

  function admin_edit($id = null) {
    $this->layout = "admin_add";  
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'delivery'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->Delivery->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->Delivery->read(null, $id);
      $this->set('delivery', $this->Delivery->read(null, $id));
    }
  }

  function admin_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'delivery'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->Delivery->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'Delivery'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Delivery'));
    $this->redirect(array('action' => 'index'));
  }

  function supplier_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'delivery'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->Delivery->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'Delivery'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Delivery'));
    $this->redirect(array('action' => 'index'));
  }

  function is_dates_consecutive() {
    if ($this->RequestHandler->isAjax()) {
      Configure::write('debug', 0);
      $ids = null; 
      foreach ($this->params['form']['ids'] as $id) {
        $ids[] = $id; 
      }
      $this->log($ids, 'activity');
      if ($this->Delivery->isDatesConsecutive($ids)) {
        $this->set('valid', "yes");
      } else {
        $this->set('valid', "no");
      }
      $this->render('/elements/is_dates_consecutive');
    }
  }
  
  function coordinator_edit($id = null) {
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false; 
      if($this->params['form']['paid']) {
        $paid = $this->params['form']['paid'];
        $this->Delivery->recursive = -1;
        if(isset($this->params['form']['ids'])) {
          $ids = null; 
          $this->Delivery->recursive = 1;
          $bank_transfer_amount = 0; 
          foreach ($this->params['form']['ids'] as $id) {
            $ids[] = $id;
            $delivery = $this->Delivery->findById($id);
            $total_due = 0;
            foreach($delivery['Order'] as $order) {
              $total_due += $order['total2_supplied'];
            }
            $bank_transfer_amount += $total_due;
            if($paid == 'Yes') $delivery['Delivery']['paid'] = true;
            if($paid == 'No') $delivery['Delivery']['paid'] = false;    
            $this->Delivery->save($delivery);
          }
          list($minDeliveryDate, $maxDeliveryDate) = $this->Delivery->getMinAndMaxDates($ids); 
          $transaction = array('Transaction' => array(
            'type' => "Bank Transfer", 'user_id' => $this->currentUser['User']['id'],  
            'from' => $minDeliveryDate['Delivery']['date'], 'to' => $maxDeliveryDate['Delivery']['date'],
            'bank_transfer_amount' => $bank_transfer_amount, 'delivery_id' => $maxDeliveryDate['Delivery']['id'])); 
          $Transaction = ClassRegistry::init('Transaction');
          $Transaction->create(); 
          $Transaction->save($transaction); 
            
        } else {
          $delivery = $this->Delivery->findById($this->params['form']['id']);
          if($paid == 'Yes') {
            $delivery['Delivery']['paid'] = true;
          }
          if($paid == 'No') {
            $delivery['Delivery']['paid'] = false;    
          }
          $this->Delivery->save($delivery);          
        }
      }
    }     
  }
  
  function supplier_edit($id = null) {
    $this->layout = "supplier/add";
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false; 
      if($this->params['form']['closed']) {
        $closed = $this->params['form']['closed'];
        $this->Delivery->recursive = -1;
        $delivery = $this->Delivery->findById($this->params['form']['id']);
        if($closed == 'Yes') {
          $delivery['Delivery']['closed'] = true;
          $this->Delivery->sendConfirmationEmail($delivery['Delivery']['id']);
        }
        if($closed == 'No') {
          $delivery['Delivery']['closed'] = false;    
        }
        $this->Delivery->save($delivery);
        
      }
    } else {
      //Non-Ajax request 
      if (!$id && empty($this->data)) {
        $this->Session->setFlash(sprintf(__('Invalid %s', true), 'delivery'));
        $this->redirect(array('action' => 'index'));
      }
      if (!empty($this->data)) {
        if ($this->Delivery->save($this->data)) {
          $this->Session->setFlash(sprintf(__('The %s has been saved', true), 
                                           'delivery'));
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'), 'flash_error');
        }
      }
      if (empty($this->data)) {
        $this->data = $this->Delivery->read(null, $id);
        $this->set('delivery', $this->Delivery->read(null, $id));
      }

      $this->render("/deliveries/admin_edit");

    }
  }
  
  function edit($id = null) {
    if($this->RequestHandler->isAjax()) {
      Configure::write('debug', 0);
      $this->autoRender = false;
      if (isset($this->params['form']['next_delivery'])) {
        if ($this->params['form']['next_delivery'] == "1") {
          $this->Delivery->changeNextDelivery($id); 
          
        }
      }
    }
  }

  function coordinator_arrival_of_shipment() {
    $this->layout = "coordinator/index";
    $deliveryDates = $this->Delivery->getDeliveryDatesList(); 
    $this->set('delivery_dates', $deliveryDates); 
    if (!empty($this->data)) {
      $this->Delivery->sendEmailArrivalOfShipment($this->data['Delivery']['delivery_date']); 
      $orders = $this->Order->find('all', array('conditions' => array(
        'Order.delivery_id' => $this->data['Delivery']['delivery_date'], 
        'Order.status' => 'packed')));
      $this->set('default_delivery_date', $this->data['Delivery']['delivery_date']);
      $this->set('orders', $orders);
      $this->Session->setFlash('Emails has been sent', 'system_message');  
    }
    if (isset($this->params['url']['delivery_date'])) {
      $orders = $this->Order->find('all', array('conditions' => array(
        'Order.delivery_id' => $this->params['url']['delivery_date'], 
        'Order.status' => 'packed')));
      $this->set('default_delivery_date', $this->params['url']['delivery_date']);
      $this->set('orders', $orders);
    }
  }
  
  function coordinator_send_email_arrival_of_shipment() {
    
  }
}
?>
