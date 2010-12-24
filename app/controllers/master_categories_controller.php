<?php
class MasterCategoriesController extends AppController {

  var $name = 'MasterCategories';
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
    $supplierActions = array(
      'supplier_index', 'supplier_add', 'supplier_delete', 'supplier_edit');
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") {
       $this->redirect('/coordinator'); 
      }
    }            
  }
  

  function supplier_index() {
    $this->layout = "supplier/index";
    $this->MasterCategory->recursive = 0;
    $this->set('master_categories', $this->paginate());
    if($this->RequestHandler->isAjax()) {      
      $masterCategories = $this->MasterCategory->find('all');
      $responce->page = 1;
      $responce->total = 1;
      $responce->records = count($masterCategories);
      $i = 0; 
      foreach ($masterCategories as $masterCategory) {
        $responce->rows[$i]['id'] = $masterCategory['MasterCategory']['id']; 
        $responce->rows[$i]['cell'] = array(
          $masterCategory['MasterCategory']['id'], 
          $masterCategory['MasterCategory']['name'], 
          $masterCategory['MasterCategory']['priority']); 
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
      $masterCategory = $this->MasterCategory->find('first', array(
        'order' => array('MasterCategory.priority DESC')));
      $this->data['MasterCategory']['priority'] = 
        $masterCategory['MasterCategory']['priority'] + 1;
      $this->MasterCategory->create();
      if ($this->MasterCategory->save($this->data)) {
        $this->Session->setFlash(
          'The masterCategory has been saved', 'flash_notice');
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(
          'The masterCategory could not be saved. Please, try again', 'flash_error');
      }
    }
  }

  function supplier_edit($id = null) {
    $this->layout = "supplier/add";
    if($this->RequestHandler->isAjax()) { 
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->MasterCategory->recursive = -1;
      $masterCategory = $this->MasterCategory->read(null, $this->params['form']['id']);
      $this->MasterCategory->set(array(
        'name' => $this->params['form']['name'],
        'priority' => $this->params['form']['priority'],
      ));
      $this->MasterCategory->save();
      exit(1);      
    }
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'masterCategory'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->MasterCategory->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'masterCategory'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'masterCategory'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->MasterCategory->read(null, $id);
    }
  }

  function supplier_delete($id = null) {
    if($this->RequestHandler->isAjax()) {  
      Configure::write('debug', 0);
      $this->autoRender = false;
      $this->MasterCategory->delete($this->params['form']['id']);
      exit(1);
    }
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'masterCategory'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->MasterCategory->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'MasterCategory'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'MasterCategory'));
    $this->redirect(array('action' => 'index'));
  }
  
}
?>