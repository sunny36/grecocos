<?php
class Transaction extends AppModel {
  var $name = 'Transaction';
  var $belongsTo = array('User', 'Order'); 
  
  function getCashIn() {
    $params = array('conditions' => array('OR' => array(
      array('Transaction.type' => 'Cash Payment'))));
    $transactions = $this->find('all', $params); 
    $cashIn = 0; 
    foreach ($transactions as $transaction) {
      $cashIn += $transaction['Order']['total']; 
    }
    return $cashIn;  
  }


  function getCashInByDelivery($delivery_id) {
    $params = array('conditions' => array(
      'Transaction.type' => 'Cash Payment', 'Transaction.delivery_id' => $delivery_id));
    $transactions = $this->find('all', $params); 
    $cashIn = 0; 
    foreach ($transactions as $transaction) {
      $cashIn += $transaction['Order']['total']; 
    }
    return $cashIn;  
  }

  function getCashOut() {
    $params = array('conditions' => array('OR' => array(
      array('Transaction.type' => 'Refund'),
      array('Transaction.type' => 'Bank Transfer'))));
    $transactions = $this->find('all', $params); 
    $cashOut = 0; 
    foreach ($transactions as $transaction) {
      if ($transaction['Transaction']['type'] == "Refund") {
        $amountRefund = $transaction['Order']['total'] - $transaction['Order']['total_supplied'];
        $cashOut += $amountRefund; 
      }
    }
    return $cashOut;  
  }

  function getCashOutByDelivery($delivery_id) {
    $params = array('conditions' => array('AND' => array('OR' => array(
      array('Transaction.type' => 'Refund'), 
      array('Transaction.type' => 'Bank Transfer')),
      array('Transaction.delivery_id' => $delivery_id))));
    $transactions = $this->find('all', $params); 
    $cashOut = 0; 
    foreach ($transactions as $transaction) {
      if ($transaction['Transaction']['type'] == "Refund") {
        $amountRefund = $transaction['Order']['total'] - $transaction['Order']['total_supplied'];
        $cashOut += $amountRefund; 
      }
    }
    return $cashOut;
  }

  
  function getNumRowsForPaidTransaction() {
    $params = array('conditions' => array('OR' => array(
      array('Transaction.type' => 'Cash Payment'),
      array('Transaction.type' => 'Refund'),
      array('Transaction.type' => 'Bank Transfer'))));
    return $this->find('count', $params); 
  }

  function getNumRowsForPaidTransactionByDeliveryDate($delivery_id) {
    $params = array('conditions' => array('AND' => array('OR' => array(
      array('Transaction.type' => 'Cash Payment'), 
      array('Transaction.type' => 'Refund'), 
      array('Transaction.type' => 'Bank Transfer')),
      array('Transaction.delivery_id' => $delivery_id))));
    return $this->find('count', $params); 
  }

  
  function getPaidTransaction($recursive, $start, $limit) {
    $params = array('conditions' => array('OR' => array(
      array('Transaction.type' => 'Cash Payment'),
      array('Transaction.type' => 'Refund'),
      array('Transaction.type' => 'Bank Transfer'))), 
      'recursive' => 2, 'offset' => $start, 'limit' => $limit);
      return $this->find('all', $params);     
  }
  
  function getPaidTransactionByDeliveryDate($recursive, $start, $limit, $delivery_id) {
    $params = array('conditions' => array('AND' => array('OR' => array(
      array('Transaction.type' => 'Cash Payment'), 
      array('Transaction.type' => 'Refund'), 
      array('Transaction.type' => 'Bank Transfer')),
      array('Transaction.delivery_id' => $delivery_id))),
      'recursive' => 2, 'offset' => $start, 'limit' => $limit);
      return $this->find('all', $params);     
  }
  
}
?>
