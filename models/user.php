<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	
	var $validate = array(
  	  'username' => array(
  	    'rule' => array('minLength', 1),
  	    'require' => true,
  	    'allowEmpty' => false,
  	    'message' => 'Please enter a user name'
  	    ),
	    
      'password' => array(
        'rule' => array('minLength', 1),
        'require' => true, 
        'allowEmpty' => false,
        'message' => 'Please enter a password'
        ),
      
	    'email' => array(
	      'rule' => 'email'
        'require' => true, 
        'allowEmpty' => false,
	      'message' => 'Please enter a valid email'
	      )
	  );
}
?>