<?php
class ProductsController extends AppController {

  var $name = 'Products';
  var $components = array('Attachment');
  var $helpers = array('Html', 'Form', 'Javascript');
  var $uses = array('Product', 'Category'); 
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      if ($this->params['action'] != "view") {
        $this->redirect($this->referer());
      }      
    }
  }

  function supplier_index() {
    $this->layout = 'supplier/index'; 
    $this->Product->recursive = 0;
    if(!empty($this->params['url']['short_description'])) {
      $short_description = $this->params['url']['short_description'];
      $this->paginate = (array('conditions' => array(
        'Product.short_description LIKE' => '%' . $short_description . '%'), 'limit' => 100000)); 
      #TODO Remove hard coded limit. 
      $this->set('products', $this->paginate());    
    } else {
      $this->paginate = (array('limit' => 100000));
      $this->set('products', $this->paginate());    
    }
  }

  function supplier_view($id = null) {
    $this->layout = 'supplier/add'; 
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('product', $this->Product->read(null, $id));
  }
  
  function supplier_add() {
    $this->layout = 'supplier/add'; 
    $this->set('categories', $this->Product->Category->find('list'));
    if (!empty($this->data)) {
      $this->data['Product']['image'] = $this->Attachment->upload($this->data['Product']['Attachment']);
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

  function supplier_edit($id = null) {
    $this->layout = 'supplier/add'; 
    $this->set('categories', $this->Product->Category->find('list'));
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if(($this->Attachment->upload($this->data['Product']['Attachment']))) {
        $this->data['Product']['image'] = $this->Attachment->upload($this->data['Product']['Attachment']);
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

  function supplier_delete($id = null) {
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
  
    function view($id = null) {
      if (!$id) {
        $this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
        $this->redirect(array('action' => 'index'));
      }
      $this->set('product', $this->Product->read(null, $id));
    }
  

}
?>