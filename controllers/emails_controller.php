<?php

class EmailsController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem', 'Delivery', 'Category', 
    'Cart', 'Email');
  
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function beforeFilter(){
    parent::beforeFilter();
  }
  
  function coordinator_index() {
    $this->layout = "coordinator/add";
    $this->_index();
  }
  
  function supplier_index() {
    $this->layout = "supplier/add";
    $this->_index();
  }
  
  function _index() {
    if (!empty($this->data)) {
     $this->Email->set($this->data);
     if ($this->Email->validates()) {
       if ($this->data['Email']['to'] == "all") {
        $this->Email->sendEmailToAllCustomer($this->data['Email']['subject'], 
                                             $this->data['Email']['body']);
       }
       if ($this->data['Email']['to'] == "not_ordered") {
        $this->Email->sendEmailCustomersWhoHaveNotOrdered(
          $this->data['Email']['subject'], 
          $this->data['Email']['body']);
       }
       if ($this->data['Email']['to'] == "individual") {
        $this->Email->sendEmailToIndividualCustomer(
          $this->data['Email']['user'],
          $this->data['Email']['subject'],
          $this->data['Email']['body']);
       }
       $this->Session->setFlash('Email has been sent', 'flash_notice');
       $this->redirect(array('action' => 'index'));
     }
    }
  }
}