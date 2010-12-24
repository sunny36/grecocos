<?php
class OrganizationsController extends AppController {

  var $name = 'Organizations';
  var $helpers = array('Javascript'); 
  

  function index() {
    if ($this->params['url']['ext'] == 'json') {
      Configure::write('debug', 0);       
    }
		$this->Organization->recursive = 0;
    $this->set('organizations', $this->paginate());
     
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'organization'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('organization', $this->Organization->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Organization->create();
			if ($this->Organization->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'organization'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'organization'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'organization'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Organization->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'organization'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'organization'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Organization->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'organization'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Organization->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Organization'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Organization'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
