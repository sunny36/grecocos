<?php
class Email extends AppModel{
  var $useTable = false; 
  
  var $validate = array(
    'subject' => array(
      'rule' => 'notEmpty', 
      'message' => 'Subject must not be blank.'
      ),
    'body' => array(
      'rule' => 'notEmpty', 
      'message' => 'Message must not be blank.'
      ),
      'to' => array(
        'rule' => 'notOrderedUsers', 
        'message' => 'The site must be open to send email to users that have not ordered'
      ),
      'user' => array(
        'rule' => 'userNotEmpty', 
        'message' => 'Please select a user'           
      )
  );
  
  function sendEmailToAllCustomer($subject, $body) {
    $User = ClassRegistry::init('User'); 
    $users = $User->find('all', array(
      'conditions' => array('User.status' => 'accepted'))); 
    $to = "";
    foreach ($users as $user) {
      $to = $to . $user['User']['email'] . ", ";
    }
    $this->_sendEmail($to, $subject, $body);
  }
  
  function sendEmailCustomersWhoHaveNotOrdered($subject, $body) {
    $Delivery = ClassRegistry::init('Delivery'); 
    $nextDelivery = $Delivery->findByNextDelivery(true);
    $Order = ClassRegistry::init('Order'); 
    $orders = $Order->findAllByDeliveryId($nextDelivery['Delivery']['id']);
    $userIds = NULL; 
    foreach ($orders as $order) {
      $userIds[] = $order['User']['id']; 
    }    
    $User = ClassRegistry::init('User'); 
    $users = $User->find('all', array('conditions' => array(
      'NOT' => array('User.id' => $userIds))));
    $to = "s@sunny.in.th";
    $to = "";
    foreach ($users as $user) {
      $to = $to . $user['User']['email'] . ", ";
    }        
    $this->_sendEmail($to, $subject, $body);
  }
  
  function sendEmailToIndividualCustomer($userId, $subject, $body) {
    $User = ClassRegistry::init('User');
    $user = $User->findById($userId); 
    $this->_sendEmail($user['User']['id'], $subject, $body);
  }
  
  function _sendEmail($to, $subject, $body) {
    $AppengineEmail = ClassRegistry::init('AppengineEmail'); 
    $AppengineEmail->sendEmail($to, 
                               $this->data['Email']['subject'], 
                               $this->data['Email']['body']);        
  }
  
  function userNotEmpty() {
    if ($this->data['Email']['to'] == "individual") {
      if ($this->data['Email']['user'] > 0) {
        return true; 
      } else {
        return false; 
      }
    }
  }
  
  function notOrderedUsers() {
    if ($this->data['Email']['to'] == "not_ordered") {
      if (Configure::read('Grecocos.closed') == "no") {
        return true;
      } else {
        return false; 
      }
    }
  }
  
}
?>