<?php
class DashboardController extends AppController{
  var $uses = array(
    'Product', 'Order', 'LineItem', 'Delivery', 'Category', 'Cart');
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
    if ($this->params['action'] == "admin_coordinator") {
      if ($this->currentUser['User']['role'] == "supplier") {
       $this->redirect('/supplier'); 
      }
    }
    if ($this->params['action'] == "admin_supplier") {
      if ($this->currentUser['User']['role'] == "coordinator") {
       $this->redirect('/coordinator'); 
      }
    }
    if ($this->params['action'] == "admin_administrator") {
      if ($this->currentUser['User']['role'] == "coordinator") {
       $this->redirect('/coordinator'); 
      }
      if ($this->currentUser['User']['role'] == "supplier") {
       $this->redirect('/supplier'); 
      }
    }    
  }
  
  function admin_index() { 
    $this->set('title_for_layout', 'Site Administration | Grecocos site admin');
    $this->layout = "admin_dashboard"; 
  }
  
  function admin_coordinator() { 
    $this->set('title_for_layout', 'Grecocos | Co-ordinator');
    $this->layout = "coordinator/dashboard"; 
  }

  function admin_supplier() { 
    $this->set('title_for_layout', 'Grecocos | Supplier');
    $this->layout = "supplier/dashboard"; 
  }

  function admin_administrator() { 
    $this->set('title_for_layout', 'Grecocos | Administrator');
    $this->layout = "administrator/dashboard"; 
  }
  
}