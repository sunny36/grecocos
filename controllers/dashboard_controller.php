<?php
class DashboardController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem', 'Delivery', 'Category', 'Cart');
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
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