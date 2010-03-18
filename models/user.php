<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	
	var $validate = array(
	  
  	  'username' => array(
  	    'notempty' => array(
  	      'rule' => array('minLength', 1),
    	    'require' => true,
    	    'allowEmpty' => false,
    	    'message' => 'Please enter a user name'
  	      ),
	      'unique' => array(
	        'rule' => array('checkUnique', 'username'),
	        'message' => 'User name not available'
	        )
  	    ),
  	    
	    
      'password' => array(
        'notempty' => array('rule' => array('minLength', 1),
                            'require' => true, 
                            'allowEmpty' => false,
                            'message' => 'Please enter a password'
                            ),
        'passwordSimilar' => array('rule' => 'checkPasswords',
                                   'message' => 
                                   'Please enter the same password both times'
                                   )
        ),
      
	    'email' => array(
	      'rule' => 'email',
  	    'require' => true,
  	    'allowEmpty' => false,
	      'message' => 'Please enter a valid email'
	      )
	  );
	  
	  function checkUnique($data, $fieldName){
	    $valid = false; 
      if(isset($fieldName) && $this->hasField($fieldName)) {
        $valid = $this->isUnique(array($fieldName => $data));
      }
	    return $valid;
	  }
	  
	  function checkPasswords($data){
	    if($data['password'] == $this->data['User']['password2hashed']){
	      return true;
	    }
	    return false;
	  }
}
?>