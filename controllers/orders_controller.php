<?php
class OrdersController extends AppController {

	var $name = 'Orders';
	var $uses = array('Order', 'Product', 'LineItem');
	var $helpers = array('Html', 'Form', 'Javascript');

	function admin_index() {
	  if(!empty($this->params['url']['id'])){
	    $id = $this->params['url']['id'];
      $this->paginate = array(
        'conditions' => array('Order.id' => $this->params['url']['id'])
        );
	  }
	  if(!empty($this->params['url']['user_name'])){
      $this->paginate = array(
        'conditions' => array(
          'OR' => array(
          'User.firstname LIKE' => '%' . $this->params['url']['user_name']. '%',
          'User.lastname LIKE' => '%' . $this->params['url']['user_name']. '%')
          )
        );
	  }	  
		$this->Order->recursive = 0;
		$this->set('orders', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('order', $this->Order->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Order->create();
			if ($this->Order->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'order'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'order'));
			}
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Order->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'order'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'order'));
			}
		}
		if (empty($this->data)) {
		  $products = $this->Order->getProducts($id);
		  $this->set('products', $products);
			$this->data = $this->Order->read(null, $id);
			$this->set('order', $this->Order->read(null, $id));

		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'order'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Order->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Order'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Order'));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_changeStatus(){
    Configure::write('debug', 0);
    $this->autoRender = false;

    if($this->RequestHandler->isAjax()) {
      $this->log($this->params, 'activity');
      $order =  $this->Order->find('first', 
                                   array('conditions' => array(
                                     'Order.id' => $this->params['form']['id']), 
                                  'recursive' => -1));
      $order['Order']['status'] = $this->params['form']['status'];
      $this->Order->save($order);
      $this->log($order, 'activity');
    }
	}
}
?>