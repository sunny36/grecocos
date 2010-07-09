<?php
class TransactionsController extends AppController {

  var $name = 'Transactions';
  var $helpers = array('Html', 'Form', 'Javascript', 'Time');

  function administrator_index() {
    $this->layout = "admin_index"; 
    if($this->RequestHandler->isAjax()) {
      $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      $delivery_id = null; 
      if (isset($this->params['url']['delivery_date'])) {
        $delivery_id = $this->params['url']['delivery_date'];
      }
      
      if(!$sidx) $sidx =1;
      $count = 0;
      if (isset($delivery_id)) {
        $count = $this->Transaction->getNumRowsForPaidTransactionByDeliveryDate($delivery_id); 
    
        
      } else {
        $count = $this->Transaction->getNumRowsForPaidTransaction(); 
      }
      
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
        $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
      $recursive = 2;
      $this->log($delivery_id, 'activity');
      $cashIn = null; 
      $cashOut = null; 
      if (isset($delivery_id)) {
        $this->log($delivery_id, 'activity');
        $transactions = $this->Transaction->getPaidTransactionByDeliveryDate($recursive, $start, $limit, $delivery_id);
        $cashIn = $this->Transaction->getCashInByDelivery($delivery_id); 
        $cashOut = $this->Transaction->getCashOutByDelivery($delivery_id);
      } else {
        $transactions = $this->Transaction->getPaidTransaction($recursive, $start, $limit);
        $cashIn = $this->Transaction->getCashIn(); 
        $cashOut = $this->Transaction->getCashOut();
      }
      //$this->log($transactions, 'activity');
      App::import( 'Helper', 'Time' );
      $time = new TimeHelper;
      foreach($transactions as &$transaction) {
        $transaction['Order']['ordered_date'] = 
          $time->format($format = 'm-d-Y', $transaction['Order']['ordered_date']);
        $transaction['Transaction']['cash_in'] = "";
        $transaction['Transaction']['cash_out'] = "";
        if ($transaction['Transaction']['type'] == 'Cash Payment') {
          $transaction['Transaction']['cash_in'] = $transaction['Order']['total'];
          $transaction['Transaction']['type'] = "Order" . " #" . $transaction['Transaction']['order_id'];
        }
        if ($transaction['Transaction']['type'] == "Refund") {
          $amountRefund = $transaction['Order']['total'] - $transaction['Order']['total_supplied'];
          $transaction['Transaction']['cash_out'] = $amountRefund;
          $transaction['Transaction']['type'] = "Refund Order" . " #" . $transaction['Transaction']['order_id'];
        }
      }
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('transactions', $transactions);   
      $this->set('cash_in', $cashIn); 
      $this->set('cash_out', $cashOut); 
      $this->render('/elements/transactions', 'ajax');
    }
  }

  function admin_view($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'transaction'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('transaction', $this->Transaction->read(null, $id));
  }

  function admin_add() {
    if (!empty($this->data)) {
      $this->Transaction->create();
      if ($this->Transaction->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'transaction'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'transaction'));
      }
    }
  }

  function admin_edit($id = null) {
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'transaction'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->Transaction->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'transaction'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'transaction'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->Transaction->read(null, $id);
    }
  }

  function admin_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'transaction'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->Transaction->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'Transaction'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Transaction'));
    $this->redirect(array('action' => 'index'));
  }
}
?>
