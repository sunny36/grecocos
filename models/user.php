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
      'passwordSimilar' => array('rule' => 'checkPasswords', 'message' => 'Please enter the same password both times')
  ),
  
  'email' => array(
    'validemail' =>array(
      'rule' => 'email', 'require' => true, 'allowEmpty' => false, 'message' => 'Please enter a valid email'
    ),
    'unique' => array(
      'rule' => array('checkUnique', 'email'), 
      'message' => 'This email has already been taken, please choose a different email'
    )
  ),

  'firstname' => array(
    'rule' => array('minLength', 1), 'require' => true, 'allowEmpty' => false, 'message' => 'Please enter first name'
  ),

  'lastname' => array(
    'rule' => array('minLength', 1), 'require' => true, 'allowEmpty' => false, 'message' => 'Please enter lastname name'
  ),


  'phone' => array(
    'rule' => array('minLength', 1), 'require' => true, 'allowEmpty' => false, 'message' => 'Phone cannot be empty'
   ),  
  'organization_id' => array('required' => array('rule' => 'notEmpty', 'message' => 'Please select a delivery address'))
);
  
  function findByOrgainizationIdCondition($organizationId) {
    return array('conditions' => array('User.organization_id' => $organizationId));
  }
  
  function findByNameAndOrganizationIdCondition($name, $organizationId) {
    return array(
      'conditions' => array(
        'AND' => array(
          'OR' => array('User.firstname LIKE' => '%' . $name. '%', 'User.lastname LIKE' => '%' . $name. '%'),
          'User.organization_id' => $organizationId
        )
      )
    );
  }
  

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

  function sendAcceptanceEmail($id) {
    $user = $this->getUser($id); 
    $to = $user['User']['email']; 
    $subject = "GRECOCOS: Your account has been accepted"; 
    $body = "Dear {$user['User']['firstname']}  \n\n" . "Your account has been accepted. You can now log in at " . 
      "http://grecocos.co.cc/index.php/login\n\nThank You\n\n";
    $this->sendEmail($to, $subject, $body);
  }
  
  function sendEmailNewUserSignUp() {
    $to = "Ralph.Houtman@fao.org";
    $subject = "GRECOCOS: New User"; 
    $body = "A new user has signed up."; 
    $this->sendEmail($to, $subject, $body);
  }

  function sendEmailWaitForConfirmation($firstname, $email) {
    $to = $email; 
    $subject = "GRECOCOS: Signup" ; 
    $body = "Dear {$firstname},\n\nThank you for signing up. " . 
      "Please wait for a confirmation email from the coordinator\n\nThank you\n"; 
    $this->sendEmail($to, $subject, $body);
  }
  
  function sendEmail($to, $subject, $body) {
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail($to, $subject, $body); 
  }
  
  function resetPassword($email) {
    $user = $this->findByEmail($email);
    $this->read(null, $user['User']['id']); 
    $two_hours_from_now = time() + (180 * 60);
    $this->set(array('token' => uniqid(), 
    'token_expiry' => date('Y-m-d H:m:s', $two_hours_from_now)));
    $this->save();
    $this->sendResetPasswordEmail($user['User']['id']); 
  }

  function sendResetPasswordEmail($user_id) {
    $user = $this->findById($user_id); 
    $to = $user['User']['email']; 
    $subject = "GRECOCOS: Reset Password"; 
    $body = "Dear {$user['User']['firstname']},\n\n" . 
      "Please use the following link to reset your password.\n\n" . 
      "http://grecocos.co.cc/index.php/users/forgot_password?" .
      "email={$user['User']['email']}&token={$user['User']['token']}"; 
    $this->sendEmail($to, $subject, $body); 

  }
}
?>
