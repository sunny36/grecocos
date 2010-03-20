<?php
class CartsController extends AppController{
  var $uses = array('Product');
  
  
  function index(){
    $this->layout = 'cart'; 
    $products = $this->Product->find('all');
    $this->set('products', $products);
  }
  
  function add(){
    $this->set('data', $this->data);
  }
}