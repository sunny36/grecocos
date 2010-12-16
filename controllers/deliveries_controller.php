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
    $coordinatorActions = array('coordinator_index', 'coordinator_notify_arrival_of_shipment', 'coordinator_payments', 
      'coordinator_add', 'coordinator_delete', 'coordinator_edit', 
      'coordinator_arrival_of_shipment');
    $supplierActions = array('supplier_index', 'supplier_add', 'supplier_delete', 'supplier_edit');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") $this->redirect('/supplier');
    }
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") $this->redirect('/coordinator');
    }        
  }

  function supplier_index() {
    $this->layout = "supplier/orders/index";  
    if ($this->RequestHandler->isAjax()) {
      if (isset($this->params['url']['organization_id'])) {
        $deliveries = $this->Delivery->find('all', array(
          'conditions' => array('Delivery.organization_id' => $this->params['url']['organization_id']), 
          'order' => array('Delivery.date DESC')
        ));
        list($response->page, $response->total, $response->records) = array(1, 1, count($deliveries));
        $i = 0; 
        foreach ($deliveries as $delivery) {
          $response->rows[$i]['id'] = $delivery['Delivery']['id'];
          $response->rows[$i]['cell'] = array(
            $delivery['Delivery']['id'], $delivery['Delivery']['date'], $delivery['Delivery']['next_delivery']);
          $i++;
        }
        Configure::write('debug', 0);
        $this->autoRender = false;
        $this->autoLayout = false;
        echo(json_encode($response));
        exit(1);            
      }
    }
  }

  function coordinator_index() {
    $this->layout = "coordinator/index";  
    $this->paginate = array(
      'conditions' => array('Delivery.organization_id' => $this->currentUser['User']['organization_id']), 
      'order' => array('Delivery.date DESC')
    );
    $this->set('deliveries', $this->paginate());
  }

  function supplier_getalljson($id = null) {
    //$id = organization id
    if($this->RequestHandler->isAjax()) {
      $nextDelivery = $this->Delivery->findByNextDelivery(true);
      $this->Delivery->recursive = 0; 
      $deliveryDates = $this->Delivery->find('all', array(
        'conditions' => array(
          'Delivery.date <=' => date('Y-m-d', strtotime($nextDelivery['Delivery']['date'])), 
          'Delivery.organization_id' => intval($id)), 
        'order' => 'Delivery.date DESC'
        )
      );
      Configure::write('debug', 0);
      $this->autoRender = false; 
      $this->autoLayout = false;
      echo(json_encode($deliveryDates));
      exit(1);      
    }
  }

  function coordinator_notify_arrival_of_shipment() {
    $this->layout = "coordinator/index"; 
    $delivery = $this->Delivery->findByOrderStatus("packed");    
    if(!empty($this->params['form'])) {
      $delivery_id = $this->params['form']['id']; 
      $delivery = $this->Order->find('all', array('conditions' => array('Delivery.id' => $delivery_id, 'Order.status' => "packed"))); 
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
      $params = array('recursive' => 1, 'offset' => $start, 'limit' => $limit, 'conditions' => array(
        'Delivery.closed' => true), 'order' => array('Delivery.date DESC'));
      $deliveries = $this->Delivery->find('all', $params);
      foreach ($deliveries as &$delivery) {
        $total_received = 0; 
        $total_refund = 0; 
        $total_due = 0; 
        foreach($delivery['Order'] as $order) {
          if (($order['status'] == "packed") || ($order['status'] == "delivered") || ($order['status'] == "paid")) {
            $total_received += $order['total'];
            $total_refund += ($order['total'] - $order['total_supplied']);
            $total_due += $order['total2_supplied'];
          }
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
  
  function validate_add_delivery_date() {
    if ($this->RequestHandler->isAjax()) {
      $this->Delivery->set(array(
        'Delivery' => array('date' => $this->params['form']['Date'], 'next_delivery' => false))
      );
      $errors = $this->Delivery->invalidFields();
      Configure::write('debug', 0);
      $this->autoRender = false; 
      $this->autoLayout = false;
      echo(json_encode($errors));
      exit(1);      
    }
  }
  function supplier_add() {
    $this->layout = "supplier/add";
    if ($this->RequestHandler->isAjax()) {
      $delivery = $this->Delivery->create(array(
        'Delivery' => array('date' => $this->params['form']['date'], 'next_delivery' => false))
      );
      $this->Delivery->save($delivery);
    } else {
      if (!empty($this->data)) {
        $this->Delivery->create();
        if ($this->Delivery->save($this->data)) {
          $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'), 'flash_notice');
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash(
            sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'), 'flash_error');
        }
      }
    }
  }

  function coordinator_add() {
    $this->layout = "coordinator/add";  
    if (!empty($this->data)) {
      $this->data['Delivery']['organization_id'] = $this->currentUser['User']['organization_id'];
      $this->Delivery->create();
      if ($this->Delivery->save($this->data)) {
        $this->Session->setFlash('The delivery has been saved', 'flash_notice');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('The delivery could not be saved. Please, try again.', 'flash_error');
      }
    }
  }

  function supplier_delete($id = null) {
    if($this->RequestHandler->isAjax()) {  
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->Delivery->delete($this->params['form']['id']);
      exit(1);
    }
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

  function coordinator_delete($id = null) {
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
              if (($order['status'] == "packed") || ($order['status'] == "delivered") || ($order['status'] == "paid")) {
                $total_due += $order['total2_supplied'];
              }
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
          $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
          $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'), 
          'flash_error');
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
      $this->Delivery->sendEmailArrivalOfShipment(
        $this->data['Delivery']['delivery_date'], $this->currentUser['User']['organization_id']); 
      $orders = $this->findAllPackedOrders($this->data['Delivery']['delivery_date']); 
      $this->set('orders', $orders);
      $this->Session->setFlash('Emails have been sent', 'system_message');
      $this->redirect(
        "/coordinator/deliveries/arrival_of_shipment?delivery_date={$this->data['Delivery']['delivery_date']}");
    }
    if (isset($this->params['url']['delivery_date'])) {
      $orders = $this->findAllPackedOrders($this->params['url']['delivery_date']); 
      $this->set('default_delivery_date', $this->params['url']['delivery_date']);
      $this->set('orders', $orders);
    }
  }

  function getOrders($id = null) {
    if ($this->RequestHandler->isAjax()) {
      $totalOrders = $this->Order->find('count', array('conditions' => array('Order.delivery_id' => $id)));
      Configure::write('debug', 0);
      $this->autoRender = false; 
      $this->autoLayout = false;
      echo(json_encode(array('total_orders' => $totalOrders)));
      exit(1);      
    }
  }

  private function findAllPackedOrders($deliveryId) {
    return $this->Order->findAllByStatusAndDeliveryIdAndUserOrganizationId(
      'packed', $deliveryId, $this->currentUser['User']['organization_id']);
  }

}
?>
