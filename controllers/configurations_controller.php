<?php
class ConfigurationsController extends AppController {

  var $name = 'Configurations';
  var $helpers = array('Html', 'Form', 'Javascript', 'Time');

  function beforeFilter(){
    parent::beforeFilter();
    $coordinatorActions = array(
      'coordinator_index', 'coordinator_view', 'coordinator_add', 
      'coordinator_edit', 'coordinator_delete');
    $supplierActions = array('supplier_index');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") {
       $this->redirect('/supplier'); 
      }
    }
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") {
       $this->redirect('/coordinator'); 
      }
    }        
  }
  
  function coordinator_index() {
    $this->layout = "coordinator/add";
    $this->__index();
  }
  
  function supplier_index() {
    $this->layout = "supplier/add";
    $this->__index();
  }
  
  function __index() {
    $this->Configuration->recursive = 0;
    $this->set('closed', Configure::read('Grecocos.closed'));
    if (!empty($this->data)) {
      $closed = $this->Configuration->findByKey('closed');
      $closed['Configuration']['value'] = 
        $this->data['Configuration']['closed']; 
      $this->Configuration->save($closed);
      if ($closed['Configuration']['value'] == "no") {
        $flashMessage = "The website has been opened. ";
      } else { 
        // $closed['Configuration']['value'] == "yes"
        $flashMessage = "The website has been closed. ";
      }
      if ($this->Session->check('sendEmailReOpenSite')) {
        if ($this->Session->read('sendEmailReOpenSite')) {
          $flashMessage = $flashMessage . 
                          "Emails have been sent to all customers.";
          $this->Session->delete('sendEmailReOpenSite');
        }
      }
      $this->Session->setFlash($flashMessage, 'system_message');
      $this->redirect(array('action' => 'index'));
    }   
  }
  function isNextDeliveryDateInFuture() {    
    if($this->RequestHandler->isAjax()) {
      Configure::write('debug', 0);
      $Delivery = ClassRegistry::init('Delivery'); 
      if ($Delivery->isNextDeliveryDateInFuture()) {
        $this->set("next_delivery_in_future", "yes");
      } else {
        $this->set("next_delivery_in_future", "no");
      }      
    }
  }
    
  function sendEmailSiteReopen() {
    $User = ClassRegistry::init('User'); 
    $users = $User->find('all', array('conditions' => array(
      'User.status' => 'accepted'))); 
    $to = "";
    foreach ($users as $user) {
      $to = $to . $user['User']['email'] . ", ";
    }
    $subject = "GRECOCOS website is now open"; 
    $Delivery = ClassRegistry::init('Delivery'); 
    $nextDelivery = $Delivery->findByNextDelivery(true);
    App::import( 'Helper', 'Time' );
    $timeHelper = new TimeHelper;    
    $deliveryDate = $timeHelper->format($format = 'd-m-Y', 
                                        $nextDelivery['Delivery']['date']);
    $body = "Dear member,\n\nThe GRECOCOS website is opened. " . 
            "You can place your orders now for delivery on " . 
             "{$deliveryDate}." ."\n\nhttp://grecocos.co.cc/index.php"; 
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail($to, $subject, $body);   
    $this->Session->write('sendEmailReOpenSite', true);
  }
    
  function coordinator_view($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'configuration'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('configuration', $this->Configuration->read(null, $id));
  }

  function coordinator_add() {
    if (!empty($this->data)) {
      $this->Configuration->create();
      if ($this->Configuration->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'configuration'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'configuration'));
      }
    }
  }

  function coordinator_edit($id = null) {
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'configuration'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->Configuration->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'configuration'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'configuration'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->Configuration->read(null, $id);
    }
  }

  function coordinator_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'configuration'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->Configuration->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'Configuration'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Configuration'));
    $this->redirect(array('action' => 'index'));
  }
  
  function get_site_status() {
    if($this->RequestHandler->isAjax()) {
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->autoLayout = false;
      App::import('Helper', 'Javascript');
      $javascript = new JavascriptHelper();
      $configuration = Configure::read('Grecocos');
      echo($javascript->object($configuration));
      exit(1);
    }
  }
}
?>