<?php
class ConfigurationsController extends AppController {

	var $name = 'Configurations';
  var $helpers = array('Html', 'Form', 'Javascript');

  function beforeFilter(){
    parent::beforeFilter();
    $coordinatorActions = array('coordinator_index', 'coordinator_view', 'coordinator_add', 'coordinator_edit',
                                'coordinator_delete');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") $this->redirect('/supplier');
    }
  }
  
	function coordinator_index() {
	  $this->layout = "coordinator/add";
		$this->Configuration->recursive = 0;
		$this->set('closed', Configure::read('Grecocos.closed'));
		if (!empty($this->data)) {
		  $closed = $this->Configuration->findByKey('closed');
		  $closed['Configuration']['value'] = $this->data['Configuration']['closed']; 
		  $this->Configuration->save($closed);
		  $this->Session->setFlash("Configurations has been saved.", 'system_message');
		  $this->redirect(array('action' => 'index'));
		}
	}

	function coordinator_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'configuration'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('configuration', $this->Configuration->read(null, $id));
	}

	function coordinator_add() {
		if (!empty($this->data)) {
			$this->Configuration->create();
			if ($this->Configuration->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'configuration'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'configuration'));
			}
		}
	}

	function coordinator_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'configuration'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Configuration->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'configuration'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'configuration'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Configuration->read(null, $id);
		}
	}

	function coordinator_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'configuration'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Configuration->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Configuration'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Configuration'));
		$this->redirect(array('action' => 'index'));
	}
}
?>