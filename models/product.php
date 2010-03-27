<?php
class Product extends AppModel {
	var $name = 'Product';
	var $displayField = 'short_description';
	var $hasMany = 'LineItem';
	
	var $validate = array(
	  'short_description' => array(
	    'rule' => 'notEmpty',
	    'message' => 'Short Description must not be blank'
	    ),
	    'selling_price' => array(
	      'mustBeNumbers' => array(
	        'rule' => 'numeric',
	        'message' => 'Selling price must be a numerice value'
	        ),
        'required' => array(
          'rule' => 'notEmpty', 
          'message' => 'Selling price must not be blank'
          )
      ),
      'buying_price' => array(
	      'mustBeNumbers' => array(
	        'rule' => 'numeric',
	        'message' => 'Buying price must be a numerice value'
	        ),
        'required' => array(
          'rule' => 'notEmpty', 
          'message' => 'Selling price must not be blank'
          )
      ),
      'quantity' => array(
  	    'rule' => 'notEmpty',
  	    'message' => 'Quantity must not be blank'
  	    ),
      'stock' => array(
	      'mustBeNumbers' => array(
	        'rule' => 'numeric',
	        'message' => 'Stock must be a numerice value'
	        ),
        'required' => array(
          'rule' => 'notEmpty', 
          'message' => 'Stock must not be blank'
          )
      ),
    'image' => array(
	    'rule' => 'notEmpty',
	    'message' => 'Image must not be blank'
	    ),
  	  
	    
  );
}
?>