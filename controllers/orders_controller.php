<?php
class OrdersController extends AppController {

	var $name = 'Orders';

	function index() {
		$this->Order->recursive = 0;
		$this->set('orders', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('order', $this->Order->read(null, $id));
	}

	function add() {
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

	function edit($id = null) {
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
			$this->data = $this->Order->read(null, $id);
			$this->set('order', $this->Order->read(null, $id));
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
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
}
?>