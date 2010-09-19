<?php
class CategoriesController extends AppController {

  var $name = 'Categories';
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
    $supplierActions = array('supplier_index', 'supplier_add', 'supplier_delete', 'supplier_edit');
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") $this->redirect('/coordinator');
    }            
  }
  

  function supplier_index() {
    $this->layout = "supplier/index";
    $this->Category->recursive = 0;
    $this->set('categories', $this->paginate());
  }

  function supplier_add() {
    $this->layout = "supplier/add";
    if (!empty($this->data)) {
      $this->Category->create();
      if ($this->Category->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'category'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'category'));
      }
    }
  }

  function supplier_edit($id = null) {
    $this->layout = "supplier/add";
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'category'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->Category->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'category'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'category'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->Category->read(null, $id);
    }
  }

  function supplier_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'category'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->Category->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'Category'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Category'));
    $this->redirect(array('action' => 'index'));
  }
  
}
?>