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
       $User = ClassRegistry::init('User'); 
       $users = $User->find('all', array(
         'conditions' => array('User.status' => 'accepted'))); 
       // $to = "s@sunny.in.th";
       $to = "";
       foreach ($users as $user) {
         $to = $to . $user['User']['email'] . ", ";
       }
       $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
       $AppengineEmail->sendEmail($to, 
                                  $this->data['Email']['subject'], 
                                  $this->data['Email']['body']);
       $this->Session->setFlash('Email has been sent', 'flash_notice');
       $this->redirect(array('action' => 'index'));
     }
    }
  }
}