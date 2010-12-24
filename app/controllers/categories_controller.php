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
    if($this->RequestHandler->isAjax()) {      
      $categories = $this->Category->find('all');
      $responce->page = 1;
      $responce->total = 1;
      $responce->records = count($categories);
      $i = 0; 
      foreach ($categories as $category) {
        $responce->rows[$i]['id'] = $category['Category']['id']; 
        $responce->rows[$i]['cell'] = array(
          $category['Category']['id'], 
          $category['Category']['name'], 
          $category['Category']['priority']); 
        $i++; 
      }
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->autoLayout = false;
      echo(json_encode($responce));
      exit(1);            
    }
  }

  function supplier_add() {
    $this->layout = "supplier/add";
    if (!empty($this->data)) {
      $category = $this->Category->find('first', array(
        'order' => array('Category.priority DESC')));
      $this->data['Category']['priority'] = 
        $category['Category']['priority'] + 1;
      $this->Category->create();
      if ($this->Category->save($this->data)) {
        $this->Session->setFlash(
          'The category has been saved', 'flash_notice');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(
          'The category could not be saved. Please, try again', 'flash_error');
      }
    }
  }

  function supplier_edit($id = null) {
    $this->layout = "supplier/add";
    if($this->RequestHandler->isAjax()) { 
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->Category->recursive = -1;
      $category = $this->Category->read(null, $this->params['form']['id']);
      $this->Category->set(array(
        'name' => $this->params['form']['name'],
        'priority' => $this->params['form']['priority'],
      ));
      $this->Category->save();
      exit(1);      
    }
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
    if($this->RequestHandler->isAjax()) {  
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->Category->delete($this->params['form']['id']);
      exit(1);
    }
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