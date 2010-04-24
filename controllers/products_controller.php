<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $components = array('Attachment');

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function admin_index() {
	  $this->layout = 'admin_index'; 
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
		
	}

  function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}
	
	function admin_add() {
	  $this->layout = 'admin_add'; 
	  $this->set('categories', $this->Product->Category->find('list'));
		if (!empty($this->data)) {
      $this->data['Product']['image'] = 
        $this->Attachment->upload($this->data['Product']['Attachment']);
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'),
				'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
	  $this->set('categories', $this->Product->Category->find('list'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  if(($this->Attachment->upload($this->data['Product']['Attachment']))) {
		    $this->data['Product']['image'] = 
          $this->Attachment->upload($this->data['Product']['Attachment']);
		  }
      
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product'));
		$this->redirect(array('action' => 'index'));
	}
}
?>