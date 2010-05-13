<?php
class DeliveriesController extends AppController {

  var $name = 'Deliveries';
  var $helpers = array('Html', 'Form', 'Javascript');
  var $uses = array('Delivery', 'Order');
  
  function admin_index() {
    $this->layout = "admin_index";  
    $this->Delivery->recursive = 1;
    $this->set('deliveries', $this->paginate());
  }

  function supplier_index() {
    $this->layout = "supplier/index";  
    $this->Delivery->recursive = 3;
    $this->set('deliveries', $this->paginate());
    $this->render('/deliveries/admin_index');
  }

  function coordinator_notify_arrival_of_shipment() {
    $this->log($this->params, 'activity'); 
    $this->layout = "coordinator/index"; 

    $delivery = $this->Delivery->findByOrderStatus("packed");
    
    if(!empty($this->params['form'])) {
      $this->log($this->params['form']['send_email'], 'activity'); 

      $delivery_id = $this->params['form']['id']; 
      $delivery = $this->Order->find('all', 
                                     array('conditions' => 
                                           array('Delivery.id' => $delivery_id,
                                                 'Order.status' => "packed")                                                    
                                           )
                                     ); 
      $this->log($delivery, 'activity'); 
    } else {
      $this->set('deliveries', $this->paginate()); 
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

  function supplier_edit($id = null) {
    $this->layout = "supplier/add";
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false; 
      if($this->params['form']['closed']) {
        $closed = $this->params['form']['closed'];
        $this->Delivery->recursive = -1;
        $delivery = $this->Delivery->findById($this->params['form']['id']);
        
        if($closed == 'Yes') {
          $this->log($delivery, 'activity');
          $delivery['Delivery']['closed'] = true;
          $this->log($delivery, 'activity');
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
}
?>