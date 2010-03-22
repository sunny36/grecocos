<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	
	var $validate = array(
			  
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
				'validemail' =>array(
	      	'rule' => 'email',
  	    	'require' => true,
  	    	'allowEmpty' => false,
	      	'message' => 'Please enter a valid email'
					),
					'unique' => array(
						'rule' => array('checkUnique', 'email'),
						'message' => 'This email has already been taken, please choose a different email'
						)
	      ),

	    'firstname' => array(
	      'rule' => array('minLength', 1),
  	    'require' => true,
  	    'allowEmpty' => false,
	      'message' => 'Please enter first name'
	      ),

	    'lastname' => array(
	      'rule' => array('minLength', 1),
  	    'require' => true,
  	    'allowEmpty' => false,
	      'message' => 'Please enter lastname name'
	      ),	      

	    'city' => array(
	      'rule' => array('minLength', 1),
  	    'require' => true,
  	    'allowEmpty' => false,
	      'message' => 'City cannot be blank'
	      ),

	    'postalcode' => array(
	      'rule' => '/[0-9]{5}/',
	      'message' => 'Postal code must be 5 characters'
	      ),	      
	      
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