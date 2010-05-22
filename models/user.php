<?php
class User extends AppModel {
  var $name = 'User';
  var $displayField = 'id';
  var $hasMany = 'Order';
  var $belongsTo = 'Organization';

  var $virtualFields = array(
    'name' => 'CONCAT(User.firstname, " ", User.lastname)'
  );

  var $validate = array(                        
    'password2' => array(
      'notempty' => array(
        'rule' => array('minLength', 1),
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


  'phone' => array(
    'rule' => array('minLength', 1),
    'require' => true,
    'allowEmpty' => false,
    'message' => 'Phone cannot be empty'
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
    if($this->data['User']['password'] == $this->data['User']['password2hashed']){
      return true;
    }
    return false;
  }

  function getUser($id) {
    $user =  $this->read(null, $id);
    if (strlen($user['User']['middlename']) < 1) {
      $user['User']['middlename'] = "-";
    }
    $user['User']['status'] = ucwords($user['User']['status']);
    return $user;
  }
}
?>
