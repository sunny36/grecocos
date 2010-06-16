<?php
class TransactionsController extends AppController {

  var $name = 'Transactions';
  var $helpers = array('Html', 'Form', 'Javascript');

  function administrator_index() {
    $this->layout = "admin_index"; 
    if($this->RequestHandler->isAjax()) {
      $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      if(!$sidx) $sidx =1;
      $count = $this->Transaction->find('count'); 
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
        $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
      $params = array('recursive' => 1, 'offset' => $start, 'limit' => $limit);
      $transactions = $this->Transaction->find('all'); 
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('transactions', $transactions);      
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
