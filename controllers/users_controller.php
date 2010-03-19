<?php
class UsersController extends AppController {

	var $name = 'Users';

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
  
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
		$this->redirect(array('action' => 'index'));
	}
	
	function signup(){
	  if(!empty($this->data)) {
	    //status: 000 means self registered but not accepted
	    $this->data['User']['status'] = '000';
	    if(isset($this->data['User']['password2'])){
	      $this->data['User']['password2hashed'] =
	        $this->Auth->password($this->data['User']['password2']);
	    }
	    $this->User->create();
	    
	    if($this->User->save($this->data)){
	      $this->Session->setFlash('Please wait for an confirmation email from the co-ordinator.');
	      $this->redirect(array('controller' => 'home', 'action' => 'index'));
	    } else {
	      $this->Session->setFlash(
	        'There was an error signing up. Please try again.');
	      $this->data = null; 
	    }
	  }
	}
	
	function login(){
	  
	}
	
	function logout() { 

 	  $this->Session->setFlash('You have logged out!!');
	  $this->redirect($this->Auth->logout());
  }
}
?>