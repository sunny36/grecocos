<?php
class TransactionsController extends AppController {

	var $name = 'Transactions';

	function index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'transaction'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('transaction', $this->Transaction->read(null, $id));
	}

	function add() {
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

	function edit($id = null) {
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

	function delete($id = null) {
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
	function admin_index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
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