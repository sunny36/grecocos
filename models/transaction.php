<?php
class Transaction extends AppModel {
  var $name = 'Transaction';
  var $belongsTo = array('User', 'Order'); 
}
?>
