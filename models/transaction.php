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

  function getCashIn2($delivery_id = NULL) {
    if (isset($delivery_id)) {
      $params = array('conditions' => array('OR' => array(
        array('Transaction.type' => 'Cash Payment'), array('Transaction.type' => 'Refund'))));
    } else {
      $params = array('conditions' => array('AND' => array('OR' => array(
        array('Transaction.type' => 'Refund'), array('Transaction.type' => 'Bank Transfer')), 
      array('Transaction.delivery_id' => $delivery_id))));
    }
    $transactions = $this->find('all', $params); 
    $cashIn = 0; 
    foreach ($transactions as $transaction) {
      if ($transaction['Transaction']['type'] == "Cash Payment") {
        $cashIn += $transaction['Order']['total']; 
      }
      if ($transaction['Transaction']['type'] == "Refund") {
        $amountRefund = -($transaction['Order']['total'] - $transaction['Order']['total_supplied']);
        $cashIn = $cashIn + $amountRefund; 
      }
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
      if ($transaction['Transaction']['type'] == "Bank Transfer") {
        $cashOut += $transaction['Transaction']['bank_transfer_amount'];
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
      if ($transaction['Transaction']['type'] == "Bank Transfer") {
        $cashOut += $transaction['Transaction']['bank_transfer_amount'];
      }
    }
    return $cashOut;
  }

  function getDueToPay($delivery_id = NULL) { 
    if (isset($delivery_id)) {
      $params = array('conditions' => array('OR' => array(
        array('Transaction.type' => 'Cash Payment'), array('Transaction.type' => 'Refund'), 
        array('Transaction.type' => 'Bank Transfer')))); 
    } else {
      $params = array('conditions' => array('AND' => array('OR' => array(
        array('Transaction.type' => 'Cash Payment'), array('Transaction.type' => 'Refund'), 
        array('Transaction.type' => 'Bank Transfer')), 
      array('Transaction.delivery_id' => $delivery_id))));
    }
    $transactions = $this->find('all', $params); 
    $dueToPay = 0; 
    foreach ($transactions as $transaction) {
      if ($transaction['Transaction']['type'] == "Cash Payment") {
        $dueToPay += $transaction['Order']['total2']; 
      }
      if ($transaction['Transaction']['type'] == "Refund") {
        $amountRefund2 = -($transaction['Order']['total2'] - $transaction['Order']['total2_supplied']);
        $dueToPay += $amountRefund2; 
      }
      if ($transaction['Transaction']['type'] = "Bank Transfer") {
        $dueToPay += -($transaction['Transaction']['bank_transfer_amount']); 
      }
    }
    return $dueToPay; 
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
