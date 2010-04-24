<?php
class DashboardController extends AppController{
  var $uses = array('Product', 'Order', 'LineItem', 'Delivery', 'Category', 'Cart');
	var $helpers = array('Html', 'Form', 'Javascript');
	
	function admin_index() { 
	  $this->set('title_for_layout', 'Site Administration | Grecocos site admin');
    $this->layout = "admin_dashboard"; 
	}
}