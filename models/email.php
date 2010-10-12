<?php
class Email extends AppModel{
  var $useTable = false; 
  
  var $validate = array(
    'subject' => array('rule' => 'notEmpty', 'message' => 'Subject must not be blank.'),
    'body' => array('rule' => 'notEmpty', 'message' => 'Message must not be blank.')
  );
  
  
}
?>