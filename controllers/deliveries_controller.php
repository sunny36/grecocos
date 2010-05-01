<?php
class DeliveriesController extends AppController {

	var $name = 'Deliveries';
  var $helpers = array('Html', 'Form', 'Javascript');
  
	function admin_index() {
	  $this->layout = "admin_index";  
		$this->Delivery->recursive = 0;
		$this->set('deliveries', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'delivery'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('delivery', $this->Delivery->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Delivery->create();
			if ($this->Delivery->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'delivery'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Delivery->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'delivery'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'delivery'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Delivery->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'delivery'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Delivery->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Delivery'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Delivery'));
		$this->redirect(array('action' => 'index'));
	}
}
?>